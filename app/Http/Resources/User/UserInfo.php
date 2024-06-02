<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
                'username' => $this->username,
                'exp' => $this->exp,
                'coins' => $this->coins,
                'is_admin' =>$this->is_admin,
                'online_status'=>$this->online_status,
                'created_at' => $this->created_at,
                'cover_photo'=> $this->cover_photo,
        ];
    }
}
