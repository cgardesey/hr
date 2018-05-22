<?php

session_start();

// if($_SESSION['user']!='admin'){

// // the block is for session check 

// header('location:error.php');

// }

include "../dbfiles/config.php";

$myusername=$_POST['username']; 

$mypassword=$_POST['password'];

$myusername = stripslashes($myusername);

$mypassword = stripslashes($mypassword);

$mypassword= $mypassword;

class checklogin{

    private $username;// variable contain username

    private $password;// variable contain password

    function check_login($u, $p){

        $this->username= $u;

        $this->password= $p;

        $query="SELECT * FROM users_hrdb WHERE username='$u' and password='$p'";

	if(!$query){

	echo mysql_error();

	}

	// above query will fetch records with the entered username and password

        $result=mysql_query($query) or die(mysql_error());
        $_SESSION['user'] = $username;

        $count=mysql_num_rows($result);

//        echo $count;

        if($count > 0)

        {

	    //if record found set it to the session variable user

            $_SESSION['user']=$this->username;

            session_cache_expire(15);

                header("location:../admin/adminhome.php");

            }

        else

        {

            header("location:error.php");

        }

    }

}

$checklog= new checklogin();// an object of class checklogin created

$checklog->check_login($myusername, $mypassword);// object calls the function check_login and passes parameter username and password

?>
