// Muat konfigurasi JavaScript dasar Laravel dan koneksi AJAX.
import './bootstrap';

// Alpine menangani interaksi ringan pada komponen Blade.
import Alpine from 'alpinejs';

// Ekspor Alpine ke window agar dapat dipakai dari template.
window.Alpine = Alpine;

// Aktifkan listener dan komponen Alpine setelah aplikasi dimuat.
Alpine.start();
