<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);

if ($conn->connect_error)
    die("Can't connect to server".$conn->connect_error);

$query = "CREATE TABLE IF NOT EXISTS users(username VARCHAR(30) NOT NULL PRIMARY KEY,email VARCHAR(30) NOT NULL,password VARCHAR (30) NOT NULL, age INT(11) NOT NULL)";
$result = $conn->query($query);
if (!$result)
    die ("Can't connect to database" . $conn->error);

echo <<<_END
    <html>
        <head>
            <title>SIGNUP</title>
        </head>
        <a>
         
            <form method='post' action='signup.php' >
              
                    <h1>Sign Up</h1>
                    
                    <label for="Username"><b>Username: </b></label>
                    <input type="text" placeholder="Enter Username" name="username" required>
                    <br></br>
                    <label for="Email"><b>Email: </b></label>
                    <input type="text" placeholder="Enter Email" name="email" required>
                    <br></br>
                    <label for="password"><b>Password: </b></label>
                    <input type="password" placeholder="Enter Password" name="password" required>
                    <br></br>
                    <label for="Age"><b>Age: </b></label>
                    <input type="text" placeholder="Enter Age" name="age" required>
                    <br></br>
                    <input type='submit' name='submit' value='Sign Up'>
                <br><br>
              
            </form>
            
        </body>
    </html>
_END;

if(isset($_POST['submit'])) {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $age = $_POST["age"];
    if ($username == "" || $email == "" || $password == "" || $age == "") {
        echo "Please fill out all required information";
    } else {

        $sql = "select * from users where username='$username' ";
        $perform = mysqli_query($conn, $sql);
        if (mysqli_num_rows($perform) > 0) {
            echo "Your account exists";
            header("location: signin.php");
        } else {
            $salt1 = "qm&h*";
            $salt2 = "pg!@";
            $token = hash('ripemd128', "$salt1$password$salt2");

            $sql = "INSERT INTO users VALUES ('$username','$email','$token','$age')";
                mysqli_query($conn, $sql);
            header("location: upload.php");
            exit;


        }
    }
}

    function add_user($connection, $un,$email,$pw,$age) {
        $query = "INSERT INTO users VALUES('$un','$email','$pw','$age')";
        $result = $connection->query($query);
        if (!$result) die($connection->error);
    }

?>