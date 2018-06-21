<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;

class regisController extends Controller
{
    public function process(Request $request){
        $PRname = $request->input('nameRegis');
        $username = $request->input('uname');
        $password = $request->input('psw');
        $repassword = $request->input('repsw');
        $email = $request->input('email');
        if($password == $repassword){
            $userresult = Manager::all();
            for($i = 1;$i<=count($userresult);$i++){
                if($userresult[$i]["UNPR"] == $username){
                    return redirect('/')->with('failregis','username');
                }
                else{
                    $message = new Manager;
                    $message->PRname = $PRname;
                    $message->UNPR = $username;
                    $message->PWPR = $password;
                    $message->PREmail = $email;
                    $message->save();
                    return redirect('/')->with('failregis','DONE');
                }
            }
            $message = new Manager;
            $message->PRname = $PRname;
            $message->UNPR = $username;
            $message->PWPR = $password;
            $message->PREmail = $email;
            $message->save();
            return redirect('/')->with('failregis','DONE');
        }else{
            return redirect('/')->with('failregis','Password and Re-Password not match');
        } 
    }
}
