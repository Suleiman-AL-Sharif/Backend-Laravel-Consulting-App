<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Expertise extends Model
{
    use HasFactory;

    protected $fillable = [
        'user id',
        'type id',
        'details',
        'image_url',
        'name',
        'price',
        'phone_n',
        'adress'
    ];


    public function user():BelongsTo
    {

        return $this->belongsTo('users');
    }

    public function type():BelongsTo
    {

        return $this->belongsTo('types');
    }

    public function dates():HasMany
    {
        return $this->HasMany('dates');
    }

    public function favorite():HasMany
    {
        return $this->HasMany('favorites');
    }
}
