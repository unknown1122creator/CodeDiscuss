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

    <title>Search Results for <?php echo $_GET['search']; ?></title>
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
    <h4 class="container mt-5">Search Results for <em>"<?php echo $_GET['search']; ?>"</em></h4>
    <?php
    $noResult= true;
  if($_SERVER['REQUEST_METHOD'] == "GET"){
    $search= $_GET['search'];
    $sql= "SELECT * FROM `threads` WHERE MATCH (`thread_cat`, `thread_description`) AGAINST ('$search')";
    $result= mysqli_query($conn, $sql);
    $numRows= mysqli_num_rows($result);
    }
    if($numRows > 0){
        echo  '<div class="container mt-2">'.$numRows. ' result(s) found.</div>';
        $noResult= false;
    }
    if($noResult){
        echo '<div class="container mt-4">
        <div class="jumbotron py-4 mb-5">
        <h4 class="display-6">No Results found.</h4>
        <ul class="mt-3">
        <li>Make sure that all words are spelled correctly.</li>
        <li>Try different keywords.</li>
        <li>Try more general keywords.</li>
            </div>
            </div>';
    }

  while($search_desc= mysqli_fetch_assoc($result)){
    $id= $search_desc['thread_id'];
    echo '<div class="container border pt-3 pl-3 mt-3">
    <h6><a class="text-dark" href="../threads.php?thread='.$id.'">'.$search_desc['thread_cat'].'</a></h6>
    <p>'.$search_desc['thread_description'].'</p>
    </div>';
  }
  ?>
    <?php include'_loginModal.php'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<?php include '_footer.php'; ?>  
</body>
</html>