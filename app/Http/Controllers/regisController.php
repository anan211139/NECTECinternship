<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $message = new Manager;
            $message->name = $name;
            $message->username = $username;
            $message->password = $password;
            $message->email = $email;
            $message->save();
            return redirect('/')->with('failregis','DONE Firstuser');
        }else{
            for($i = 0;$i<count($userresult);$i++){
                if($userresult[$i]["username"] == $username){
                    return redirect('/')->with('failregis','error_username');
                }
            }
            if($password == $repassword){
                $message = new Manager;
                $message->name = $name;
                $message->username = $username;
                $message->password = $password;
                $message->email = $email;
                $message->save();
                return redirect('/')->with('failregis','DONE');
            }else{
                return redirect('/')->with('failregis','Password and Re-Password not match');
            }
        }
        


    }
}
