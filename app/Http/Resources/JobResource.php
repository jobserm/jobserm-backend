<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Image;
use App\Models\Review;
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
        $category_name = Category::where('id', '=', $this->id)->value('category_name');
        $image = Image::where('job_id', '=', $this->id)->get();
        $selected = [];
        foreach ($this->users as $user) {
            if ($user->pivot->is_selected === 1) {
                array_push($selected, $user);
            }
        }

        if(count($selected) > 0)
        {
            $user_id = $selected[0]['id'];
        }
        else{
            $user_id = 0;
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
            'review' => Review::where('user_id', '=', $user_id)->avg('rating'),

//            'jobs' => $this->whenLoaded('jobs')
        ];
    }
}
