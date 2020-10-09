<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Detail;

use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{   
    // public function show($id){
    //     return Detail::findOrFail($id);
    // }

    public function create(Request $request){
        $this->validate($request, [
            'age' => 'required',
            'city' => 'required'
        ]);
        $data = $request->only(['age', 'city']);
        
        $user = $this->authUser();

        // dd($user->details()->count());
        
        // Check if the detail belongs to this user AND if user already has a detail post 
        if($user->details()->count() == 0)
        {
            $detail = $user->details()->create($data);
            return $detail;
        } else {
            return response()->json("You already have the details set.", 401);
        }

    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'age' => 'required',
            'city' => 'required'
        ]);
        $data = $request->only(['age', 'city']);
        $findDetail = Detail::findOrFail($id);

        $user = $this->authUser();
        
        if($user->id == $findDetail->user_id)
        {
            $findDetail->update($data); 
            return $findDetail;
        } else {
            return response()->json("These details are not yours", 401);
        }

    }
    public function delete($id){
        $findDetail = Detail::findOrFail($id);
        
        $user = $this->authUser();

        if($user->isAdmin || $user->id == $findDetail->user_id)
        {
            $findDetail->delete();
            return response('Deleted Successfully', 200);
        } else {
            return response()->json("You're not authorized", 401);
        }

    }

    public function show($id){
        $findDetail = Detail::findOrFail($id);

        $user = $this->authUser();
        if($user->isAdmin || $user->id = $findDetail->user_id){
            return $findDetail;
        } else {
            return response()->json('You\'re not authorized to see these details', 401);
        }
    }

    // public function admin(){
        // $user = auth()->user()->isAdmin;
        // $post = $user->isAdmin;

        // $userTwo = $this->authUser();
        // dd($userTwo);

        // dd($user);
    // }

}
