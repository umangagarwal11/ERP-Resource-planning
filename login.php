<?php                                       

include('db.php');
session_start();
if(isset($_POST['username'])){
    
    $uname=$_POST['username'];
    $password=$_POST['password'];
    
    $sql="select * from studenttable where user='".$uname."'AND Pass='".$password."' limit 1";
    
    $result=mysqli_query($con,$sql);
    
    if(mysqli_num_rows($result)==1){
        echo " You Have Successfully Logged in";
        $_SESSION['student']=$uname;
		header('location:studenthome.php');
    }else if(mysqli_num_rows(mysqli_query($con,"select * from stafftable where user='".$uname."'AND Pass='".$password."' limit 1"))==1){
        echo " You Have Successfully Logged in";
        $_SESSION['staff']=$uname;
		header('location:staffhome.php');
    }else{
		echo 'Wrong username or password';
    }
}
?>

<html>
<head>
<title>SCHOOL MANAGEMENT SYSTEM</title>

<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no"/>
<link href="css/bootstrap.css" rel="stylesheet"/>
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.js"></script>
<style type="text/css">
body{background:url('https://thumbs.dreamstime.com/z/isometric-online-teaching-internet-classroom-student-learning-computer-class-online-university-graduate-studying-training-133246047.jpg') no-repeat;
	overflow-y:scroll;
	}
#log{
 
 padding:60px 40px;
 margin-top:80px;

}
img{ width:150px;
	margin:auto;
}
h1{
color:black;
text-align:center;
font-weight:bolder;
margin-top:-20px;
}
label{font-size:20px; color:white;}

</style>

</head>
<body>
<div class="container-fluid bg">
	<div class="row">                                  
	                                               
		<div class="col-md-4 col-sm-4 col-xs-12">         
		<form id="log" method="post">                                         
			<h1> Login</h1>                        
			<img class="img img-responsive img-circle" src="image/login.gif">
				<div class="form-group">
					<label>Username</label>
					<input type="Username" class="form-control" placeholder="Email">
				</div>
				<div class="form-group">
					<label>Password</label>
					<input type="password" class="form-control" placeholder="Password">
				</div>
				<div class="checkbox">
					<label><input type="checkbox"> Remember me</label>
				</div>
				<button type="submit" class="btn btn-success btn-block ">Login</button>
			</form>
		</div>
		
		<div class="col-md-4 col-sm-4 col-xs-12"></div>
		
		
	</div>
</div>
</body>
</html>