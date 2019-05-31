<?php
// Gets the header from template folder
require "./templates/head.php";

// Connect To Database
require "ConnectDB.php";
?>

<form action="Search.php" method="POST">

    <h1>Movie Search</h1>
    <h2>Search Type</h2>

    <div class="block">
        <label>Title:</label>
        <input type="text" name="Title">
    </div>

    <div class="block">
        <label>Genre:</label>
        <input type="text" name="Genre">
    </div>

    <div class="block">
        <label>Rating:</label>
        <input type="text" name="Rating">
    </div>

    <div class="block">
        <label>Year:</label>
        <input type="text" name="Year">
        <select name="yearOptions">
            <option value="=">=</option>
            <option value=">">></option>
            <option value="<"><</option>
        </select>
    </div>

    <input type="submit" value="Submit" name="submit">

</form>

<?php
// If Button is clicked
if (isset($_POST['submit'])) {
    // Variables for text boxes
    $titleInput = $_POST['Title'];
    $genreInput = $_POST['Genre'];
    $ratingInput = $_POST['Rating'];
    $yearInput = $_POST['Year'];
    $yearOption = $_POST['yearOptions'];

    // Start of the sql
    $sql = "SELECT * FROM `dvd` WHERE";

    // Variable for starting the sql
    $sqlFirst = false;

    // If all textboxes are empty
    if ($titleInput == null && $genreInput == null
        && $ratingInput == null && $yearInput == null
    ) {
        // display message
        echo "No Input Entered!";
    } else {
        // If title textboxes is not empty and matches regex
        if ($titleInput != null 
            && preg_match("/[a-zA-Z0-9\s\(\):]+$/", $titleInput)
        ) {
            // add to sql query
            $sql .= " `Title` LIKE '%" . $titleInput . "%'";
            $sqlFirst = true;
        }

        // If genre textboxes is not empty and matches regex
        if ($genreInput != null && preg_match("/[a-zA-Z\/]+$/", $genreInput)) {
            if ($sqlFirst == false) {
                // add to sql query
                $sql .= " `Genre` LIKE '%" . $genreInput . "%'";
                $sqlFirst = true;
            } else {
                // add to sql query
                $sql .= " AND `Genre` LIKE '%" . $genreInput . "%'";
            }
        }

        // If rating textboxes is not empty and matches regex
        if ($ratingInput != null && preg_match("/[a-zA-Z0-9\-]+$/", $ratingInput)) {
            if ($sqlFirst == false) {
                // add to sql query
                $sql .= " `Rating` LIKE '%" . $ratingInput . "%'";
                $sqlFirst = true;
            } else {
                // add to sql query
                $sql .= " AND `Rating` LIKE '%" . $ratingInput . "%'";
            }
        }

        // If year textboxes is not empty and matches regex and selectbox is equals
        if ($yearInput != null 
            && preg_match("/^[0-9]{4}$/", $yearInput) && $yearOption == "="
        ) {
            if ($sqlFirst == false) {
                // add to sql query
                $sql .= " `Year` = " . $yearInput;
                $sqlFirst = true;
            } else {
                // add to sql query
                $sql .= " AND `Year` = " . $yearInput;
            }
            // If year textboxes is not empty and 
            //matches regex and selectbox is greater than
        } elseif ($yearInput != null && preg_match("/^[0-9]{4}$/", $yearInput) 
            && $yearOption == ">"
        ) {
            if ($sqlFirst == false) {
                // add to sql query
                $sql .= " `Year` > " . $yearInput;
                $sqlFirst = true;
            } else {
                // add to sql query
                $sql .= " AND `Year` > " . $yearInput;
            }
            // If year textboxes is not empty and matches regex and selectbox is less
        } elseif ($yearInput != null && preg_match("/^[0-9]{4}$/", $yearInput) 
            && $yearOption == "<"
        ) {
            if ($sqlFirst == false) {
                // add to sql query
                $sql .= " `Year` < " . $yearInput;
                $sqlFirst = true;
            } else {
                // add to sql query
                $sql .= " AND `Year` < " . $yearInput;
            }
        }

        // End of Sql Query
        $sql .= ";";

        // put sql results into variable
        $result = mysqli_query($conn, $sql);

        // If Sql has been built
        if ($sqlFirst == true) {
            // If Results contains data
            if (mysqli_num_rows($result) > 0) {
                // Display heading
                echo "<h2>Search Results</h2>";

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

                while ($row = mysqli_fetch_assoc($result)) {
                    // Put Data from a row into variables
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
                    $searchCount = $row['SearchCount'];

                    // Display Row Data in a table
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

                    // Update sql to increment searchcount
                    $sqlUpdate = "UPDATE `dvd` SET `SearchCount` = " 
                    . ($searchCount + 1) . " WHERE `ID` = " . $id . ";";
                    // Run Update Sql
                    mysqli_query($conn, $sqlUpdate);
                }

                // Close table
                echo "</table>";

            } else {
                // Display no DVD's
                echo "No DVD Found!";
            }
        } else {
            // Error If Regex Match fails
            echo "Incorrect Formatting!";
        }

    }

    // Close Database Connection
    mysqli_close($conn);
}

// Get Footer
require "./templates/foot.php";
?>
