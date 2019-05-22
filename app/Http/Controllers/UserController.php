<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function getUserById($id, Request $request){
        if($request->has('hosted') || $request->has('participated')){
            $hosted = FALSE;
            $participated = FALSE;
            if($request->has('hosted')){
                $hosted = (bool)$request->input('hosted');
            }
            if($request->has('participated')){
                $participated = (bool)$request->input('participated');
            }
            if(!$hosted && !$participated){
                $user = User::findOrFail($id);
                return $user;
            }
            $users;
            if($hosted){
                if($participated){
                    $users = User::with('hosted','participated')->get();
                }else{
                    $users = User::with('hosted')->get();
                }
            }
            if(!$hosted && $participated){
                $users = User::with('participated')->get();
            }
            foreach($users as $user){
                if($user->id == $id){
                    return $user;
                }
            }
            abort(404);
        }
        return User::findOrFail($id);
    }

    public function getAllUsers(){
        $users = User::all();
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
        $users = User::with('hosted')->withCount('hosted')->get();
        foreach($users as $user){
            if($user->id == $id){
                return $user->hosted;
            }
        }
        abort(404);
    }
    public function getParticipatedEvents($id){
        $users = User::with('participated')->withCount('participated')->get();
        foreach($users as $user){
            if($user->id == $id){
                return $user->participated;
            }
        }
        abort(404);
    }
}
