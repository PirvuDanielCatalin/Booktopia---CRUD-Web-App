<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'value'
    ];

    // Offer(FK) 1 - 1 Book
    public function book()
    {
        return $this->belongsTo('App\Models\Book');
    }
}
