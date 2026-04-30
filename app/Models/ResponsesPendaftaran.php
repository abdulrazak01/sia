<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResponsesPendaftaran extends Model
{
    protected $table = 'responses_pendaftaran';
    protected $primaryKey = 'id';
    
    // ✅ Timestamp mapping
    const CREATED_AT = 'submitted_at';
    const UPDATED_AT = 'updated_at';
    public $timestamps = true;
    

    protected $fillable = [
        'submitted_at',  // ← PENTING: Tambahkan ini!
        'nama_lengkap',
        'tanggal_lahir',
        'tempat_lahir',
        'jenis_kelamin',
        'agama',
        'nisn',
        'alumni_sekolah',
        'tahun_tamat',
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'tinggal_bersama',
        'transportasi_sehari_hari',
        'program_paket_id',
        'kelas_id',
        'nik',
        'nama_ibu_kandung',
        'nik_ibu_kandung',
        'pekerjaan_ibu',
        'penghasilan_ibu',
        'pendidikan_ibu',
        'nama_ayah_kandung',
        'nik_ayah_kandung',
        'pekerjaan_ayah',
        'penghasilan_ayah',
        'pendidikan_ayah',
        'no_handphone',
        'email',
        'orang_dikenal_pkbm',
        'tanggal_daftar',
        'file_akte_lahir',
        'file_ktp',
        'file_kartu_keluarga',
        'file_ijazah_terakhir',
        'file_raport',
        'file_pas_foto',
    ];

    public function programPaket()
    {
        return $this->belongsTo(ProgramPaket::class, 'program_paket_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}