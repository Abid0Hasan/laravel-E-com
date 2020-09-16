<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResouce extends JsonResource
{

    public function toArray($request)
    {
        return [
            'category_name' => $this->category_name,
            'category_description' => $this->category_description,
            'publication_status' => $this->publication_status,


            'href' => [
                'products' => route('products.index',$this->id)
            ]
        ];
    }
}
