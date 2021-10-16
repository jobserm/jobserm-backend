<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
//            'user' => [
//                'id' => $this->user->id,
//                'name' => $this->user->name
//            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'comment' => $this->comment,
            'rating' => $this->rating
        ];
    }
}
