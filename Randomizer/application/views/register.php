<?php
if(!isset($_SESSION))
{
    session_start();
}

include_once(__DIR__.'/layouts/title.php');
?>
<div class="login-box">
    <h2>Thank you for registering to our site! &#128512;</h2>
    <form method="POST" action="../register/register">

        <div class="user-box">
            <input type="text" name="userName" required="required" minlength="5">
            <label>Username</label>
        </div>

        <div class="user-box">
            <input type="password" name="userPassword" required="required" minlength="8">
            <label>Password</label>
        </div>

        <?php if(isset($_SESSION['errMsg'])) {
            echo '<div style="text-align:center"><i><strong style="color: red;">* '.$_SESSION['errMsg']. '*</strong></i></div>';
        }?>

        <input id="loginButton" type="submit" value="Register">
        <a href="../public/login" class="float-right"> Login </a>
        </form>
</div>