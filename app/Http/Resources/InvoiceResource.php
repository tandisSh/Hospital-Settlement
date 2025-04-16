<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Morilog\Jalali\Jalalian;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */


     public function toArray($request)
     {
         $paidAmount = $this->payments->sum('amount');
         $total = $this->amount ?? 0;

         $remaining = max(0, $total - $paidAmount);

         return [
             'id' => $this->id,
             'total_amount' => $total,
             'paid_amount' => $paidAmount,
             'remaining_amount' => $remaining,
             'created_at' => $this->created_at->format('Y/m/d'),
         ];
     }


}
