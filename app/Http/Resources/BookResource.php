<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use function App\Helpers\formatDate;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'         => $this->title,
            'description'   => $this->description,
            'rate'          => $this->rate,
            'publish_date'  => formatDate($this->publish_date),
            'copies_number' => $this->copies_number,
            'available'     => $this->available,
            'authors'       => AuthorResource::collection($this->authors)
        ];
    }
}
