<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Kelola Master Menu Makanan
        </h2>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Action Bar -->
        <div class="flex justify-between items-center mb-6">
            <p class="text-gray-500 text-sm">Daftar menu makanan, minuman, dan cemilan yang tersedia.</p>
            <a href="{{ route('foods.create') }}" class="inline-flex items-center bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm px-4 py-2.5 rounded-lg shadow-sm transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                + Tambah Menu
            </a>
        </div>

        <!-- Tabel Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-600 text-xs font-semibold uppercase tracking-wider">
                            <th class="py-3.5 px-4 text-center">Gambar</th>
                            <th class="py-3.5 px-4">Nama Menu</th>
                            <th class="py-3.5 px-4">Kategori</th>
                            <th class="py-3.5 px-4">Harga</th>
                            <th class="py-3.5 px-4">Deskripsi</th>
                            <th class="py-3.5 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse($foods as $food)
                        <tr class="hover:bg-gray-50/80 transition duration-150">
                            <td class="py-3 px-4 text-center">
                                @if($food->image)
                                    <img src="{{ asset('storage/' . $food->image) }}" class="w-14 h-14 object-cover mx-auto rounded-lg shadow-sm border border-gray-200">
                                @else
                                    <div class="w-14 h-14 bg-gray-100 rounded-lg mx-auto flex items-center justify-center text-gray-400 text-xs font-medium border border-gray-200">
                                        No Image
                                    </div>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-semibold text-gray-800">{{ $food->name }}</td>
                            <td class="py-3 px-4">
                                @if($food->category == 'Makanan')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                        {{ $food->category }}
                                    </span>
                                @elseif($food->category == 'Minuman')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $food->category }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $food->category }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 font-bold text-emerald-600 whitespace-nowrap">Rp {{ number_format($food->price, 0, ',', '.') }}</td>
                            <td class="py-3 px-4 text-gray-600 max-w-xs truncate">{{ $food->description }}</td>
                            <td class="py-3 px-4 text-center whitespace-nowrap space-x-1">
                                <a href="{{ route('foods.edit', $food->id) }}" class="inline-flex items-center px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 text-xs font-semibold rounded-md transition duration-150">
                                    Edit
                                </a>
                                <form action="{{ route('foods.destroy', $food->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 text-xs font-semibold rounded-md transition duration-150">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-400 font-medium">
                                Belum ada menu tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>