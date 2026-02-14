<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\QuotaStand;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => QuotaStand::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kd_stand' => 'required|unique:tbl_quota_stand,kd_stand',
            'nama_stand' => 'required',
            'quota' => 'required|numeric',
        ]);

        $stand = QuotaStand::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Stand ' . $stand->nama_stand . ' berhasil ditambahkan!',
            'data' => $stand,
        ]);
    }

    public function show($id)
    {
        $stand = QuotaStand::findOrFail($id);
        return response()->json(['data' => $stand]);
    }

    public function update(Request $request, $id)
    {
        $stand = QuotaStand::findOrFail($id);
        
        $validated = $request->validate([
        'kd_stand'    => 'required|unique:tbl_quota_stand,kd_stand,' . $id,
        'nama_stand'  => 'required',
        'quota'       => 'required|numeric',
    ]);

        $stand->update($validated);

        return response()->json([
        'success' => true,
        'message' => 'Data stand berhasil diperbarui!'
        ]);
    }

    public function destroy($id)
    {
        QuotaStand::destroy($id);

        return response()->json([
            'message' => 'Deleted'
        ]);
    }
}
