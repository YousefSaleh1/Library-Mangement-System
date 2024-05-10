<?php

namespace App\Http\Resources;

use App\Http\Traits\GetReviewItemTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    use GetReviewItemTrait;
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'     => $this->id,
            'review' => $this->review,
            'rate'   => $this->rate,
            'item'   => $this->getItem($this->reviewable_type, $this->reviewable_id),
        ];
    }
}
