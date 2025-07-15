<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pretest;
use App\Models\Question;

class PretestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat satu pretest
        $pretest = Pretest::create([
            'title' => 'Pretest Pengetahuan Dasar',
            'description' => 'Tes ini mengukur pengetahuan dasar Anda sebelum mengikuti pelatihan.',
            'is_active' => true,
        ]);

        // Buat 10 soal untuk pretest
        $questions = [
            [
                'question_text' => 'Apa yang dimaksud dengan kewirausahaan?',
                'option_a' => 'Proses menciptakan sesuatu yang baru dan bernilai',
                'option_b' => 'Proses menjual barang',
                'option_c' => 'Proses membeli barang',
                'option_d' => 'Proses mengelola karyawan',
                'correct_answer' => 'A',
                'order' => 1,
            ],
            [
                'question_text' => 'Manakah yang bukan merupakan karakteristik seorang wirausahawan?',
                'option_a' => 'Inovatif',
                'option_b' => 'Pengambil risiko',
                'option_c' => 'Pesimis',
                'option_d' => 'Kreatif',
                'correct_answer' => 'C',
                'order' => 2,
            ],
            [
                'question_text' => 'Apa langkah pertama dalam memulai bisnis?',
                'option_a' => 'Mencari modal',
                'option_b' => 'Membuat rencana bisnis',
                'option_c' => 'Merekrut karyawan',
                'option_d' => 'Membeli aset',
                'correct_answer' => 'B',
                'order' => 3,
            ],
            [
                'question_text' => 'Apa itu analisis SWOT?',
                'option_a' => 'Analisis kekuatan, kelemahan, peluang, dan ancaman',
                'option_b' => 'Analisis penjualan, laba, biaya, dan omset',
                'option_c' => 'Analisis pasar, pesaing, pelanggan, dan produk',
                'option_d' => 'Analisis sumber daya manusia, keuangan, operasional, dan pemasaran',
                'correct_answer' => 'A',
                'order' => 4,
            ],
            [
                'question_text' => 'Mengapa inovasi penting dalam bisnis?',
                'option_a' => 'Untuk menjaga bisnis tetap relevan dan kompetitif',
                'option_b' => 'Untuk mengurangi biaya produksi',
                'option_c' => 'Untuk meningkatkan gaji karyawan',
                'option_d' => 'Untuk memperluas pasar',
                'correct_answer' => 'A',
                'order' => 5,
            ],
            [
                'question_text' => 'Apa yang dimaksud dengan target pasar?',
                'option_a' => 'Semua orang yang mungkin membeli produk',
                'option_b' => 'Kelompok pelanggan tertentu yang menjadi fokus pemasaran',
                'option_c' => 'Pesaing utama di pasar',
                'option_d' => 'Lokasi geografis bisnis',
                'correct_answer' => 'B',
                'order' => 6,
            ],
            [
                'question_text' => 'Manakah strategi pemasaran yang paling efektif untuk bisnis online?',
                'option_a' => 'Pemasaran dari mulut ke mulut',
                'option_b' => 'Pemasaran media cetak',
                'option_c' => 'Pemasaran digital',
                'option_d' => 'Pemasaran melalui pameran dagang',
                'correct_answer' => 'C',
                'order' => 7,
            ],
            [
                'question_text' => 'Apa pentingnya laporan keuangan?',
                'option_a' => 'Untuk mengetahui posisi keuangan dan kinerja bisnis',
                'option_b' => 'Untuk menghitung pajak',
                'option_c' => 'Untuk mengajukan pinjaman bank',
                'option_d' => 'Semua jawaban benar',
                'correct_answer' => 'D',
                'order' => 8,
            ],
            [
                'question_text' => 'Apa itu branding?',
                'option_a' => 'Proses membuat logo',
                'option_b' => 'Proses menciptakan identitas unik untuk bisnis',
                'option_c' => 'Proses mengiklankan produk',
                'option_d' => 'Proses menetapkan harga',
                'correct_answer' => 'B',
                'order' => 9,
            ],
            [
                'question_text' => 'Bagaimana cara mengatasi kegagalan dalam bisnis?',
                'option_a' => 'Menyerah dan mencoba hal lain',
                'option_b' => 'Belajar dari kesalahan dan mencoba lagi',
                'option_c' => 'Menyalahkan orang lain',
                'option_d' => 'Mengabaikannya dan berharap masalah hilang',
                'correct_answer' => 'B',
                'order' => 10,
            ],
        ];

        foreach ($questions as $q) {
            Question::create([
                'pretest_id' => $pretest->id,
                'question_text' => $q['question_text'],
                'option_a' => $q['option_a'],
                'option_b' => $q['option_b'],
                'option_c' => $q['option_c'],
                'option_d' => $q['option_d'],
                'correct_answer' => $q['correct_answer'],
                'order' => $q['order'],
            ]);
        }
    }
}
