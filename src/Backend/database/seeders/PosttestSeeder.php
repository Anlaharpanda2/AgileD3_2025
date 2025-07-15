<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Posttest;
use App\Models\PosttestQuestion;

class PosttestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Buat satu posttest
        $posttest = Posttest::create([
            'title' => 'Posttest Pengetahuan Lanjutan',
            'description' => 'Tes ini mengukur pemahaman Anda setelah mengikuti pelatihan.',
            'is_active' => true,
        ]);

        // Buat 10 soal untuk posttest
        $questions = [
            [
                'question_text' => 'Apa perbedaan utama antara ide bisnis dan peluang bisnis?',
                'option_a' => 'Ide bisnis adalah konsep, peluang bisnis adalah ide yang telah divalidasi',
                'option_b' => 'Tidak ada perbedaan',
                'option_c' => 'Peluang bisnis selalu menghasilkan keuntungan, ide bisnis tidak',
                'option_d' => 'Ide bisnis lebih mudah ditemukan daripada peluang bisnis',
                'correct_answer' => 'A',
                'order' => 1,
            ],
            [
                'question_text' => 'Apa itu Unique Selling Proposition (USP)?',
                'option_a' => 'Harga jual produk',
                'option_b' => 'Fitur unik yang membedakan produk dari pesaing',
                'option_c' => 'Strategi pemasaran yang digunakan',
                'option_d' => 'Target pasar utama',
                'correct_answer' => 'B',
                'order' => 2,
            ],
            [
                'question_text' => 'Manakah yang termasuk dalam modal intelektual?',
                'option_a' => 'Uang tunai',
                'option_b' => 'Peralatan kantor',
                'option_c' => 'Paten dan merek dagang',
                'option_d' => 'Gedung dan tanah',
                'correct_answer' => 'C',
                'order' => 3,
            ],
            [
                'question_text' => 'Apa tujuan dari riset pasar?',
                'option_a' => 'Memahami kebutuhan dan keinginan pelanggan',
                'option_b' => 'Menganalisis kekuatan dan kelemahan pesaing',
                'option_c' => 'Mengidentifikasi tren pasar',
                'option_d' => 'Semua jawaban benar',
                'correct_answer' => 'D',
                'order' => 4,
            ],
            [
                'question_text' => 'Apa itu Business Model Canvas?',
                'option_a' => 'Sebuah dokumen rencana bisnis yang detail',
                'option_b' => 'Sebuah alat visual untuk mengembangkan atau mendokumentasikan model bisnis',
                'option_c' => 'Sebuah laporan keuangan tahunan',
                'option_d' => 'Sebuah strategi pemasaran',
                'correct_answer' => 'B',
                'order' => 5,
            ],
            [
                'question_text' => 'Mengapa manajemen arus kas penting bagi bisnis?',
                'option_a' => 'Untuk memastikan bisnis memiliki cukup uang untuk membayar tagihan',
                'option_b' => 'Untuk memaksimalkan keuntungan',
                'option_c' => 'Untuk meminimalkan pajak',
                'option_d' => 'Untuk menarik investor',
                'correct_answer' => 'A',
                'order' => 6,
            ],
            [
                'question_text' => 'Apa yang dimaksud dengan skala bisnis (scaling up)?',
                'option_a' => 'Meningkatkan ukuran bisnis secara signifikan',
                'option_b' => 'Membuka cabang baru',
                'option_c' => 'Menambah jumlah karyawan',
                'option_d' => 'Meningkatkan pendapatan tanpa meningkatkan biaya secara proporsional',
                'correct_answer' => 'D',
                'order' => 7,
            ],
            [
                'question_text' => 'Manakah yang merupakan contoh dari model bisnis berlangganan (subscription)?',
                'option_a' => 'Membeli kopi di kafe',
                'option_b' => 'Menonton film di bioskop',
                'option_c' => 'Berlangganan layanan streaming musik',
                'option_d' => 'Membeli pakaian di toko',
                'correct_answer' => 'C',
                'order' => 8,
            ],
            [
                'question_text' => 'Apa pentingnya membangun jaringan (networking) bagi wirausahawan?',
                'option_a' => 'Mendapatkan teman baru',
                'option_b' => 'Mendapatkan akses ke sumber daya, informasi, dan peluang baru',
                'option_c' => 'Menjual lebih banyak produk',
                'option_d' => 'Mendapatkan diskon dari pemasok',
                'correct_answer' => 'B',
                'order' => 9,
            ],
            [
                'question_text' => 'Apa yang harus dilakukan jika model bisnis awal tidak berhasil?',
                'option_a' => 'Segera menutup bisnis',
                'option_b' => 'Terus menjalankan model yang sama dan berharap yang terbaik',
                'option_c' => 'Melakukan pivot atau mengubah model bisnis berdasarkan umpan balik pasar',
                'option_d' => 'Menyalahkan kondisi ekonomi',
                'correct_answer' => 'C',
                'order' => 10,
            ],
        ];

        foreach ($questions as $q) {
            PosttestQuestion::create([
                'posttest_id' => $posttest->id,
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
