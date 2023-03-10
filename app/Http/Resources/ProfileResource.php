<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'gender' => $this->gender,
            'birth_date' => $this->dob,
            'avatar' => $this->avatar,
            'about' => strip_tags($this->about)
        ];
    }
}
