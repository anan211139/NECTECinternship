@if(session('regis'))
    <div class="alert-message">
        {{session('regis')}}
    </div>
@endif