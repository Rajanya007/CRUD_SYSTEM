<?php
include_once 'db_connect.php';
session_start();
if (isset($_GET['action']) && $_GET['action'] == "checkLoginDetails") {
    if (isset($_GET['user']) && $_GET['user'] == "admin" && isset($_GET['pass']) && $_GET['pass'] == "admin") {
        echo "yes";
        $_SESSION['User'] = "true";
        exit;
    } else {
        echo "no";
        exit;
    }
}

if (isset($_GET['action']) && $_GET['action'] == "updateDetails") {
    echo "pass";
    exit;
} 
// elseif (isset($_GET['action']) && $_GET['action'] == "delDetails") {
//     echo "allow";
//     exit;
// } elseif (isset($_GET['action']) && $_GET['action'] == "del1Details") {
//     $id = $_GET['id'];
//     $del = "DELETE FROM MyGuests WHERE id='$id'";
//     $conn->query($del);
//     if ($conn->query($del) == true) {
//         echo "pro";
//     } else {
//         echo "noob";
//     }
// } 
// else {
//     // echo "fail";
// }

if (isset($_POST['action']) && $_POST['action'] == "DeleteSelectedCustomMenu") {
    $DeleteArray = "";
    $data = $_POST['data'];
    foreach ($data as $key => $val) {
        $DeleteArray .= "'" . $val . "',";
    }
    $newarraynama = rtrim($DeleteArray, ", ");
    $delall = "DELETE FROM MyGuests WHERE id IN ($newarraynama  )";
    $conn->query($delall);
    exit;
}
