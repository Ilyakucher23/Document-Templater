@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <form action="/generate/1/download" method="POST">
        @csrf
        <h1 class="text-center mb-5 mt-5">ДОВІДКА для дитячого садочку, школи</h1>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">П.І.Б. пацієнта </label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Дата народження</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Адреса</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Дата з</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Дата по</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">З приводу</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Висновок</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">Дата видачі довідки</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">П.І.Б. лікаря</label>
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div>
        <button class="btn btn-primary w-100" type="submit">create</button>
    </form>
@endsection
