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
        <title>cars</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    ?>

   <?php
        if(isset($_POST['addCarButton'])){
        header('Location: addCar.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['rentalHistoryButton'])){
            if (!empty($_POST['rentalHistoryVin'])) {
                $_SESSION['currentRentalHistoryVIN'] = $_POST['rentalHistoryVin'];
            }
        header('Location: carRentalHistory.php');
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

   <?php
        if(isset($_POST['backButton'])){
        header('Location: admin.php');
        exit;
    }
    ?>

    <form name='cars' id='cars' action='cars.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
            <td>
                <input type='submit' id='addCarButton' name='addCarButton' value='Add a car' />
            </td>
            <tr>
                <td><input type='text' name='rentalHistoryVin' id='rentalHistoryVin' placeholder='VIN' /></td>
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
    <td><?php
                include_once 'config/connection.php'; 
                $query = "SELECT * FROM cars;";
                $stmt = $con -> prepare($query); 
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                //echo "<br />" . $result -> num_rows . " rows in result <br />";

                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">VIN</th>
                    <th class="content">Make</th>
                    <th class="content">Model</th>
                    <th class="content">Year</th>
                    <th class="content">Location ID</th>
                    <th class="content">Daily Fee</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["VIN"] . '</td>
                                <td class="content">' . $row["make"] . '</td>
                                <td class="content">' . $row["model"] . '</td>
                                <td class="content">' . $row["year"] . '</td>
                                <td class="content">' . $row["location_ID"] . '</td>
                                <td class="content">' . $row["daily_fee"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>