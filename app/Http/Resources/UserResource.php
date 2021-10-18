<?php

namespace App\Http\Resources;

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
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
            'facebook' => $this->facebook,
            'line' => $this->line,
            'activation' => $this->activation,
            'review' => Review::where('user_id', '=', $this->id)->avg('rating')
        ];
    }
}
