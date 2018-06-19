@extends('layout.app')
@section('content')
    <h1>Regis</h1>
    {!! Form::open(['url' => 'home/submit']) !!}
        <div class="form_group">
            {{Form::label('username','Username')}}
            {{Form::text('username','',['class' => 'forminput1'])}}
        </div>
        <div class="form_group">
            {{Form::label('password','Password')}}
            {{Form::text('password','')}}
        </div>
        <div class="form_group">
            {{Form::label('code','Code')}}
            {{Form::text('code','')}}
        </div>
        <div>
            {{Form::submit('Submit',['class' => 'btmsubmit'])}}
        </div>
    {!! Form::close() !!}
@endsection