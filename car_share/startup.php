<!DOCTYPE HTML>
<html>
    <head>
        <title>startup</title>
    </head>
<body>

<?php
  //Create a user session or resume an existing one
 session_start();
 ?>

<?php

 
//check if the login form has been submitted
if(isset($_POST['loginBtn'])){
 
    // include database connection
    include_once 'config/connection.php'; 
    
    // SELECT query
        $query = "SELECT member_number, is_admin FROM ktcs_member WHERE member_number=?";
 
        // prepare query for execution
        if($stmt = $con->prepare($query)){
        
        // bind the parameters. This is the best way to prevent SQL injection hacks.
        $stmt->bind_Param("s", $_POST['member_number']);

         
        // Execute the query
        $stmt->execute();
 
        /* resultset */
        $result = $stmt->get_result();

        // Get the number of rows returned
        $num = $result->num_rows;;
        
        //
//make a case in the if statements below that accounts for if they put nothing in
        //

        if($num>0){
            //If the username/password matches a user in our database
            //Read the user details
            $myrow = $result->fetch_assoc();
            //Create a session variable that holds the user's id
            $_SESSION['member_number'] = $myrow['member_number'];
            //Redirect the browser to the profile editing page and kill this page.
            if($myrow['is_admin']){
                header('Location: admin.php');
            }
            else{
                header('Location: member.php');
            }
            die();
        } else {
            //If the username/password doesn't matche a user in our database
            // Display an error message and the login form
            header('Location: newMember.php');
        }
        } else {
            echo "failed to prepare the SQL";
        }
 }
 
?>
    <form name='startup' id='startup' action='startup.php' method='post'>
    <table border='0'>
        <tr>
            <td>Member number</td>
            <td><input type='text' name='member_number' id='member_number' /></td>
        </tr>
        <tr>
            <td></td>
            <td>
                <input type='submit' id='loginBtn' name='loginBtn' value='Log In' /> 
            </td>
        </tr>
    </table>
    </form>
</body>
</html>