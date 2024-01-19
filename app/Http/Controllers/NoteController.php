<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use Illuminate\Http\Request;
use ZipArchive;

class NoteController extends Controller
{
    public function store(NoteRequest $request)
    {
        $advert = Note::create($request->validated() + ['user_id' => auth()->user()->id]);
        $this->storePhotos($advert, $request->photos);

        return successMessage("Ogłoszenie zostało zapisane", ['id' => $advert->id]);
    }

    public function update(NoteRequest $request, Note $advert)
    {
        $advert->update($request->validated());
        $this->storePhotos($advert, $request->photos);

        return successMessage("Zmiany zostały zapisane", ['id' => $advert->id]);
    }

    public function destroy(Request $request)
    {
        foreach ($request->ids as $id) {
            Note::find($id)->delete();
        }

        return successMessage(count($request->ids) > 1 ? "Ogłoszenia zostały usunięte" : "Ogłoszenie zostało usunięte");
    }
}
