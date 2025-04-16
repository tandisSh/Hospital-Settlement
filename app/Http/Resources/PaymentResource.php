<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   // app/Http/Resources/PaymentResource.php



public function toArray(Request $request): array
{
    return [
        'id'        => $this->id,
        'amount'    => $this->amount,
        'pay_type'  => $this->pay_type,
        'date'      => $this->date ? Jalalian::fromDateTime($this->date)->format('Y/m/d H:i') : null,
        'invoice_id'=> $this->invoice_id,
    ];
}

}
