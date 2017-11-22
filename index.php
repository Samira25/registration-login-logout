<?php
session_start();
try {
    $conn = new PDO('mysql:host=localhost;dbname=login', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if(isset($_POST['register'])){
    	$name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

        $insert = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
	    //bindparam is used for more security so that hacker can't find what the actual name I am using for every data
        $insert->bindParam(':name',$name);
        $insert->bindParam(':email',$email);
        $insert->bindParam(':password',$password);
        $insert->execute();
    }
    elseif(isset($_POST['loginsubmit'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $query = "SELECT * FROM `users` WHERE email='$email' AND password='$password'";
        $select = $conn->prepare($query);
        $select->execute();
        $data=$select->fetch();
        if($data['email']!=$email and $data['password']!=$password)
        {
            echo "invalid email or password";
        }
        elseif($data['email']==$email and $data['password']==$password){
            $_SESSION['email']=$data['email'];
            $_SESSION['name']=$data['name'];
            header("location:dashboard.php");
        }
    }
}
catch(PDOException $e)
    {
    echo "error". $e->getMessage();
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
    <style type="text/css">
        div{
            margin: 20px;
            padding: 100px;
        }
        #regi{
            float: left;
        }
        #log{
            float: right;
        }
    </style>
</head>
<body>

	<div id="regi"><h1>Sign Up</h1><form method="post">
		
		Name<input type="text" name="name" id="name"><br>
		E-mail<input type="email" name="email" id="email"><br>
		Password<input type="password" name="password" id="password"><br>
		<input type="submit" name="register" value="Register" id="register">

	</form></div>

    <div id="log"><h1>Login</h1><form method="post">
        
        E-mail<input type="email" name="email" id="email"><br>
        Password<input type="password" name="password" id="password"><br>
        <input type="submit" name="loginsubmit" value="Login" id="loginsubmit">

    </form></div>

</body>
</html>
