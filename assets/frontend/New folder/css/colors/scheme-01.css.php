<?php 
header("Content-Type: text/css");
$primary_color = isset($_GET['primary_color']) ? $_GET['primary_color'] : '#000000';
$secondary_color = isset($_GET['secondary_color']) ? $_GET['secondary_color'] : '#000000';
$primary_color_rgb = '120, 202, 92';
$secondary_color_rgb = '25, 158, 28';
?>
:root {
  --primary-color: <?php echo $primary_color; ?>;
  --primary-color-rgb: <?php echo $primary_color_rgb; ?>;

  --secondary-color: <?php echo $secondary_color; ?>;
  --secondary-color-rgb: <?php echo $secondary_color_rgb; ?>;
}