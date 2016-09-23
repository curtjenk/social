<?php

namespace App\Http\Controllers;

use App\Post;
use App\Like;
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

    public function getDeletePost($post_id)
    {
        $post = Post::where('id', '=', $post_id)->first();  //where() will return an array

        //Delete only posts that belong to the logged-in user
        //logic is also in the UI 'dashboard.blade.php'
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }

        $post->delete();
        //TODO: Is there a delete where id=post type of synta??
        //alternative $post = Post::find($post_id)

        return redirect()->route('dashboard')->with(['message' => ['Successfully deleted']]);
    }

    public function postEditPost(Request $request)
    {
        $this->validate($request, [
            'body' => 'required|max:1000',
        ]);
        $post = Post::find($request['postId']); //by defaul 'find' looks at the primary key

         //Update only posts that belong to the logged-in user
        //logic is also in the UI 'dashboard.blade.php'
        if (Auth::user() != $post->user) {
            return redirect()->back();
        }

        $post->body = $request['body'];
        $post->update();

        return response()->json(['message' => 'Post Edited!', 'new_body' => $post->body], 200);
    }

// this function handles both Like and Dislike user clicks
    public function postLikePost(Request $request)
    {
        $post_id = $request['postId'];
        $is_like = $request['isLike'] === 'true' ? true : false;   //comes over as a string so convert to boolean
        //in the above True=user clicked "Like" and False=user clicked "Dislike"
        $update = false;
        $post = Post::find($post_id);
        if (!$post) {   //this shouldn't happen
            return null;
        }
        $user = Auth::user();
        //check if user already likes this post
        $like = $user->likes()->where('post_id', $post_id)->first(); //should be only one but we don't want a query builder object.
        //Now check if user already registered a "like" or "dislike" for the post
        if ($like) {
            //Yes, he did.  But was it a "like" or "dislike".
            //$already_like = $like->like; //True already like, else false not already like
            $update = true;
            //checking if user wants to reverse his previous like or dislike.
            //if like=true and user clicked the like button OR ..
            //if like=false and user clicked the dislike button
            //  then Delete the like row
            if ($like->like == $is_like) {
                $like->delete();

                return null;  //TODO: Don't we want to update the UI?
            }
        } else {
            $like = new Like();
        }
        $like->like = $is_like;
        $like->user_id = $user->id;
        $like->post_id = $post->id;
        if ($update) {
            $like->update();
        } else {
            $like->save();
        }

        return null;
    }
}
