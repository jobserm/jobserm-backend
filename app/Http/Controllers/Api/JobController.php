<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Http\Resources\JobCollection;
use App\Http\Resources\JobResource;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        $this->authorize('create',Job::class);
//        $validated = $request->validate([
//            'title' => ['required'],
//            'description' => ['required'],
//            'compensation' => ['required'],
//            'requirement' => ['required'],
//            'province' => ['required'],
//        ]);
        $validator = Validator::make($request->all(),[
            'title'=>[
                Rule::unique('jobs'),
            ],
        ])->validate();

        $jobs = new Job();
        $jobs->title = $request->input('title');
        $jobs->description = $request->input('description');
        $jobs->compensation = $request->input('compensation');
        $jobs->requirement = $request->input('requirement');
        $jobs->province = $request->input('province');
        $jobs->save();

        $categories = $request->input('category');
        return $jobs;
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
}
