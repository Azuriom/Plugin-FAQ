<?php

namespace Azuriom\Plugin\FAQ\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\FAQ\Models\Question;
use Azuriom\Plugin\FAQ\Requests\QuestionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('position')->get();

        return view('faq::admin.questions.index', ['questions' => $questions]);
    }

    /**
     * Update the resources order in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updateOrder(Request $request)
    {
        $this->validate($request, [
            'questions' => ['required', 'array'],
        ]);

        $questions = $request->input('questions');

        $position = 1;

        foreach ($questions as $questionId) {
            Question::whereKey($questionId)->update(['position' => $position++]);
        }

        return response()->json([
            'message' => trans('faq::admin.questions.updated'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faq::admin.questions.create', [
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Plugin\FAQ\Requests\QuestionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        $question = Question::create($request->validated());

        $question->persistPendingAttachments($request->input('pending_id'));

        return redirect()->route('faq.admin.questions.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Azuriom\Plugin\FAQ\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('faq::admin.questions.edit', ['question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\FAQ\Requests\QuestionRequest  $request
     * @param  \Azuriom\Plugin\FAQ\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->validated());

        return redirect()->route('faq.admin.questions.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\FAQ\Models\Question  $question
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('faq.admin.questions.index')
            ->with('success', trans('messages.status.success'));
    }
}
