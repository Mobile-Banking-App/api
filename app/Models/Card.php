<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UUID;

class Card extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'id',
        'user_id',
        'card_number',
        'cvv',
        'expiry_date',
        'card_type',
        'card_pin',
        'duress_pin',
    ];


    /**
     * Get the user that owns the Card
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }


}
