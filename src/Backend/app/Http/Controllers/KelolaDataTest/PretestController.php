<?php

namespace App\Http\Controllers\KelolaDataTest;

use App\Http\Controllers\Controller;
use App\Models\Pretest;
use App\Models\Question;
use App\Models\PretestScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PretestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pretests = Pretest::with('questions')->get();
        return response()->json($pretests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'array',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D',
            'questions.*.order' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $pretest = Pretest::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if ($request->has('questions')) {
                foreach ($request->questions as $questionData) {
                    $pretest->questions()->create($questionData);
                }
            }

            DB::commit();
            return response()->json($pretest->load('questions'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create pretest', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pretest $pretest)
    {
        return response()->json($pretest->load('questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pretest $pretest)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'array',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.question_text' => 'required|string',
            'questions.*.option_a' => 'required|string',
            'questions.*.option_b' => 'required|string',
            'questions.*.option_c' => 'required|string',
            'questions.*.option_d' => 'required|string',
            'questions.*.correct_answer' => 'required|in:A,B,C,D',
            'questions.*.order' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $pretest->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $existingQuestionIds = $pretest->questions->pluck('id')->toArray();
            $incomingQuestionIds = [];

            if ($request->has('questions')) {
                foreach ($request->questions as $questionData) {
                    if (isset($questionData['id'])) {
                        $question = $pretest->questions()->find($questionData['id']);
                        if ($question) {
                            $question->update($questionData);
                            $incomingQuestionIds[] = $question->id;
                        }
                    } else {
                        $newQuestion = $pretest->questions()->create($questionData);
                        $incomingQuestionIds[] = $newQuestion->id;
                    }
                }
            }

            $questionsToDelete = array_diff($existingQuestionIds, $incomingQuestionIds);
            if (!empty($questionsToDelete)) {
                $pretest->questions()->whereIn('id', $questionsToDelete)->delete();
            }

            DB::commit();
            return response()->json($pretest->load('questions'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update pretest', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pretest $pretest)
    {
        try {
            $pretest->delete();
            return response()->json(['message' => 'Pretest deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete pretest', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the visibility of multiple pretests.
     */
    public function updateVisibility(Request $request)
    {
        $request->validate([
            'pretests' => 'required|array',
            'pretests.*.id' => 'required|exists:pretests,id',
            'pretests.*.is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->pretests as $pretestData) {
                Pretest::where('id', $pretestData['id'])->update(['is_active' => $pretestData['is_active']]);
            }
            DB::commit();
            return response()->json(['message' => 'Pretest visibility updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update pretest visibility', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Submit pretest answers and calculate score.
     */
    public function submitPretest(Request $request, Pretest $pretest)
    {
        $request->validate([
            'user_nik' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:questions,id',
            'answers.*.selected_option' => 'required|in:A,B,C,D',
        ]);

        // Check if user has already submitted this pretest
        if (PretestScore::where('pretest_id', $pretest->id)->where('user_nik', $request->user_nik)->exists()) {
            return response()->json(['message' => 'You have already submitted this pretest.'], 409);
        }

        $score = 0;
        $totalQuestions = $pretest->questions->count();

        foreach ($request->answers as $answerData) {
            $question = $pretest->questions->find($answerData['question_id']);
            if ($question && $question->correct_answer === $answerData['selected_option']) {
                $score++;
            }
        }

        try {
            $pretestScore = PretestScore::create([
                'pretest_id' => $pretest->id,
                'user_nik' => $request->user_nik,
                'user_name' => $request->user_name,
                'score' => $score,
                'total_questions' => $totalQuestions,
                'submitted_at' => now(),
            ]);
            return response()->json(['message' => 'Pretest submitted successfully!', 'score' => $score, 'total_questions' => $totalQuestions, 'data' => $pretestScore], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to submit pretest', 'error' => $e->getMessage()], 500);
        }
    }
}
