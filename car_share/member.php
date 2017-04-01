<!DOCTYPE HTML>
<html>
    <head>
        <title>member</title>
    </head>
<body>

   <?php
        if(isset($_POST['rentalHistoryButton'])){
        header('Location: rentalHistory.php');
        exit;
}
 ?>
 
    <?php
        if(isset($_POST['pickupFormButton'])){
        header('Location: pickupForm.php');
        exit;
}
 ?>
 
	<?php
        if(isset($_POST['dropoffFormButton'])){
        header('Location: dropoffForm.php');
        exit;
}
 ?>
 
	<?php
        if(isset($_POST['reserveCarButton'])){
        header('Location: reserveCar.php');
        exit;
}
 ?>

    <form name='member' id='member' action='member.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='rentalHistoryButton' name='rentalHistoryButton' value='Rental History' />
            </td>
			<td>
                <input type='submit' id='pickupFormButton' name='pickupFormButton' value='Pick Up Car' />
            </td>
			<td>
                <input type='submit' id='dropoffFormButton' name='dropoffFormButton' value='Drop Off Car' />
            </td>
			<td>
                <input type='submit' id='reserveCarButton' name='reserveCarButton' value='Reserve Car' />
            </td>
        </tr>
    </table>
    </form>
	
</body>
</html>