<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\UserNote;
use Illuminate\Http\Request;
use DB;

class NotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        $notes = DB::table('notes')
            ->join('user_notes','notes.id','=','user_notes.note_id')
            ->select('notes.*')
            ->where('user_id','=',$user->id)->paginate(10);

        return view('notes.list',[
            'notes'=>$notes,
            'title'=>'- lista notatek'
        ]);
    }

    public function show($id)
    {
        $note = Note::find($id);

        return view('notes.show',[
            'note'=>$note,
            'title'=>'- podgląd notatki'
        ]);
    }

    public function delete($id)
    {
        $note = Note::destroy($id);

        return redirect()->action('NotesController@index');
    }

    public function create()
    {
        return view('notes.create',[
            'title'=>'- nowa notatka'
        ]);
    }

    public function edit($id)
    {
        $note = Note::find($id);

        return view('notes.edit',[
            'note'=>$note,
            'title'=>'- edycja notatki'
        ]);
    }

    public function store(Request $request)
    {
        $note = new Note;
        $note->title = $request->input('title');
        $note->description = $request->input('description');
        $note->created_at = date('Y-m-d H:i:s');
        $note->updated_at = date('Y-m-d H:i:s');
        $note->save();

        $user = auth()->user();

        $user_note = new UserNote;
        $user_note->note_id = $note->id;
        $user_note->user_id = $user->id;
        $user_note->save();

        return redirect()->action('NotesController@index');
    }

    public function update(Request $request)
    {
        $note = Note::find($request->input('id'));
        $note->title = $request->input('title');
        $note->description = $request->input('description');
        $note->updated_at = date('Y-m-d H:i:s');

        $note->save();

        return redirect()->action('NotesController@index');
    }
}
