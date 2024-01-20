<?php

namespace App\Http\Controllers;

use App\DB\Models\Note;
use App\Http\Requests\NoteRequest;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = auth()->user()->notes()->get()->map(function ($note) {
            return [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'color' => $note->color,
                'x' => $note->pos_x,
                'y' => $note->pos_y,
                'zIndex' => $note->pos_z,
                'width' => $note->width,
                'height' => $note->height,
            ];
        })->toArray();

        return vueResponse(data: ['notes' => $notes]);
    }

    public function store(NoteRequest $request)
    {
        $note = Note::create($request->validated() + ['user_id' => auth()->user()->id]);

        return successMessage("Ogłoszenie zostało zapisane", ['id' => $note->id]);
    }

    public function update(NoteRequest $request, Note $note)
    {
        $note->update($request->validated());

//        return successMessage("Zmiany zostały zapisane", ['id' => $note->id]);
    }

    public function destroy(Request $request)
    {
        foreach ($request->ids as $id) {
            Note::find($id)->delete();
        }

        return successMessage(count($request->ids) > 1 ? "Ogłoszenia zostały usunięte" : "Ogłoszenie zostało usunięte");
    }
}
