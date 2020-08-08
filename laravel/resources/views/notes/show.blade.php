@extends('template')

@section('title')
    @if (isset($title)) {{$title}}
    @endif
@endsection

@section('content')
<div class="show">
    <ul>
        <li>Tytuł: {{$note['title']}}</li>
        <pre>{{$note['description']}}</pre>
        <li>Data utworzenia: {{$note['created_at']}}</li>
        <li>Data modyfikacji: {{$note['updated_at']}}</li>
    </ul>

    <a href="/notes/">
        <button>Powrót do listy notatek</button>
    </a>
</div>
@endsection('content')
