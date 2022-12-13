@extends('layouts.app')

@section('content')
<div class="container">
    <div class="body__gap--control"></div>
    <div class="row justify-content-center">
        <div class="col-sm-8 col-lg-4 col-10">
            <div class="card card_modify">
                <div class="card-body discavaMate_cardBody">
                    <div class="col-md-10 offset-md-1">
                        <div class="discavaMate_title font--fammily__AN">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    @csrf
                    <div class="form-group row mb-3">
                        <div class="col-md-10 offset-md-1 sendmail_subTitle">
                            ご登録のメールアドレスへ、パスワード再設定用のメールをお送りしました。<br>
                            メールの本文中に記載されているURLをクリックしてパスワードの再設定を行なってください。<br>
                            <br>
                        </div>
                        <div class="col-md-10 offset-md-1 sendmail_subTitle sendmail_komeNotice">
                            ※再設定用URLの有効期限は60分です。
                        </div>
                        <div class="col-md-10 offset-md-1 sendmail_subTitle sendmail_komeNotice">
                            ※メールが届かない場合は、迷惑メールフォルダ等に入っていないかご確認ください。
                        </div>
                    </div>
                    <div class="mb-0 justify-content-center">
                        <div class="d-grid justify-content-center">
                            <a class="btn btn_green sendmail_btnBackToLogin" href="{{ route('login') }}">
                                {{ __('戻る') }}
                            </a>
                        </div>
                    </div>
                    <div class="row mb-0 justify-content-center text-center">
                        @if (Route::has('password.request'))
                        <a class="sendmail_link" href="{{ route('password.request') }}">
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