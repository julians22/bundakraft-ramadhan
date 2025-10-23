<?php

namespace App\Http\Resources\Campaign;

use App\Http\Resources\TagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class MenuAlfamart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $people = null;
        $time = null;
        $porsi = null;

        foreach ($this->tags as $tag) {

            if (Str::afterLast($tag->slug, '-') === 'menit') {
                $time = new TagResource($tag);
            }

            if (Str::afterLast($tag->slug, '-') === 'orang') {
                $people = new TagResource($tag);
            }
            if (Str::afterLast($tag->slug, '-') === 'porsi') {
                $porsi = new TagResource($tag);
            }
        }

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'ingredients' => $this->ingredients,
            'instruction' => $this->instruction,
            'status' => $this->status,
            'moment' => $this->moment,
            'tags' => [
                'orang' => $porsi,
                'time' => $time
            ],
            'is_award' => $this->is_award ?? 0,
            'creation_date' => $this->created_at,
            'media' => $this->getFirstMedia('recipes'),
            'video_url' => $this->video_url
        ];
    }
}
