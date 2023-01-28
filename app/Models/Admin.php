<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UUID;


class Admin extends Model
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
    ];



    public function profile()
    {
        return $this->morphOne(\App\Models\Profile::class, 'profileable');
    }
}
