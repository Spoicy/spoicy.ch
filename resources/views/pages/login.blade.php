<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Karla:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Login</title>
</head>
<body class="light-blue">
    <div class="container login-container site-container text-center d-flex flex-column">
        <div class="main-div">
            <h1 class="pb-3">Login</h1>
            <form action="/blog/login/validate" method="post">
                @if (session('status'))
                    <p class="password-error">The password is incorrect. Please try again.</p>
                @endif
                @csrf
                <input type="text" class="form-control" id="loginPass" name="loginPass" placeholder="Password">
                <button class="form-control btn btn-primary mt-2" id="loginSubmit" name="loginSubmit" type="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>