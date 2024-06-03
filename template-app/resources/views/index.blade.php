@extends('template')

@section('title')
    Головна сторінка
@endsection

@section('content')
    @auth
        <div class="container py-2">
            @foreach ($templates as $template)
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row g-0 justify-content-between">
                            <div class="col">
                                <h5 class="card-title"><a href="/generate/{{ $template->id }}"
                                        class="text-decoration-none mt-3 text-black">{{ $template->title }}</a></h5>
                                <p class="card-text col">{{ $template->desc }}</p>

                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary">@lang('public.delete')</button>
                                {{-- <button class="btn btn-primary">Редактировать</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="p-5 my-5 text-center border bg-light">
                {{-- <div class="col-10 col-sm-8 col-lg-6">
                    <img class="d-block mx-lg-auto img-fluid" src="{{ asset('screenshot/screen_1.png') }}" alt=""
                        width="720">
                </div> --}}

                <h1 class="display-5 fw-bold lh-1 mb-3">@lang('public.app_name')</h1>
                <p class="lead" style="padding-right: 240px; padding-left: 240px;">
                    @lang('public.instruction')
                </p>
                <div class="text-center">
                    <a href="/registration" class="btn btn-primary">@lang('public.sign_up')</a>
                </div>

            </div>
            <div class="pt-5 mx-5 text-center border shadow-lg bg-light fs-4 lh-1"
                style="font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">
                <p>
                <div class="py-3">
                    @lang('public.guide_1')
                </div>
                <img class="d-block mx-lg-auto img-fluid" src="{{ asset('screenshot/screen_reg.png') }}" alt=""
                    width="300">
                </p>
                <p>
                <div class="py-3">
                    @lang('public.guide_2')
                </div>
                <img class="d-block mx-lg-auto img-fluid" src="{{ asset('screenshot/screen_create_template.png') }}"
                    alt="" width="720">
                <img class="d-block mx-lg-auto img-fluid" src="{{ asset('screenshot/screen_doc.png') }}" alt=""
                    width="720">
                </p>
                <p>
                <div class="py-3">
                    @lang('public.guide_3')
                </div>
                <img class="d-block mx-lg-auto img-fluid" src="{{ asset('screenshot/screen_create_docx.png') }}" alt=""
                    width="720">
                </p>
            </div>
        @endauth
    </div>
@endsection
