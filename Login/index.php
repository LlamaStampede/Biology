<?php 
    require 'db.php';
    session_start();
?>

<!Doctype html>
<html>
    <head>
        <title>Log in!</title>
        <link rel="stylesheet" type="text/css" href="loginStyles.css">
    </head>
    <body>
        <?php
            $email = $password = "";
            function test_input($data) {
              $data = trim($data);
              $data = stripslashes($data);
              $data = htmlspecialchars($data);
              return $data;
            }
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
                document.getElementById('registerContainer1').style.display = "none";
                document.getElementById('registerContainer2').style.display = "none";
                document.getElementById('submit').name = "login";
            }
            function register() {
                document.getElementById('registerContainer1').style.display = "inline";
                document.getElementById('registerContainer2').style.display = "inline";
                document.getElementById('submit').name = "register";
            }
            
        </script>
        
        <h1 id="welcome">Welcome to the Biology Notes</h1>
        <div id="container">
            <div id="buttonContainer">
                <button id="chooseLogin" class="button" onclick="login()" style="float:left;">Login</button> 
                <button id="chooseRegister" class="button" onclick="register()" style="float:left;">Register</button><br>
            </div>
            <br>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
                <div id="registerContainer1" style="display:none;">
                    First Name: <input type="text" name="name"><br>
                </div>
                <div id="loginContainer">
                    <a style="color:red;">*</a> Email: <input type="email" name="email"><br>
                    <a style="color:red;">*</a> Password: <input type="password" name="password"><br>
                </div>
                <div id="registerContainer2" style="display:none;">
                    <a style="color:red;">*</a> Confirm Password: <input type="password" name="cPassword"><br>
                </div>
                <input class="button" id="submit" type="submit" value="Submit" name="login">
            </form>
        </div>
    </body>
</html>