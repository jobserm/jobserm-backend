<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class ImageController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = JWTAuth::user();
        $file = $request->photo->getClientOriginalName();
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $filePath = $request->photo->store('/' . "jobserm-" . $user->username, 'azure');

        $job = Job::findOrFail($request->header('X-JOB-ID'));
        $newImage = new Image();
        $newImage->name = $fileName;
        $newImage->path = Storage::disk('azure')->url($filePath);
        $newImage->job_id = $job->id;
        $newImage->save();

        return response()->json(['image' => $newImage]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getImageByJobId($id) {
        $image = Image::where('job_id', '=', $id)->get();
        return $image;
    }

    public function uploadProfile(Request $request, $id) {
        $user = JWTAuth::user();
        $file = $request->photo->getClientOriginalName();
        $fileName = pathinfo($file, PATHINFO_FILENAME);
        $filePath = $request->photo->store('/' . "jobserm-" . $user->username . '/profile', 'azure');

        $user = User::findOrFail($id);
        $user->img_url = Storage::disk('azure')->url($filePath);
        $user->save();

        return response()->json(['image' => $user->img_url]);
    }
}
