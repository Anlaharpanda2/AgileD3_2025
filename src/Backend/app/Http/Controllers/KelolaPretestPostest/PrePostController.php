<?php

namespace App\Http\Controllers\KelolaPretestPostest;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Question;

class PrePostController extends Controller
{
    /**
     * Menampilkan semua soal (pretest & postest).
     */
    public function index()
    {
        $questions = Question::all();
        return response()->json($questions);
    }

    /**
     * Menampilkan soal berdasarkan tipe (pretest / postest).
     */
    public function show($type)
    {
        if (!in_array($type, ['pretest', 'postest'])) {
            return response()->json(['message' => 'Tipe tidak valid (pretest/postest).'], 400);
        }

        $questions = Question::where('type', $type)->get();
        return response()->json($questions);
    }

    /**
     * Menyimpan soal baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:pretest,postest',
            'question_type' => 'required|in:multiple_choice,text',
            'question' => 'required|string',
            'options' => 'nullable|array|min:2',
            'options.*' => 'string',
            'answer' => 'nullable|string',
        ]);

        // Jika tipe soal multiple_choice maka wajib ada options dan answer harus salah satu dari options
        if ($validated['question_type'] === 'multiple_choice') {
            if (empty($validated['options']) || count($validated['options']) < 2) {
                return response()->json(['message' => 'Pilihan jawaban harus ada minimal 2 untuk tipe multiple_choice.'], 422);
            }
            if (!in_array($validated['answer'], $validated['options'])) {
                return response()->json(['message' => 'Jawaban harus ada di dalam pilihan jawaban.'], 422);
            }
        } else {
            // Untuk tipe text jawaban bisa kosong/null atau string bebas
            $validated['options'] = null;
            if (!isset($validated['answer'])) {
                $validated['answer'] = null;
            }
        }

        $question = Question::create($validated);

        return response()->json([
            'message' => 'Soal berhasil ditambahkan.',
            'data' => $question
        ], 201);
    }

    /**
     * Menghapus soal berdasarkan ID.
     */
    public function destroy($id)
    {
        $question = Question::find($id);

        if (!$question) {
            return response()->json(['message' => 'Soal tidak ditemukan.'], 404);
        }

        $question->delete();

        return response()->json(['message' => 'Soal berhasil dihapus.']);
    }
}

