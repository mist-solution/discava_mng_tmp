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
                        @foreach($errors->all() as $error)
                        <div class="discavaMate_errorMsg">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>

                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-2 email_subTitle">
                                ご登録いただいているメールアドレスを入力してください。<br>
                                パスワード再設定ページのURLをお送りします。
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror discavaMate_textInput" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <!-- @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror -->
                            </div>
                        </div>
                        <div class="mb-0 justify-content-center">
                            <div class="d-grid justify-content-center">
                                <button type="submit" class="btn btn_green email_btnSubmit">
                                    {{ __('送信する') }}
                                </button>
                            </div>
                        </div>
                        <div class="row mb-0 justify-content-center text-center">
                            @if (Route::has('password.request'))
                            <a class="email_link" href="mailto:info@discava.net">
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