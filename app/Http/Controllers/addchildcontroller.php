<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Studentparent;

class addchildcontroller extends Controller
{
    public function addchild(Request $request){
        $linecode = $request->input('code');
        $name = $request->input('nickname');
        $id = Session::get('id','default');

        $insert = new Studentparent;
        $insert->line_code = $linecode;
        $insert->parent_id = $id;
    }
}
