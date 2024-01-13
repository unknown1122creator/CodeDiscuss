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

    <style>
        .custom_font {
            font-size: 0.99rem;
        }
    </style>

    <title>Forums</title>
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
                <li class="nav-item">
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
    <?php
    $postSuccess= false;
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $id= $_GET['catid'];
        $ques_title= $_POST['ques_title'];
        $ques_title= str_replace("<", "&lt", $ques_title);
        $ques_title= str_replace(">", "&gt", $ques_title);
        $ques_desc= $_POST['ques_desc'];
        $ques_desc= str_replace("<", "&lt", $ques_desc);
        $ques_desc= str_replace(">", "&gt", $ques_desc);
        $sql= "INSERT INTO `threads` (`thread_description`, `thread_cat_id`, `thread_username`, `thread_cat`) VALUES ('$ques_desc', '$id', '$user', '$ques_title')";
        $result= mysqli_query($conn, $sql);
        if($result){
            $postSuccess= true;
        }
    }
    if($postSuccess){
      echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
        Question posted successfully. Wait until someone answers your question.
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
    }
    ?>
    <?php include'_loginModal.php'; ?>
    <?php
    $id= $_GET['catid'];
    $sql= "SELECT * FROM `categories` WHERE `category_id`='$id'"; 
    $result= mysqli_query($conn, $sql);
    while ($row= mysqli_fetch_assoc($result)) {
        $cat_name= $row['category_name'];
        $cat_desc= $row['category_description'];
    }   
    ?>
    <div class="container mt-3">
    <div class="jumbotron py-4 mb-5">
  <h3 class="display-6">Welcome to <?php echo $cat_name; ?> Forum</h3>
  <p class="custom_font mt-4"><?php echo $cat_desc ?></p>
</div>
<h3 mt-4>Browse Questions</h3>
<?php
if($activeuser){
    echo '<!-- Button trigger modal -->
<button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#exampleModal">
  Post a Question
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Post a Question</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="'.$_SERVER['REQUEST_URI'].'" method="POST">
      <div class="form-group">
        <label for="ques_title">Question Title</label>
        <input type="title" class="form-control" name="ques_title" id="ques_title" aria-describedby="emailHelp" placeholder="Question Title">
        <small id="emailHelp" class="form-text text-muted">Keep your title as short as possible.</small>
      </div>
      <div class="form-group">
    <label for="ques_desc">Elaborate your Question</label>
    <textarea class="form-control" name="ques_desc" id="ques_desc" rows="3"></textarea>
  </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Post</button>
      </div>
      </form>
    </div>
  </div>
</div>';
} else {
echo '<p class="text-danger">You should login first to post your question.</p>';
}
$noResult= true;
    $id= $_GET['catid'];
    $sql= "SELECT * FROM `threads` WHERE `thread_cat_id`='$id'"; 
    $result= mysqli_query($conn, $sql);
    while ($row= mysqli_fetch_assoc($result)) {
        $id= $row['thread_id'];
        $thread_desc= $row['thread_description'];
        $username= $row['thread_username'];
        $date= $row['date'];
        $noResult= false;
        echo 
        '<div class="container border mt-3">
        <small>Posted by '.$username.' at '.$date.'</small>  
        <p>Q: <a class="text-dark" href="threads.php?thread='.$id.'">'.$thread_desc.'</a> </p>
        </div>';
    }  
    if($noResult){
        echo '<div class="container mt-4">
        <div class="jumbotron py-4 mb-5">
        <h3 class="display-6">No Questions for '.$cat_name.'</h3>
        <p class="custom_font mt-4">Be the first to ask a Question.</p>
      </div>
      </div>';
    }
?>


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