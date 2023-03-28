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
	
<?php require dirname(__FILE__). "/templates/nav.php"; ?>

<div class="container">
        <h1>About Us</h1>
        <p>We are a team of passionate developers who love creating solutions that make people's lives easier. Our goal is to provide high-quality software that solves real-world problems and makes a positive impact on society.</p>
        <h2>Our Mission</h2>
        <p>Our mission is to build software that simplifies complex processes, enhances productivity, and improves the quality of life for our users. We believe that technology should be accessible to everyone, and we strive to create intuitive and user-friendly applications that are easy to use and understand.</p>
        <h2>Our Values</h2>
        <ul>
            <li><strong>Innovation:</strong> We are always looking for new and better ways to do things. We believe that innovation is the key to success.</li>
            <li><strong>Collaboration:</strong> We believe that the best solutions come from working together. We value open communication and teamwork.</li>
            <li><strong>Integrity:</strong> We believe in doing the right thing, even when no one is watching. We hold ourselves to the highest standards of honesty and ethics.</li>
            <li><strong>Creativity:</strong> We believe that creativity is essential to our success. We encourage our team members to think outside the box and come up with new ideas.</li>
        </ul>
        <h2>Our Team</h2>
        <p>We are a diverse group of individuals with a wide range of skills and expertise. Our team includes developers, designers, project managers, and quality assurance specialists. We work together to create innovative software solutions that meet the needs of our clients and users.</p>
        <h2>Contact Us</h2>
        <p>If you have any questions or comments, please feel free to contact us using the information below:</p>
        <ul>
            <li><strong>Email:</strong> info@ourcompany.com</li>
            <li><strong>Phone:</strong> (+44) 1234567890</li>
            <li><strong>Address:</strong> 123 Main Street, Anytown, UK</li>
        </ul>
		<p>Send us a message:</p>
		
    </div>

</body>
</html>