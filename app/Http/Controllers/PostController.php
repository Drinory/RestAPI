<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Post;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(){
        return Post::all();
    }

    public function self(){

        //auth->user checks if the token matches
        // $posts = auth()->user()->posts;

        // authUser is defined in Controller.php
        $user = $this->authUser();

        
        return $user->posts;
    }

    public function show($id){
        return Post::findOrFail();
    }

    public function create(Request $request){
        $data = $request->only('title');
        
        $user = $this->authUser();

        $post = $user->posts()->create($data);
        return $post;

    }

    public function update(Request $request, $id){
        
        $data = $request->only('title');
        $findPost = Post::findOrFail($id);

        $user = $this->authUser();
        
        $findPost->update($data); 

        return $findPost;

    }
    public function delete($id){
        $findPost = Post::findOrFail($id);
        
        $this->authUser();

        $findPost->delete();
        
        return response('Deleted Successfully', 200);
    }

}
