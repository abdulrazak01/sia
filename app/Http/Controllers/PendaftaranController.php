<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\ProgramPaket;
use App\Models\ResponsesPendaftaran;

class PendaftaranController extends Controller
{
    /**
     * Tampilkan form pendaftaran
     */
    public function create()
    {
        return view('pendaftaran.form');
    }

    /**
     * Proses submit form pendaftaran
     */
public function store(Request $request)
{
    // === LOG 0: Konfirmasi request masuk ===

    // === LOG 1: Validasi ===
    try {
        $validated = $request->validate([
            // Data Pribadi
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date|before:today',
            'jenis_kelamin' => ['required', Rule::in(['pria', 'wanita'])],
            'agama' => ['required', Rule::in(['Islam', 'Katholik', 'Protestan', 'Budha', 'Hindu', 'Konghucu'])],
            'agama_lain' => 'nullable|string|max:50|required_if:agama,Yang lain',
            'nisn' => 'nullable|numeric|digits_between:10,10',
            'no_kk' => 'required|numeric|digits:16',
            
            // Pendidikan
            'alumni_sekolah' => 'required|string|max:255',
            'tahun_tamat' => 'required|integer|min:1990|max:' . date('Y'),
            'program_paket' => ['required', Rule::in(['paket_a', 'paket_b', 'paket_c'])],
            
            // Alamat
            'alamat' => 'required|string|max:500',
            'kelurahan' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'tinggal_bersama' => ['required', Rule::in(['orang_tua', 'sendiri', 'kontrakan'])],
            'tinggal_lain' => 'nullable|string|max:50|required_if:tinggal_bersama,Yang lain',
            'transportasi' => ['required', Rule::in(['motor', 'angkot', 'mobil', 'jalan_kaki'])],
            
            // Data Ibu
            'nama_ibu' => 'required|string|max:255',
            'nik_ibu' => 'required|numeric|digits:16',
            'pekerjaan_ibu' => 'required|string|max:100',
            'penghasilan_ibu' => ['required', Rule::in(['0-500rb', '500rb-1jt', '1jt-2jt', '2jt-4jt', '>4jt'])],
            'pendidikan_ibu' => ['required', Rule::in(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'])],
            
            // Data Ayah
            'nama_ayah' => 'required|string|max:255',
            'nik_ayah' => 'required|numeric|digits:16',
            'pekerjaan_ayah' => 'required|string|max:100',
            'penghasilan_ayah' => ['required', Rule::in(['0-500rb', '500rb-1jt', '1jt-2jt', '2jt-4jt', '>4jt'])],
            'pendidikan_ayah' => ['required', Rule::in(['Tidak Sekolah', 'SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'])],
            
            // Kontak
            'no_hp' => ['required', 'array', 'min:2'],
            'no_hp.0' => 'required|string|max:20',  // Nomor 1 wajib
            'no_hp.1' => 'required|string|max:20',  // Nomor 2 wajib
            'no_hp.2' => 'nullable|string|max:20',  // Nomor 3 opsional
            'no_hp.3' => 'nullable|string|max:20',
            'email' => 'required|email|max:255',
            'nama_pengenal' => 'required|string|max:255',
            'tanggal_daftar' => 'required|date',
            
            // Upload Dokumen
            'akta_lahir' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'kartu_keluarga' => 'required|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'raport' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240',
            'pas_foto' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
        ], [
            'no_kk.digits' => 'NIK harus 16 digit angka.',
            'nik_ibu.digits' => 'NIK Ibu harus 16 digit.',
            'nik_ayah.digits' => 'NIK Ayah harus 16 digit.',
            'nisn.digits_between' => 'NISN harus 10 digit angka.',
            'akta_lahir.max' => 'Ukuran file maksimal 10 MB.',
            'no_hp.min' => 'Minimal 2 nomor handphone harus diisi.',
        ]);
        Log::info('✅ Validasi BERHASIL', ['fields' => count($validated)]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        Log::error('❌ Validasi GAGAL', ['errors' => $e->errors()]);
        
        if ($request->ajax()) {
            return response()->json(['success' => false, 'errors' => $e->errors()], 422);
        }
        throw $e;
    }

    // === LOG 2: Mapping Program Paket ===
    $programId = \App\Models\ProgramPaket::where('nama_program', 'like', 'Paket A%')->value('id');
    Log::info('🔄 Mapping Program', [
        'input' => $validated['program_paket'],
        'query_result' => $programId,
        'available' => \App\Models\ProgramPaket::pluck('nama_program', 'id')->toArray(),
    ]);
    
    if (!$programId) {
        Log::error('❌ Program ID tidak ditemukan!');
        throw new \Exception("Program paket tidak ditemukan di database");
    }

    // === LOG 3: Upload File (minimal akta_lahir) ===
    $filePathAkta = null;
    if ($request->hasFile('akta_lahir') && $request->file('akta_lahir')->isValid()) {
        try {
            $filePath = $request->file('akta_lahir')->store('uploads/pendaftaran', 'public');
            Log::info('✅ File uploaded', ['path' => $filePath]);
        } catch (\Exception $e) {
            Log::error('❌ File upload error', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    // === LOG 4: Insert Database ===
    try {
        Log::info('🗄️ Memulai insert ke DB');
        
        $uploadPaths = [];
            $files = [
                'akta_lahir' => 'file_akte_lahir',
                'ktp' => 'file_ktp',
                'kartu_keluarga' => 'file_kartu_keluarga',
                'ijazah' => 'file_ijazah_terakhir',
                'raport' => 'file_raport',
                'pas_foto' => 'file_pas_foto',
            ];

            foreach ($files as $formField => $dbColumn) {
                if ($request->hasFile($formField) && $request->file($formField)->isValid()) {
                    $path = $request->file($formField)->store('uploads/pendaftaran', 'public');
                    $uploadPaths[$dbColumn] = $path;
                }
            }

            // 3. MAPPING PROGRAM PAKET (DINAMIS)
            $programId = null;
            if ($validated['program_paket'] === 'paket_a') {
                $programId = ProgramPaket::where('nama_program', 'like', 'Paket A%')->value('id');
            } elseif ($validated['program_paket'] === 'paket_b') {
                $programId = ProgramPaket::where('nama_program', 'like', 'Paket B%')->value('id');
            } elseif ($validated['program_paket'] === 'paket_c') {
                $programId = ProgramPaket::where('nama_program', 'like', 'Paket C%')->value('id');
            }
            
            if (!$programId) {
                throw new \Exception("Program paket '{$validated['program_paket']}' tidak ditemukan");
            }

            // 4. MAPPING ENUM & NILAI LAINNYA
            $maps = [
                'jenis_kelamin' => ['pria' => 'Pria', 'wanita' => 'Wanita'],
                'tinggal_bersama' => ['orang_tua' => 'Orang Tua', 'sendiri' => 'Sendiri', 'kontrakan' => 'Kontrakan'],
                'transportasi' => ['motor' => 'Sepeda Motor', 'angkot' => 'Angkutan Umum', 'mobil' => 'Mobil', 'jalan_kaki' => 'Jalan Kaki'],
                'penghasilan' => [
                    '0-500rb' => '0 - 500rb / bulan',
                    '500rb-1jt' => '500 rb - 1jt / bulan',
                    '1jt-2jt' => '1 jt - 2 jt / bulan',
                    '2jt-4jt' => '2 jt - 4 jt / bulan',
                    '>4jt' => 'lebih dari 4jt / bulan'
                ],
            ];

            $agamaFinal = $validated['agama'] === 'Yang lain' 
                ? ($validated['agama_lain'] ?? 'Yang lain') 
                : $validated['agama'];
            
            $tinggalFinal = ($validated['tinggal_bersama'] === 'Yang lain' && !empty($validated['tinggal_lain']))
                ? $validated['tinggal_lain']
                : ($maps['tinggal_bersama'][$validated['tinggal_bersama']] ?? $validated['tinggal_bersama']);

            // 5. INSERT KE DATABASE (Gunakan $validated, BUKAN hardcoded!)
            $result = ResponsesPendaftaran::create([
                'submitted_at' => now(),
                
                // Data Pribadi - AMBIL DARI $validated
                'nama_lengkap' => $validated['nama_lengkap'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'tempat_lahir' => $validated['tempat_lahir'],
                'jenis_kelamin' => $maps['jenis_kelamin'][$validated['jenis_kelamin']],
                'agama' => $agamaFinal,
                'nisn' => $validated['nisn'] ?? null,
                'nik' => $validated['no_kk'],
                
                // Pendidikan
                'alumni_sekolah' => $validated['alumni_sekolah'],
                'tahun_tamat' => $validated['tahun_tamat'],
                'program_paket_id' => $programId,
                'kelas_id' => null,
                
                // Alamat
                'alamat' => $validated['alamat'],
                'kelurahan' => $validated['kelurahan'],
                'kecamatan' => $validated['kecamatan'],
                'kota' => $validated['kota'],
                'tinggal_bersama' => $tinggalFinal,
                'transportasi_sehari_hari' => $maps['transportasi'][$validated['transportasi']],
                
                // Data Ibu
                'nama_ibu_kandung' => $validated['nama_ibu'],
                'nik_ibu_kandung' => $validated['nik_ibu'],
                'pekerjaan_ibu' => $validated['pekerjaan_ibu'],
                'penghasilan_ibu' => $maps['penghasilan'][$validated['penghasilan_ibu']],
                'pendidikan_ibu' => $validated['pendidikan_ibu'],
                
                // Data Ayah
                'nama_ayah_kandung' => $validated['nama_ayah'],
                'nik_ayah_kandung' => $validated['nik_ayah'],
                'pekerjaan_ayah' => $validated['pekerjaan_ayah'],
                'penghasilan_ayah' => $maps['penghasilan'][$validated['penghasilan_ayah']],
                'pendidikan_ayah' => $validated['pendidikan_ayah'],
                
                // Kontak
                'no_handphone' => implode(', ', $validated['no_hp']),
                'email' => $validated['email'],
                'orang_dikenal_pkbm' => $validated['nama_pengenal'],
                'tanggal_daftar' => $validated['tanggal_daftar'],
                
                // File Paths
                'file_akte_lahir' => $uploadPaths['file_akte_lahir'] ?? null,
                'file_ktp' => $uploadPaths['file_ktp'] ?? null,
                'file_kartu_keluarga' => $uploadPaths['file_kartu_keluarga'] ?? null,
                'file_ijazah_terakhir' => $uploadPaths['file_ijazah_terakhir'] ?? null,
                'file_raport' => $uploadPaths['file_raport'] ?? null,
                'file_pas_foto' => $uploadPaths['file_pas_foto'] ?? null,
            ]);

            // 6. RESPONSE
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '✅ Pendaftaran berhasil!',
                    'data' => ['id' => $result->id]
                ]);
            }

            return redirect()->back()->with('success', '✅ Pendaftaran berhasil! Bukti dikirim ke email.');
        
        Log::info('✅ INSERT BERHASIL!', ['id' => $result->id, 'nik' => $result->nik]);

      
        
    } catch (\Exception $e) {
        Log::error('❌ INSERT GAGAL', [
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'sql_error' => method_exists($e, 'errorInfo') ? $e->errorInfo : null,
        ]);
        
        if ($request->ajax()) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
        throw $e;
    }
    $verify = \App\Models\ResponsesPendaftaran::find($result->id);
    Log::info('🔍 VERIFY AFTER INSERT', [
        'found' => $verify ? true : false,
        'nik_in_db' => $verify->nik ?? 'NOT_FOUND',
        'current_db' => config('database.connections.mysql.database'),
    ]);
}

    /**
     * Method test insert - HARUS di luar method store()
     */
    
}