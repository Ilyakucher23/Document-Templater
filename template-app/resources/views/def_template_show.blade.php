@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')

    <div class="p-5 m-5 card mb-4">
        @foreach ($templates as $template)
        <div class="card-body">
            <div class="row g-0 justify-content-between">
                <div class="col">
                    <h5 class="card-title"><a href="/generate_def_doc/{{ $template->id }}"
                            class="text-decoration-none mt-3 text-black">{{ $template->title }}</a></h5>
                    <p class="card-text col">{{ $template->desc }}</p>

                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
