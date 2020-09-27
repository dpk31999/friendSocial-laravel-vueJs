<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Illuminate\Http\Request;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('user_id',$request->user()->id)->orderBy('id','desc')->toSql();
        return response()->json($posts, 200);
    }

    public function getByUsername($username)
    {
        $user = User::where('username',$username)->first();
        $posts = Post::where('user_id',$user->id)->orderBy('id','desc')->get();

        return response()->json($posts, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request,[
            'title' => 'required|max:255',
            'url_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $image = $this->handleUpload($request);

        $post = Post::create([
            'user_id' => $request->user()->id,
            'title' => $request->title,
            'url_image' => $image,
        ]);

        return response()->json($post, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json($post, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->validate($request,[
            'title' => 'required|max:255'
        ]); 

        $post->title = $request->title;
        $post->save();

        return response()->json($post, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->deleteExistImage($post);

        $post->delete();

        return response()->json([
            'message' => 'Success'
        ], 200);
    }

    public function handleUpload($request)
    {
        $postService = PostService::create();

        $image = $postService->handleUploadImagePost($request);

        return $image;
    }

    public function deleteExistImage($post)
    {
        $postService = PostService::create();

        $postService->handleDeleteImagePost($post);
    }

    public function getPostFriend(User $user)
    {
        $friendRequest = $user->friendRequest;

        $friendAccept = $user->friendAccept;

        $friends = $friendRequest->merge($friendAccept);

        $id_friends = $friends->pluck('id');

        $posts = Post::whereIn('user_id',$id_friends)->orderBy('id','desc')->get();

        foreach($posts as $post)
        {
            $post->name = $post->user->name;
            $post->url_avatar_user = $post->user->url_avatar;
            $post->username = $post->user->username;
        }

        return response()->json($posts, 200);
    }
}
