<?php

namespace App\Http\Controllers;

use App\DB\Models\Note;
use App\Http\Requests\NoteRequest;

class NoteController extends Controller
{
    public function index()
    {
        $notes = auth()->user()->notes()->get()->map(function ($note) {
            return $note->parseToVue();
        })->toArray();

        return vueResponse(data: ['notes' => $notes]);
    }

    public function store(NoteRequest $request)
    {
        $note = Note::create($request->validated() + ['user_id' => auth()->user()->id]);

        return vueResponse(data: ['note' => $note->parseToVue()]);
    }

    public function update(NoteRequest $request, Note $note)
    {
        $note->update($request->validated());
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return vueResponse('Notatka została usunięta', 'success');
    }
}
