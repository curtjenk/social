<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
     public function getDashboard(Request $request)
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return view('dashboard', ['posts' => $posts]);
    }
    
    public function postCreatePost(Request  $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);
        $message = 'There was an error';
        $post = new Post();
        $post->body = $request['body'];
        if ($request->user()->posts()->save($post)) {  // attaches/relates the post to the user.  populates user_id in the posts table
            $message = 'Post successfully created';
        }
      //"with" puts the array in the Session
      // retrieve using the Session facade
        return redirect()->route('dashboard')->with(['message' => [$message]]);
    }
    
    public function getDeletePost($post_id) {
        $post = Post::where('id', '=', $post_id)->first();  //where() will return an array
        
        //Delete only posts that belong to the logged-in user
        //logic is also in the UI 'dashboard.blade.php'
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
            
        $post->delete();
        //TODO: Is there a delete where id=post type of synta??
        //alternative $post = Post::find($post_id)
        
        return redirect()->route('dashboard')->with( ['message'=>['Successfully deleted']] );
    }

    public function postEditPost(Request $request) {
        $this->validate($request, [
            'body' => 'required|max:1000'
        ]);
        $post = Post::find($request['postId']); //by defaul 'find' looks at the primary key
        
         //Update only posts that belong to the logged-in user
        //logic is also in the UI 'dashboard.blade.php'
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }
        
        $post->body = $request['body'];
        $post->update();
        return response()->json(['message'=>'Post Edited!', 'new_body'=>$post->body],200);
    }
    
}
