<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'name' => $this->name ,
            'type' => $this->type ,
            'email' => $this->email ,
            'address' => $this->address ,
            'city' => $this->city ,
            'state' => $this->state ,
            'postalcode' => $this->postalcode ,
            'invoices' => InvoiceResource::collection($this->whenLoaded('invoices')),
        ];
    }
}
