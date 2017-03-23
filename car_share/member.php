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

    <form name='member' id='member' action='member.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='rentalHistoryButton' name='rentalHistoryButton' value='Rental History' />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>