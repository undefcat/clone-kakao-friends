<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PublicFileResource extends JsonResource
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
            'id' => $this->id,
            'size' => $this->size,
            'mimeType' => join('/', [$this->mime_type, $this->mime_subtype]),
            'name' => $this->original_name,
            'url' => Storage::disk('public')->url($this->path),
        ];
    }
}
