<!DOCTYPE HTML>
<html>
    <head>
        <title>admin</title>
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
        if(isset($_POST['carsButton'])){
        header('Location: cars.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['memButton'])){
        header('Location: members.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['reservationButton'])){
        header('Location: reservations.php');
        exit;
}
?>
    <a href="startup.php?logout=1">Log Out</a><br/>
    <form name='admin' id='admin' action='admin.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='carsButton' name='carsButton' value='cars' />
            </td>
            <td>
                <input type='submit' id='memButton' name='memButton' value='members' />
            </td>
            <td>
                <input type='submit' id='reservationButton' name='reservationButton' value='reservations' />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>