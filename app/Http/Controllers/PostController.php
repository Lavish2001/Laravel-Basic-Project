<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    // UPLOAD USER POST //
    function upload(Request $req){
        if($req->hasFile('image')){
            if($req->file('image')->getClientOriginalExtension() == 'webp' || $req->file('image')->getClientOriginalExtension() == 'jpg' || $req->file('image')->getClientOriginalExtension() == 'jpeg'){
                $currentDateTime = Carbon::now()->format('YmdHis');
                $filename = $currentDateTime. "-" .$req->file('image')->getClientOriginalName();
                $req->file('image')->storeAs('Posts', $filename);

                // Get user from session
                $user = $req->session()->get('user');
                
                // Upload a post 
                $post = Post::create([
                    'owner_id' => $user->id,
                    'image' => $filename,
                    'description' => $req->input('description') ? $req->input('description') : ""
                ]);
                return response()->json(['status' => 'RXSUCCESS', 'message' => 'File Uploaded.' ], 200);
            }else{
                return response()->json(['status' => 'RXERROR', 'message' => 'File format not supported.'], 400);
            }
        }else{
            return response()->json(['status' => 'RXERROR', 'message' => 'No file selected.'], 400);
        }
    }




    // DELETE USER POST //
    function delete(Request $req){
        if($req->query('id')){
            $user = $req->session()->get('user');
            $deletePost = Post::where(['id' => $req->query('id'), 'owner_id' => $user->id])->first();
            if($deletePost){
                $deletePost->delete();
                return response()->json(['status' => 'RXSUCCESS', 'message' => 'Post deleted.'], 200);
            }else{
                return response()->json(['status' => 'RXERROR', 'message' => 'No post found.'], 400);
            }   
        }else{
            return response()->json(['status' => 'RXERROR', 'message' => 'No post selected.'], 400);
        }
    }




    // COMMENT ON POST //
    function comment(Request $req){

        // Validate comment
        $validator = Validator::make($req->all(),[
            'comment' => 'required',
            'id'=> 'required'
        ]);
        
        // If validation fails, return the errors
            if ($validator->fails()) {
            return response()->json(['status' => 'RXERROR', 'message' => $validator->errors()], 400);
        }

        $user = $req->session()->get('user');
        $comment = Comment::create([
           'post_id'=>$req->query('id'),
           'user_id'=>$user->id,
           'comment'=>$req->input('comment')
        ]);

        if($comment){
            return response()->json(['status' => 'RXSUCCESS', 'message' => 'Comment post successfully.'], 200);
        }else{
            return response()->json(['status' => 'RXERROR', 'message' => 'failed.'], 400);
        }

    }




    // USER LIVE POST //
    function live(Request $req){
        $image = $req->route('name');
        $path = storage_path('app\\Posts\\'. $image);
        return response()->file($path);
    }




    // USER ALL DETAILS //
    function all(Request $req){
        $user = $req->session()->get('user');
        $users = User::with('user_post.post_comment')->find($user->id);
        return response()->json(['status' => 'RXSUCCESS', 'data' => $users], 200);
    }




    // USER ALL POSTS //
    function allPosts(Request $req){
        $user = $req->session()->get('user');
        $posts = Post::where(['owner_id' => $user->id])->paginate(2);
        // $posts = Post::with('post_comment')->where('owner_id', $user->id)->paginate(2);
        return response()->json(['status' => 'RXSUCCESS', 'data' => $posts], 200);
    }
}
