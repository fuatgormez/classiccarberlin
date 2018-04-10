<?php
session_start();

$string = '';

for ($i = 0; $i < 5; $i++) 
{
	// this numbers refer to numbers of the ascii table (lower case)
	$string .= chr(rand(97, 122));
}

$_SESSION['rand_code'] = $string;

$dir = 'fonts/';

$image = imagecreatetruecolor(80, 30);
$black = imagecolorallocate($image, 0, 0, 0);
$color = imagecolorallocate($image, 200, 100, 90); // red
$white = imagecolorallocate($image, 250, 250, 250);

imagefilledrectangle($image,0,0,399,99,$white);
imagettftext ($image, 14, 0, 10, 20, $color, $dir."banksia.ttf", $_SESSION['rand_code']);

header("Content-type: image/png");
imagepng($image);
