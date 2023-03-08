<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;

class Transaction extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        "id",
        "reference_id",
        "account_name",
        "account_number",
        "bank_name",
        "amount",
        "status"
    ];


}
