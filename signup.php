<?php
$firstname = $lastname = $username = $email = $password =$passwordConfirm = "";

if ($_SERVER["users"] == "POST") {
  $firstname = test_input($_POST["firstname"]);
  $lastname = test_input($_POST["lastname"]);
  $username = test_input($_POST["username"]);
  $email = test_input($_POST["email"]);
  $password = test_input($_POST["password"]);
  $passwordConfirm = test_input($_POST["passwordConfirm"]);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
 if(isset($_POST["users"])){
  extract($_POST);
  if(strlen($firstname)<3){ // Minimum 
      $error[] = 'Please enter First Name.';
        }
if(strlen($firstname)>20){  // Max 
      $error[] = 'First Name: Max length 20 Characters Not allowed';
        }
if(!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $firstname)){
            $error[] = 'Invalid Entry First Name. Please Enter letters without any Digit or special symbols like ( 1,2,3#,$,%,&,*,!,~,`,^,-,)';
        }    
if(strlen($lastname)<3){ // Minimum 
      $error[] = 'Please enter Last Name.';
        }
if(strlen($lastname)>20){  // Max 
      $error[] = 'Last Name: Max length 20 Characters Not allowed';
        }
if(!preg_match("/^[A-Za-z _]*[A-Za-z ]+[A-Za-z _]*$/", $lastname)){
            $error[] = 'Invalid Entry Last Name. Please Enter letters without any Digit or special symbols like ( 1,2,3#,$,%,&,*,!,~,`,^,-,)';
              }    
      if(strlen($username)<3){ // Change Minimum Lenghth   
            $error[] = 'Please enter Username.';
        }
  if(strlen($username)>50){ // Change Max Length 
            $error[] = 'Username : Max length 50 Characters Not allowed';
        }
  if(!preg_match("/^^[^0-9][a-z0-9]+([_-]?[a-z0-9])*$/", $username)){
            $error[] = 'Invalid Entry for Username. Enter lowercase letters without any space and No number at the start- Eg - myusername, okuniqueuser or myusername123';
        }  
if(strlen($email)>50){  // Max 
            $error[] = 'Email: Max length 50 Characters Not allowed';
        }
   if($passwordConfirm ==''){
            $error[] = 'Please confirm the password.';
        }
        if($password != $passwordConfirm){
            $error[] = 'Passwords do not match.';
        }
          if(strlen($password)<5){ // min 
            $error[] = 'The password is 6 characters long.';
        }
        
         if(strlen($password)>20){ // Max 
            $error[] = 'Password: Max length 20 Characters Not allowed';
        }
          $sql="select * from users where (username='$username' or email='$email');";
      $res=mysqli_query($dbc,$sql);
   if (mysqli_num_rows($res) > 0) {
$row = mysqli_fetch_assoc($res);

     if($username==$row['username'])
     {
           $error[] ='Username alredy Exists.';
          } 
       if($email==$row['email'])
       {
            $error[] ='Email alredy Exists.';
          } 
      }
         if(!isset($error)){ 
            $password = password_hash($password,PASSWORD_BCRYPT,$options);
            
            $result = mysqli_query($dbc,"INSERT into users(fname,lname,username,email,password,passwordConfirm)
            values('$firstname','$lastname','$username','$email','$password','$passwordConfirm')");

           if($result)
    {
     $done=2; 
    }
    else{
      $error[] ='Failed : Something went wrong';
    }
 }
 } ?>

            <div class="col-sm-4">

                <?php 
  if(isset($error)){ 
foreach($error as $error){ 
  echo '<p class="errmsg">&#x26A0;'.$error.' </p>'; 
}
}
?>