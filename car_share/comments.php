<!DOCTYPE HTML>
<html>
    <head>
    <style>
        table.content, th.content, td.content {
        border: 1px solid black;
        border-collapse: collapse;
        }
        th.content, td.content {
            padding: 5px;
            text-align: left;    
                }
        </style>
        <title>comments</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    ?>
   <?php
        if(isset($_POST['backButton'])){
        header('Location: members.php');
        exit;
    }
    ?>
<?php
        if(isset($_POST['respondButton'])&& isset($_POST['responseRentalID']) && isset($_POST['responseComment'])){
            include_once 'config/connection.php'; 
                $query = "UPDATE rental_comments SET comment_reply=? WHERE rental_ID=?";
                $stmt = $con -> prepare($query); 
                $stmt->bind_Param('ss', $_POST['responseComment'],$_POST['responseRentalID']);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
}
?>

    <form name='comments' id='comments' action='comments.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
			<tr>
                <td><input type='text' name='responseRentalID' id='responseRentalID' value='Comment Rental ID' /></td>
				<td><input type='text' name='responseComment' id='responseComment' value='Comment' /></td>
                <td><input type='submit' id='respondButton' name='respondButton' value='Submit Comment' /></td>
            </tr>
    </table>
    </form>
    <td><?php
                include_once 'config/connection.php'; 
                $query = "SELECT * FROM rental_comments;";
                $stmt = $con -> prepare($query); 
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                //echo "<br />" . $result -> num_rows . " rows in result <br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">Rental ID</th>
                    <th class="content">VIN</th>
                    <th class="content">Member #</th>
					<th class="content">Rating</th>
                    <th class="content">Comment</th>
                    <th class="content">Admin Reply</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["rental_ID"] . '</td>
                                <td class="content">' . $row["VIN"] . '</td>
                                <td class="content">' . $row["member_number"] . '</td>
								<td class="content">' . $row["rating"] . '</td>
                                <td class="content">' . $row["comment_text"] . '</td>
                                <td class="content">' . $row["comment_reply"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?><td>
</body>
</html>