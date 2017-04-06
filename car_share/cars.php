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
    include_once 'config/connection.php'; 
    if(!isset($_SESSION['member_number'])){
        //User is not logged in. Redirect the browser to the login index.php page and kill this page.
        header("Location: startup.php");
        die();
    }
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
            <tr>
                <td><input type='submit' id='backButton' name='backButton' value='Back' /></td>
                <td><a href="startup.php?logout=1">Log Out</a><br/></td>
            </tr>
            <tr>
            <td><?php
                $query = "select VIN, rentalcount
                from (select VIN, count(*) as rentalcount from car_rental group by VIN) as M
                where  rentalcount = (
                select max(rentalcount)
                from (select VIN, count(*) as rentalcount from car_rental group by VIN) as M);";
                $stmt = $con -> prepare($query);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                $myrow = $result->fetch_assoc();                
                echo "most rented car: VIN " . $myrow['VIN'] . " with " . $myrow['rentalcount'] . " rentals";
                ?></td>
                </tr>
                <tr>
                <td><?php
                $query = "select VIN, rentalcount
                from (select VIN, count(*) as rentalcount from car_rental group by VIN) as M
                where  rentalcount = (
                select min(rentalcount)
                from (select VIN, count(*) as rentalcount from car_rental group by VIN) as M);";
                $stmt = $con -> prepare($query);
                try {
                $stmt -> execute(); }
                catch(Exception $exception) {
                echo "Query failed: ", $exception->getMessage(); }
                $result = $stmt -> get_result();
                $myrow = $result->fetch_assoc();                
                echo "least rented car: VIN " . $myrow['VIN'] . " with " . $myrow['rentalcount'] . " rentals";
    ?></td></tr>
            <tr>
                <td><input type='text' name='rentalHistoryVin' id='rentalHistoryVin' placeholder='VIN' /></td>
                <td><input type='submit' id='rentalHistoryButton' name='rentalHistoryButton' value='Get rental history' /></td>
            </tr>
            <tr><td><input type='submit' id='car5000Button' name='car5000Button' value='Get 5000+ km cars' /></td></tr>
            <tr><td><input type='submit' id='damagedCarsButton' name='damagedCarsButton' value='Get damaged cars' /></td></tr>
            <tr><td><input type='submit' id='addCarButton' name='addCarButton' value='Add a car' /></td></tr>
    </table>
    </form>
    <td><?php
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