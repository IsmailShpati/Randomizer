<?php
if(!isset($_SESSION))
{
    session_start();
}

include_once(__DIR__.'/layouts/title.php');
?>
<div class="login-box">
    <h2>Login</h2>
    <form method="POST" action="../public/login/login">

        <div class="user-box">
            <input type="text" name="userName" required="required">
            <label>Username</label>
        </div>

        <div class="user-box">
            <input type="password" name="userPassword" required="required">
            <label>Password</label>
        </div>

        <?php if(isset($_SESSION['errMsg'])) {
            echo '<div style="text-align:center"><i><strong style="color: red;">* '.$_SESSION['errMsg']. '*</strong></i></div>';
        }?>

        <input id="loginButton" type="submit" value="Login">
        <a href="../public/register/index" class="float-right" >
            Register
        </a>
        </form>
</div>