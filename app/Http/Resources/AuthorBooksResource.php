<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorBooksResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return 
[
        'Book attributes' =>
        [
            'id' => $this->id,
            'name' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status
        ],
        'Chapters' => AuthorBookChaptersResource::collection($this->Chapters)
];
    }
}
