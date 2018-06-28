@if(session('regis'))
    <div class="alert-message " style = "color : red; padding-bottom:10px;">
        {{session('regis')}}
    </div>
@endif