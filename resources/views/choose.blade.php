@extends('layout.app')
@section('content')
<h1>Choose</h1>
<a href="/logout">logout</a>
{{Session::get('countchild','default')}}
@endsection
