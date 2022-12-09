@extends('layouts.app')

@section('content')
<div class="container">
    <div class=" body__gap--control"></div>
    <div class="row justify-content-center align-items-center">
        <div class="col-sm-8 col-lg-4 col-10">
            <div class="card card_modify">
                <!-- <div class="card-header">{{ __('DISCaVa MATE') }}</div> -->
                <div class="card-body discavaMate_cardBody">
                    <div class="offset-md-1">
                        <div class="discavaMate_title font--fammily__AN">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-1">
                                <label for="email" class="col-md-8 col-form-label text-md-left">{{ __('メールアドレス') }}</label>
                            </div>
                            <div class="col-md-10 offset-md-1">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror discavaMate_textInput" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback login_errorMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-1">
                                <label for="password" class="col-md-8 col-form-label text-md-left">{{ __('パスワード') }}</label>
                            </div>
                            <div class="col-md-10 offset-md-1">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror discavaMate_textInput" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback login_errorMsg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- Remember Me コメントアウト -->
                        <!-- <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <!-- Remember Me コメントアウト -->

                        <div class="mb-0 justify-content-center">
                            <div class="d-grid justify-content-center">
                                <button type="submit" class="btn btn_green login_btnLogin">
                                    {{ __('ログイン') }}
                                </button>
                            </div>
                        </div>
                        <div class="row mb-0 justify-content-center text-center">
                            @if (Route::has('password.request'))
                            <a class="login_link" href="{{ route('password.request') }}">
                                {{ __('パスワードを忘れた場合はこちら') }}
                            </a>
                            @endif

                            @if (Route::has('password.request'))
                            <a class="login_link" href="{{ route('password.request') }}">
                                {{ __('ログインに関するお問い合わせ') }}
                            </a>
                            @endif
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection