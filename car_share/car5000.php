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
        <title>car5000</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    ?>

   <?php
        if(isset($_POST['backButton'])){
        header('Location: cars.php');
        exit;
    }
    ?>

    <form name='car5000' id='car5000' action='car5000.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
            </td>
    </table>
    </form>
    <td>
    <?php
            include_once 'config/connection.php'; 
                $query = "select car_rental.VIN, rental.dropoff_odemeter as odometer_from_previous_rental, maintenance_history.odometer_reading as odometer_from_previous_maintenance from
                    (rental natural join car_rental natural join maintenance_history) join 
                    (SELECT date, EachItem.VIN, car_rental.rental_ID
                    FROM car_rental
                    INNER JOIN 
                    (SELECT VIN, MAX(date) as TopDate
                    FROM car_rental
                    GROUP BY VIN) AS EachItem ON 
                    EachItem.TopDate = car_rental.date 
                    AND EachItem.VIN = car_rental.VIN) as recent_rentals
                    on car_rental.rental_ID = recent_rentals.rental_ID
                    where (rental.dropoff_odemeter - maintenance_history.odometer_reading) > '5000';";
                $stmt = $con -> prepare($query); 
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                echo "<br />" . $result -> num_rows . " rows in result <br />";
                echo '<table class="content" style="width:100%">
                  <tr class="content">
                    <th class="content">VIN</th>
                    <th class="content">Odometer from previous rental</th>
                    <th class="content">Odometer from previous previous maintenance</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["VIN"] . '</td>
                                <td class="content">' . $row["odometer_from_previous_rental"] . '</td>
                                <td class="content">' . $row["odometer_from_previous_maintenance"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>