<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    // Factory membantu pembuatan detail pesanan untuk pengujian.
    use HasFactory;

    // Detail pesanan disimpan pada tabel khusus dan id tetap dilindungi.
    protected $table = 'order_details';
    protected $guarded = ['id'];

    public function food()
    {
        // Setiap detail mengacu pada satu menu makanan.
        return $this->belongsTo(Food::class, 'food_id');
    }

    public function order()
    {
        // Setiap detail merupakan bagian dari satu pesanan.
        return $this->belongsTo(Order::class, 'order_id');
    }
}