<?php

namespace App\Http\Controllers;

use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodController extends Controller
{
    // Controller ini mengelola seluruh proses CRUD menu makanan untuk admin.
    public function index()
    {
        // Ambil menu terbaru dan bagi menjadi beberapa halaman agar daftar tetap ringan.
        $foods = Food::latest()->paginate(10);
        return view('admin.foods.index', compact('foods'));
    }

    public function create()
    {
        // Tampilkan formulir untuk membuat menu baru.
        return view('admin.foods.create');
    }

    public function store(Request $request)
    {
        // Pastikan data menu memenuhi aturan sebelum disimpan.
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman,Cemilan',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            // Simpan gambar ke disk public dan simpan hanya lokasi filenya di database.
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Buat record menu menggunakan data yang sudah divalidasi.
        Food::create([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil ditambahkan!');
    }

    public function edit(Food $food)
    {
        // Tampilkan formulir edit dengan menu yang ditemukan oleh route model binding.
        return view('admin.foods.edit', compact('food'));
    }

    public function update(Request $request, Food $food)
    {
        // Gunakan aturan yang sama saat admin memperbarui menu.
        $request->validate([
            'name'        => 'required|string|max:255',
            'category'    => 'required|in:Makanan,Minuman,Cemilan',
            'price'       => 'required|numeric|min:0',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $food->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama agar file yang tidak terpakai tidak menumpuk.
            if ($food->image && Storage::disk('public')->exists($food->image)) {
                Storage::disk('public')->delete($food->image);
            }
            $imagePath = $request->file('image')->store('foods', 'public');
        }

        // Pertahankan gambar lama jika admin tidak mengunggah gambar baru.
        $food->update([
            'name'        => $request->name,
            'category'    => $request->category,
            'price'       => $request->price,
            'description' => $request->description,
            'image'       => $imagePath,
        ]);

        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil diperbarui!');
    }

    public function destroy(Food $food)
    {
        // Hapus file gambar sebelum menghapus data menu dari database.
        if ($food->image && Storage::disk('public')->exists($food->image)) {
            Storage::disk('public')->delete($food->image);
        }
        $food->delete();

        return redirect()->route('foods.index')->with('success', 'Data makanan berhasil dihapus!');
    }
}