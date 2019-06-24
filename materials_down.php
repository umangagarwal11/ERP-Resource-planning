<?php
include ('db.php');
session_start();
?>
<html>
<head>
<meta name="viewport" content="width=device-width initial-scale=1 shrink-to-fit=no">
    
	<title > Study Materials </title>
	<link rel = "stylesheet " type = "text/css" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	
	<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #575757  ;
  text-align: center;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
tr:nth-child(odd) {
  background-color: #ffffff;
}
</style>

</head>
<body style="background-image:url('./back.jpg');  background-repeat: no-repeat; background-position: center;  background-attachment: fixed; background-size:cover;">
<br><br>
<div class="card col-12 col-md-6 offset-md-3" align="center" style=" padding:2% 2% 1% 2%;">
<form action="" method = "post" class="form-inline" align="center">
	<div class="form-group" style="width:77.5% !important;margin-bottom:0 !important;width:auto;">
		<select class="form-control" style="width:100%;" name="sub" required id="exampleFormControlSelect1">
		<option value="">Choose Subject</option>
		<?php
			$result = mysqli_query($con, "select distinct subject from materials");
			while($row=mysqli_fetch_row($result))
				echo '<option value="'.$row[0].'">'.$row[0].'</option>';
		?>
		</select>
	</div>
	<button type="submit" style="width:auto !important; margin-left:1%;"class="btn btn-success btn-block ">Submit</button>
</form></div>
<br><br><br><br>
<?php
	if(isset($_POST['sub']))
	{
		$a=$_POST['sub'];
		$result=mysqli_query($con, "select distinct teacher from materials where subject='$a'");
		echo'<table class="col-12 col-md-6 offset-md-3" align:"center">
				<tr>
					<th align="center">Faculty</th>
					<th align="center" style="width:auto !important;">View</th>
				</tr>';

			while($row=mysqli_fetch_row($result))
			{	$_SESSION['sub']=$a;
				$_SESSION['tec']=$row[0];
				$rows=mysqli_fetch_row(mysqli_query($con, "select name from stafftable where user='$row[0]'"));
				echo '  <tr>
							<td align="center">'.$rows[0].'</td>
							<td align="center" style="width:auto !important;"><a href="topics_down.php" class="btn btn-primary">	View</a></td>
						</tr>';}
			echo '</table>';
	}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>