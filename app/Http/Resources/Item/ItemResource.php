<?php

namespace App\Http\Resources\Item;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "title"=>$this->title,
            "description"=> $this->description,
            "color"=> $this->color,
            "price"=> $this->price,
            "type"=> $this->type,
            "image"=> $this->image,
            "created_at"=> $this->created_at,
        ];
    }
}
