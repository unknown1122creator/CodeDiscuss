<?php
require '_dbconnect.php';
$usernameError= false;
$passwordError= false;
if(isset($_POST['login_form'])){
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username= $_POST['username'];
    $username= str_replace("<", "&lt", $username);
    $username= str_replace(">", "&gt", $username);
    $password= $_POST['password'];
    $password= str_replace("<", "&lt", $password);
    $password= str_replace(">", "&gt", $password);
    $sql= "SELECT * FROM `users` WHERE `username`='$username'";
    $result= mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1){
        while ($passwordmatch = mysqli_fetch_assoc($result)) {
            if(password_verify($password, $passwordmatch["password"])){
                session_start();
                $_SESSION["loggedin"]= true;
                $_SESSION["username"]= $username; 
                header('location: ../index.php?loginsuccess=true');
        } else {
            $passwordError= true;
        }
    }
} else {
    $usernameError= true;
}
}
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Login</title>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../index.php">CodeDiscuss</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Top Categories
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                        $sql= "SELECT * FROM `categories` LIMIT 3";
                        $result= mysqli_query($conn, $sql);
                        while($row= mysqli_fetch_assoc($result)){
                            $id= $row['category_id'];
                            $name= $row['category_name'];
                            echo '<li><a class="dropdown-item" href="../threadlist.php?catid='.$id.'">'.$name.'</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="_about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="_contact.php" tabindex="-1">Contact</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="_search.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
            </form>
                <div class="btn-group mx-2">
                    <a class="btn btn-outline-success" href="signup.php" role="button">Signup</a>
        </div>
    </nav>
    <?php
    if($usernameError){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Failed!</strong> Account with this username does not exist.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if($passwordError){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Failed!</strong> Invalid Password.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <div class="container mt-5">
        <h3 class="text-center">Login to CodeDiscuss</h3>
        <form class="mt-4" action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" aria-describedby="Help">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div>
                <button type="submit" name="login_form" class="btn btn-primary">Login</button>
            </div>
            <hr>
            <p>Don't have have an account? <a href="signup.php">Signup here</a>.</p>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <?php include ("_footer.php"); ?>
</body>

</html>