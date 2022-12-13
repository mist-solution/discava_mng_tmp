<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SendMailController extends Controller
{
    /**
     * Display the form
     *
     * @return \Illuminate\View\View
     */
    public function showSendmailForm()
    {
        return view('auth.passwords.sendmail');
    }
}
