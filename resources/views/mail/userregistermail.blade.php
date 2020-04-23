<h2>Hi, {{$name}}</h2>
@if($flag===1)
<p>
    You have Successfully Register now.
</p>
<p>Username:{{$username}}</p>
<p>Password:{{$password}}</p>
@endif
@if($flag===2)
<p>
    Your Username and Password is changed.
</p>
<p>Username:{{$username}}</p>
<p>Password:{{$password}}</p>
@endif
<hr>
<h4>Sincerely,</h4>
<h4>Hilltourismbd</h4>
