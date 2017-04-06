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
        <title>NewMember</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    ?>
    <?php
        if(isset($_POST['acceptNewMember'])){
			include_once 'config/connection.php'; 
            if (isset($_POST['newFname']) && isset($_POST['newLname']) && isset($_POST['newEmail']) && isset($_POST['newAddress']) && isset($_POST['newDriversLicense']) && isset($_POST['newPhoneNumber'])) {
                $randomNumber = rand(3,100);
				$query = "select max(member_number)+1 as newMemberNum from ktcs_member";
				$stmt = $con -> prepare($query);
				$stmt -> execute();
				$result = $stmt -> get_result();
				while($row = $result->fetch_assoc())
                    {
                         $memberNum=$row["newMemberNum"];
                    }
				$stmt = $con -> prepare($query); 
				
				$query = "insert into ktcs_member values(?,?,?,?,?,?,?,25, false)";
                $stmt = $con -> prepare($query); 
                $stmt->bind_Param('sssssss',$memberNum, $_POST['newFname'],$_POST['newLname'],$_POST['newEmail'],$_POST['newAddress'],$_POST['newDriversLicense'],$_POST['newPhoneNumber']);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
				echo "Member Number: ", $memberNum;
            }  
}
 ?>
   <?php
        if(isset($_POST['backButton'])){
        header('Location: startup.php');
        exit;
    }
    ?>
    <form name='newMember' id='newMember' action='newMember.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
            <tr>
                <td><input type='text' name='newFname' id='newFname' placeholder='fname' /></td>
                <td><input type='text' name='newLname' id='newLname' placeholder='lname' /></td>
                <td><input type='text' name='newEmail' id='newEmail' placeholder='Email' /></td>
                <td><input type='text' name='newAddress' id='newAddress' placeholder='Address' /></td>
                <td><input type='text' name='newDriversLicense' id='newDriversLicense' placeholder='Drivers License' /></td>
                <td><input type='text' name='newPhoneNumber' id='newPhoneNumber' placeholder='Phone Number' /></td>
            </tr>
			<td>
                <input type='submit' id='acceptNewMember' name='acceptNewMember' value='Create' />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>