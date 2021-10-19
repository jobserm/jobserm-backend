<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
//    public static $wrap = 'job';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::find($this->id);
        $users = UserResource::collection($this->users)->count();
        return [
            'id' => $this->id,
            'compensation' => $this->compensation,
            'description' => $this->description,
            'requirement' => $this->requirement,
            'province' => $this->province,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'job_owner' => $user->name,
            'users' => UserResource::collection($this->users),
            'freelancer_count' => $users,
            'report' => $this->report,
//            'jobs' => $this->whenLoaded('jobs')
        ];
    }
}
