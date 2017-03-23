<!DOCTYPE HTML>
<html>
    <head>
        <title>startup</title>
    </head>
<body>

   <?php
        if(isset($_POST['adminButton'])){
        header('Location: admin.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['memButton'])){
        header('Location: member.php');
        exit;
}
 ?>

    <?php
        if(isset($_POST['newMemButton'])){
        header('Location: newMember.php');
        exit;
}
?>
    <form name='startup' id='startup' action='startup.php' method='post'>
    <table border='0'>
            <td>
                <input type='submit' id='adminButton' name='adminButton' value='Admin' />
            </td>
            <td>
                <input type='submit' id='memButton' name='memButton' value='Member' />
            </td>
            <td>
                <input type='submit' id='newMemButton' name='newMemButton' value='New Member' />
            </td>
        </tr>
    </table>
    </form>
</body>
</html>