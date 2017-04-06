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
        <title>member info</title>
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
	echo "Enter the date range of one month:";
        if(isset($_POST['invoiceButton'])){
				if (isset($_POST['dateFrom'])) {
                $_SESSION['currentDateFrom'] = $_POST['dateFrom'];
            }
			if (isset($_POST['dateTo'])) {
                $_SESSION['currentDateTo'] = $_POST['dateTo'];
            }
        header('Location: invoice.php');
        exit;
}
 ?>

    <form name='membersInfo' id='membersInfo' action='membersInfo.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
			<tr>
                <td><input type='text' name='dateFrom' id='dateFrom' value='YYYY-MM-DD' /></td>
				<td><input type='text' name='dateTo' id='dateTo' value='YYYY-MM-DD' /></td>
                <td><input type='submit' id='invoiceButton' name='invoiceButton' value='Generate Invoice' /></td>
            </tr>
    </table>
    </form>
    <td>
    <?php
                include_once 'config/connection.php'; 
                $query = "SELECT * FROM ktcs_member where member_number=?;";
                $stmt = $con -> prepare($query); 
                if (isset($_SESSION['currentMemberInfoNum'])) {
                    $currentMNum = $_SESSION['currentMemberInfoNum'];
                }
                $stmt->bind_Param("s", $currentMNum);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                echo "<br />" . $result -> num_rows . " Member Info: " . $currentMNum . "<br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">Member #</th>
                    <th class="content">First Name</th>
                    <th class="content">Last Name</th>
                    <th class="content">Address</th>
                    <th class="content">Phone #</th>
                    <th class="content">Email</th>
                    <th class="content">Drivers License</th>
					<th class="content">Monthly Membership Fee</th>
                    <th class="content">Admin Privlages</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["member_number"] . '</td>
                                <td class="content">' . $row["fname"] . '</td>
                                <td class="content">' . $row["lname"] . '</td>
                                <td class="content">' . $row["address"] . '</td>
                                <td class="content">' . $row["phone_number"] . '</td>
                                <td class="content">' . $row["email"] . '</td>
                                <td class="content">' . $row["drivers_license"] . '</td>
								<td class="content">' . $row["monthly_membership_fee"] . '</td>
                                <td class="content">' . $row["is_admin"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>