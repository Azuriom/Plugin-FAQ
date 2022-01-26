<?php

namespace Azuriom\Plugin\FAQ\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Http\Requests\AttachmentRequest;
use Azuriom\Plugin\FAQ\Models\Question;

class QuestionAttachmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Http\Requests\AttachmentRequest  $request
     * @param  \Azuriom\Plugin\FAQ\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function store(AttachmentRequest $request, Question $question)
    {
        $imageUrl = $question->storeAttachment($request->file('file'));

        return response()->json(['location' => $imageUrl]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Http\Requests\AttachmentRequest  $request
     * @param  string  $pendingId
     * @return \Illuminate\Http\Response
     */
    public function pending(AttachmentRequest $request, string $pendingId)
    {
        $imageUrl = Question::storePendingAttachment($pendingId, $request->file('file'));

        return response()->json(['location' => $imageUrl]);
    }
}
