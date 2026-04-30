<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ProgramPaket extends Model
{
    protected $table = 'program_paket';
    protected $primaryKey = 'id';
    public $timestamps = true; // menggunakan created_at

    protected $fillable = ['nama_program', 'jenjang_setara', 'is_aktif'];

    // Relasi
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'program_paket_id');
    }

    public function responses()
    {
        return $this->hasMany(ResponsesPendaftaran::class, 'program_paket_id');
    }
}