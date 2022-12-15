@extends('layouts.app')

@section('content')
<div class="container">
    <div class="body__gap--control"></div>
    <div class="row col-11 discavaMate_cardMl justify-content-center align-items-center">
        <div class="col-sm-8 col-lg-5 col-12">
            <div class="card card_modify">
                <div class="card-body discavaMate_cardBody">
                    <div class="offset-md-2">
                        <div class="discavaMate_title font--fammily__AN">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    @csrf
                    <div class="form-group row mb-3">
                        <div class="col-md-8 offset-md-2 complete_subTitle">
                            パスワード設定完了
                        </div>
                        <div class="col-md-8 offset-md-2 complete_text">
                            新しいパスワードの設定が完了しました。<br>
                            下記のボタンよりログインしてください。
                        </div>
                    </div>
                    <div class="mb-0 justify-content-center">
                        <div class="d-grid justify-content-center">
                            <a class="btn btn_green complete_btnBackToLogin" href="{{ route('login') }}">
                                {{ __('ログイン画面へ') }}
                            </a>
                        </div>
                    </div>
                    <div class="row mb-0 justify-content-center text-center">
                        @if (Route::has('password.request'))
                        <a class="complete_link" href="{{ route('password.request') }}">
                            {{ __('ログインに関するお問い合わせ') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection