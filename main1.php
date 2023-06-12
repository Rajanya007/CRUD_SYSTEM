<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<?php
include_once 'db_connect.php';
session_start();
$id = $_GET['id'];
if (isset($_SESSION['User']) && $_SESSION['User'] != "true") {
    header('Location: ./index.php');
} elseif (isset($_POST['update'])) {

    $fname1 = $_POST['fname'];
    $lname1 = $_POST['lname'];
    $eml1 = $_POST['eml'];
    $ps1 =  $_POST['ps'];

    $update = "UPDATE MyGuests SET `lastname`='$lname1',`firstname`='$fname1',`email`='$eml1',`pass`='$ps1' WHERE `id`='$id'";
    $conn->query($update);
    if ($conn->query($update) == true) {
?>
        <script>
            confirm("Record Updated Successfully");
            window.location.href = './main.php';
        </script>
        <?php
        $select = "SELECT * FROM MyGuests WHERE id='$id'";
        $result = $conn->query($select);
        while ($row = mysqli_fetch_assoc($result)) {
            $fname =  $row['firstname'];
            $lname =  $row['lastname'];
            $eml =  $row['email'];
            $ps =  $row['pass'];
        ?>
            <h1>Update Details</h1>
            <form id="form2" method="POST">
                <div class="form-group">
                    <label for="exampleInputfname1">First Name</label>
                    <input type="text" class="form-control" id="exampleInputfname1" aria-describedby="emailHelp" placeholder="Enter First Name" name="fname" value="<?php echo $fname ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputlname1">Last Name</label>
                    <input type="text" class="form-control" id="exampleInputlname1" placeholder="Enter Last Name" name="lname" value="<?php echo $lname ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Email" name="eml" value="<?php echo $eml ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="ps" value="<?php echo $ps ?>">
                </div>
                <button type="submit" class="btn btn-primary" id="btn2" name="update">Update</button>
            </form>
        <?php
        }
    }
} else {

    $select = "SELECT * FROM MyGuests WHERE id='$id'";
    $result = $conn->query($select);
    while ($row = mysqli_fetch_assoc($result)) {
        $fname =  $row['firstname'];
        $lname =  $row['lastname'];
        $eml =  $row['email'];
        $ps =  $row['pass'];
        ?>
        <h1>Update Details</h1>
        <form id="form2" method="POST">
            <div class="form-group">
                <label for="exampleInputfname1">First Name</label>
                <input type="text" class="form-control" id="exampleInputfname1" aria-describedby="emailHelp" placeholder="Enter First Name" name="fname" value="<?php echo $fname ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputlname1">Last Name</label>
                <input type="text" class="form-control" id="exampleInputlname1" placeholder="Enter Last Name" name="lname" value="<?php echo $lname ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email</label>
                <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter Email" name="eml" value="<?php echo $eml ?>">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="ps" value="<?php echo $ps ?>">
            </div>
            <button type="submit" class="btn btn-primary" id="btn2" name="update">Update</button>
        </form>
<?php
    }
}


?>