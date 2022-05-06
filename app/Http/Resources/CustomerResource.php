<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "firstname" => $this->firstname,
            "lastname" => $this->lastname,
            "title" => $this->title,
            "email" => $this->email,
            "gender" => $this->gender,
            "company" => $this->company,
            "city" => $this->city,
            "longitude" => $this->longitude,
            "latitude" => $this->latitude,
        ];
    }
}
