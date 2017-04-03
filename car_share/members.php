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
		 <title>members</title>
	</head>
<body>
<?php
    //Create a user session or resume an existing one
    session_start();
    ?>
	
 <?php
        if(isset($_POST['infoButton'])){
            if (isset($_POST['memberInfoNum'])) {
                $_SESSION['currentMemberInfoNum'] = $_POST['memberInfoNum'];
            }
        header('Location: membersInfo.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['commentButton'])){
        header('Location: comments.php');
        exit;
}
 ?>
 <?php
        if(isset($_POST['backButton'])){
        header('Location: admin.php');
        exit;
}
?>
  <form name='members' id='members' action='members.php' method='post'>
    <table border='0'>
			<td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
			<tr>
                <td><input type='text' name='memberInfoNum' id='memberInfoNum' value='Member #' /></td>
                <td><input type='submit' id='infoButton' name='infoButton' value='Get Member Info' /></td>
            </tr>
            <td>
                <input type='submit' id='commentButton' name='commentButton' value='Comments' />
            </td>
        </tr>
    </table>
    </form>
	  <td><?php
                include_once 'config/connection.php'; 
                $query = "SELECT * FROM ktcs_member;";
                $stmt = $con -> prepare($query); 
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                //echo "<br />" . $result -> num_rows . " rows in result <br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">First Name</th>
                    <th class="content">Last Name</th>
                    <th class="content">Member #</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["fname"] . '</td>
                                <td class="content">' . $row["lname"] . '</td>
                                <td class="content">' . $row["member_number"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>