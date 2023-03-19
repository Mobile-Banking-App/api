<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Otp extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'id',
        'user_id',
        'transaction_id',
        'code'
    ];

    /**
     * Get the user that owns the Otp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Model\User::class, 'user_id');
    }

    /**
     * Get the transaction that owns the Otp
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(\App\Model\Transaction::class, 'transaction_id');
    }
}
