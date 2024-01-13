<?php include '_dbconnect.php'; 
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION!=true){
    $activeuser=false;
} else{
    $activeuser=true;
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
        <style>
            #description {
                min-height: 75px;
            }
        </style>

    <title>Contact us</title>
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
                    <a class="nav-link" href="../index.php">Home</a>
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
                <li class="nav-item active">
                    <a class="nav-link" href="_contact.php" tabindex="-1">Contact <span
                            class="sr-only">(current)</span></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="_search.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
            </form>
            <?php 
                if($activeuser){
                    echo '<a class="btn btn-outline-danger mx-2" href="logout.php" role="button">Logout</a>';
                } else{
                    echo '<div class="btn-group mx-2">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#loginModal">Login</button>
                    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="login.php">Go to Login Page</a>
                    </div>
                  </div>
                    <a class="btn btn-outline-success" href="signup.php" role="button">Signup</a>';
                }
                ?>
        </div>
    </nav>
    <?php
    $successAlert= false;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $email= $_POST['feedbackemail'];
        $email= str_replace("<", "&lt", $email);
        $email= str_replace(">", "&gt", $email);
        $desc= $_POST['feedback_desc'];
        $desc= str_replace("<", "&lt", $desc);
        $desc= str_replace(">", "&gt", $desc);
        $sql= "INSERT INTO `feedbacks` (`email`, `feedback`) VALUES ('$email', '$desc')";
        $result= mysqli_query($conn, $sql);
        if($result){
            $successAlert= true;
        }
    }
    if($successAlert){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Thanks for your valuable feedback😊.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <?php include'_loginModal.php'; ?>

    <div class="container mt-5 text-center">
      <h2 class="text-center mb-5">Get in Touch!</h2>
      <p class="mb-5">We'd love to hear from you! Whether you have a question about our services, want to collaborate, or just want to say hello, we're here and ready to chat.</p>

    <h5>Contact Information</h5>

    <p class="mt-3 mb-5">Address: Basti Dosa, P.O. Basti Shah Ali, Tehsil Kot Chutta District Dera Ghazi Khan<br>
    Phone: 0326-6658554<br>
    Email: saadfareed901@gmail.com</p>

    <h5>Business Hours</h5>

    <p class="mt-3">Monday - Sunday: 7AM - 10PM
    </div>

    <div class="container mt-5 text-center" id="description">
    <p>
  <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
    Reach us
  </a>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body mt-2" style="border: none;">
  <form action="_contact.php" method="POST">
  <div class="form-group text-left">
    <label for="feedbackemail">Email address</label>
    <input type="email" name="feedbackemail" class="form-control text-left" id="feedbackemail">
  </div>
  <div class="form-group text-left">
    <label for="feedback_desc">Feedback</label>
    <textarea class="form-control text-left" name="feedback_desc" id="feedback_desc" rows="3" placeholder="Your feedback is highly appreciated"></textarea>
  </div>
  <button type="submit" class="btn btn-primary text-left">Submit</button>
</form>
  </div>
</div>
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
    <?php include '_footer.php'; ?>
</body>

</html>