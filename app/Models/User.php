<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'wallet_balance'
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
}
