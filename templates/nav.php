<?php
$page_name = basename($_SERVER['PHP_SELF']);


if ($page_name == "index.php") {
    $active_index = "active";
} else {
    $active_index = "";
}
if ($page_name == "signup.php") {
    $active_signup = "active";
} else {
    $active_signup = "";
}
if ($page_name == "login.php") {
    $active_login = "active";
} else {
    $active_login = "";
}
if ($page_name == "messages.php") {
    $active_messages = "active";
} else {
    $active_messages = "";
}
if ($page_name == "account.php") {
    $active_account = "active";
} else {
    $active_account = "";
}
if ($page_name == "admin.php") {
    $active_admin = "active";
} else {
    $active_admin = "";
}
if ($page_name == "edit-user.php") {
    $active_edit = "active";
} else {
    $active_edit = "";
}
if ($page_name == "about-us.php"){
    $active_aboutus = "active";
} else {
    $active_aboutus = "";
}
if ($page_name == "contact-us.php"){
    $active_contactus = "active";
} else {
    $active_contactus = "";
}
if ($page_name == "dashboard.php"){
    $active_dashboard = "active";
} else {
    $active_dashboard = "";
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">HAG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
            <li class="nav-item">
            <a class="nav-link <?=$active_index?>" href="index.php">Home
                <span class="visually-hidden">(current)</span>
            </a>
            </li>
            <?php if (!isset($_SESSION['userid'])):?>
                <li class="nav-item ">
                    <a class="nav-link <?=$active_signup?>" href="signup.php">Sign Up</a>
                </li>
            <?php endif;?>

            <?php if (!isset($_SESSION['userid'])):?>
                <li class="nav-item ">
                <a class="nav-link <?=$active_login?>" href="login.php">Login</a>
                </li>
            <?php endif;?>

            <?php if(isset($_SESSION['userid'])):?>
                <li class="nav-item">
                    <a class="nav-link <?=$active_dashboard?>" href="dashboard.php">Dashboard</a>
                </li>
            <?php endif;?>

            <?php if (isset($_SESSION['userid'])):?>
                <li class="nav-item">
                    <a class="nav-link <?=$active_messages?>" href="messages.php">Forum</a>
                </li>
            <?php endif;?>
            
            <?php if(isset($_SESSION['isadmin']) && ($_SESSION["isadmin"] == true)):?>
                <li class="nav-item">
                    <a class="nav-link <?=$active_admin?>" href="admin.php">Admin</a>
                </li>
            <?php endif;?>

            <?php if(isset($_SESSION['userid'])):?>
                <li class="nav-item">
                    <a class="nav-link <?=$active_account?>" href="account.php">Account</a>
                </li>
            <?php endif;?>

                <li class="nav-item">
                    <a class="nav-link <?=$active_aboutus?>" href="about-us.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?=$active_contactus?>" href="contact-us.php">Contact Us</a>
                </li>

        </ul>
        <?php if(isset($_SESSION['userid'])):?>
            
                <form action="account-action.php" method="post">           
                    <button type="submit" name="logout" class="btn btn-danger" style="scale: 70%">Log Out</button>
                </form>
        
        <?php endif;?>

        <?php if(isset($_SESSION["isadmin"])):?>
            <?php if($_SESSION["isadmin"] == true):?>
                <?php if(connect()):?>
                    <span class="badge rounded-pill bg-success">Connected</span>
                <?php else:?>
                    <span class="badge rounded-pill bg-danger">Failed</span>
                <?php endif;?>
            <?php endif;?>
        <?php endif;?>

        </div>
    </div>
</nav>
