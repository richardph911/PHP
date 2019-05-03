<?php
require_once 'login.php';
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error)
    die("Can't connect to server".$conn->connect_error);

$query = "CREATE TABLE IF NOT EXISTS upload (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,filename VARCHAR(30) NOT NULL,content LONGTEXT, username VARCHAR(30) NOT NULL REFERENCES users(username))";
$result = $conn->query($query);
if (!$result)
    die ("Can't connect to database " . $conn->error);

echo <<<_END
   <html>
       <head>
           <title>PHP Upload </title>
           <style>
               table {
                 font-family: arial, sans-serif;
                 border-collapse: collapse;
                 width: 70%;
                 margin-left: 2%;
               } 
               td, th {
                 font-family: arial, sans-serif;
                 border: 2px solid #dddddd;
                 text-align: center;
                 size = 12;
               }
             
               form{
                   margin-left:2%;
              
               }
           </style>
       </head>
       <body>
           <strong>HOMEWORK 4: UPLOADING FILE</strong>
          <br><br>
           <form method='post' action='upload.php' enctype='multipart/form-data'>
               Enter file name:
               <input type="text" name="inputname">
               <br><br>
               Select a text file to upload:
               <input type='file' name= 'uploadfile' id='uploadfile'>
                <br><br>
               <input type='submit' name='submit' value='Upload'>
                <br><br>
           </form>
       </body>
   </html>
_END;
    session_start();
    if (isset($_SESSION['username'])){
        $username = $_SESSION['username'];
        $password = $_SESSION['password'];
        $email = $_SESSION['email'];
        $age = $_SESSION['age'];
        echo "Welcome back.$username.<br>";

        destroy_session_and_data();

        $filename = $_POST['inputname'];
        if ($_FILES['uploadfile']['type'] == 'text/plain'){

            $content = file_get_contents($_FILES['uploadfile']['tmp_name']);
            $query = "INSERT INTO upload VALUES (NULL,'$filename','$content','$un_temp')";
            $result = $conn->query($query);
            if (!$result) die ("Database access failed: " . $conn->error);
        }
        else {
            echo "This is not a text file. Please try again";
        }

//print table
        $sql = "SELECT filename, content FROM upload WHERE username='$un_temp'";
        $result = mysqli_query($conn,$sql);
        if (!$result) die ("Database access failed: " . $conn->error);

        print "<table border= 1 bgcolor='#8fbc8f'>\n";
        print "<tr>";
        print "<th text-align='center' width='20%'>Name</th>";
        print "<th text-align='center' width='50%'>Content</th>";
        print "</tr>";
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $name = $row['filename'];
            $content = $row['content'];

            print "<tr>";
            print "<td>";
            echo "$name";
            print "</td>";
            print "<td>";
            echo "$content";
            print "</td>";
            print "</tr>";
        }
        print "</table>\n";


    }
    else echo "Please <a href='signin.php'>click here</a> to log in.";

    function mysql_fix_string($connection, $string)
    {
        if (get_magic_quotes_gpc())
            $string = stripslashes($string);
        return $connection->real_escape_string($string);
    }

    function destroy_session_and_data() {
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }


mysqli_close($conn);
?>


