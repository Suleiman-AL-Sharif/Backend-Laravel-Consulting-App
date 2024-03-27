<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expertise_id'
    ];

    public function user():BelongsTo
    {

        return $this->belongsTo('users');
    }

    public function expertise():BelongsTo
    {

        return $this->belongsTo('expertises');
    }
}
