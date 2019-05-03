<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error)
    die("Can't connect to server".$conn->connect_error);

echo <<<_END
   <html>
       <head>
           <title>PHP Upload </title>
          
       </head>
       <body>
           <strong>HOMEWORK 5</strong>
          <br><br>
           <form method='post' action='home.php' >
              <input type='submit' name='signin' value='Sign In' size = '20'>
               
              <input type='submit' name='signup' value='Sign Up' size = '20'>
                <br><br>
           </form>
       </body>
   </html>
_END;

if(isset($_POST['signin']))
    header("location: signin.php");
if(isset($_POST['signup']))
    header("location: signup.php");

?>