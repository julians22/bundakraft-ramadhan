<?php

namespace App\Http\Resources\Campaign;

use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuAlfamart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'ingredients' => $this->ingredients,
            'instruction' => $this->instruction,
            'status' => $this->status,
            'moment' => $this->moment,
            'tags' => TagResource::collection($this->tags),
            'creation_date' => $this->created_at,
            'media' => $this->getFirstMedia('recipes')
        ];
    }
}
