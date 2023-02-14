@extends('layouts.app')

@section('content')
<div class="container">
    <div class=" body__gap--control"></div>
    <div class="row col-11 discavaMate_cardMl justify-content-center align-items-center">
        <div class="col-sm-8 col-lg-5 col-12">
            <div class="card card_modify">
                <div class="card-body discavaMate_cardBody">
                    <div class="offset-md-2">
                        <div class="discavaMate_title font--fammily__AN">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    <!-- エラーメッセージ -->
                    <div class="col-md-8 offset-md-2 error-container">
                        @if($errors->any())
                        @foreach($errors->all() as $error)
                        <div class="discavaMate_errorMsg">{{ $error }}</div>
                        @endforeach
                        @endif
                    </div>

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group row mb-3">
                            <div class="col-md-8 offset-md-2">
                                <label for="email" class="col-md-8 col-form-label text-md-left discavaMate_colName">{{ __('メールアドレス') }}</label>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror discavaMate_textInput" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus onblur="validateEmail()">
                                <!-- @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror -->
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-8 offset-md-2">
                                <label for="password" class="col-md-8 col-form-label text-md-left discavaMate_colName">{{ __('パスワード') }}</label>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror discavaMate_textInput" name="password" required autocomplete="current-password">
                                <!-- @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror -->
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
                        <div class="row mb-0 justify-content-center text-center mt-2">
                            @if (Route::has('password.request'))
                            <a class="login_link mb-3 mb-sm-2" href="{{ route('password.request') }}">
                                {{ __('パスワードを忘れた場合はこちら') }}
                            </a>
                            @endif

                            @if (Route::has('password.request'))
                            <a class="login_link" href="mailto:info@discava.net">
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
@verbatim
<!-- メールアドレスのバリデーション（RFC） -->
<script type="text/javascript">
    function validateEmail() {
        var email = document.getElementById("email").value;
        var errorContainer = document.querySelector('.error-container');
        if (email) {
            var emailRegxp = /^(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])$/;
            if (emailRegxp.test(email) != true) {
                var errorMessage = 'メールアドレスには、有効なメールアドレスを入力してください。';
                errorContainer.innerHTML = '<div class="discavaMate_errorMsg">' + errorMessage + '</div>';
                document.getElementById('email').focus();
                // document.getElementById('email').select();
            } else {
                errorContainer.innerHTML = '';
            }
        }
    }
</script>
@endverbatim