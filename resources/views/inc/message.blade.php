@if(session('failregis'))
    <div class="alert-message">
        {{session('failregis')}}
    </div>
@endif