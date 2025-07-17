<?php

namespace App\Http\Controllers\DataNilai;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Test;

    class PrePostTestController extends Controller
    {
        public function index()
        {
            return response()->json(Test::with('user')->get());
        }

        public function store(Request $request)
        {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'jenis_test' => 'required|in:Pretest,Postest',
                'nilai' => 'required|numeric',
                'tanggal_test' => 'required|date',
            ]);

            $test = Test::create($validated);
            return response()->json($test, 201);
        }

        public function update(Request $request, $id)
        {
            $test = Test::findOrFail($id);
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'jenis_test' => 'required|in:Pretest,Postest',
                'nilai' => 'required|numeric',
                'tanggal_test' => 'required|date',
            ]);

            $test->update($validated);
            return response()->json($test);
        }

        public function destroy($id)
        {
            $test = Test::findOrFail($id);
            $test->delete();
            return response()->json(['message' => 'Deleted']);
        }

        public function massDestroy(Request $request)
        {
            $ids = $request->input('ids');
            Test::whereIn('id', $ids)->delete();
            return response()->json(['message' => 'Mass delete successful']);
        }
    }
