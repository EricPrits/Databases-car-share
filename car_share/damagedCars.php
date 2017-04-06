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
        <title>damagedCars</title>
    </head>
<body>
    <?php
    //Create a user session or resume an existing one
    session_start();
    include_once 'config/connection.php'; 
    if(!isset($_SESSION['member_number'])){
        //User is not logged in. Redirect the browser to the login index.php page and kill this page.
        header("Location: startup.php");
        die();
    }
    ?>

   <?php
        if(isset($_POST['backButton'])){
        header('Location: cars.php');
        exit;
    }
    ?>
    <form name='damagedCars' id='damagedCars' action='damagedCars.php' method='post'>
    <table border='0'>
            <td><input type='submit' id='backButton' name='backButton' value='Back' /></td>
            <td><a href="startup.php?logout=1">Log Out</a><br/></td>
    </table>
    </form>
    <td>
    <?php
            include_once 'config/connection.php'; 
                $query = "SELECT car_rental.VIN, car_rental.date, rental.return_status
                    FROM (car_rental natural join rental)
                    INNER JOIN 
                    (SELECT VIN, MAX(date) as TopDate
                    FROM car_rental
                    GROUP BY VIN) AS EachItem ON 
                    EachItem.TopDate = car_rental.date 
                    AND EachItem.VIN = car_rental.VIN
                    where rental.return_status != 'normal';";
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
                    <th class="content">Most recent rental date</th>
                    <th class="content">Current status</th>
                  </tr>';
                while($row = $result->fetch_assoc())
                    {
                         echo '<tr class="content">
                                <td class="content">' . $row["VIN"] . '</td>
                                <td class="content">' . $row["date"] . '</td>
                                <td class="content">' . $row["return_status"] . '</td>
                            </tr>';
                    }
                echo '</table>';
                $result->close();
                $con->close();
            ?></td>
</body>
</html>