<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Image;
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
        $users = UserResource::collection($this->users)->count();
        $image = Image::where('job_id', '=', $this->id)->get();
        $selected = "";
        $freelancer_name = "ยังไม่มีผู้รับงาน";
        $category_name = "ยังไม่ถูกจัดหมวดหมู่";
        foreach ($this->categories as $category) {
            $category_name = $category->category_name;
        }
        foreach ($this->users as $user) {
            if ($user->pivot->is_selected === 1) {
                $selected = $user;
                $freelancer_name = $selected->name . ' ' . $selected->lastname;
            }
        }

        return [
            'id' => $this->id,
            'compensation' => $this->compensation,
            'description' => $this->description,
            'requirement' => $this->requirement,
            'province' => $this->province,
            'title' => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'job_owner' => User::where('id', '=', $this->user_id)->get(),
            'users' => UserResource::collection($this->users),
            'freelancer_count' => $users,
            'report' => $this->report,
            'working_status' => $this->working_status,
            'user_id' => $this->user_id,
            'catagory' => Category::where('id', '=', $this->id)->get(),
            'category_name' => $this->categories,
            'image' => $image,
            'selected_user' => $selected,
            'selected_user_admin' => $freelancer_name,
            'category_admin' => $category_name,

//            'jobs' => $this->whenLoaded('jobs')
        ];
    }
}
