@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <div class="container py-2">
        <form action="/editor" method="GET">
            @csrf
            <h1 class="text-center mb-5 mt-5">Create file</h1>
            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label">File name </label>
                    <input type="text" class="form-control" name="name">
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label">File description</label>
                    <input type="text" class="form-control" name="desc">
                </div>
            </div>

            <button class="btn btn-primary w-100" type="submit">Go to editor</button>
        </form>
    </div>
@endsection
