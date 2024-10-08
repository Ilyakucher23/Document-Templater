@extends('template')

@section('title')
    Головна сторінка
@endsection

@section('content')
    @auth
        <div id="template-list" class="container py-2 px-3 px-md-5 px-lg-10">
            @foreach ($templates as $template)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-0 justify-content-between align-items-center">
                            <div class="col-12 col-md-8">
                                <h5 class="card-title">
                                    <a href="/generate/{{ $template->id }}"
                                        class="text-decoration-none mt-3 text-black">{{ $template->title }}</a>
                                </h5>
                                <p class="card-text">{{ $template->desc }}</p>
                            </div>
                            <div class="col-12 col-md-auto mt-3 mt-md-0">
                                <a href="/delete/{{ $template->id }}"
                                    class="btn btn-primary text-light w-100 w-md-auto">@lang('public.delete')</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="hero p-5 my-5 text-center border bg-light" id="hero">

            <h1 class="display-5 fw-bold lh-1 mb-3">@lang('public.app_name')</h1>
            <p class="lead p-3 mx-auto" style="max-width: 600pt;">
                @lang('public.instruction')
            </p>
            <div class="text-center">
                <a href="/registration" class="btn btn-primary">@lang('public.sign_up')</a>
            </div>

        </div>
        <div class="pt-5 text-center border shadow-lg bg-light fs-4 lh-1" id="guide"
            style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
            <p>
            <div class="py-3">
                @lang('public.guide_1')
            </div>
            <img class="d-block mx-auto img-fluid" src="{{ asset('screenshot/screen_reg.png') }}" alt="" width="300">
            </p>
            <p>
            <div class="py-3">
                @lang('public.guide_2')
            </div>
            <img class="d-block mx-auto img-fluid" src="{{ asset('screenshot/screen_create_template.png') }}" alt=""
                width="720">
            <img class="d-block mx-auto img-fluid" src="{{ asset('screenshot/screen_doc.png') }}" alt="" width="720">
            </p>
            <p>
            <div class="py-3">
                @lang('public.guide_3')
            </div>
            <img class="d-block mx-auto img-fluid" src="{{ asset('screenshot/screen_create_docx.png') }}" alt=""
                width="720">
            </p>
        </div>
    @endauth
    </div>
@endsection
