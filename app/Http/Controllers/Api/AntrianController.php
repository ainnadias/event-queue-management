<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AntriStand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AntrianController extends Controller
{
    public function index()
    {
        $data = AntriStand::select('tbl_antri_stand.*', 'tbl_quota_stand.nama_stand')
                ->join('tbl_quota_stand', 'tbl_antri_stand.kd_stand', '=', 'tbl_quota_stand.kd_stand')
                ->orderBy('tbl_antri_stand.created_at', 'desc')
                ->get();

        $data = $data->map(function($item) {
            $tgl = Carbon::parse($item->tanggal_pesan);
            
            return [
                'id' => $item->id,
                'nama' => $item->nama,
                'email' => $item->email,
                'nama_stand' => $item->nama_stand,
                'tanggal_pesan' => $tgl->format('d-m-Y'),
                'nomor_antri' => $item->nomor_antri,
                'kode_tiket' => sprintf('%s%s%03d', $item->kd_stand, $tgl->format('Ymd'), $item->nomor_antri),
                'created_at' => Carbon::parse($item->created_at)->format('d-m-Y H:i'),
                'raw_tanggal' => $item->tanggal_pesan,
                'kd_stand' => $item->kd_stand
            ];
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    public function show($id)
    {
        $data = AntriStand::select('tbl_antri_stand.*', 'tbl_quota_stand.nama_stand')
            ->join('tbl_quota_stand', 'tbl_antri_stand.kd_stand', '=', 'tbl_quota_stand.kd_stand')
            ->where('tbl_antri_stand.id', $id)
            ->firstOrFail();
        
        $tgl = \Carbon\Carbon::parse($data->tanggal_pesan);

        $data->kode_tiket = sprintf('%s%s%03d', 
            $data->kd_stand, 
            $tgl->format('Ymd'), 
            $data->nomor_antri
        );

        $data->tanggal_pesan_formatted = $tgl->format('d-m-Y');

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
        {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:100',
                'email' => 'required|email|max:100',
            ]);

            if($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }

            try {
                $antrian = AntriStand::findOrFail($id);
                
                $antrian->update([
                    'nama' => $request->nama,
                    'email' => $request->email,
                ]);

                return response()->json([
                    'success' => true, 
                    'message' => 'Data berhasil diperbarui'
                ]);

            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Gagal update data'], 500);
            }
        }

    public function destroy($id)
    {
        try {
            $antrian = AntriStand::findOrFail($id);
            $antrian->delete();
            return response()->json(['success' => true, 'message' => 'Data berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data'], 500);
        }
    }
}