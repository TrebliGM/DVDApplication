<?php
// Gets the header from template folder
require "./templates/head.php";

// Connect To Database
require "ConnectDB.php";

// Heading Movies
echo "<h1>All Movies</h1>";

// Sql Query
$sql = mysqli_query($conn, "SELECT * FROM dvd");

if (mysqli_num_rows($sql) > 0) {
    // Creates the table
    echo "<table class = 'centre'>";
    echo "	<tr>
				<th>ID</th>
				<th>Title</th>
				<th>Studio</th>
				<th>Status</th>
				<th>Sound</th>
				<th>Versions</th>
				<th>RecRetPrice</th>
				<th>Rating</th>
				<th>Year</th>
				<th>Genre</th>
				<th>Aspect</th>
			</tr>";

    // while Row has data
    while ($row = mysqli_fetch_assoc($sql)) {
        // Get data from sql and place them in variables
        $id = $row['ID'];
        $title = $row['Title'];
        $studio = $row['Studio'];
        $status = $row['Status'];
        $sound = $row['Sound'];
        $versions = $row['Versions'];
        $recRetPrice = $row['RecRetPrice'];
        $rating = $row['Rating'];
        $year = $row['Year'];
        $genre = $row['Genre'];
        $aspect = $row['Aspect'];

        // Display variables data into a table
        echo "<tr>
        	<td>$id</td>
			<td>$title</td>
			<td>$studio</td>
			<td>$status</td>
			<td>$sound</td>
			<td>$versions</td>
			<td>$recRetPrice</td>
			<td>$rating</td>
			<td>$year</td>
			<td>$genre</td>
			<td>$aspect</td>
			
        	<tr>";
    }

    // Close Table
    echo "</table>";
} else {
    // Error if no dvds
    echo "No DVD's Stored!";
}
// Close Database Connection
mysqli_close($conn);

// Get Footer
require "./templates/foot.php";
?>