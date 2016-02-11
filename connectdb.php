<?php



$DBConnection = mysqli_connect("localhost", "root", "");
$DBName = "pizza";
$TableName = "orders";

mysqli_select_db($DBConnection, $DBName);

$SQLString = "SELECT * FROM $TableName ";

$QueryResult = mysqli_query($DBConnection, $SQLString);

echo "<table border ='1' cellspacing = '0' cellpadding='10'>\n".
     "<th> Order ID </th>".
     "<th> Student </th>".
     "<th> First Name </th>".
     "<th> Last Name </th>".
     "<th> Email </th>".
     "<th> Address </th>".
     "<th> Phone </th>".
     "<th> Price </th>".
     "<th> Size </th>".
     "<th> Anchovies </th>".
     "<th> Pineapple </th>".
     "<th> Pepperoni </th>".
     "<th> Peppers  </th>".
     "<th> Olives </th>".
     "<th> Onions </th>".
     "<th> Created (time + date) </th></tr>";


     while($order=mysqli_fetch_assoc($QueryResult)){
          echo "<tr>" .
               "<td>" . $order['order_id'] . "</td>".
               "<td>" . $order['student'] . "</td>".
               "<td>" . $order['firstname'] . "</td>".
               "<td>" . $order['lastname'] . "</td>".
               "<td>" . $order['email'] . "</td>".
               "<td>" . $order['address'] . "</td>".
               "<td>" . $order['phone'] . "</td>".
               "<td>" . $order['price'] . "</td>".
               "<td>" . $order['size'] . "</td>".
               "<td>" . $order['anchovies'] . "</td>".
               "<td>" . $order['pineapples'] . "</td>".
               "<td>" . $order['pepperoni'] . "</td>".
               "<td>" . $order['peppers'] . "</td>".
               "<td>" . $order['olives'] . "</td>".
               "<td>" . $order['onions'] . "</td>".
               "<td>" . $order['createdatetime'] . "</td>".
               "</tr>\n" ;}
echo "</table>\n";























?>﻿