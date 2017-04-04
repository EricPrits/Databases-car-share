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
        <title>addCar</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    ?>

    <?php
        if(isset($_POST['acceptAddCarButton'])){
            if (isset($_POST['addedVin']) && isset($_POST['addedMake']) && isset($_POST['addedModel']) && isset($_POST['addedYear']) && isset($_POST['addedLocationID']) && isset($_POST['addedDailyFee'])) {
                //do the query
                header('Location: cars.php');
                exit;
            }  
}
 ?>

   <?php
        if(isset($_POST['backButton'])){
        header('Location: cars.php');
        exit;
    }
    ?>

    <form name='addCar' id='addCar' action='addCar.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
            <tr>
                <td><input type='text' name='addedVin' id='addedVin' placeholder='VIN' /></td>
                <td><input type='text' name='addedMake' id='addedMake' placeholder='Make' /></td>
                <td><input type='text' name='addedModel' id='addedModel' placeholder='Model' /></td>
                <td><input type='text' name='addedYear' id='addedYear' placeholder='Year' /></td>
                <td><input type='text' name='addedLocationID' id='addedLocationID' placeholder='Location ID' /></td>
                <td><input type='text' name='addedDailyFee' id='addedDailyFee' placeholder='Daily Fee' /></td>
                <td><input type='submit' id='acceptAddCarButton' name='acceptAddCarButton' value='add car' /></td>
            </tr>
        </tr>
    </table>
    </form>
</body>
</html>