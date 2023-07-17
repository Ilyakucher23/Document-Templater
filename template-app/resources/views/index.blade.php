@extends('template')

@section('title')
    Головна сторінка
@endsection

@section('content')
    <div>
        <a href="/generate/1" class="card text-decoration-none mt-3">
            <div class="card-body">
                <div class="row g-0 justify-content-between">
                    <div class="col">
                        <h5 class="card-title">Название шаблона</h5>
                        <p class="card-text col">Le template description</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">Удалить</button>
                        <button class="btn btn-primary">Редактировать</button>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div>
        <a href="/generate/2" class="card text-decoration-none mt-3">
            <div class="card-body">
                <div class="row g-0 justify-content-between">
                    <div class="col">
                        <h5 class="card-title">Название шаблона</h5>
                        <p class="card-text col">Le template description</p>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary">Удалить</button>
                        <button class="btn btn-primary">Редактировать</button>
                    </div>
                </div>
            </div>
        </a>
    </div>
@endsection
