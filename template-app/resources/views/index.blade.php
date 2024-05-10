@extends('template')

@section('title')
    Головна сторінка
@endsection

@section('content')
    {{-- <div class="card mb-4">
        <div class="card-body">
            <div class="row g-0 justify-content-between">
                <div class="col">
                    <a href="/generate/1" class="text-decoration-none mt-3 text-black">
                        <h5 class="card-title">ДОВІДКА для дитячого садочку, школи</h5>
                        <p class="card-text col">Довідка для хворої дитини що доказує виправдану вітсутність у дитячому
                            садочку, школі</p>
                    </a>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary">Удалить</button>
                    <button class="btn btn-primary">Редактировать</button>
                </div>
            </div>
        </div>
    </div> --}}

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
                                <button class="btn btn-primary">Удалить</button>
                                <button class="btn btn-primary">Редактировать</button>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        @else
            No templates yet
        @endauth

    </div>
@endsection
