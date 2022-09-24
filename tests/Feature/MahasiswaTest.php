<?php

namespace Tests\Feature;

use App\Models\Mahasiswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MahasiswaTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_list_mahasiswa_has_no_data()
    {
        //user buka halaman mahasiswa
        $response = $this->get('/mahasiswa');
        //pastikan halamannya bisa dibuka
        $response->assertStatus(200);
        //cek header table
        $response->assertSeeText("Nim");
        $response->assertSeeText("Nama");
        $response->assertSeeText("Kelas");
        $response->assertSeeText("Jurusan");
        $response->assertSeeText("Action");
    }

    public function test_list_mahasiswa_has_one_data()
    {
        //setup 
        // Isi dulu satu data
        Mahasiswa::create([
            'Nim' => '2041720093',
            'Nama' => 'Rayhan Supaja',
            'Kelas' => 'MI 2G',
            'Jurusan' => 'Teknologi Informasi',
        ]);
        //do something
        //user buka halaman list mahasiswa
        $response = $this->get('/mahasiswa');
        //pastikan halamannya bisa dibuka
        $response->assertStatus(200);
        //cek header table
        $response->assertSeeText("Nim");
        $response->assertSeeText("Nama");
        $response->assertSeeText("Kelas");
        $response->assertSeeText("Jurusan");
        $response->assertSeeText("Action");
        //cek tampil keterangan tabel sudah terisi 
        $response->assertSeeText("2041720093");
        $response->assertSeeText("Rayhan Supaja");
        $response->assertSeeText("MI 2G");
        $response->assertSeeText("Teknologi Informasi");
        $response->assertSeeText("Delete");
    }

    public function test_create_mahasiswa_test()
    {
        //buka halaman /mahasiswa/create
        $response = $this->get('/mahasiswa/create');
        //pastikan halamannya bisa dibuka
        $response->assertStatus(200);
        $response->assertSeeText("Tambah Mahasiswa");
        //ada input nim tampil
        $response->assertSeeText("Nim");
        //ada input nama tampil
        $response->assertSeeText("Nama");
        //ada input kelas tampil
        $response->assertSeeText("Kelas");
        //ada input jurusan tampil
        $response->assertSeeText("Jurusan");
        //ada tombol submit
        $response->assertSeeText("Submit");
    }

    public function test_create_mahasiswa_with_data()
    {
        $this->assertTrue(true);
        //tambahkan post ke /create
        Mahasiswa::create([
                    'Nim' => 2041720093,
                    'Nama' => 'Rayhan Supaja',
                    'Kelas' => 'MI 2G',
                    'Jurusan' => 'Teknologi Informasi',
        ]);
        $response = $this->get('/mahasiswa/create');
        $response->assertStatus(200);
    }

    public function test_nim_is_required()
    {
        //buka halaman /mahasiswa/create
        $response = $this->post('/mahasiswa', [
            'Nim' => '',
            'Nama' => 'Rayhan Supaja',
            'Kelas' => 'MI 2G',
            'Jurusan' => 'Teknologi Informasi',
        ]);
        //pastikan halamannya bisa dibuka
        $response->assertStatus(302);
        $response->assertInvalid([
            'Nim' => 'The nim field is required.',
        ]);
    }

    public function test_nama_is_required()
    {
        //buka halaman /mahasiswa/create
        $response = $this->post('/mahasiswa', [
            'Nim' => 2041720093,
            'Nama' => '',
            'Kelas' => 'MI 2G',
            'Jurusan' => 'Teknologi Informasi',
        ]);
        //pastikan halamannya bisa dibuka
        $response->assertStatus(302);
        $response->assertInvalid([
            'Nama' => 'The nama field is required.',
        ]);
    }

    public function test_kelas_is_required()
    {
        //buka halaman /mahasiswa/create
        $response = $this->post('/mahasiswa', [
            'Nim' => 2041720093,
            'Nama' => 'Rayhan Supaja',
            'Kelas' => '',
            'Jurusan' => 'Teknologi Informasi',
        ]);
        //pastikan halamannya bisa dibuka
        $response->assertStatus(302);
        $response->assertInvalid([
            'Kelas' => 'The kelas field is required.',
        ]);
    }

    public function test_jurusan_is_required()
    {
        //buka halaman /mahasiswa/create
        $response = $this->post('/mahasiswa', [
            'Nim' => 2041720093,
            'Nama' => 'Rayhan Supaja',
            'Kelas' => 'MI 2G',
            'Jurusan' => '',
        ]);
        //pastikan halamannya bisa dibuka
        $response->assertStatus(302);
        $response->assertInvalid([
            'Jurusan' => 'The jurusan field is required.',
        ]);
    }

    public function test_all_input_is_required()
    {
        //buka halaman /mahasiswa/create
        $response = $this->post('/mahasiswa', [
            'Nim' => '',
            'Nama' => '',
            'Kelas' => '',
            'Jurusan' => '',
        ]);
        //pastikan halamannya bisa dibuka
        $response->assertStatus(302);
        $response->assertInvalid([
            'Nim' => 'The nim field is required.',
            'Nama' => 'The nama field is required.',
            'Kelas' => 'The kelas field is required.',
            'Jurusan' => 'The jurusan field is required.',
        ]);
    }

    public function test_edit_existing_mahasiswa()
    {
        $this->assertTrue(true);
        // generate 1 data post
        $Mahasiswa = Mahasiswa::create([
            'Nim' => 2041720093,
            'Nama' => 'Rayhan Supaja',
            'Kelas' => 'MI 2G',
            'Jurusan' => 'Teknologi Informasi',
        ]);

        $response = $this->get('/mahasiswa/2041720093/edit');
        $response->assertStatus(200);
        Mahasiswa::where('Nama', 'Rayhan Supaja')->update(['Nama' => 'Isma Fitria Risnandari']);

        $response = $this->get('/mahasiswa');

        $response->assertSeeText('Isma Fitria Risnandari');
    }

    public function test_delete_mahasiswa()
    {
        $response = $this->get('/mahasiswa');
        $response->assertStatus(200);
        $response = Mahasiswa::where('Nim', '2041720093')->delete();
        $response = $this->get('/mahasiswa');
        $response->assertDontSeeText('2041720093');
    }

    public function test_pagination()
    {
        //setup
        $this->seed();

        //action
        $response = $this->get('/mahasiswa');

        //assert
        $response->assertStatus(200);

        $response = $this->get('mahasiswa?page=2');
        $response->assertStatus(200);

        $response = $this->get('mahasiswa?page=3');
        $response->assertStatus(200);
    }
}
