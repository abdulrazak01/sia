<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = ['program_paket_id', 'nama_kelas', 'tingkat', 'is_aktif'];

    public function programPaket()
    {
        return $this->belongsTo(ProgramPaket::class, 'program_paket_id');
    }

    public function responses()
    {
        return $this->hasMany(ResponsesPendaftaran::class, 'kelas_id');
    }
}