<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    use HasFactory;

    protected $table = 'actors';

    protected $fillable = ['name', 'birthdate', 'nationality'];

    public function films()
    {
        return $this->belongsToMany(Film::class);
    }
}
