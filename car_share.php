<html>
<head><title>Load car_share Database</title></head>
<body>

<?php
/* Program: car_share_load.php
 * Desc:    Creates and loads the car share database tables with 
 *          sample data.
 */
 
 $host = "localhost";
 $user = "cisc332";
 $password = "cisc332password";
 $database = "car_share";

 $cxn = mysqli_connect($host,$user,$password, $database);
 // Check connection
 if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  die();
  }

mysqli_query($cxn,"drop table rental_comments;");
mysqli_query($cxn,"drop table rental;");
mysqli_query($cxn,"drop table mem_rental;");
mysqli_query($cxn,"drop table car_rental;");
mysqli_query($cxn,"drop table reservations;");
mysqli_query($cxn,"drop table ktcs_member;");
mysqli_query($cxn,"drop table cars;");
mysqli_query($cxn,"drop table parking_locations;");
mysqli_query($cxn,"drop table car_maintenance;");



mysqli_query($cxn,"create table rental_comments
	(rental_ID				INT not null,
	 VIN					INT not null,
	 member_number			INT not null,
     rating					INT(1) not null,
     comment_text			text not null,
     comment_reply			text,
	 primary key (rental_ID, VIN, member_number)
	 );");

mysqli_query($cxn,"insert into rental_comments values
	('1110',	'1010',	'0000',	'4', 'very good!', null),
	('1111',	'1011',	'0001',	'3', 'very medium!', null),	
	('1112',	'1012',	'0002',	'2', 'very bad!', null);");

mysqli_query($cxn,"create table rental
	(rental_ID				INT not null,
	 pickup_odemeter		INT not null,
	 dropoff_odemeter		INT,
	 pickup_time			datetime not null,
	 dropoff_time			datetime,
     return_status			VARCHAR(11) not null,
	 primary key (rental_ID)
	);");

mysqli_query($cxn,"insert into rental values
	(1110,0,9000,'2017-01-01 00:00:00','2017-01-02 00:00:00','normal'),
	(1111,0,3000,'2017-02-02 00:00:00','2017-02-04 00:00:00','damaged'),
	(1112,255,4000,'2016-03-03 00:00:00',null,'not running');");

mysqli_query($cxn,"create table mem_rental
	(rental_ID				INT not null,
	 member_number			INT not null,
	 date					date not null,
	 primary key (rental_ID, member_number)
	);");

mysqli_query($cxn,"insert into mem_rental values
	(1110,0000,'2017-01-01'),
	(1111,0001,'2017-02-02'),
	(1112,0002,'2016-03-03');");

mysqli_query($cxn,"create table car_rental
	(rental_ID				INT not null,
	 VIN					INT not null,
	 date					date not null,
	 primary key (rental_ID, VIN)
	);");

mysqli_query($cxn,"insert into car_rental values
	(1110,1010,'2017-01-01'),
	(1111,1011,'2017-02-02'),
	(1112,1012,'2016-03-03');");

mysqli_query($cxn,"create table reservations
	(rental_ID				INT not null,
	 reservation_number		INT not null,
	 member_number			INT not null,
	 VIN					INT not null,
	 access_code			INT not null,
	 reservation_length		INT not null,
	 date					date not null,
	 primary key (rental_ID, reservation_number)
	);");

mysqli_query($cxn,"insert into reservations values
	(1110,2220,0000,1010,3330,1,'2017-01-01'),
	(1111,2221,0001,1011,3331,2,'2017-02-02'),
	(1112,2222,0002,1012,3332,3,'2016-03-03');");

mysqli_query($cxn,"create table ktcs_member
	(member_number				INT not null,
	 fname						CHAR(40) not null,
	 lname						CHAR(40) not null,
     address					VARCHAR(40) not null,
     phone_number				INT(10) not null,
     email						VARCHAR(40),
     drivers_license			INT not null,
     monthly_membership_fee		INT not null,
	 primary key (member_number)
	);");

mysqli_query($cxn,"insert into ktcs_member values
	(0000,'Alex','Seppala','1234 6th avenue',1234567890,'abcd@gmail.com',12345,25),
	(0001,'Angus','Short','3456 8th avenue',2468024680,'efgh@gmail.com',34567,20),
	(0002,'Eric','Prits','8765 23rd avenue',0987654321,'ijkl@gmail.com',56789,20);");

mysqli_query($cxn,"create table cars
	(VIN					INT not null,
	 make					VARCHAR(40) not null,
	 model					VARCHAR(40) not null,
	 year					INT(4) not null,
	 location_ID			INT not null,
	 daily_fee				INT not null,
	 primary key (VIN)
	);");

mysqli_query($cxn,"insert into cars values
	(1010,'Toyota','Corolla', 2000, 0, 25),
	(1011,'Ford', 'Focus', 2017, 1, 20),
	(1012,'Ford', 'Mustang',1965,1, 55);");

mysqli_query($cxn,"create table parking_locations
	(location_ID					INT not null,
	 address						VARCHAR(40) not null,
	 number_of_spaces				INT not null,
	 primary key (location_ID)
	);");

mysqli_query($cxn,"insert into parking_locations values
	(0,'1234 Kingston Way', 200),
	(1,'5678 Princess Street', 2),
	(3,'8765 Division street', 46);");

mysqli_query($cxn,"create table maintenance_history
	(VIN					INT not null,
	 maintenance_date		date not null,
	 odometer_reading		INT not null,
	 maintenance_type		VARCHAR(9) not null,
	 description			text not null,
	 primary key (VIN, maintenance_date)
	);");

mysqli_query($cxn,"insert into maintenance_history values
	(1010,'2010-05-05',200,'body work','totalled, had to replace entire body and all parts'),
	(1011,'2009-06-06',5000,'scheduled','annual checkup'),
	(1012,'2000-07-07',20000,'repair','fixed broken stick shift');");

   mysqli_close($cxn); 

?>
</body></html>