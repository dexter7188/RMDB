  <?php
  //I wrote this with respect to my own database. I'm not sure how I'm
  //supposed to get access to our database. Is it rmdb.sql?
  //I tried importing that through phpmyadmin, but I got an error.
  
  //include_once('include/db_tools.php');
  
  //checks if there was any previous _POST
  if($_SERVER['REQUEST_METHOD'] == "POST"){
    //previously entered information is redisplayed instead of
    //having user retype it if an error occurs during registration
    $submit = $_POST['submit'];
    $firstName = strip_tags($_POST['firstName']);
    $lastName = strip_tags($_POST['lastName']);
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $confirmPassword = strip_tags($_POST['confirmPassword']);
    $gender = strip_tags($_POST['gender']);
    $yearOfBirth =  strip_tags($_POST['yearOfBirth']);
    $eMail =  strip_tags($_POST['eMail']);

    if($submit){
      //Open database
       $connect = mysql_connect("localhost","root","");
       //open_db();
       mysql_select_db("rmdblogin");
       $namecheck = mysql_query("SELECT username FROM users WHERE username='$username'");
       $count = mysql_num_rows($namecheck);
       if($count!=0){
        die("That username has already been taken. Choose another.");
       }
             if($firstName&&$lastName&&$username
             &&$password&&$confirmPassword){

             //are we supposed to encrypt the passwords?
              $password = md5($password);
              $confirmPassword = md5($confirmPassword);
                if($password==$confirmPassword){

                 $queryreg = mysql_query("INSERT INTO users VALUES (
                          '','$username','$password','$firstName','$lastName',
                          '$gender','$yearOfBirth','$eMail')");
                           die("You have been registered. Click <a href='index.php'>here</a> to log in.");
                }

                else{
                 echo 'Your passwords do not match.';
                }
             }
             else{
                  echo "All fields must be filled in.";
             }
    }
  }
  else{
    //if a registration error did not occur, the text fields should be blank
    $firstName = "";
    $lastName = "";
    $username = "";
    $password = "";
    $confirmPassword = "";
    $gender = "";
    $yearOfBirth =  "";
    $eMail =  "";
  }
  ?>

   <html>
      <a href = 'index.php'>Take me home</a>
   <h1>Registration Page</h1>
  <form action="register.php" method="POST">
  <table>
        <tr><td> Username: </td><td><input type="text" name='username' value='<?php echo $username; ?>'></td></tr>
        <tr><td>Create a password: </td><td><input type="password" name='password'> 8 character minimum</td></tr>
        <tr><td>Confirm password: </td><td><input type="password" name='confirmPassword'></td></tr>
        <tr><td>First Name: </td><td><input type="text" name='firstName' value='<?php echo $firstName; ?>'></td></tr>
        <tr><td> Last Name: </td><td><input type="text" name='lastName' value='<?php echo $lastName; ?>'></td></tr>
        <tr><td>Gender:</td>
        <td><input type="radio" name='gender' value='male'> Male
        <input type="radio" name='gender' value='female'> Female</td></tr>
        <tr><td> Year of birth: </td><td><input type="text" name='yearOfBirth' value='<?php echo $yearOfBirth; ?>'></td></tr>
        <tr><td>E-mail: </td><td><input type="text" name='eMail' value='<?php echo $eMail; ?>'></td></tr>
        <tr><td><input type="submit" name = 'submit' value='Register'></td></tr>
       </table>
  </form>

  </html>
