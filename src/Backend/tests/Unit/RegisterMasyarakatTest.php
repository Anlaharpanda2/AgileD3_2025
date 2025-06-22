<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterMasyarakatTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function gagal_register_jika_field_kosong()
    {
        $response = $this->postJson('/api/daftar/masyarakat', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nama', 'nik', 'tempat_tanggal_lahir']);
    }

    #[Test]
    public function sukses_register_dengan_data_valid()
    {
        $response = $this->postJson('/api/daftar/masyarakat', [
            'nama' => 'Rani',
            'nik' => '1234567890',
            'tempat_tanggal_lahir' => 'Padang, 1 Januari 2000',
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'message' => 'Registrasi berhasil',
                 ]);
    }
}
