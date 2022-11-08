<?php include 'db.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
	<link rel="stylesheet" href="main.css">
</head>
<body>
<h1 style="text-align:center;color:#49C628">NEXT LINK</h1>
<div class="box-form">
<div class="main">
<h1 style="text-align:center;color:#49C628">Upload</h1>

   
				<form method="post" enctype="multipart/form-data">
					<?php
						// If submit button is clicked
						if (isset($_POST['submit']))
						{
						// get name from the form when submitted
						$name = $_POST['name'];					

						if (isset($_FILES['pdf_file']['name']))
						{
						// If the ‘pdf_file’ field has an attachment
							$file_name = $_FILES['pdf_file']['name'];
							$file_tmp = $_FILES['pdf_file']['tmp_name'];
							
							// Move the uploaded pdf file into the pdf folder
							move_uploaded_file($file_tmp,"./uploads".$file_name);
							// Insert the submitted data from the form into the table
							$insertquery =
							"INSERT INTO upload(username,filename) VALUES('$name','$file_name')";
							
							// Execute insert query
							$iquery = mysqli_query($con, $insertquery);	

								if ($iquery)
							{							
					?>											
								
									<a class="close" data-dismiss="alert" aria-label="close">
									
									</a>
									<strong>Success!</strong> Data submitted successfully.
								
								<?php
								}
								else
								{
								?>
									<a class="close" data-dismiss="alert" aria-label="close">
									
									</a>
									<strong>Failed!</strong> Try Again!
								
								<?php
								}
							}
							else
							{
							?>
								<a class="close" data-dismiss="alert" aria-label="close">
									
								</a>
								<strong>Failed!</strong> File must be uploaded in PDF format!
							
							<?php
							}// end if
						}// end if
					?>
					
					
							<input type="text" 
								placeholder="Enter your name" name="name">
							<input type="file" name="pdf_file"
								 accept=".pdf, .jpg, .png, jpeg" required/>
						
							<input type="submit"
								class="btnRegister" name="submit" value="Submit">
				
				</form>
				<br>
				<a href=" http://localhost/nextlink/welcome.php" class="btn btn-primary">Back</a>
					
			</div></div>
						
			<br>
			<div class="box-form">
			<div class="main">
				<h1 style="text-align:center;color:#49C628">Records</h1>
			
					<table>
						<thead>
							<th>ID</th>
							<th>UserName</th>
							<th>FileName</th>
						</thead>
						<tbody>
						<?php
							$selectQuery = "select * from upload";
							$squery = mysqli_query($con, $selectQuery);

							while (($result = mysqli_fetch_assoc($squery))) {
						?>
						<tr>
							<td><?php echo $result['id']; ?></td>
							<td><?php echo $result['username']; ?></td>
							<td><?php echo $result['filename']; ?></td>
						</tr>
						<?php
							}
						?>
						</tbody>
					</table>			
				
	
	</div>
</div>
</div>
</body>
</html>
