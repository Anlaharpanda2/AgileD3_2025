<?php

namespace App\Http\Controllers\KelolaDataTest;

use App\Http\Controllers\Controller;
use App\Models\Posttest;
use App\Models\PosttestQuestion;
use App\Models\CombinedScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosttestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posttests = Posttest::with('questions')->get();
        return response()->json($posttests);
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
            $posttest = Posttest::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if ($request->has('questions')) {
                foreach ($request->questions as $questionData) {
                    $posttest->questions()->create($questionData);
                }
            }

            DB::commit();
            return response()->json($posttest->load('questions'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to create posttest', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Posttest $posttest)
    {
        return response()->json($posttest->load('questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Posttest $posttest)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions' => 'array',
            'questions.*.id' => 'nullable|exists:posttest_questions,id',
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
            $posttest->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $existingQuestionIds = $posttest->questions->pluck('id')->toArray();
            $incomingQuestionIds = [];

            if ($request->has('questions')) {
                foreach ($request->questions as $questionData) {
                    if (isset($questionData['id'])) {
                        $question = $posttest->questions()->find($questionData['id']);
                        if ($question) {
                            $question->update($questionData);
                            $incomingQuestionIds[] = $question->id;
                        }
                    } else {
                        $newQuestion = $posttest->questions()->create($questionData);
                        $incomingQuestionIds[] = $newQuestion->id;
                    }
                }
            }

            $questionsToDelete = array_diff($existingQuestionIds, $incomingQuestionIds);
            if (!empty($questionsToDelete)) {
                $posttest->questions()->whereIn('id', $questionsToDelete)->delete();
            }

            DB::commit();
            return response()->json($posttest->load('questions'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update posttest', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posttest $posttest)
    {
        try {
            $posttest->delete();
            return response()->json(['message' => 'Posttest deleted successfully'], 204);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete posttest', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the visibility of multiple posttests.
     */
    public function updateVisibility(Request $request)
    {
        $request->validate([
            'posttests' => 'required|array',
            'posttests.*.id' => 'required|exists:posttests,id',
            'posttests.*.is_active' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            foreach ($request->posttests as $posttestData) {
                Posttest::where('id', $posttestData['id'])->update(['is_active' => $posttestData['is_active']]);
            }
            DB::commit();
            return response()->json(['message' => 'Posttest visibility updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Failed to update posttest visibility', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Submit posttest answers and calculate score.
     */
    public function submitPosttest(Request $request, Posttest $posttest)
    {
        $request->validate([
            'user_nik' => 'required|string|max:255',
            'user_name' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*.question_id' => 'required|exists:posttest_questions,id',
            'answers.*.selected_option' => 'required|in:A,B,C,D',
        ]);

        // Check if user has already submitted this posttest
        $existingScore = CombinedScore::where('user_nik', $request->user_nik)->first();

        if ($existingScore && $existingScore->posttest_score !== null) {
            return response()->json(['message' => 'You have already submitted this posttest.'], 409);
        }

        $score = 0;
        $totalQuestions = $posttest->questions->count();

        foreach ($request->answers as $answerData) {
            $question = $posttest->questions->find($answerData['question_id']);
            if ($question && $question->correct_answer === $answerData['selected_option']) {
                $score++;
            }
        }

        $percentageScore = ($totalQuestions > 0) ? round(($score / $totalQuestions) * 100, 2) : 0;

        try {
            if ($existingScore) {
                $existingScore->update([
                    'posttest_score' => $percentageScore,
                    'user_name' => $request->user_name, // Update name in case it changed
                ]);
            } else {
                CombinedScore::create([
                    'user_nik' => $request->user_nik,
                    'user_name' => $request->user_name,
                    'pretest_score' => null, // Ensure pretest_score is null for new entries
                    'posttest_score' => $percentageScore,
                ]);
            }
            return response()->json(['message' => 'Posttest submitted successfully!', 'score' => $percentageScore, 'total_questions' => $totalQuestions], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to submit posttest', 'error' => $e->getMessage()], 500);
        }
    }
}
