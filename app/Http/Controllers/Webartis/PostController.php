<?php

namespace App\Http\Controllers\Webartis;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Webartis\Post;
use App\User;
use Validator;
use Response;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        return $post = Post::join('users', 'posts.id', '=', 'users.id')->orderBy('title', 'desc')->paginate(4);

        return $users = User::all();


        return view('post.index', compact('post'));

        //$post = DB::table('posts')->paginate(4);
        //return $post;
        //dd($post);
        
        //return Post::findOrFail(5);
        //return Post::max('id');
        return Post::count();
    }

    public function addPost(Request $request)
    {
        $rules = array(
            'title' => 'required',
            'body' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Response::json(
                array('errors'=> $validator->getMessageBag()->toarray())
            );
        } else {
            $post = new Post;
            $post->title = $request->title;
            $post->body = $request->body;
            $post->save();
            return response()->json($post);
        }
    }

    public function editPost(request $request)
    {
        $post = Post::find($request->id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();
        return response()->json($post);
    }

    public function deletePost(request $request){
        $post = Post::find($request->id)->delete();
        return response()->json();
    }
}
