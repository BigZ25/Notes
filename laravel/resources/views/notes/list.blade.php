@extends('template')

@section('title')
    @if (isset($title)) {{$title}}
    @endif
@endsection

@section('content')
    @if(count($notes)>0)
    <table class="table">
        <thead>
        <tr>
            <th>Tytuł</th>
            <th>Data utworzenia</th>
            <th>Data ostatniej modyfikacji</th>
            <th>Operacje</th>
        </tr>
        </thead>
        <tbody>
        @foreach($notes as $note)
        <tr>
            <td>{{$note->title}}</td>
            <td>{{$note->created_at}}</td>
            <td>{{$note->updated_at}}</td>
            <td>
                <ul>
                    <a href="{{URL::to('/notes/show/'.$note->id)}}">Pokaż</a>
                    <a href="{{URL::to('/notes/edit/'.$note->id)}}">Edytuj</a>
                    <a href="{{URL::to('/notes/delete/'.$note->id)}}" onclick="return confirm('Czy napewno usunac?')">Usuń</a>
                </ul>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
        {{$notes->links()}}
    @else <h1>Brak notatek</h1>
    @endif
@endsection('content')
