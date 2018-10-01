<?php

namespace App\Http\Controllers;

use function auth;
use Illuminate\Http\Request;
use function json_encode;
use LRedis;
use App\Events\MessageSent;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redis = LRedis::connection();
        $redis->publish('message',json_encode(['date'=>date('Y-m-d')]));
        return view('home');
    }

    public function send()
    {
        $redis = LRedis::connection();
        $data = ['message' => request()->input('message'), 'user' => request()->input('user')];
        $message = json_encode($data);
        $redis->publish('message',$message );
        return $message;
    }
}
