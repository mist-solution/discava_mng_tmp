@extends('layouts.app')

@section('content')
<div class="container">
    <div class="body__gap--control"></div>
    <div class="row col-11 discavaMate_cardMl justify-content-center align-items-center">
        <div class="col-sm-8 col-lg-5 col-12">
            <div class="card card_modify">
                <div class="card-body discavaMate_cardBody">
                    <div class="offset-md-2">
                        <div class="discavaMate_title">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    <!-- エラーメッセージ -->
                    <div class="col-md-8 offset-md-2 error-container">
                        @if($errors->any())
                        <ul class="discavaMate_errorMsg">
                            @foreach($errors->all() as $error)
                            {{ $error }}<br>
                            @endforeach
                        </ul>
                        @endif
                    </div>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-2">
                                <label for="email" class="col-md-8 col-form-label text-md-left discavaMate_colName">{{ __('メールアドレス') }}</label>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror discavaMate_textInput reset_textReadonly" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" readonly>
                                <!-- @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-2">
                                <label for="password" class="col-md-8 col-form-label text-md-left discavaMate_colName">{{ __('新パスワード') }}</label>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror discavaMate_textInput" name="password" required autocomplete="new-password" autofocus>
                                <!-- @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-2">
                                <label for="password-confirm" class="col col-form-label text-md-left discavaMate_colName">{{ __('新パスワード（確認）') }}</label>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <input id="password-confirm" type="password" class="form-control discavaMate_textInput" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="mb-0 justify-content-center">
                            <div class="d-grid justify-content-center">
                                <button type="submit" class="btn btn_green reset_btnReset">
                                    {{ __('パスワード設定') }}
                                </button>
                            </div>
                        </div>

                        <div class="row mb-0 justify-content-center text-center">
                            @if (Route::has('password.request'))
                            <a class="reset_link" href="mailto:info@discava.net">
                                {{ __('ログインに関するお問い合わせ') }}
                            </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection