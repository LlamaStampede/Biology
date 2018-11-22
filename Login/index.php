<?php 
    require 'db.php';
    session_start();
?>

<!Doctype html>
<html>
    <head>
        <title>Log in!</title>
    </head>
    <body>
        <?php
            $email = $password = "";

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (isset($_POST['login'])) {
                    require 'login.php';
                }
                if (isset($_POST['register'])) {
                    require 'register.php';
                }
            }
            
            if (isset($_SESSION['message'])) {
                echo "<div class='error'>" . $_SESSION['message'] . "</div>";
            }
        ?>
        <script>
            function login() {
                document.getElementById('registerContainer').style.display = "none";
                document.getElementById('loginButton').style.display = "inline";
            }
            function register() {
                document.getElementById('loginButton').style.display = "none";
                document.getElementById('registerContainer').style.display = "inline";
            }
            
        </script>
        
        <h1>Login Page</h1>
        <div id="container">
            <div id="buttonContainer">
                <button onclick="login()" style="float:left;">Log in</button> 
                <button onclick="register()" style="margin-left:50px;float:left;">Register</button><br>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div id="loginContainer">
                    <a style="color:red;">*</a> Email: <input type="email" name="email"><br>
                    <a style="color:red;">*</a> Password: <input type="password" name="password"><br>
                    <input id="loginButton" type="submit" value="Submit" name="login"> <br>
                </div>
                <div id="registerContainer"  style="display:none;">
                    First Name: <input type="text" name="name"><br>
                    <a style="color:red;">*</a> Confirm Password: <input type="password" name="cPassword"><br>
                    <input type="submit" value="Sign Up" name="register">
                </div>
            </form>
        </div>
    </body>
</html>