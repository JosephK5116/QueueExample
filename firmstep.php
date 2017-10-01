<!--QueueExampleJoeKennedy-->
<html>
<head>
    <title>Customer Form</title>
	<!--Links to externally referenced scripts-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
<br>
    <div class="col-sm-12">
        <button type="button" id="togglebutton" class="btn btn-primary">Show/Hide the add customer form</button><!--button shows and hides the form-->
    </div>
    <div class="col-sm-4" id="addcustomer">

        <form action="firmstep.php" method="post">
            <div class="form-group">
                <H1>Select a Service</H1>
                <!--Radio to select service --->
                <input type="radio" name="service" value="Missed Bin" checked>Missed Bin<br>
                <input type="radio" name="service" value="Housing">Housing<br>
                <input type="radio" name="service" value="Benefits">Benefits<br>
                <input type="radio" name="service" value="Council Tax">Council Tax<br>
                <input type="radio" name="service" value="Fly Tipping">Fly Tipping<br>
            </div>
            <div class="form-group">
                <h1>Select Customer Type</h1><!--user selects button, on click loads relevant div-->
                <button type="button" onclick="TypeSelection('Citizen','Citizen')" class="btn btn-primary">Citizen</button>


                <button type="button" onclick="TypeSelection('Organisation','Organisation')" class="btn btn-primary">Organisation</button>
                <button type="button" name="Anonymous" onclick="TypeSelection('Anonymous', 'Anonymous')" class="btn btn-primary">Anonymous</button>
            </div>
            <div class="form-group">
                <div id="details">

                </div>
            </div>
            <div class="form-group">
                <div id="form">
                </div>

            </div>
        </form>


        <div hidden id="CitizenForm"><!-- div is hidden as it is only needed if user selects citizen button--> 
            <div class="form-group">

                <select class="form-control" name="title">
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Ms">Ms</option>
                </select><br>
                <input type="hidden" name="select" value="Citizen">
                Name: <input type="text" name="name" id="name" class="form-control" onblur="Validation(this.value)"></input><br>

                <input type="submit" name="submit" class="btn btn-success" id="submit" style="display:none;">
            </div>
        </div>

        <div hidden id="OrganisationForm">
            <? $title = 0;?>
            <div class="form-group">
                <input type="hidden" name="select" value="Organisation">
                Organisation Name: <input type="text" name="organisationname" class="form-control" onblur="Validation(this.value)"></input>
				<!--input is disabled to prevent user from submitting without inputting a name -->
                Name: <input type="text" name="name" id="name" class="form-control" onblur="Validation(this.value)" disabled="disabled"></input><br>

                <input type="submit" name="submit" class="btn btn-success" id="submit" style="display:none;">
            </div>
        </div>

        <div hidden id="AnonymousForm">
            <? $title = 0;?>
            <div class="form-group">
                <input type="hidden" name="select" value="Anonymous">
                <input type="submit" name="submit" class="btn btn-success" id="submit" style="display:block;">
            </div>
        </div>

        <script type="text/javascript"><!--JavaScript script to load relevant divs depending on user selection -->
            function TypeSelection(type, form) {
                document.getElementById("details").innerHTML =
				"<H2>" + type + " input form<H1>";


                switch (form) {
                    case 'Citizen':
                        document.getElementById("form").innerHTML = document.getElementById("CitizenForm").innerHTML;
                        document.getElementById("name").style.display = 'block';
                        document.getElementById("form").style.display = 'block';
                        break;

                    case 'Organisation':
                        document.getElementById("form").innerHTML = document.getElementById("OrganisationForm").innerHTML;
                        document.getElementById("name").style.display = 'block';
                        document.getElementById("form").style.display = 'block';
                        break;

                    case 'Anonymous':
                        document.getElementById("form").innerHTML = document.getElementById("AnonymousForm").innerHTML;
                        document.getElementById("name").style.display = 'none';
                        document.getElementById("submit").style.display.block;
                        break;
                }
            }
        </script>
        <br>
        <br>
        <script> <!--operates the toggle to show/hide the entry form -->
            $("#togglebutton").click(function () {
                $("#addcustomer").toggle();
            }); </script>

        <script><!--validation to check to ensure that field input isn't empty-->
            function Validation(val) {
                if (val == '') {
                    alert("A field hasn't been filled out");
                    document.getElementById("submit").style.display = 'none';
                    return false;
                }
                else {
                    document.getElementById("submit").style.display = 'block';
                    document.getElementById("name").disabled = false;
                }
            }
        </script>
        <?php
        require ('connect_db.php'); //connects to database
        if(isset($_POST['submit']))
        { //if form has been submitted sets variables as user input
        $select = mysqli_real_escape_string($conn, $_POST['select']);
        if ($select == 'Anonymous') //if customer is anonymous sets the name to anonymous
        {
        $name = 'Anonymous';
        }
        $service = mysqli_real_escape_string($conn, $_POST['service']); //mysqli_real_escape_string protects database from sql injection
        if ($select == 'Citizen')
        {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $name = "$title, $name"; //adds the title selected to the customers name 
        }
        if ($select == 'Organisation')
        {
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $org = mysqli_real_escape_string($conn, $_POST['organisationname']);
        $name = "$name ($org)"; //adds the organisation which the customer works for in brackets to the name
        }

        $time = date('H:i:s', time());
		
        $service = htmlentities($service); //htmlentities protects website from cross site scripting
        $name = htmlentities($name);
        $select = htmlentities($select);

        $query = "INSERT INTO `queue`.`queuetable` VALUES (NULL, '$name', '$time', '$service', '$select')"; //stores user input as a record in customer table
        $r = mysqli_query($conn,$query);

        mysqli_close($conn);
        }
        ?>
    </div>
    <div id="Queue" class="col-sm-8"><!--displays queue of current customers-->
        <H1>QUEUE</H1>
        <div id="QueueList">

            <table class="table table-condensed"><!--utilises bootstrap to condense the table -->
                <thead class="table-condensed">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Service</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    require ('connect_db.php');
                    $customers = "SELECT * FROM queuetable
                    ORDER BY 'QueueTime' DESC;";//sql query to select all customers currently in db
                    $result = mysqli_query($conn, $customers);

                    if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                    echo "
                    <tr><td>". $row["ID"]."</td><td>".$row["Customer_Name"]."</td><td>".$row["CustomerType"]."</td><td>".$row["Service"]."</td><td>".$row["QueueTime"]."</td></tr>";
                    }
                    } else {
                    echo "No-one in queue";
                    }

                    mysqli_close($conn);
                    ?>

                </tbody>
            </table>
        </div>
    </div>
    </div>
    </div>
</body>
</html>