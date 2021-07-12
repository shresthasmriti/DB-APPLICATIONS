<!DOCTYPE html>
<html lang="en">
<head>
    <title>Siddhi Vehicle Rental</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
    table, th, td {
      border: 1px solid black;
    }
    </style>

</head>

<body>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand">Siddhi Vehicle Rental</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="?page=Booking">Booking</a></li>
      <li><a href="?page=Vehicles">Vehicles</a></li>
      <li><a href="?page=Customers">Customers</a></li>
      <li><a href="https://github.com/shresthasmriti/DB-APPLICATIONS/wiki">Help</a></li>

      
    </ul>
  </div>
</nav>


<?php

    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "Vehicle_rental";

    function booking_page ($conn) {
        
        echo "<div class='container'> <h1>Books</h1> <br> <table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";

        
        $result = $conn->query("SELECT * FROM Customers WHERE ID > 0");

        if ($result->num_rows > 0) {
            
               echo "<tr><th>ID</th> <th>Type of vehicle</th> <th>Capacity(THB)</th> <th>Availability</th></tr>";
            while($row = $result->fetch_assoc()) {
                
                echo "<tr>";
             echo "<td>".$row["vehicle_id"]."</td>";
                echo "<td>".$row["type_of_vehicle"]."</td>";
                echo "<td>".$row["capacity"]."</td>";
                echo "<td>".$row["availability"]."</td>";

                echo "</tr>";
            }

            echo '</tbody></table>';

            if ($_GET['vehicle_id']) {
                  $id = $_GET['vehicle_id'];
             
              $stmt = $conn->prepare("SELECT * FROM Vehicles WHERE vehicle_id = ?");
              $ok = $stmt->bind_param("i", $id);
              if (!$ok) { die("Bind param error"); }
              $ok = $stmt->execute();
              if (!$ok) { die("Exec error"); }
          $result = $stmt->get_result();

              print("<br/>");
              
             while($row = $result->fetch_assoc()) {
                  echo "Customer: " . $row["customer"]. "<br>\n";
                  echo "Passenger capacity: " . $row["passenger_capacity"]. "<br>\n";
                  echo "Vehicle Insurance: " . $row["vehicle_insurance"]. "<br>\n";
                

                          $stmt = $conn->prepare("SELECT vehicle_type FROM Vehicles WHERE vehicle_id = ?");
                      $ok = $stmt->bind_param("i", $id);
                      if (!$ok) { die("Bind param error"); }
                      $ok = $stmt->execute();
                      if (!$ok) { die("Exec error"); }
                      
                          $result2 = $stmt->get_result();

                          echo "Vehicle(s): ";

                          $count = 1;
                      while($row2 = $result2->fetch_assoc()) {
                          $authid = $row2["Customer_ID"];
                          
                          $stmt = $conn->prepare("SELECT customer_name FROM Customers WHERE Customer_ID = ?");
                          $ok = $stmt->bind_param("i", $authid);
                          if (!$ok) { die("Bind param error"); }
                          $ok = $stmt->execute();
                          if (!$ok) { die("Exec error"); }
                          $result3 = $stmt->get_result();
                          $customername = $result3->fetch_row()[0];
                          
                          if ($count > 1) echo ", ";
                          print($customername);

                          $count++;
                      }

            }
          }
          echo '</div>';

        } else {
            echo "0 results";
        }
    }

    echo "<form method='POST'>
    </table></div>
    <div class='container'> <h3>Add new</h3> <table class='table table-bordered'>
    <tr>
        <th>ID</th> <td> <input type='text' id = 'ID' name='ID' required='true' maxlength='150'> </td>
    </tr>
    <tr>
        <th>Customer Name</th> <td> <input type='text' id = 'Customername' name='Customername' required='true' maxlength='14'> </td>
    </tr>
    <tr>
        <th>Vehicle Type</th> <td> <input type='text' id = 'Vehicletype' name='Vehicletype' required='true' maxlength='150'> </td>
       </tr>
    <tr>
        <th>Rental Start Date</th> <td> <input type='date' id = 'Rentalstartdate' name='Rentalstartdate' required='true'> </td>
    </tr>
    <tr>
        <th>Rental End Date</th> <td> <input type='date' id = 'Rentalenddate' name='Rentalenddate' required='true'> </td>
    </tr>
    <tr>
         <th>Total Price</th> <td> <input type='number' min = '1' max = '10000' id = 'Totalprice' name='Totalprice' required='true'> </td>
     </tr>
    <tr>
        <td></td> <td colspan='2'><button type='submit'> Add Booking </button> </td>
    </tr>
    </table></div>
</form>";

if (isset($_POST['ID'])) {
    $ID = $_POST['ID'];
    $customername = $_POST['Customername'];
    $vehicletype = $_POST['Vehicletype'];
    $rentalstartdate = $_POST['Rentalstartdate'];
    $rentalenddate = $_POST['Retalenddate'];
    $totalprice = $_POST['Totalprice'];
    $cust = $_POST['Customers'];


    $res = $conn->query("SELECT max(vehicle_id) from Vehicles");
    if (!$res) { die("Query1 failed"); }
    $maxid = $res->fetch_row()[0];
    if (!$maxid) { $next = 1; } else { $next = $maxid + 1; }
    $vehicleid = $next;
    
    $sql = "INSERT into Vehicle values (?,?,?,?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
      $ok = $stmt->bind_param('isssiiii', $vehilceid, $ID, $Customername, $vehicletype, $rentalstartdate, $rentalenddate, $totalprice);
      if (!$ok) { die("Bind param error"); }
      $ok = $stmt->execute();
      if (!$ok) { die("Exec error"); }
    $result = $stmt->get_result();

    $cust_arr = explode (", ", $cust);
    
    foreach($cust_arr as $value){
        
        $sql = "SELECT Customer_ID from Customers where customer_name = ?";
        $stmt = $conn->prepare($sql);
        $ok = $stmt->bind_param('s', $value);
        if (!$ok) { die("Bind param error"); }
        $ok = $stmt->execute();
        if (!$ok) { die("Exec error"); }
        $result = $stmt->get_result();
        $cust_id = $result->fetch_row()[0];
        
        if (!$cust_id){
            $sql = "INSERT into Customers(customer_name) values (?)";
            $stmt = $conn->prepare($sql);
              $ok = $stmt->bind_param('s', $value);
              if (!$ok) { die("Bind param error"); }
              $ok = $stmt->execute();
              if (!$ok) { die("Exec error"); }
            $result = $stmt->get_result();

            $sql = "SELECT Customer_ID from Customers where customer_name = ?";
            $stmt = $conn->prepare($sql);
              $ok = $stmt->bind_param('s', $value);
              if (!$ok) { die("Bind param error"); }
              $ok = $stmt->execute();
              if (!$ok) { die("Exec error"); }
            $result = $stmt->get_result();
            $cust_id = $result->fetch_row()[0];
        }

        $sql = "INSERT into Customer_booking values (?,?)";
        $stmt = $conn->prepare($sql);
          $ok = $stmt->bind_param('ii', $cust_id, $bookingid);
          if (!$ok) { die("Bind param error"); }
          $ok = $stmt->execute();
          if (!$ok) { die("Execc error"); }
        $result = $stmt->get_result();
        

    }

}
    
    function add_customer($conn) {
        echo "<h2>Customers</h2><br/>";
        
        echo
        "<div class=\"container\">
              <form method=\"POST\">
            <div class=\"form-group\">
              <label for=\"Customer_ID\">Customer ID</label>
              <input type=\"number\" required min=\"1\" max=\"99999\" class=\"form-control\" id=\"Customer_ID\" placeholder=\"Enter Customer ID\" name=\"Customer_ID\">
            </div>
            <div class=\"form-group\">
              <label for=\"name\">Name</label>
              <input type=\"text\" required maxlength=\"30\" class=\"form-control\" id=\"name\" placeholder=\"Enter Customer's name\" name=\"name\">
            </div>
            <div class=\"form-group\">
              <label for=\"contact_number\">Contact Number</label>
              <input type=\"number\" required class=\"form-control\" id=\"contact_number\" placeholder=\"Enter contact number\" name=\"contact_number\">
            </div>
            <div class=\"form-group\">
              <label for=\"License_number\">License number</label>
              <input type=\"number\" required maxlength=\"30\" class=\"form-control\" id=\"License_number\" placeholder=\"Enter License number\" name=\"License_number\">
            </div>
            <button type=\"submit\" class=\"btn btn-default\">Submit</button>
          </form>
        </div>";
        
        
        if (isset($_POST['Customer_ID'])) {
            $Customer_ID = $_POST['Customer_ID'];
            $name = $_POST['name'];
            $contact_number = $_POST['contact_number'];
            $License_number = $_POST['License_number'];
            $sql = "insert into author (Customer_ID, name, contact_number, License_number) values (?,?,?,?)";
            // prepare statement
            $stmt = $conn->prepare($sql);
              $ok = $stmt->bind_param('isss', $Customer_ID, $name, $contact_number, $License_number);
              if (!$ok) { die("Bind param error"); }
              $ok = $stmt->execute();
              if (!$ok) { die("Exec error"); }
            $result = $stmt->get_result();
        }
    }


    function vehiclerental_page($conn) {

        $result = $conn->query("SELECT vehicletype, Passenger_capacity, Availabilty from Vehicles where availabilty.vehicle_id = vehilces.vehilce_id order by date");

        if ($result->num_rows > 0) {

            echo "<div class='container'> <h2>Sales</h2> <br> <table id='example' class='table table-striped table-inverse table-bordered table-hover' cellspacing='0' width='100%'>";

            echo "<thead><tr><th></th> <th>Vehicle Type</th> <th>Passenger Capacity</th> <th>Availabilty</th></tr></thead><tbody>";
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$no."."."</td>";
                echo "<td>".$row["vehicletype"]."</td>";
                echo "<td>".$row["Passenger_capacity"]."</td>";
                echo "<td>".$row["availabilty"]."</td>";
                echo "</tr>";
                $no = $no + 1;
            }
            echo "</tbody></table></div>";
        }

        else echo "0 results";

        echo
         "<form method='POST'>
              </table></div>
              <div class='container'> <h4>Add new</h4> <table class='table table-bordered'>
              <tr> <th>Vehicle Type</th> <th>Availabilty</th> <th> </th> </tr>
              <tr>
                  <td> <input type='text' id = 'Vehicletype' name='Vehicletype' required='true' maxlength='150'> </td>
                  <td> <input type='number' id = 'availability' name='availability' required = 'true'> </td>
                  <td colspan='2'><button type='submit'> Make Transaction </button></td>
              </tr>
              </table></div>
        </form>";


        if (isset($_POST['Vehicletype'])) {
            $Vehicletype = $_POST['Vehicletype'];
            $availbilty = $_POST['Availability'];
            $date = date("Y-m-d");

            $stmt = $conn->prepare("SELECT vehicle_id FROM Vehicles WHERE title = ?");
              $ok = $stmt->bind_param("s", $title);
              if (!$ok) { die("Bind param error"); }
              $ok = $stmt->execute();
              if (!$ok) { die("Exec error"); }
            $result = $stmt->get_result();
            $id_result = $result->fetch_row()[0];

            $res = $conn->query("UPDATE  Vehicles SET availability = availability - 1 WHERE vehicle_id = ".$id_result);
            
            if (!$res) { die("Query failed"); }

            $res = $conn->query("SELECT max(bookedvehicle_id) from vehicle_booked");
            if (!$res) { die("Query failed"); }
            $maxid = $res->fetch_row()[0];
            if (!$maxid) { $next = 1; } else { $next = $maxid + 1; }
            
            $sql = "INSERT into vehicle_booked values (?,?,?,?)";
            $stmt = $conn->prepare($sql);
              $ok = $stmt->bind_param('isii', $next, $date, $emp_id, $id_result);
              if (!$ok) { die("Bind param error"); }
              $ok = $stmt->execute();
              if (!$ok) { die("Exec error"); }
            $result = $stmt->get_result();
        }
    }

    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $page = $_GET['page'];
    if ($page == "" || $page == "Vehicles") {
       
        list_vehicles($conn);
    } elseif ($page == "Customers") {
       
        add_customer($conn);
    } elseif ($page == "Bookings") {
        
    } else {
        
    }

    $conn->close();

?>

</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.13/js/dataTables.bootstrap4.min.js"></script>
<script> type="text/javascript"
  $(document).ready(function() {
    $('#example').DataTable( {
    } );
  });
</script>
</html>
