<?php
if(isset($_POST['login_form'])){
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        require '_dbconnect.php';
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
            } else{
                header("location: ../index.php?loginfailed=true");
            }
        }
    } 
    else{
        header("location: ../index.php?loginfailed=true");
    }
    }
}
?>
<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login to CodeDiscuss</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="_loginModal.php" method="POST">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                    </div>
                    <button type="submit" name="login_form" class="btn btn-primary text-left">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>