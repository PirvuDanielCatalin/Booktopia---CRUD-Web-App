<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'increment', 'status'
    ];

    // Requirement(FK) M - 1 User
    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    // Requirement(FK) M - 1 Book
    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }
}
