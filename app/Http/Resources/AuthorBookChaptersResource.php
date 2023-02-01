<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuthorBookChaptersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'Chapter attributes' => 
            [
              
            'id' =>  $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'book id' =>$this->book_id,
            'book status' => $this->status,
            'content' => $this->chapter_content,
            'deleted at' => $this->deleted_at,
            'created at' => $this->created_at,
            'updated at' => $this->updated_at
            
            ]
        ];
    }
}
