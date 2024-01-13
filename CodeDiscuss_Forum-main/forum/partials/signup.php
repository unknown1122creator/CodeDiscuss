<?php
require '_dbconnect.php';
$usernameError= false;
$successAlert= false;
$passwordError= false;
$emailError= false;
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $email= $_POST['email'];
    $password= $_POST['password'];
    $cpassword= $_POST['cpassword'];
    $username= $_POST['username'];
    $sql= "SELECT * FROM `users` WHERE `username`='$username'";
    $result= mysqli_query($conn,$sql);
    if(mysqli_num_rows($result)> 0){
        $usernameError=true;
    } else{
        $sql= "SELECT * FROM `users` WHERE `email`='$email'";
        $result= mysqli_query($conn,$sql);
        if(mysqli_num_rows($result)> 0){
            $emailError= true;
        } else {
            if($password == $cpassword){
                $hash= password_hash("$password", PASSWORD_DEFAULT);
                $sql= "INSERT INTO `users` (`email`, `password`, `username`) VALUES ('$email', '$hash', '$username')";
                $result= mysqli_query($conn,$sql);
                if($result){
                    $successAlert= true;
                }
            } else {
                $passwordError= true;
            }
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

    <title>Signup to CodeDiscusss</title>
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
                    <a class="btn btn-outline-success mx-2" href="login.php" role="button">Login</a>
        </div>
    </nav>
    <div>
        <?php
        if($usernameError){
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Failed!</strong> Username already exists.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        }
        if($successAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Great!</strong> Account created successfully. Now you can <a href="login.php">login here</a>.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        }
        if($passwordError){
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Failed!</strong> Passwords do not match.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        }
        if($emailError){
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Failed!</strong> Entered email address is already in use.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
        }
        ?>
    </div>
    <div class="container mt-3">
        <h3 class="text-center">Signup to CodeDiscuss</h3>
        <form class="mt-3" action="signup.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone
                    else.</small>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" maxlength=255 minlength=7 class="form-control" name="password" id="password">
                <small class="form-text text-muted">Password should be at least 7 characters long.</small>
            </div>
            <div class="form-group">
                <label for="cpassword">Confirm Password</label>
                <input type="password" maxlength=255 minlength=7 class="form-control" name="cpassword" id="cpassword">
                <small class="form-text text-muted">Make sure that both passwords match.</small>
            </div>
            <button type="submit" class="btn btn-primary">Signup</button>
        </form>
        <hr>
        <small id="Help">Already have an account? <a href="login.php">Login here</a>.</small>
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