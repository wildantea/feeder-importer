<?php
if (file_exists('install.txt')) {
	header("location:installasi/index.php");
} else {
	header("location:admina/index.php");
}
	
?>
