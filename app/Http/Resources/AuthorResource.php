<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class AuthorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $views = DB::table("authors_view_count")
        ->where("user_id", $this->id)->count();
        return 
        [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->profile->gender,
            'birth_date' => $this->profile->dob,
            'avatar' => $this->profile->avatar,
            'views' => $views,
            'about' => strip_tags($this->profile->about)
        ];
    }
}
