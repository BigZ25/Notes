@extends('template')

@section('title')
    @if (isset($title)) {{$title}}
    @endif
@endsection

@section('content')
    <div>
        <h3>Dodawanie notatki</h3>
        <div>
            <form class="note-form" action="{{action('NotesController@store')}}" method="post">
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <ul>
                    <li>
                        <label>Tytuł <span class="required">*</span></label>
                        <input type="text" name="title" class="field-long" />
                    </li>
                    <li>
                        <label>Treść</label>
                        <textarea name="description" id="field5" class="field-long field-textarea"></textarea>
                    </li>
                    <li>
                        <input type="submit" value="Dodaj" />
                    </li>
                </ul>
            </form>
        </div>
    </div>
@endsection('content')
