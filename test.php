<?php phpinfo() ?>



$pfp_jpg = $target_file;
$pfp_png = $target_file;
$pfp_gif = $target_file;

if(file_exists("php-images/".$pfp_jpg)){
    unlink("php-images/".$pfp_png);
    unlink("php-images/".$pfp_gif);
}
else if(file_exists("php-images/".$pfp_png)){
    unlink("php-images/".$pfp_jpg);
    unlink("php-images/".$pfp_gif);
}
else if(file_exists("php-images/".$pfp_gif)){
    unlink("php-images/".$pfp_png);
    unlink("php-images/".$pfp_jpg);
}