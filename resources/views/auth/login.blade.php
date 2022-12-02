@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card card_modify">
                <!-- <div class="card-header">{{ __('DISCaVa MATE') }}</div> -->
                <div class="card-body login_cardBody">
                    <div class="offset-md-1">
                        <div class="login_title font--fammily__AN">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-1">
                                <label for="login_user_id" class="col-md-8 col-form-label text-md-left">{{ __('ユーザID') }}</label>
                            </div>
                            <div class="col-md-10 offset-md-1">
                                <input id="login_user_id" type="text" class="form-control @error('login_user_id') is-invalid @enderror login_textInput" name="login_user_id" value="{{ old('login_user_id') }}" required autocomplete="login_user_id" autofocus>
                                @error('login_user_id')
                                <span class="invalid-feedback" role="alert">
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
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror login_textInput" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
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
                            <div class="d-grid justify-content-center login_btnLogin">
                                <button type="submit" class="btn btn_green">
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