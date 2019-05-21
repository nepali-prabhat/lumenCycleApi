<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function getUserById($id){
        $user = User::findOrFail($id);
        return $user;
    }

    public function getAllUsers(){
        $users = User::with('hosts')->get();
        return $users;
    }

    public function addUser(Request $request){
        $this->validate($request,[
            'f_name'=>'required|min:3',
            'l_name'=>'required',
            'phone'=>'required|size:10',
            'active'=>'required'
        ]);
        $values_encoded = json_encode($request->all());
        $values_decoded = json_decode($values_encoded,true);
        $values_decoded["active"] = (bool)$values_decoded["active"];
        $user=User::create($values_decoded);
        return $user;
    }

    public function updateUser($id,Request $request){
        $user = User::findOrFail($id);

        if($request->has('f_name')){
            $user->f_name = $request->input('f_name');
        }
        if($request->has('l_name')){
            $user->l_name = $request->input('l_name');
        }
        if($request->has('phone')){
            $user->phone = $request->input('phone');
        }
        if($request->has('active')){
            $user->active = (bool)$request->input('active');
        }

        $user->save();

        return $user;
    }

    public function deleteUser($id){
        $user = User::findOrFail($id);
        $name = "$user->f_name $user->l_name";
        $user->delete();
        return [
            "msg"=>"$name deleted.",
        ];
    }

    public function getHostedEvents($id){
        $users = Users::with('hosted')->get();
        return $users;
    }
}
