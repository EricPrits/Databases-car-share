<!DOCTYPE HTML>
<html>
	<head>
		 <title>reservations</title>
	</head>
<body>
	<?php
    //Create a user session or resume an existing one
    session_start();
    ?>
 <?php
        if(isset($_POST['dateButton'])){
            if (isset($_POST['reservationDate'])) {
                $_SESSION['currentReservationDate'] = $_POST['reservationDate'];
            }
        header('Location: reservationDate.php');
        exit;
}
 ?>


 <?php
        if(isset($_POST['locationButton'])){
            if (isset($_POST['reservationLocation'])) {
                $_SESSION['currentReservationLocation'] = $_POST['reservationLocation'];
            }
        header('Location: reservationLocation.php');
        exit;
}
 ?>
  <?php
        if(isset($_POST['backButton'])){
        header('Location: admin.php');
        exit;
}
?>
  <form name='reservations' id='reservations' action='reservations.php' method='post'>
    <table border='0'>
            <tr>
                <td><input type='text' name='reservationDate' id='reservationDate' value='YYYY-MM-DD' /></td>
                <td><input type='submit' id='dateButton' name='dateButton' value='View Reservations by Date' /></td>
            </tr>
            <tr>
                <td><input type='text' name='reservationLocation' id='reservationLocation' value='Location' /></td>
                <td><input type='submit' id='locationButton' name='locationButton' value='View Reservations by Location' /></td>
            </tr>
			<td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>