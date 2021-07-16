<!DOCTYPE html>
<!--	Author: Anthony Storti
		Date:	11/12/19
		Purpose:Show customer data with all the films they rented
-->
<html>
<head>
	<title>Customers</title>
	<link rel ="stylesheet" type="text/css" href="sample.css">
</head>

<body>
	<form>
		<button type="Return To Manager" formaction="manager.html">return</button>

	<?php

       $mysqli = new mysqli("localhost", "root", "", "sakila");
        if($mysqli->connect_error) {
          exit('Error connecting to database'); //Should be a message a typical user could understand in production
        }
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $mysqli->set_charset("utf8mb4");
        //The ? below is a placeholder
        $stmt = $mysqli->prepare("select first_name, last_name, address, city, district, postal_code, c.customer_id as customer_id, title
								from rental r, film f, inventory i, customer c, address a, city ci
								where c.address_id = a.address_id and a.city_id = ci.city_id and (c.customer_id = r.customer_id and
								r.inventory_id = i.inventory_id and i.film_id = f.film_id)
								order by last_name");
        //We now bind the ? to actual values ... in quotes we
        //show we want to format as a string
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows === 0) exit('No rows');

      	print("<h1 align = 'center'>Table of Customers</h1>");
        print("<table align = 'center' border='2'>");
        print("<tr><th>First Name</th><th>Last Name</th><th>Address</th><th>City</th><th>District</th><th>Postal Code</th><th>Films</th></tr>");


        while($row = $result->fetch_assoc())
		{
          $rowIndex = $row['customer_id'];
		  $customer[$rowIndex][] = $row['first_name'];
		  $customer[$rowIndex][] = $row['last_name'];
		  $customer[$rowIndex][] = $row['address'];
		  $customer[$rowIndex][] = $row['city'];
      $customer[$rowIndex][] = $row['district'];
		  $customer[$rowIndex][] = $row['postal_code'];
		  $customer[$rowIndex][] = $row['title'];
		}
				foreach($customer as $key=>$value)
		{
			print("<tr>"); // Tyler Schlesigner and I worked together from here
			$str = "";
			for($x = 0; $x < 6; $x++){
				print("<td>".$value[$x]."</td>");
				}
			for($p = 6; $p < count($customer[$key]) -1; $p+= 7){
			$str .= $value[$p].", "; // to here
			}
			$str .=$value[count($customer[$key])-1];
		print("<td>".$str."</td></tr>");
		}
print("</table>");
$stmt->close();
$mysqli->close();
?>
</body>
</html>
