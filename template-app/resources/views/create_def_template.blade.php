@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <form class="container my-3 px-3" action="/generate_def_doc/{{ $template->id }}/download" method="POST">
        @csrf
        <h1 class="text-center mb-5 mt-5">{{ $template->title }}</h1>
        {{-- @dd($template->params) --}}
        @foreach (json_decode($template->params) as $param)
            <div class="card mb-3">
                <div class="card-body">
                    <label class="form-label">{{ $param }}</label>
                    <input type="hidden" name="doc_vars_names[]" value="{{ $param }}">
                    <input type="text" class="form-control" name="doc_vars[]">
                </div>
            </div>
        @endforeach
        {{-- <h1 class="text-center mb-5 mt-5">{{ $template->title }}</h1>
        <div class="card mb-3">
            <div class="card-body">
                <label class="form-label">{{ $param }}</label>
                <input type="hidden" name="doc_vars_names[]" value="{{ $param }}">
                <input type="text" class="form-control" name="doc_vars[]">
            </div>
        </div> --}}

        <button class="btn btn-primary w-100" type="submit">@lang('public.create')</button>
    </form>
@endsection
