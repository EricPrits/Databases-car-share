<!DOCTYPE HTML>
<html>
	<head>
	<title>PickupFormPage</title>
	</head>
	<body>
		<?php
			//Create a user session or resume an existing one
			session_start();
			?>
			
			<?php
			if(isset($_POST['backButton'])){
			header('Location: member.php');
			exit;
			}
		?>
		
		<form name='memberRentalHistory' id='memberRentalHistory' action='memberRentalHistory.php' method='post'>
			<table border='0'>
				<td>
                <input type='submit' id='backButton' name='backButton' value='Back' />
				</td>
			</table>
		</form>
	</body>

</html>