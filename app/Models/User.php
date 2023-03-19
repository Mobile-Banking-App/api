<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Model
{
    use UUID, HasFactory;


     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'fullname',
        'username',
        'account_number',
        'bvn',
        'passcode',
        'transaction_pin',
        'duress_pin',
        'wallet_balance',
        'safe_balance'
    ];



    public function profile()
    {
        return $this->morphOne(\App\Models\Profile::class, 'profileable');
    }

    /**
     * Get all of the transactions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(\App\Models\Transaction::class, 'user_id', 'id');
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

    /**
     * Get the card associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function card(): HasOne
    {
        return $this->hasOne(\App\Models\Card::class, 'user_id', 'id');
    }

}
