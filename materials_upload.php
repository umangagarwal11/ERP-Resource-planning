<?php
	include('db.php');
	session_start();
    if (isset($_POST['upload'])) {
			
			$file_name  = $_FILES['file']['name'];
			$file_type = $_FILES['file']['type'];
			$file_size = $_FILES['file']['size'];
			$file_tem_Loc = $_FILES['file']['tmp_name'];
			$file_store = "uploads/".$file_name;
			$fileextension = (explode('.',$file_name));
			$fileextension = strtolower(end($fileextension));
			$uploadPath = "./uploads/";
			$extensions = array("pdf");
			$name = $_POST['name'];
			$subject=$_POST['name1'];
			$staff = $_SESSION['staff'];
			    if (! in_array($fileextension,$extensions)) {
            $err =1;
        }

        else if ($file_size > 200000000) {
            $err=2;
        }

        else {
          $didUpload=move_uploaded_file($_FILES["file"]["tmp_name"], $uploadPath.$subject.'_'.$staff.'_'.$name.'.pdf');
          if ($didUpload) {
				
              $err=0;
              $query="INSERT INTO `materials` values('$subject','$name','$staff')";
              if(!mysqli_query($con,$query))
              {
				
                $err=4;
              }
              else {
				
                $err=0;
              }
                //echo "DONE";

            } else {
                $err=3;
            }
        }

        
    }
    else {
      //echo "NOT THERE";
    }
    if(isset($_GET))
    {
      extract($_GET);
    }

			
			
?>
<html>
<head>
<link rel = "stylesheet " type = "text/css" href = "https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel = "stylesheet" type = "text/css" href = "style.css">
</head>
   <body>
   <div style = "padding-top: 10%; ">
      <div class = "ml-auto mr-auto col-md-3 card"  align = "left">
	  <br>
	  <?php
	  if(isset($err))
	  {
		if( $err == 1){
		echo "Only .jpg is supported!";
		}
		else if( $err == 2){
		echo "File size exceeded!";
		}
		else if( $err > 2){
		echo "File not uploaded";
		}
		else {
		echo "File uploaded!";
		}
		
		}
	  ?>
	  <br>
      <form action="" method="POST" enctype="multipart/form-data">
        <input type = "file" name = "file" class  = "form-control" required placeholder ="Material" ><br><br>
		<input type="mediumtext" name="name1" placeholder="Subject" /><br><br>
		<input type="mediumtext" name="name" placeholder="Topic" /><br><br>
         <input type="submit" name = "upload" class="btn btn-success" value = "Upload"/>
		 
      </form>
      </div>
	  </div>
   </body>
</html>