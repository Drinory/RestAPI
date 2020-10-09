<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        $post = Post::all();
        return $post;
    }
    
    public function show($id){
        return Post::findOrFail($id);
    }

    public function create(Request $request){
        $this->validate($request, [
            'title' => 'required'
        ]);
        $data = $request->only('title');
        
        $user = $this->authUser();

        if($user->isAdmin || $user->id == $findPost->user_id)
        {
            $post = $user->posts()->create($data);
            return $post;
        } else {
            return response()->json("You're not authorized", 401);
        }

    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'title' => 'required'
        ]);
        $data = $request->only('title');
        $findPost = Post::findOrFail($id);

        $user = $this->authUser();
        
        $findPost->update($data); 

        return $findPost;

    }
    public function delete($id){
        $findPost = Post::findOrFail($id);
        
        $user = $this->authUser();

        if($user->isAdmin || $user->id == $findPost->user_id)
        {
            $findPost->delete();
            return response('Deleted Successfully', 200);
        } else {
            return response()->json("You're not authorized", 401);
        }
    }

    public function self(){

        //auth->user checks if the token matches
        // $posts = auth()->user()->posts;

        // authUser is defined in Controller.php
        $user = $this->authUser();

        
        return $user->posts;
    }


}
