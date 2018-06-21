<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;

class regisController extends Controller
{
    public function psregis(Request $request){
        $PRname = "temp";
        $username = $request->input('uname');
        $password = $request->input('psw');
        $repassword = $request->input('repsw');
        $email = $request->input('email');
        if($password == $repassword){
            $userresult = Manager::all();
            for($i = 0;$i<count($userresult);$i++){
                if($userresult[$i]["UNPR"] == $username){
                    return 123;
                }
                else{
                    insertuser($username,$password,$email,$PRname);
                }
            }  
        }else{
            return redirect('/')->with('failregis','Password and Re-Password not match');
        } 
    }

    function insertuser($username,$password,$email,$PRname){
        $message = new Manager;
        $message->PRname = $PRname;
        $message->UNPR = $username;
        $message->PWPR = $password;
        $message->PREmail = $email;
        $message->save();
        return redirect('/')->with('failregis','DONE');
    }
}
