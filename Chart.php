<?php
// Get the head of the html page
require "./templates/head.php";

// Connect to database
require "ConnectDB.php";

echo "<h1>Top 10 Search</h1>";

// Chart image
$image = @imagecreate(600, 350) or die("Cannot Load Image!");
$backgroundColor = imagecolorallocate($image, 0, 0, 0);
$white = imagecolorallocate($image, 255, 255, 255);

// image lines
imageline($image, 20, 20, 20, 330, $white);
imageline($image, 20, 20, 580, 20, $white);

// image text numbers
imagestring($image, 5, 3, 40, "1", $white);
imagestring($image, 5, 3, 70, "2", $white);
imagestring($image, 5, 3, 100, "3", $white);
imagestring($image, 5, 3, 130, "4", $white);
imagestring($image, 5, 3, 160, "5", $white);
imagestring($image, 5, 3, 190, "6", $white);
imagestring($image, 5, 3, 220, "7", $white);
imagestring($image, 5, 3, 250, "8", $white);
imagestring($image, 5, 3, 280, "9", $white);
imagestring($image, 5, 3, 310, "10", $white);

// image text titles
imagestring($image, 5, 30, 3, "Title:", $white);
imagestring($image, 5, 475, 3, "Search Count:", $white);

// Sql to get top 10
$sql = "SELECT * FROM `dvd` ORDER BY `SearchCount` DESC;";

// Run sql query
$sql = mysqli_query($conn, $sql);

// Position for displaying
$pos = 40;

// If sql query returns data
if (mysqli_num_rows($sql) > 0) {
    // Forloop for top 10
    for ($count = 0; $count < 10; $count++) {
        // Row of data from sql 
        $row = mysqli_fetch_assoc($sql);

        // Variables for Title and search count
        $title = $row['Title'];
        $searchCount = $row['SearchCount'];

        // Create Text for Title and Search count
        imagestring($image, 5, 30, $pos, $title, $white);
        imagestring($image, 5, 575, $pos, $searchCount, $white);

        // Increase pos by 30
        $pos = $pos + 30;
    }
}

// Close MySQL Connection
mysqli_close($conn);

//image
imagepng($image, "images/graph.png");
echo "<img src='images/graph.png'/>";
imagedestroy($image);


require "./templates/foot.php";
?>