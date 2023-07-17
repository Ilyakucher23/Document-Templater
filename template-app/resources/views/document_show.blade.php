@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <form action="/lol/kek" method="POST">
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">title</label>
                <input type="text" class="form-control" name="title" placeholder="title">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="name">name</label>
                <input type="text" class="form-control" name="name" placeholder="name">
            </div>
        </div>
        <button class="btn btn-primary w-100" type="submit">create</button>
    </form>
@endsection
