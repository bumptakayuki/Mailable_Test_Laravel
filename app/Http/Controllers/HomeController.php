<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Post;
use App\Mail\SendMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Events\PublicAlertCreated;
use App\Events\PersonalAlertCreated;

/**
 * Class HomeController
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * @var array
     */
    private $types = [
        'like'     => 'いいね',
        'dislike'  => 'やだね',
        'whatever' => 'どうでもいい',
        'yourname' => '君の名は？',
    ];

    /**
     * @var null
     */
    private $triggered_user = null;
    /**
     * @var null
     */
    private $data = null;

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
        $this->setAlertData($request);

        // いいねのときはユーザー全員に知らせる
        event(new PublicAlertCreated($post, $this->triggered_user, $this->data));

        return response()->json(['status' => 200]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendDislike(Request $request, Post $post)
    {
        $this->setAlertData($request);

        // やだねのときは本人だけに知らせる
        event(new PersonalAlertCreated($post, $this->triggered_user, $this->data));


        return response()->json(['status' => 200]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendWhatever(Request $request, Post $post)
    {
        $this->setAlertData($request);

        // どうでもいいときは誰にも知らせない

        return response()->json(['status' => 200]);
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendYourname(Request $request, Post $post)
    {
        $this->setAlertData($request);

        // 君の名は？のときは本人だけに知らせる
        event(new PersonalAlertCreated($post, $this->triggered_user, $this->data));

        return response()->json(['status' => 200]);
    }

    /**
     * @param $request
     */
    private function setAlertData($request) {
        $this->triggered_user = Auth::user();

        $this->data = [
            'type' => $this->types[$request->type],
        ];
    }

}
