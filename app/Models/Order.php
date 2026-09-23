<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Izinkan pembuatan data pengujian menggunakan factory Laravel.
    use HasFactory;

    // Kolom id dikelola database dan tidak boleh diisi dari request.
    protected $guarded = ['id'];

    // Satu pesanan dapat memiliki banyak detail item menu.
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
}
