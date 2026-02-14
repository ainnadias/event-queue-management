<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AntriStand;
use App\Models\QuotaStand;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicAntrianController extends Controller
{
    public function getStand(Request $request)
    {
        $tanggal = $request->tanggal;

        if (!$tanggal) {
            return response()->json([
                'success' => false,
                'message' => 'Tanggal wajib dipilih'
            ], 400);
        }

        $stands = QuotaStand::all();

        $data = $stands->map(function ($stand) use ($tanggal) {
            $terisi = AntriStand::where('kd_stand', $stand->kd_stand)
                        ->whereDate('tanggal_pesan', $tanggal)
                        ->count();
            
            $sisa = $stand->quota - $terisi;
            
            return [
                'kd_stand' => $stand->kd_stand,
                'nama_stand' => $stand->nama_stand,
                'quota_max' => $stand->quota,
                'terisi' => $terisi,
                'sisa' => $sisa,
                'status' => $sisa > 0 ? 'BUKA' : 'PENUH'
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'email' => 'required|email',
            'kd_stand' => 'required|exists:tbl_quota_stand,kd_stand',
            'tanggal_pesan' => 'required|date|after_or_equal:today',
        ]);

        if($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $standInfo = QuotaStand::where('kd_stand', $request->kd_stand)->first();

            $jumlahAntrianHariIni = AntriStand::where('kd_stand', $request->kd_stand)
                ->whereDate('tanggal_pesan', $request->tanggal_pesan)
                ->count();
            
            if($jumlahAntrianHariIni >= $standInfo->quota) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mohon maaf, kuota sudah penuh untuk hari ini!'
                ], 400);
            }

            $nomorUrut = $jumlahAntrianHariIni + 1;

            $antrian = AntriStand::create([
                'nama'=> $request->nama,
                'email' => $request->email,
                'tanggal_pesan' => $request->tanggal_pesan,
                'kd_stand' => $request->kd_stand,
                'nomor_antri' =>$nomorUrut
            ]);

            $tgl = Carbon::parse($request->tanggal_pesan);
            $kodeTiket = sprintf('%s%s%03d', $request->kd_stand, $tgl->format('Ymd'), $nomorUrut);

            return response()->json([
                'success' => true,
                'message' => 'Pendaftaran Berhasil!',
                'data' => [
                    'id' => $antrian->id,
                    'kode_tiket' => $kodeTiket,
                    'nomor_antri' => $nomorUrut,
                    'tanggal' => $request->tanggal_pesan,
                    'stand' => $standInfo->nama_stand
                ]
            ], 201);

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] === 1062) {
                return response()->json([
                    'success' => false,
                    'message' => 'Satu email hanya bisa mendaftar satu kali per hari di stand ini.'
                ], 409);
            }
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function cetakTiket($id)
    {
        $antrian = AntriStand::findOrFail($id);
        
        $standInfo = QuotaStand::where('kd_stand', $antrian->kd_stand)->first();

        $tgl = Carbon::parse($antrian->tanggal_pesan);
        
        $kodeTiket = sprintf(
            '%s%s%03d', 
            $antrian->kd_stand, 
            $tgl->format('Ymd'), 
            $antrian->nomor_antri
        );

        $data = [
            'kode_tiket'  => $kodeTiket,
            'nama'        => $antrian->nama,
            'stand'       => $standInfo->nama_stand,
            'tanggal'     => $tgl->format('d-m-Y'),
            'nomor_antri' => $antrian->nomor_antri
        ];

        $pdf = Pdf::loadView('pdf_tiket', $data);
        
        $pdf->setPaper('a5', 'landscape');

        return $pdf->download('Tiket-' . $kodeTiket . '.pdf');
    }
}