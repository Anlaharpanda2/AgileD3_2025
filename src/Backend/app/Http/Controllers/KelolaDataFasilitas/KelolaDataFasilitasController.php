<?php

namespace App\Http\Controllers\KelolaDataFasilitas;

use App\Http\Controllers\Controller;
use App\Models\DataFasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelolaDataFasilitasController extends Controller
{
    public function index()
    {
        $dataFasilitas = DataFasilitas::all();
        return response()->json($dataFasilitas);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $dataFasilitas = DataFasilitas::create($request->all());
        return response()->json($dataFasilitas, 201);
    }

    public function show(DataFasilitas $dataFasilitas)
    {
        return response()->json($dataFasilitas);
    }

    public function update(Request $request, DataFasilitas $dataFasilitas)
    {
        $validator = Validator::make($request->all(), [
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'status' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $dataFasilitas->update($request->all());
        return response()->json($dataFasilitas, 200);
    }

    public function destroy(DataFasilitas $dataFasilitas)
    {
        $dataFasilitas->delete();
        return response()->json(null, 204);
    }

    public function destroyMassal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:data_fasilitas,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        DataFasilitas::whereIn('id', $request->ids)->delete();
        return response()->json(['message' => 'Data fasilitas berhasil dihapus sementara.'], 200);
    }

    public function trash()
    {
        $dataFasilitas = DataFasilitas::onlyTrashed()->get();
        return response()->json($dataFasilitas);
    }

    public function restore($id)
    {
        $dataFasilitas = DataFasilitas::onlyTrashed()->findOrFail($id);
        $dataFasilitas->restore();
        return response()->json($dataFasilitas);
    }

    public function restoreMassal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:data_fasilitas,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        DataFasilitas::onlyTrashed()->whereIn('id', $request->ids)->restore();
        return response()->json(['message' => 'Data fasilitas berhasil dipulihkan.'], 200);
    }

    public function forceDelete($id)
    {
        $dataFasilitas = DataFasilitas::onlyTrashed()->findOrFail($id);
        $dataFasilitas->forceDelete();
        return response()->json(null, 204);
    }

    public function forceDeleteMassal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ids' => 'required|array',
            'ids.*' => 'exists:data_fasilitas,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        DataFasilitas::onlyTrashed()->whereIn('id', $request->ids)->forceDelete();
        return response()->json(['message' => 'Data fasilitas berhasil dihapus permanen.'], 200);
    }
}
