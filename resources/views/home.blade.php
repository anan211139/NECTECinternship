@extends('layout.app')
@section('content')
    <section>
        <div class="logo">Logo</div>
        <div class="body">
            <div class="sectionleft">
                <div>Content</div>
                @include('inc.message')
                <div class="sectionBTM">
                    <a  class="{{Request::is('/login') ? 'active' : ''}}" href="/login"><div class="BTMlogin">Login</div></a>
                    <a  class="{{Request::is('/regis') ? 'active' : ''}}" href="/regis"><div class="BTMRegis">Regis</div></a>
                </div>
            </div>
            <div class="sectionright">Picture</div>
        </div>
        <div class="foot"></div>
    </section>
@endsection