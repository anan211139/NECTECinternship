@extends('layout.app')
@section('content')
    <h1>Login</h1>
    {!! Form::open(['url' => 'home/submit']) !!}
        <div class="form_group">
            {{Form::label('name','Name')}}
            {{Form::text('name','',['class' => 'forminput1'])}}
        </div>
        <div class="form_group">
            {{Form::label('email','E-mail Address')}}
            {{Form::text('email','')}}
        </div>
        <div>
            {{Form::submit('Submit',['class' => 'btmsubmit'])}}
        </div>
    {!! Form::close() !!}
@endsection