<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasRelationships;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, HasRelationships;

    public function genre(){
    	return $this->hasMany(Genre::class);
    }

    public function book(){
    	return $this->belongsTo(Book::class);
    }

    public function user(){
    	return $this->belongsTo(User::class);
    }
}
