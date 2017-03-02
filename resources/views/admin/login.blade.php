<html >
<head>
    <meta charset="UTF-8">
    <title>shortnews admin page</title>



    {{--<link rel="stylesheet" href="css/style.css">--}}
    <link href={{ URL::asset('css/style-login.css') }} rel="stylesheet">

</head>

<body>

<?php echo Form::open(array('route'=>'login','method'=>'post','enctype'=>'multipart/form-data')) ?>
<header>Login</header>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: #00CC00">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<label>Username <span>*</span></label>
<input name = 'user_name'/>
<div class="help">At least 6 character</div>
<label>Password  <span>*</span></label>
<input type="password" name='password'/>
<div class="help">Use upper and lowercase lettes as well</div>
<button type="submit">Login</button>

<?php echo Form::close() ?>


</body>
</html>