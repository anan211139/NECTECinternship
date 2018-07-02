@extends('layout.app')
@section('content')
<h1>Step</h1>
<a href="/logout">logout</a>
{{Session::get('countchild','default')}}
@endsection
