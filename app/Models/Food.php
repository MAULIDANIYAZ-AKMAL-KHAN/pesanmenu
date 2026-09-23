<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
   // Aktifkan factory agar model dapat digunakan dalam pengujian atau data awal.
   use HasFactory;

   // Tentukan tabel menu dan lindungi kolom id dari mass assignment.
   protected $table = 'foods';
   protected $guarded = ['id'];
}
