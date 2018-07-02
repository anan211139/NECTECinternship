@extends('layout.app')
    @section('content')
    <h1>Userpage</h1>
    <a href="/logout">logout</a>
    {{Session::get('countchild','default')}}
    @endsection
