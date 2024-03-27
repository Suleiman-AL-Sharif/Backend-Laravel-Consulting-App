<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Date extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'time',
        'available',
        'user_id',
        'expertises_id'
    ];

    public function users():BelongsTo
    {

        return $this->belongsTo('users');
    }

    public function expertises():BelongsTo
    {

        return $this->belongsTo('expertises');
    }


}
