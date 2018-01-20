<?php

namespace App\Http\Controllers;

use Auth;
use App\Post;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::latest('updated_at')
            ->paginate(5);
        return view(
            'home',
            compact('posts')
        );
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function posts(Post $post)
    {
        return view(
            'post',
            compact('post')
        );
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendLike(Request $request, Post $post)
    {
        $triggered_user = Auth::user();

        $data = [
            'type' => 'いいね',
        ];

        Mail::to($post->user)
            ->send(new SendMail($post, $triggered_user, $data));

        return response()->json(['status' => 0]);
    }
}
