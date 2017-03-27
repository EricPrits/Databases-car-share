<!DOCTYPE HTML>
<html>
    <head>
        <title>cars</title>
    </head>
<body>

   <?php
        if(isset($_POST['addCarButton'])){
        header('Location: addCar.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['rentalHistoryButton'])){
        header('Location: rentalHistory.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['car5000Button'])){
        header('Location: car5000.php');
        exit;
}
?>

<?php
        if(isset($_POST['damagedCarsButton'])){
        header('Location: damagedCars.php');
        exit;
}
?>
    <form name='admin' id='admin' action='admin.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='addCarButton' name='addCarButton' value='Add a car' />
            </td>
            <tr>
                <td><input type='text' name='rentalHistoryVin' id='rentalHistoryVin' value='VIN' /></td>
                <td><input type='submit' id='rentalHistoryButton' name='rentalHistoryButton' value='Get rental history' /></td>
            </tr>
            <td>
                <input type='submit' id='car5000Button' name='car5000Button' value='Get 5000+ km cars' />
            </td>
            <td>
                <input type='submit' id='damagedCarsButton' name='damagedCarsButton' value='Get damaged cars' />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>