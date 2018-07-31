<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Manager;

class regisController extends Controller
{
    public function process(Request $request){
        $name = $request->input('nameRegis');
        $username = $request->input('uname');
        $password = $request->input('psw');
        $repassword = $request->input('repsw');
        $email = $request->input('email');
        $userresult = Manager::all();
        if(count($userresult)==0){
            if($password == $repassword){
                $message = new Manager;
                $message->name = $name;
                $message->username = $username;
                $message->password = Hash::make($password);
                $message->email = $email;
                $message->save();
                return redirect('/')->with('regis','DONE Firstuser');
            }else{
                return redirect('/')->with('regis','Password and Re-Password not match');
            }
        }else{
            for($i = 0;$i<count($userresult);$i++){
                if($userresult[$i]["username"] == $username){
                    return redirect('/')->with('regis','error_username');
                }
            }
            if($password == $repassword){
                $message = new Manager;
                $message->name = $name;
                $message->username = $username;
                $message->password = Hash::make($password);
                $message->email = $email;
                $message->save();
                return redirect('/')->with('regis','DONE');
            }else{
                return redirect('/')->with('regis','Password and Re-Password not match');
            }
        }



    }

    public function processinaddchild(Request $request){
        $name = $request->input('nameRegis');
        $username = $request->input('uname');
        $password = $request->input('psw');
        $repassword = $request->input('repsw');
        $email = $request->input('email');
        $userresult = Manager::all();
        if(count($userresult)==0){
            if($password == $repassword){
              $message = new Manager;
              $message->name = $name;
              $message->username = $username;
              $message->password = Hash::make($password);
              $message->email = $email;
              $message->save();
                return redirect('/addchild')->with('regis','DONE Firstuser');
            }else{
                return redirect('/addchild')->with('regis','Password and Re-Password not match');
            }
        }else{
            for($i = 0;$i<count($userresult);$i++){
                if($userresult[$i]["username"] == $username){
                    return redirect('/addchild')->with('regis','error_username');
                }
            }
            if($password == $repassword){
              $message = new Manager;
              $message->name = $name;
              $message->username = $username;
              $message->password = Hash::make($password);
              $message->email = $email;
              $message->save();
                return redirect('/addchild')->with('regis','DONE');
            }else{
                return redirect('/addchild')->with('regis','Password and Re-Password not match');
            }
        }



    }
}
