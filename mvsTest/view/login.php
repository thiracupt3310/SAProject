<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="login.css" />
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet"> 
    <script src="https://kit.fontawesome.com/b13ddaf0a8.js" crossorigin="anonymous"></script> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.0/css/bootstrap.min.css" integrity="sha384-SI27wrMjH3ZZ89r4o+fGIJtnzkAnFs3E4qz9DIYioCQ5l9Rd/7UAa8DHcaL8jkWt" crossorigin="anonymous">   
</head>
<body>
    <form method="GET" action="../controller/LoginController.php">
    <header>Login</header>
        <div class="inputWithIcon">
            <input type='text' name='user' placeholder="user ID">
            <i class="fas fa-user" aria-hidden="true"></i>
        </div>
        <div class="inputWithIcon">
            <input type='password' name='pass' placeholder="password">
            <i class="fas fa-key"></i>
        </div>
        <?php
            session_start();
            echo '<div class="inputWithIcon" style="color: red;">';
            if (isset($_SESSION['message'] ))
            {
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }
            echo '</div>'
        ?>
        <div class="inputWithIcon" style="margin-bottom: 20px">
            <input class="btn btn-primary" value="LOGIN" type="submit">
        </div>
    </form>   
</body>
</html>