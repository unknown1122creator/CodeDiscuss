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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        #description {
            min-height: 505px;
        }
    </style>

    <title>About us</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="_about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="_contact.php" tabindex="-1">Contact</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0" action="_search.php" method= "GET">
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
    <div class="container mt-5" id="description">
        <h4>Website Owner</h4>
        <p class="mt-4">Welcome to Saad's corner of the web! I'm a dedicated PHP developer passionate about crafting seamless digital experiences. With a solid foundation in PHP, I specialize in building dynamic, user-centric web applications. My journey in coding has been fueled by a love for creating efficient, scalable solutions that not only meet but exceed expectations. I believe in the power of clean, elegant code and thrive on transforming innovative ideas into functional, engaging realities. Join me on this coding journey and let's bring your web projects to life!</p>
        <h4 class="mt-5">Website Developer</h4>
        <p class="mt-4">Welcome to Saad's digital domain! As the creator behind this site, I'm thrilled to showcase my skills as a PHP developer through the very platform you're exploring. Every line of code, every feature, and every pixel on this website has been crafted with passion and expertise in PHP. With a deep-rooted understanding of PHP's capabilities, I've designed this space to exemplify not just my technical prowess but also my commitment to creating functional, user-friendly web solutions. Take a look around and witness firsthand the seamless synergy of PHP's power and innovation!</p>
    <div class="container text-right mt-4">
        <span>Muhammad Saad Fareed &nbsp &nbsp</span>
        <span><br>Website Owner and Developer</span>
    </div>
    </div>
    <?php include'_loginModal.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<?php include '_footer.php'; ?>  
</body>
</html>