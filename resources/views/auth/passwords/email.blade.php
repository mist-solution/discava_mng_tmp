@extends('layouts.app')

@section('content')
<div class="container">
    <div class="body__gap--control"></div>
    <div class="row justify-content-center">
        <div class="col-sm-8 col-lg-4 col-10">
            <div class="card card_modify">
                <!-- <div class="card-header">{{ __('パスワードリセット') }}</div> -->
                <div class="card-body email_cardBody">
                    <div class="col-md-10 offset-md-1">
                        <div class="discavaMate_title font--fammily__AN">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <div class="col-md-10 offset-md-1 email_subTitle">
                                ご登録いただいているメールアドレスを入力してください。<br>
                                パスワード再設定ページのURLをお送りします。
                            </div>
                            <div class="col-md-10 offset-md-1">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror email_textInput" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('メールアドレス') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div> -->
                        <div class="mb-0 justify-content-center">
                            <div class="d-grid justify-content-center email_btnSubmit">
                                <button type="submit" class="btn btn_green">
                                    {{ __('送信する') }}
                                </button>
                            </div>
                        </div>
                        <!-- <div class="row mb-0">
                            <div class="d-grid justify-content-center email_btnLogin">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('パスワードリセットリンクを送信') }}
                                </button>
                            </div>
                        </div> -->

                        <div class="row mb-0 justify-content-center text-center">
                            @if (Route::has('password.request'))
                            <a class="email_link" href="{{ route('password.request') }}">
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