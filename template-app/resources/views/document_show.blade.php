@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <form action="/generate/1/download" method="POST">
        @csrf

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">П.І.Б. пацієнта </label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">Дата народження</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">Адреса</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">Дата з</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">Дата по</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">З приводу</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">Висновок</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">Дата видачі довідки</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label" for="title">П.І.Б. лікаря</label>
                <input type="text" class="form-control" name="doc_vars[]" placeholder="title">
            </div>
        </div>
        <button class="btn btn-primary w-100" type="submit">create</button>
    </form>
@endsection
