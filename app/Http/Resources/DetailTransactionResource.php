<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'  => $this->id,
            'book' => $this->book->book_name,
            'qty' => $this->detail_transaction_qty,
            'return_date' => $this->detail_transaction_return_date,
            'actual_return_date' => $this->detail_transaction_actual_return_date,
            'fine_days' => $this->detail_transaction_fine_days,
            'fine' => $this->detail_transaction_fine
        ];
    }
}
