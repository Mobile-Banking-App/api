<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    /**
     * Get the user that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get all of the otps for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function otps(): HasMany
    {
        return $this->hasMany(\App\Models\Otp::class, 'user_id', 'id');
    }

}
