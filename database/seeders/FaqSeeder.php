<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Bagaimana cara melakukan checkout?',
                'answer' => "1. Pilih produk dan klik tombol \"Tambah ke Keranjang\".\n2. Buka halaman keranjang (ikon keranjang di menu atas).\n3. Klik tombol \"Checkout\".\n4. Lengkapi alamat pengiriman dan pilih metode pembayaran.\n5. Klik \"Konfirmasi Pesanan\" untuk menyelesaikan transaksi.",
                'order' => 1,
                'is_active' => true
            ],
            [
                'question' => 'Apakah saya bisa membatalkan pesanan setelah checkout?',
                'answer' => "Ya, Anda bisa membatalkan pesanan selama status masih \"Pending\".\n\n1. Buka halaman \"Pesanan Saya\" di akun Anda.\n2. Pilih pesanan yang ingin dibatalkan.\n3. Klik tombol \"Batalkan Pesanan\" dan konfirmasi pembatalan.",
                'order' => 2,
                'is_active' => true
            ],
            [
                'question' => 'Berapa lama waktu pengiriman produk?',
                'answer' => "Waktu pengiriman bervariasi tergantung lokasi Anda:\n\n- Jakarta dan sekitarnya: 1-3 hari kerja\n- Jawa: 3-5 hari kerja\n- Luar Jawa: 5-7 hari kerja\n\nWaktu pengiriman dihitung setelah pesanan dikonfirmasi dan dikirim oleh toko.",
                'order' => 3,
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara melacak pesanan saya?',
                'answer' => "1. Login ke akun Anda.\n2. Buka halaman \"Pesanan Saya\".\n3. Klik pada pesanan yang ingin dilacak.\n4. Lihat status pengiriman dan nomor resi (jika sudah dikirim).\n5. Klik nomor resi untuk tracking langsung di website kurir.",
                'order' => 4,
                'is_active' => true
            ],
            [
                'question' => 'Apakah semua produk bergaransi?',
                'answer' => "Ya, semua produk di IGGStore adalah 100% original dan bergaransi resmi.\n\n- Laptop & Gaming Gear: Garansi distributor/internasional 1-2 tahun\n- Aksesoris Komputer: Garansi distributor 6-12 bulan\n- Smartphone & Tablet: Garansi resmi 1 tahun\n\nDetail garansi dapat dilihat pada halaman detail produk.",
                'order' => 5,
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara mengganti password akun?',
                'answer' => "Jika lupa password:\n1. Klik \"Lupa Password\" di halaman login.\n2. Masukkan alamat email Anda.\n3. Cek email untuk link reset password.\n4. Klik link dan buat password baru.\n\nJika sudah login:\n1. Buka halaman \"Profile\".\n2. Klik \"Ubah Password\".\n3. Masukkan password lama dan password baru.",
                'order' => 6,
                'is_active' => true
            ],
            [
                'question' => 'Apakah data pribadi saya aman?',
                'answer' => "Ya, keamanan data Anda adalah prioritas kami.\n\n- Semua data dienkripsi dengan SSL/TLS\n- Kami tidak membagikan data Anda ke pihak ketiga\n- Password disimpan dengan enkripsi hash yang aman\n- Transaksi pembayaran menggunakan gateway terpercaya\n\nKami patuh terhadap standar keamanan data internasional.",
                'order' => 7,
                'is_active' => true
            ],
            [
                'question' => 'Bagaimana cara memberikan review produk?',
                'answer' => "Anda bisa memberikan review setelah pesanan selesai:\n\n1. Buka halaman \"Pesanan Saya\".\n2. Pilih pesanan dengan status \"Completed\".\n3. Klik tombol \"Beri Review\" (hijau dengan icon bintang).\n4. Pilih produk yang ingin direview.\n5. Berikan rating 1-5 bintang.\n6. Tulis komentar pengalaman Anda.\n7. Klik \"Kirim Review\".\n\nReview Anda akan tampil di halaman produk dan membantu pembeli lain!",
                'order' => 8,
                'is_active' => true
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
