@extends('template')

@section('title')
    сторінка шаблону
@endsection

@section('content')
    <section>
        <div class="container">
            <div class="signup-container"
                style="max-width: 400px; margin: 50px auto; padding: 40px; background-color: #fff; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                <h2 class="signup-heading text-center" style="margin-bottom: 30px;">Sign Up</h2>
                <form class="signup-form" action="{{ route('regUser') }}" method="POST">
                    @csrf
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input name="name" type="text" class="form-control" id="inputName" placeholder="Name">
                    </div>
                    @error('name')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fas fa-at"></i></span>
                        <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email">

                    </div>
                    @error('email')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input name="password" type="password" class="form-control" id="inputPassword"
                            placeholder="Password">
                    </div>
                    @error('password')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <div class="mb-3 input-group">
                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                        <input name="password_confirmation" type="password" class="form-control" id="inputRepeatPassword"
                            placeholder="Repeat Password">

                    </div>
                    @error('password_confirmation')
                        <p class="text-danger">
                            {{ $message }}
                        </p>
                    @enderror
                    <button type="submit" class="btn btn-primary btn-block w-100">Sign Up</button>
                </form>
                <p class="w-100 text-center mt-3">
                    <a href="/login" class="text-decoration-none">Already have an account? Login</a>
                </p>
            </div>
        </div>
    </section>
@endsection
