<?php

namespace App\Http\Resources;

use App\Interfaces\DropdownModel;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin DropdownModel */
class DropdownResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'value' => $this->getDropdownValue(),
            'text' => $this->getDropdownText(),
        ];
    }
}
