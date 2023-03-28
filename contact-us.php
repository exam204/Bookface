<?php
session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Health Advice Group</title>
	<?php require dirname(__FILE__)."/Style/links.php"; ?>
    <?php require dirname(__FILE__)."/PHPFunc/db-connect.php";?>
</head>
<body>
	
<?php require dirname(__FILE__). "/templates/nav.php"; 
if(isset($_SESSION["contact-fail"])){
	echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
	<strong>Oops!!</strong> ", $_SESSION['contact-fail'],"!!
	<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
	</div>";
	unset($_SESSION["contact-fail"]);
}
if(isset($_SESSION["contact"])){
	echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
	<strong>Success!!</strong> ", $_SESSION['contact'],"!!
	<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
	</div>";
	unset($_SESSION["contact"]);
}
?>
<div class="container">
		<div class="row">
			<div class="col-md-6 mx-auto">
				<h2>Contact Us</h2>
				<form method="post" action="contact-us-action.php">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
					</div>
					<div class="form-group">
						<label for="phone">Phone Number</label>
						<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
					</div>
					<div class="form-group">
						<label for="message">Message</label>
						<textarea class="form-control" id="message" name="message" placeholder="Enter your message" rows="5" required></textarea>
					</div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>


</body>
</html>