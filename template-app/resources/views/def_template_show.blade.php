@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <div class="p-5 m-5 card mb-4">
        <div class="card-body">
            <div class="row g-0 justify-content-between">
                <div class="col">
                    <h5 class="card-title"><a href="/generate_def_doc/999{{-- {{ $template->id }} --}}"
                            class="text-decoration-none mt-3 text-black">Document{{-- {{ $template->title }} --}}</a></h5>
                    <p class="card-text col">default document{{-- {{ $template->desc }} --}}</p>

                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">@lang('public.delete')</button>
                </div>
            </div>
        </div>
    </div>
@endsection
