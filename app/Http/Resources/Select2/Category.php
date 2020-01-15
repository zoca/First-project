<?php

namespace App\Http\Resources\Select2;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
{
    public function toArray($request)
    {
        self::wrap('results');
        
        return [
            'id' => $this->id,
            'text' => $this->name,
        ];
    }
}
