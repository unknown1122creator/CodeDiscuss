<?php
require 'partials/_dbconnect.php';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    $activeuser=false;
} else{
    $activeuser=true;
    $user= $_SESSION['username'];
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

    <title>Welcome to CodeDiscuss - Coding Discussions</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">CodeDiscuss</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
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
                            echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$id.'">'.$name.'</a></li>';
                        }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="partials/_about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="partials/_contact.php" tabindex="-1">Contact</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="partials/_search.php" method="GET">
                <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
            </form>
                <?php 
                if($activeuser){
                    echo '<a class="btn btn-outline-danger mx-2" href="partials/logout.php" role="button">Logout</a>';
                } else{
                    echo '<div class="btn-group mx-2">
                    <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#loginModal">Login</button>
                    <button type="button" class="btn btn-outline-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="partials/login.php">Go to Login Page</a>
                    </div>
                  </div>
                    <a class="btn btn-outline-success" href="partials/signup.php" role="button">Signup</a>';
                }
                ?>
        </div>
    </nav>

    <?php include'_loginModal.php'; ?>
    <?php
    if(isset($_GET['loginsuccess']) && $_GET['loginsuccess'] == true){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Logged in as '.$user.'
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if(isset($_GET['loginfailed']) && $_GET['loginfailed'] == true){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Invalid Credentials.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    if(isset($_GET['logoutsuccess']) && $_GET['logoutsuccess'] == true){
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
        Logged out successfully.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <div class="container alert alert-success mt-5" role="alert">
        <h4 class="alert-heading">Welcome Aboard! <?php 
         if($activeuser){
            echo $_SESSION['username'];
         }
         ?></h4>
        <p>
            <br>Welcome to our vibrant online community dedicated to the world of programming and coding! Whether you're a
            seasoned developer, an enthusiastic beginner, or simply someone fascinated by the art of coding, this forum
            is your go-to destination for engaging discussions, invaluable insights, and a shared passion for all things
            related to software development.<br><br>

            Join us as we explore the ever-evolving landscape of programming languages, discuss the latest tech trends,
            troubleshoot coding challenges, share helpful tips, and foster a collaborative environment where knowledge
            meets innovation.<br><br>

            Our forum is a melting pot of diverse perspectives, where enthusiasts and experts alike come together to
            learn, grow, and exchange ideas. Whether you're here to seek guidance, contribute your expertise, or simply
            connect with like-minded individuals, you've found the perfect online hub.<br>
            
            In our forum community, we prioritize mutual respect and constructive engagement. This means treating fellow members with dignity and refraining from any form of discrimination, harassment, or offensive language. We encourage staying on topic within discussions to maintain a clear and organized forum. Spam, advertising, and plagiarism are not tolerated here. We ask that you use appropriate language and formatting to ensure readability for all users. If you encounter any content violating these rules, please report it. Violations may result in warnings, temporary suspension, or even permanent banning from the community. Let's strive to make this forum a welcoming space for diverse opinions and meaningful discussions.




            <br>Get ready to dive into stimulating conversations, expand your coding horizons, and become part of a
            supportive community that thrives on curiosity and a shared love for coding.</p>
        <hr>
        <p class="mb-0 text-center">Welcome aboard!</p>
    </div>

    <!-- Category Container starts here... -->

    <div class="container mt-5">
        <h4>Browse Categories</h4>
    </div>

    <div class="container row mt-4 ml-5 mr-5">
    <?php
    $sql= "SELECT * FROM `categories`";
    $result= mysqli_query($conn,$sql);
    while ($rows = mysqli_fetch_assoc($result)) {
        $name= $rows['category_name'];
        $description= $rows['category_description'];
        $catid= $rows['category_id'];
        echo '<div class="col-md-4 my-3">
                <div class="card" style="width: 18rem;">
                <img src=" img/card_'. $catid .'.png " class="card-img-top" alt="' .$name. '">
                    <div class="card-body">
                    <h5 class="card-title">' . $name . '</h5>
                    <p class="card-text">' . substr($description, 0, 90) . '...</p>
                    <a href="threadlist.php?catid='.$catid.'" class="btn btn-primary">Explore ' . $name . '</a>
                    </div>
            </div>
        </div>';
    }
    ?>
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
        <?php include ("partials/_footer.php"); ?>
</body>

</html>