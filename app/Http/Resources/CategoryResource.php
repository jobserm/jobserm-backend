<?php

namespace App\Http\Resources;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $job = JobResource::collection($this->jobs)->count();
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'category_name' => $this->category_name,
            'job_count' => $job,
        ];
    }
}
