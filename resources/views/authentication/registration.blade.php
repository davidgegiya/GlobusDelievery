<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
</head>

<body style="display: flex; align-items:center; flex-direction: column;">
<h1>Регистрация</h1>
<form action="{{ route('user.registration') }}" method="post" style="max-width: 1000px">
    @csrf
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Почта</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email" id="mail">
        @error('email')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Пароль</label>
        <input type="password" class="form-control" id="exampleInputPassword1" name="password" id="pass">
        @error('password')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" name="remember">
        <label class="form-check-label" for="flexCheckDefault">
            Запомнить меня
        </label>
    </div>
    <button type="submit" class="btn btn-primary" style="margin-right: 4em;">Регистрация</button> <a href="{{ route('user.login') }}">Вход</a>
</form>
</body>

</html>
