<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobResource;
use App\Models\Category;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $jobs = Job::paginate(4);
        return JobResource::collection($jobs);
//        return new JobCollection($jobs);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param JobRequest $request
     * @return Job
     */
    public function store(JobRequest $request)
    {
        $this->authorize('create',Job::class);
        $validated = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'compensation' => ['required'],
            'requirement' => ['required'],
            'province' => ['required'],
        ]);

//        if ($validated->fails()) {
//            return response()->json($validated->errors()->toJson(), 400);
//        }
//        $validator = Validator::make($request->all(),[
//            'title'=>[
//                Rule::unique('jobs'),
//            ],
//        ])->validate();

        // injects employer who owns this job
        $user = JWTAuth::user();

        $job = new Job();
        $job->title = $request->input('title');
        $job->description = $request->input('description');
        $job->compensation = $request->input('compensation');
        $job->requirement = $request->input('requirement');
        $job->province = $request->input('province');
        $job->user_id = $user->id;
        $job->save();

        // injects category related to this job
        // category formats "A, B, C, ..."
        $categories = $request->input('category');
        $this->updateCategory($job, $categories);
        return $job;
    }

    private function updateCategory(Job $job, $categoriesWithComma)
    {
        if ($categoriesWithComma) {
            $category_array = [];
            $categories = explode(",", $categoriesWithComma);
            foreach ($categories as $category_name) {
                $category_name = trim($category_name);
                if ($category_name) {
                    $category = Category::firstOrCreate(['category_name' => $category_name]);
                    array_push($category_array, $category->id);
                }
            }
            $job->categories()->sync($category_array);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return JobResource
     */
    public function show(Job $job)
    {
        return new JobResource($job);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param JobRequest $request
     * @param \App\Models\Job $job
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        $this->authorize('update',$job);
//        $validated = $request->validate([
//            'title' => ['required'],
//            'description' => ['required'],
//            'compensation' => ['required'],
//            'requirement' => ['required'],
//            'province' => ['required'],
//        ]);

        $validator = Validator::make($request->all(),[
            'title'=>[
                Rule::unique('jobs')->ignore($job),
            ],
        ])->validate();

        $job->title = $request->input('title');
        $job->description = $request->input('description');
        $job->compensation = $request->input('compensation');
        $job->requirement = $request->input('requirement');
        $job->province = $request->input('province');
        $job->save();

        $categories = $request->input('category');
        return $job;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Job $job)
    {
        $this->authorize('delete',$job);

        $job->delete();

        return response()->json(['message' => 'Successfully deleted']);

    }

    public function userApplyJob(Request $request, Job $job){

        $user = User::findOrFail($request->input('id'));
        $userAlreadyApplied =  $job->users()->find($request->input('id'));

        if (is_null($userAlreadyApplied)) {
            $job->users()->attach($user->id, ['remark' => $request->input('remark')]);
            return response()->json(['message' => '??????????????????????????????????????????????????? ????????????????????????????????????????????????????????????????????????????????????',$job]);
        }

        return response()->json(['message' => 'You already applied this job'], 409);

    }

    public function employerSelectFreelancer(Request $request, Job $job) {
//        $this->authorize('update', $job);

        $user = User::findOrFail($request->input('id'));
        $job->users()->updateExistingPivot($user->id, ['is_selected' => true]);
        $job->working_status = "IN PROGRESS";
        $job->save();

        return response()->json(['message' => 'Selected freelancer successfully']);
    }

    public function reportInappropriateJob (Request $request, Job $job) {

        $this->authorize('update', $job);

        $job->report += 1;
        $job->save();

        return response()->json(['Thank you for your feedback!']);
    }

    public function finishJob (Request $request, Job $job) {
//        $this->authorize('update', $job);

        $job->working_status = "FINISH";
        $job->save();

        return response()->json(['message' => 'Your job is finished!', $job->users]);
    }

    public function getAllJobs () {
        return JobResource::collection(Job::get());
    }

    public function getRandJobs (Request $request) {
        $id = $request->input("id");
        $user = JWTAuth::user();

        return Job::where('id','!=', $id)->where('user_id','!=',$user->id)->where('working_status','=',1)->inRandomOrder()->get();
    }

    public function getJobByUser (Request $request) {
        $id = $request->input("id");
        $working_status = $request->input("working_status");
        if($working_status === 'ALL')
        {
            $jobs = Job::where('user_id','=', $id)->get();
            return JobResource::collection($jobs);

        }
        elseif ($working_status === 'AVAILABLE')
        {
            $jobs = Job::where('user_id','=', $id)->where('working_status','=',1)->get();
            return JobResource::collection($jobs);
        }
        elseif ($working_status === "IN PROGRESS")
        {
            $jobs = Job::where('user_id','=', $id)->where('working_status','=',2)->get();
            return JobResource::collection($jobs);
        }elseif ($working_status === "FINISH")
        {
            $jobs = Job::where('user_id','=', $id)->where('working_status','=',3)->get();
            return JobResource::collection($jobs);
        }

    }

    public function getJobThatUserApply (Request $request) {


        $id = $request->input("id");
        $working_status = $request->input("working_status");
        $user = User::findOrFail($id);
        $jobs = $user->jobs;
        if($working_status === 'ALL')
        {
            return JobResource::collection($jobs);

        }
        elseif ($working_status === 'AVAILABLE')
        {
            $jobs = $jobs->where('working_status','=',"AVAILABLE");
            return JobResource::collection($jobs);
        }
        elseif ($working_status === "IN PROGRESS")
        {
            $jobs = $jobs->where('working_status','=',"IN PROGRESS");
            return JobResource::collection($jobs);
        }elseif ($working_status === "FINISH")
        {
            $jobs = $jobs->where('working_status','=',"FINISH");

            return JobResource::collection($jobs);
        }


    }

    public function getAllAvaliableJobWithoutUserLogedIn (Request $request) {
        $id = $request->input("id");
        $jobs = Job::where('user_id','!=', $id)->where('working_status','=',1)->get();
        return JobResource::collection($jobs);
    }

    public function getJobAvaliableWithoutUserLogedIn (Request $request) {
        $id = $request->input("id");
        $jobs = Job::where('user_id','!=', $id)->where('working_status','=',1)->get();
//        $jobs = Job::where('user_id','=', $id)->paginate(4);
        return JobResource::collection($jobs);
    }

    public function getJobFromSearch (Request $request){
        $province = $request->input("province");
        $title = $request->input("title");
        $compensation = $request->input("compen");
        $check = $request->input("check");
        $id = $request->input("user_id");
        if($check === 0) {


            $jobs = Job::where('user_id','!=',$id)->where('title', 'like', $title)->where('province', 'like', $province)->where('working_status','=',1)->whereBetween('compensation', $compensation)->paginate(4);
            return JobResource::collection($jobs);
        }
        elseif($check === 1){
            $jobs = Job::where('user_id','!=',$id)->where('title', 'like', $title)->where('province', 'like', $province)->where('working_status','=',1)->paginate(4);
            return JobResource::collection($jobs);
        }
    }
}
