<?php

$mode = $_GET["mode"];

if ($mode == "newOrder") {
    insertNewOrder();
}

if ($mode == "viewExisting") {
    viewExistingOrder();
}

if ($mode == "deleteOrder") {
    deleteOrder();
}

if ($mode == "editOrder") {
    editOrder();
}

if ($mode == "showEditForm") {
    showEditForm();
}






// function which reads all necessary variables from the POST array and prepares the SQL string
function insertNewOrder()
{
    
    // series of switch statements which chcek if a particulat toppping was chosen and then convert the "on"/"off" from the HTML form to a single char // ("y"/"n") as required by the database
    // also increments a counter for the number of toppings which is used to calculate price
    $howManyToppings = 0;
    if (array_key_exists('addAnchovies', $_POST)) {
        switch ($_POST['addAnchovies']) {
            case "yes":
                $anchovies       = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $anchovies = "n";
                break;
        }
    } else {
        $anchovies = "n";
        
    }
    
    if (array_key_exists('addPepperoni', $_POST)) {
        switch ($_POST['addPepperoni']) {
            
            case "yes":
                $pepperoni       = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $pepperoni = "n";
                break;
        }
    } else {
        $pepperoni = "n";
        
    }
    
    if (array_key_exists('addPineapple', $_POST)) {
        switch ($_POST['addPineapple']) {
            
            case "yes":
                $pineapple       = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $pineapple = "n";
                break;
        }
    } else {
        $pineapple = "n";
        
    }
    
    if (array_key_exists('addPeppers', $_POST)) {
        switch ($_POST['addPeppers']) {
            
            case "yes":
                $peppers         = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $peppers = "n";
                break;
        }
    } else {
        $peppers = "n";
        
    }
    
    
    if (array_key_exists('addOlives', $_POST)) {
        switch ($_POST['addOlives']) {
            
            case "yes":
                $olives          = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $olives = "n";
                break;
        }
    } else {
        $olives = "n";
        
    }
    
    if (array_key_exists('addOnion', $_POST)) {
        switch ($_POST['addOnion']) {
            
            case "yes":
                $onion           = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $onion = "n";
                break;
        }
    } else {
        $onion = "n";
        
    }
    
    // generates a unique ID for the order
    
    if (array_key_exists('order_id', $_GET)) {
        $order_id = $_GET['order_id'];
    } else {
        $order_id = uniqid();
    }
    
    
    
    if (array_key_exists('student', $_POST)) {
        switch ($_POST['student']) {
            
            case "on":
                $student = "y";
                break;
            default:
                $student = "n";
                break;
        }
    } else {
        $student = 'n';
    }
    
    
    // parses the cname string into fname and lname as required by the DB
    if (array_key_exists('customerName', $_POST)) {
        $cname       = $_POST['customerName'];
        $stringarray = explode(" ", $cname);
        switch (count($stringarray)) {
            case 1:
                $firstname = $stringarray[0];
                $lastname  = "";
                break;
            
            case 2:
                $firstname = $stringarray[0];
                $lastname  = $stringarray[1];
                break;
                
        }
    } else {
        $cname = "";
    }
    
    
    // simple retrieval of variables from POST array
    if (array_key_exists('emailAddress', $_POST)) {
        $email = $_POST['emailAddress'];
    } else {
        $email = "";
    }
    
    if (array_key_exists('address', $_POST)) {
        $address = $_POST['address'];
    } else {
        $address = "";
    }
    
    if (array_key_exists('phoneNo', $_POST)) {
        $phone = $_POST['phoneNo'];
    } else {
        $phone = "";
    }
    
    if (array_key_exists('phoneNo', $_POST)) {
        $size = $_POST['pizzaSize'];
    } else {
        $size = "";
    }
    
    
    
    
    
    // generate a timestamp for the order
    $info      = getdate();
    $date      = $info['mday'];
    $month     = $info['mon'];
    $year      = $info['year'];
    $hour      = $info['hours'];
    $min       = $info['minutes'];
    $sec       = $info['seconds'];
    $ordertime = "$year-$month-$date $hour:$min:$sec";
    
    
    
    // switch statement and arithmatic calculation to work out the price of the pizza
    switch ($size) {
        
        case "large":
            $pizzaBasePrice  = 12;
            $pricePerTopping = 1;
            break;
        case "medium":
            $pizzaBasePrice  = 10;
            $pricePerTopping = 1;
            break;
        case "small":
            $pizzaBasePrice  = 6;
            $pricePerTopping = .5;
            break;
        default:
            $pizzaBasePrice  = 0;
            $pricePerTopping = 0;
            break;
            
    }
    
    $price = $pizzaBasePrice + $pricePerTopping * $howManyToppings;
    
    
    
    // now that all required information has been collected and parsed from the form, the SQL string is coded
    $SQLInsert = "   INSERT INTO 
pizza.orders 
    (
    `order_id`,
    `student`, 
    `firstname`, 
    `lastname`, 
    `email`, 
    `address`, 
    `phone`, 
    `price`, 
    `size`, 
    `anchovies`,
    `pineapples`,
    `pepperoni`,
    `peppers`, 
    `olives`, 
    `onions`,
    `createdatetime` 
     ) 
VALUES 
    (
    '$order_id',
    '$student',
    '$firstname',
    '$lastname',
    '$email',
    '$address',
    '$phone', 
    '$price',
    '$size',
    '$anchovies', 
    '$pineapple', 
    '$pepperoni', 
    '$peppers', 
    '$olives',
    '$onion',
    '$ordertime')  ";
    
    
    
    
    // connect to the DB
    include 'DBConnection.php';
    
    
    // if the SQL INSERT command is succesful, notify the user, otherwise display an error message and exit
    if (mysqli_query($DBConnection, $SQLInsert)) {
        
        echo "<p>Order created sccesfully. Here's your receipt: </p>";
        
        echo "<table border ='1' cellspacing = '0' cellpadding='10'>\n" . "<th> Order ID </th>" . "<th> Student </th>" . "<th> First Name </th>" . "<th> Last Name </th>" . "<th> Email </th>" . "<th> Address </th>" . "<th> Phone </th>" . "<th> Price </th>" . "<th> Size </th>" . "<th> Anchovies </th>" . "<th> Pineapple </th>" . "<th> Pepperoni </th>" . "<th> Peppers  </th>" . "<th> Olives </th>" . "<th> Onions </th>" . "<th> Created (time + date) </th></tr>";
        
        echo "<tr>" . "<td>" . $order_id . "</td>" . "<td>" . $student . "</td>" . "<td>" . $firstname . "</td>" . "<td>" . $lastname . "</td>" . "<td>" . $email . "</td>" . "<td>" . $address . "</td>" . "<td>" . $phone . "</td>" . "<td>" . $price . "</td>" . "<td>" . $size . "</td>" . "<td>" . $anchovies . "</td>" . "<td>" . $pineapple . "</td>" . "<td>" . $pepperoni . "</td>" . "<td>" . $peppers . "</td>" . "<td>" . $olives . "</td>" . "<td>" . $onion . "</td>" . "<td>" . $ordertime . "</td>" . "</tr>\n";
        
        echo "</table>\n";
        
        echo "<p>To view your order later or to make changes to it, please visit this <a href='http://localhost/pizza/vieworder.php?mode=viewExisting&order_id=$order_id'>link</a></p>";
        
    } else {
        
        echo "Error: " . $SQLInsert . "<br>" . mysqli_error($DBConnection);
        
    }
    
    
    
    
}



function viewExistingOrder()
{
    
    if (array_key_exists('showEditForm', $_GET)) {
        $showEditForm = $_GET['showEditForm'];
    } else {
        $showEditForm = 'no';
    }
    
    
    
    $orderId   = $_GET['order_id'];
    $SQLSelect = "SELECT * FROM pizza.orders WHERE order_id = '$orderId' ; ";
    
    include 'DBConnection.php';
    $QueryResult = mysqli_query($DBConnection, $SQLSelect);
    
    echo "<table border ='1' cellspacing = '0' cellpadding='10'>\n" . "<th> Order ID </th>" . "<th> Student </th>" . "<th> First Name </th>" . "<th> Last Name </th>" . "<th> Email </th>" . "<th> Address </th>" . "<th> Phone </th>" . "<th> Price </th>" . "<th> Size </th>" . "<th> Anchovies </th>" . "<th> Pineapple </th>" . "<th> Pepperoni </th>" . "<th> Peppers  </th>" . "<th> Olives </th>" . "<th> Onions </th>" . "<th> Created (time + date) </th></tr>";
    
    
    $order = mysqli_fetch_assoc($QueryResult);
    
    echo "<tr>" . "<td>" . $order['order_id'] . "</td>" . "<td>" . $order['student'] . "</td>" . "<td>" . $order['firstname'] . "</td>" . "<td>" . $order['lastname'] . "</td>" . "<td>" . $order['email'] . "</td>" . "<td>" . $order['address'] . "</td>" . "<td>" . $order['phone'] . "</td>" . "<td>" . $order['price'] . "</td>" . "<td>" . $order['size'] . "</td>" . "<td>" . $order['anchovies'] . "</td>" . "<td>" . $order['pineapples'] . "</td>" . "<td>" . $order['pepperoni'] . "</td>" . "<td>" . $order['peppers'] . "</td>" . "<td>" . $order['olives'] . "</td>" . "<td>" . $order['onions'] . "</td>" . "<td>" . $order['createdatetime'] . "</td>" . "</tr>\n";
    
    echo "</table>\n";
    
    echo "<p>Click <a href='http://localhost/pizza/vieworder.php?showEditForm=yes&mode=viewExisting&order_id=$orderId'>here</a> to modify order</p>";
    
    
    echo "<p>Click <a href='http://localhost/pizza/vieworder.php?mode=deleteOrder&order_id=$orderId'>here</a> to delete order</p>";
    
    
    
    
    
    if ($showEditForm == 'yes') {
        showEditForm($orderId);
    }
    
}

function deleteOrder()
{
    $orderId   = $_GET['order_id'];
    $SQLDelete = "DELETE FROM pizza.orders WHERE order_id = '$orderId' ; ";
    
    include 'DBConnection.php';
    
    if (mysqli_query($DBConnection, $SQLDelete)) {
        echo "Order $orderId deleted from the system";
        echo "<br><a href='http://localhost/pizza/pizza_order.html'>Click here to Enter a new order </a>";
    } else {
        echo "Error deleting record: " . mysqli_error($DBConnection);
    }
}

function showEditForm($orderIDtoEdit)
{
    $orderId = $orderIDtoEdit;
    echo "<form  id='pizza-form'  name='theform' method='post' action='vieworder.php?mode=editOrder&order_id=$orderId'>";
    
?>
      <h3>What Size of Pizza Would You Like? </h3>
     
        Small
        <input id="small" type="radio" name="pizzaSize" value="small" />
        Medium
        <input id="medium" type="radio" name="pizzaSize" value="medium"  />
        Large
        <input id="large" type="radio" name="pizzaSize" value="large"  checked/>
   
      
      <br>
      <h3>Add Extra Toppings</h3>
    
        Anchovies
       <input id="anchovies" type="checkbox" name="addAnchovies" value="yes"  checked/>
       
        Pineapple
      <input id="pineapple" type="checkbox" name="addPineapple" value="yes"  checked/>
      
        Pepperoni
       <input id="pepperoni" type="checkbox" name="addPepperoni" value="yes"  checked/>
       
        Olives
        <input id="olives" type="checkbox" name="addOlives" value="yes"  checked/>
        
        Onion
        <input id="onion" type="checkbox" name="addOnion" value="yes"  checked/>
        
        Peppers
        <input id="peppers" type="checkbox" name="addPeppers" value="yes"  checked/>
   
   
   
     <h3>Total Price is: €<span id="pricetext">18</span></h3>
     
      
        <h3>Enter your  details</h3>
        Name:
        <input name="customerName" id="cname" type="text" required />
        <br/>
        <br/>
        Address:
        <textarea name="address" id = "caddress" type="text"rows="5" cols="30" required></textarea>
        <br/>
        <br/>
        Email Address:
        <input name="emailAddress" type="email" required />
        <br/>
        <br/>
       
        <br/>
        Phone Number:
        <input name="phoneNo" id="phoneNumber" type="text" required/>
         <br/>
         <br/>
        Tick here if you are student:
        <input type="checkbox" id="studentdiscount" name="student" />
       
  
      <br/>
      <button type="submit" value="Place Order" >Submit order</button>
    </form>


    <?php
    
    
}

function editOrder()
{
    
    
    
    $order_id = $_GET['order_id'];
    
    
    
    $howManyToppings = 0;
    if (array_key_exists('addAnchovies', $_POST)) {
        switch ($_POST['addAnchovies']) {
            case "yes":
                $anchovies       = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $anchovies = "n";
                break;
        }
    } else {
        $anchovies = "n";
        
    }
    
    if (array_key_exists('addPepperoni', $_POST)) {
        switch ($_POST['addPepperoni']) {
            
            case "yes":
                $pepperoni       = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $pepperoni = "n";
                break;
        }
    } else {
        $pepperoni = "n";
        
    }
    
    if (array_key_exists('addPineapple', $_POST)) {
        switch ($_POST['addPineapple']) {
            
            case "yes":
                $pineapple       = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $pineapple = "n";
                break;
        }
    } else {
        $pineapple = "n";
        
    }
    
    if (array_key_exists('addPeppers', $_POST)) {
        switch ($_POST['addPeppers']) {
            
            case "yes":
                $peppers         = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $peppers = "n";
                break;
        }
    } else {
        $peppers = "n";
        
    }
    
    
    if (array_key_exists('addOlives', $_POST)) {
        switch ($_POST['addOlives']) {
            
            case "yes":
                $olives          = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $olives = "n";
                break;
        }
    } else {
        $olives = "n";
        
    }
    
    if (array_key_exists('addOnion', $_POST)) {
        switch ($_POST['addOnion']) {
            
            case "yes":
                $onion           = "y";
                $howManyToppings = $howManyToppings + 1;
                break;
            default:
                $onion = "n";
                break;
        }
    } else {
        $onion = "n";
        
    }
    
    
    
    
    
    
    
    
    
    
    if (array_key_exists('student', $_POST)) {
        switch ($_POST['student']) {
            
            case "on":
                $student = "y";
                break;
            default:
                $student = "n";
                break;
        }
    } else {
        $student = 'n';
    }
    
    
    // parses the cname string into fname and lname as required by the DB
    if (array_key_exists('customerName', $_POST)) {
        $cname       = $_POST['customerName'];
        $stringarray = explode(" ", $cname);
        switch (count($stringarray)) {
            case 1:
                $firstname = $stringarray[0];
                $lastname  = "";
                break;
            
            case 2:
                $firstname = $stringarray[0];
                $lastname  = $stringarray[1];
                break;
                
        }
    } else {
        $cname = "";
    }
    
    
    // simple retrieval of variables from POST array
    if (array_key_exists('emailAddress', $_POST)) {
        $email = $_POST['emailAddress'];
    } else {
        $email = "";
    }
    
    if (array_key_exists('address', $_POST)) {
        $address = $_POST['address'];
    } else {
        $address = "";
    }
    
    if (array_key_exists('phoneNo', $_POST)) {
        $phone = $_POST['phoneNo'];
    } else {
        $phone = "";
    }
    
    if (array_key_exists('phoneNo', $_POST)) {
        $size = $_POST['pizzaSize'];
    } else {
        $size = "";
    }
    
    
    
    
    
    // generate a timestamp for the order
    $info      = getdate();
    $date      = $info['mday'];
    $month     = $info['mon'];
    $year      = $info['year'];
    $hour      = $info['hours'];
    $min       = $info['minutes'];
    $sec       = $info['seconds'];
    $ordertime = "$year-$month-$date $hour:$min:$sec";
    
    
    
    // switch statement and arithmatic calculation to work out the price of the pizza
    switch ($size) {
        
        case "large":
            $pizzaBasePrice  = 12;
            $pricePerTopping = 1;
            break;
        case "medium":
            $pizzaBasePrice  = 10;
            $pricePerTopping = 1;
            break;
        case "small":
            $pizzaBasePrice  = 6;
            $pricePerTopping = .5;
            break;
        default:
            $pizzaBasePrice  = 0;
            $pricePerTopping = 0;
            break;
            
    }
    
    $price = $pizzaBasePrice + $pricePerTopping * $howManyToppings;
    
    $SQLUpdate = " UPDATE pizza.orders 
SET 
order_id = '$order_id' ,
student = '$student', 
firstname = '$firstname', 
lastname = '$lastname' , 
email = '$email' , 
address = '$address', 
phone = '$phone' , 
price = '$price', 
size = '$size' , 
anchovies = '$anchovies' ,
pineapples = '$pineapple',
pepperoni = '$pepperoni',
peppers = '$peppers', 
olives = '$olives', 
onions = '$onion',
createdatetime =  '$ordertime'
WHERE order_id = '$order_id' ; ";
    
    include 'DBConnection.php';
    
    if (mysqli_query($DBConnection, $SQLUpdate)) {
        
        echo "<p>Order updated sccesfully. Here's your receipt: </p>";
        
        echo "<table border ='1' cellspacing = '0' cellpadding='10'>\n" . "<th> Order ID </th>" . "<th> Student </th>" . "<th> First Name </th>" . "<th> Last Name </th>" . "<th> Email </th>" . "<th> Address </th>" . "<th> Phone </th>" . "<th> Price </th>" . "<th> Size </th>" . "<th> Anchovies </th>" . "<th> Pineapple </th>" . "<th> Pepperoni </th>" . "<th> Peppers  </th>" . "<th> Olives </th>" . "<th> Onions </th>" . "<th> Created (time + date) </th></tr>";
        
        echo "<tr>" . "<td>" . $order_id . "</td>" . "<td>" . $student . "</td>" . "<td>" . $firstname . "</td>" . "<td>" . $lastname . "</td>" . "<td>" . $email . "</td>" . "<td>" . $address . "</td>" . "<td>" . $phone . "</td>" . "<td>" . $price . "</td>" . "<td>" . $size . "</td>" . "<td>" . $anchovies . "</td>" . "<td>" . $pineapple . "</td>" . "<td>" . $pepperoni . "</td>" . "<td>" . $peppers . "</td>" . "<td>" . $olives . "</td>" . "<td>" . $onion . "</td>" . "<td>" . $ordertime . "</td>" . "</tr>\n";
        
        echo "</table>\n";
        
        echo "<p>To view your order later or to make changes to it, please visit this <a href='http://localhost/pizza/vieworder.php?mode=viewExisting&order_id=$order_id'>link</a></p>";
        
    } else {
        
        echo "Error: " . $SQLUpdate . "<br>" . mysqli_error($DBConnection);
        
    }
    
    
    
}


?>