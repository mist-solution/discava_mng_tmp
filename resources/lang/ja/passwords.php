<?php

return [

    /*
    |--------------------------------------------------------------------------
    | パスワードリセット言語行
    |--------------------------------------------------------------------------
    |
    | 以下の言語行は既存のパスワードを無効にしたい場合に、無効なトークンや
    | 新しいパスワードが入力された場合のように、パスワードの更新に失敗した
    | 理由を示すデフォルトの文言です。
    |
    */

    'reset' => 'パスワードがリセットされました。',
    'sent' => 'パスワードリセットのメールを送信しました。',
    'throttled' => '再送信はしばらくお待ちください。',
    'token' => 'このパスワードリセットトークンは無効です。',
    'user' => '登録されていないメールアドレスです。',
    'password_requirements' => [
        '[0-9]'             => 'パスワードは半角英数字及び記号（「-」「_」「%」「$」「#」）を含む、12文字以上72文字以内で入力してください。',
        '[a-z,A-Z]'         => 'パスワードは半角英数字及び記号（「-」「_」「%」「$」「#」）を含む、12文字以上72文字以内で入力してください。',
        '[-_%$#]'           => 'パスワードは半角英数字及び記号（「-」「_」「%」「$」「#」）を含む、12文字以上72文字以内で入力してください。',
    ]
];
