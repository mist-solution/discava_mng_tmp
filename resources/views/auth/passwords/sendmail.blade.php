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
                    @csrf
                    <div class="form-group row mb-3">
                        <div class="col-md-8 offset-md-2 sendmail_subTitle">
                            ご登録のメールアドレスへ、パスワード再設定用のメールをお送りしました。<br>
                            メールの本文中に記載されているURLをクリックしてパスワードの再設定を行なってください。<br>
                            <br>
                        </div>
                        <div class="col-md-8 offset-md-2 sendmail_subTitle sendmail_komeNotice">
                            ※再設定用URLの有効期限は60分です。
                        </div>
                        <div class="col-md-8 offset-md-2 sendmail_subTitle sendmail_komeNotice">
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
                        <a class="sendmail_link" href="mailto:info@discava.net">
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