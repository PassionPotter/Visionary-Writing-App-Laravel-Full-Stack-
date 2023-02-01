<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class UserResource extends JsonResource
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
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->profile->gender,
            'birth_date' => $this->profile->dob,
            'avatar' => $this->profile->avatar,
            'views' => $views,
            'about' => strip_tags($this->profile->about),
            'is_admin' => $this->admin == 1 ? true : false,
            'is_verified' => $this->verified == 1 ? true : false,
            'is_author' => $this->active == 1 ? true : false,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}