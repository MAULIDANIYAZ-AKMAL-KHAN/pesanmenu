<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        // Halaman pelanggan membutuhkan seluruh menu yang tersedia untuk dipilih.
        $foods = Food::all();
        return view('customer.index', compact('foods'));
    }

    /**
     * Menyimpan pesanan customer beserta detail item dalam satu transaksi database.
     */
    public function store(Request $request)
    {
        // Validasi identitas pelanggan, meja, dan jumlah setiap menu.
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'table_number'  => 'required|integer|min:1',
            'items'          => 'required|array',
            'items.*'        => 'nullable|integer|min:0',
        ]);

        // Abaikan menu yang jumlah pesanannya nol.
        $orderedItems = array_filter($request->items, fn ($qty) => $qty > 0);

        if (empty($orderedItems)) {
            return back()->with('error', 'Pilih minimal satu menu makanan!');
        }

        // Simpan pesanan dan detailnya sebagai satu transaksi agar data tetap konsisten.
        $order = DB::transaction(function () use ($request, $orderedItems) {
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'table_number'  => $request->table_number,
                'total_price'   => 0,
                'status'        => 'pending',
            ]);

            $totalPrice = 0;

            foreach ($orderedItems as $foodId => $quantity) {
                // Ambil harga terbaru dari database, lalu hitung subtotal item.
                $food = Food::findOrFail($foodId);
                $subtotal = $food->price * $quantity;
                $totalPrice += $subtotal;

                OrderDetail::create([
                    'order_id' => $order->id,
                    'food_id'  => $food->id,
                    'quantity' => $quantity,
                    'subtotal' => $subtotal,
                ]);
            }

            // Setelah semua detail tersimpan, tetapkan total pesanan.
            $order->update(['total_price' => $totalPrice]);

            return $order;
        });

        return redirect()->route('customer.index')->with('success', 'Pesanan berhasil dibuat! Nomor Meja: ' . $order->table_number);
    }

    /**
     * Menampilkan rekap pesanan untuk admin.
     */
    public function adminDashboard()
    {
        // Muat detail dan menu terkait sekaligus untuk mencegah query berulang.
        $orders = Order::with('orderDetails.food')->latest()->get();
        return view('dashboard', compact('orders'));
    }

    /**
     * Memperbarui status pesanan dari kontrol admin.
     */
    public function updateStatus(Request $request, $id)
    {
        // Admin hanya boleh mengubah status ke nilai yang telah ditentukan.
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan #' . $order->id . ' berhasil diperbarui!');
    }
}