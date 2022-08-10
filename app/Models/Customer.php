<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function purchaseTransactions()
    {
        return $this->hasMany(PurchaseTransaction::class);
    }
}
