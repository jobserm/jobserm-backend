<?php

namespace App\Http\Resources;

use App\Models\Job;
use App\Models\Review;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'phone' => $this->phone,
            'address' => $this->address,
            'facebook' => $this->facebook,
            'line' => $this->line,
            'about_me' => $this->about_me,
            'skill' => $this->skill,
            'activation' => $this->activation,
            'info' => $this->jobs,
            'review' => Review::where('user_id', '=', $this->id)->avg('rating'),
            'img_url' => $this->img_url
        ];
    }
}
