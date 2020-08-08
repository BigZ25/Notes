@extends('template')

@section('title')
    @if (isset($title)) {{$title}}
    @endif
@endsection

@section('content')
    <div>
        <h3>Edycja notatki</h3>
        <div>
            <form class="note-form" action="{{action('NotesController@update')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <input type="hidden" name="id" value="{{$note->id}}"/>
                <ul>
                    <li>
                        <label>Tytuł <span class="required">*</span></label>
                        <input type="text" name="title" class="field-long" value="{{$note->title}}"/>
                    </li>
                    <li>
                        <label>Treść</label>
                        <textarea name="description" id="field5" class="field-long field-textarea">{{$note->description}}</textarea>
                    </li>
                    <li>
                        <input type="submit" value="Zapisz" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endsection('content')
