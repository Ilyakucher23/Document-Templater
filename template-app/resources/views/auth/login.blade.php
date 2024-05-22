@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="login-container"
                style="max-width: 400px; margin: 50px auto; padding: 40px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                <h2 class="login-heading text-center" style="margin-bottom: 30px;">@lang('public.login')</h2>
                <form class="login-form" action="{{ route('logUser') }}" method="POST">
                    @csrf
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                        <input name="email" type="email" class="form-control" id="inputEmail" placeholder="@lang('public.email')">
                    </div>
                    @error('email')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fa-solid fa-key"></i></span>
                        <input name="password" type="password" class="form-control" id="inputPassword"
                            placeholder="@lang('public.password')">
                    </div>
                    @error('password')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <button type="submit" class="btn btn-primary btn-block w-100">@lang('public.login')</button>
                </form>
                <p class="w-100 text-center mt-3">
                    <a href="/registration" class="text-decoration-none">@lang('public.create_acc')</a>
                </p>
            </div>
        </div>
    </section>
@endsection
