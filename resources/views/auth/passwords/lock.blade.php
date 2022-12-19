@extends('layouts.app')

@section('content')
<div class="container">
    <div class="body__gap--control"></div>
    <div class="row col-11 discavaMate_cardMl justify-content-center align-items-center">
        <div class="col-sm-8 col-lg-5 col-12">
            <div class="card card_modify">
                <div class="card-body discavaMate_cardBody">
                    <div class="offset-md-2 offset-1">
                        <div class="discavaMate_title font--fammily__AN">{{ __('DISCaVa MATE') }}</div>
                    </div>
                    @csrf
                    <div class="row mb-3 col-10 col-md-8 offset-1 offset-md-2 lock_alertBorder">
                        <div class="col-md-10 lock_alertIcon">
                            <!-- <span class="mdi mdi-alert-outline lock_alertIcon"></span> -->
                            <img src="/images/errorIcon.png" class="lock_errorIcon" alt="アラートアイコン"></img>
                            <span class="lock_title">アカウントがロックされました</span>
                        </div>
                        <div class="col-md-12 lock_subTitle">
                            連続でロブインを失敗したためアカウントをロック(保護)しました。
                            パスワードを再設定してロック解除を行なってください。
                        </div>
                    </div>
                    <div class="mb-0 justify-content-center">
                        <div class="d-grid justify-content-center">
                            <a class="btn btn_green lock_btnSubmit" href="{{ route('password.request') }}">
                                {{ __('パスワード再設定') }}
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