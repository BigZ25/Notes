<?php

namespace App\Http\Controllers;

use App\DB\Models\Note;
use App\Http\Requests\NoteRequest;
use Illuminate\Http\Request;

class TabController extends Controller
{
    public function index()
    {
        $tabs = auth()->user()->tabs()->get()->toArray();

        return vueResponse(data: ['tabs' => $tabs]);
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
