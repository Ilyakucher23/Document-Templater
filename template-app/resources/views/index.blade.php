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
                        <h5 class="card-title">ДОВІДКА для дитячого садочку, школи
                        </h5>
                        <p class="card-text col">Довідка для хворої дитини що доказує виправдану вітсутність у дитячому
                            садочку, школі</p>
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
