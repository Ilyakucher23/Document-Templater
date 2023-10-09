@extends('template')

@section('title')
    Головна сторінка
@endsection

@section('content')
    <div>
        <form action="/save" method="POST">
            @csrf
            <input id="text" type="hidden" name="content">
            <trix-editor input="text" style="height: 800px"></trix-editor>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
@endsection
