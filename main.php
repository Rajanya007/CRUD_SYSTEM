<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<style>
    body {
        width: 100%;
    }

    .row {
        width: 100%;
    }

    tbody:hover {
        cursor: move;
    }

    #example_wrapper {
        padding: 30px;
    }

    #mainCheckbox:hover {
        cursor: pointer;
    }

    .checkboxSingle:hover {
        cursor: pointer;
    }

    #rowSelect:hover {
        cursor: pointer;
    }
</style>
<?php
include_once 'db_connect.php';
session_start();
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
if (isset($_GET['row'])) {
    $no_of_records_per_page = $_GET['row'];

    // echo $no_of_records_per_page;
} else {
    $no_of_records_per_page = 10;
}

if (isset($_POST['logout'])) {
    $_SESSION['User'] = "false";
    header('Location: ./index.php');
    exit;
}
if (isset($_SESSION['User']) && $_SESSION['User'] != "true") {
    header('Location: ./index.php');
    exit;
} else {
    if (isset($_POST['search'])) {
        $search = $_POST['schr'];
        $_SESSION["search"] = $search;
    }
    if (isset($_GET["filter"]) && !empty($_GET["filter"]) && isset($_SESSION["search"])) {
        $search = $_SESSION["search"];
        $offset = ($pageno - 1) * $no_of_records_per_page;
        $total_pages_sql = "SELECT COUNT(*) FROM myguests WHERE CONCAT(firstname, ' ', lastname, ' ', pass, ' ', email,' ',id) LIKE '%" . $search . "%'";
        $result1 = mysqli_query($conn, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result1)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);


        $searchQuery = "SELECT * FROM myguests WHERE CONCAT(firstname, ' ', lastname, ' ', pass, ' ', email,' ',id) LIKE '%" . $search . "%' LIMIT $offset, $no_of_records_per_page";
        $result = $conn->query($searchQuery);
    } else {
        unset($_SESSION["search"]);
        $offset = ($pageno - 1) * $no_of_records_per_page;
        $total_pages_sql = "SELECT COUNT(*) FROM myguests";
        $result1 = mysqli_query($conn, $total_pages_sql);
        $total_rows = mysqli_fetch_array($result1)[0];
        $total_pages = ceil($total_rows / $no_of_records_per_page);

        $sql = "SELECT * FROM myguests LIMIT $offset, $no_of_records_per_page";
        $result = $conn->query($sql);
    }
    if(isset($_SESSION["delete"]) && $_SESSION["delete"] == "1" && isset($_GET["delete"])){
        $_SESSION["delete"] = "0";
        $id = $_GET['id'];
        $del = "DELETE FROM MyGuests WHERE id='$id'";
        $conn->query($del);
        if ($conn->query($del) == true) {
            echo "<script> window.location.href = './main.php' </script>";
        }else{
            echo "noob";
        }
    }
}

?>
<form action="" method="post" style="margin: 0; padding: 10px;">
    <button type="submit" name="logout">
        Logout
    </button>
</form>
<div id="loading" style="
            display: none;
            background: url('http://iptvbillingsolution.com/loveyword/channel/wp-content/plugins/MyPlugin/img/loading-unscreen.gif') no-repeat center center;
            height: 100%;
            width: 100%;
            "></div>
<form action="" id="form1" style="padding: 16px;">
    <label for="rowSelect">No Of Rows:
        <select name="Selectrow" id="rowSelect">
            <option value="10" <?php if ($no_of_records_per_page == "10") {
                                    echo ' selected="selected"';
                                } ?> class="dropdown">10</option>
            <option value="25" <?php if ($no_of_records_per_page == "25") {
                                    echo ' selected="selected"';
                                } ?> class="dropdown">25</option>
            <option value="50" <?php if ($no_of_records_per_page == "50") {
                                    echo ' selected="selected"';
                                } ?> class="dropdown">50</option>
            <option value="100" <?php if ($no_of_records_per_page == "100") {
                                    echo ' selected="selected"';
                                } ?> class="dropdown">100</option>
        </select>
    </label>
</form>
<form action="?filter=1" id="fm1" method="POST" style="float:right;">
    <label for="Search">Search:
        <input type="search" name="schr" id="txtsch" value="">
    </label>
    <button type="submit" name="search">Search</button>
</form>

<table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
            <th><span><input type="checkbox" name="mainCheck" id="mainCheckbox" onclick="allSelect(this)"></span></th>
            <th>ID</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Password</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php

        while ($row = mysqli_fetch_array($result)) {
        ?>

            <tr>
                <td><input type="checkbox" class="checkboxSingle" onclick="selectBox()" id="<?php echo $row['id']; ?>"></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['firstname']; ?></td>
                <td><?php echo $row['lastname']; ?></td>
                <td><?php echo $row['email']; ?></td>
                <td>*******</td>
                <td><button type="button" class="btn btn-primary" onclick="myFunction(this)" id="<?php echo $row['id']; ?>">Update Details</button></td>
                <td><button type="button" class="btn btn-danger" onclick="myF(this)" id="<?php echo $row['id']; ?>">Delete</button></td>
            </tr>

        <?php
        }

        ?>
    </tbody>
</table>
<?php
// }
// mysqli_close($conn);
?>
<div id="div2">
    <div>
        <button type="button" class="btn btn-danger" onclick="SelectedDelete()">Delete Selected Records</button>
    </div>
    <label for="pagination">Please Enter the Page Number (Max pages are <?php echo $total_pages ?> ):
        <input type="number" id="page">
        <button type="button" onclick="pagination(this)" class="btn btn-success"> Submit </button>
    </label>
    <div align="center">
        <nav style="text-align: center;width: fit-content;" aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item"><a class="page-link" href="?pageno=1<?php if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
                                                                                echo "&filter=1";
                                                                            } ?>">First</a></li>
                <li class="page-item <?php if ($pageno <= 1) {
                                            echo 'disabled';
                                        } ?>">
                    <a href="<?php if ($pageno <= 1) {
                                    echo '#';
                                } else {
                                    echo "?pageno=" . ($pageno - 1);
                                } 
                                if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
                                    echo "&filter=1";
                                }?>" class="page-link">Prev</a>
                </li>

                <li class="page-item <?php if ($pageno >= $total_pages) {
                                            echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="<?php if ($pageno >= $total_pages) {
                                                    echo '#';
                                                } else {
                                                    echo "?pageno=" . ($pageno + 1);
                                                }
                                                if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
                                                    echo "&filter=1";
                                                } ?>">Next</a>
                </li>
                <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages;
                if (isset($_GET["filter"]) && !empty($_GET["filter"])) {
                    echo "&filter=1";
                } ?>">Last</a></li>
            </ul>
        </nav>
    </div>
</div>

<script>
    function myF(del) {
        var cnf = confirm("Are You really want to delete this record?");
        if (cnf == true) {
            window.location.href = "?delete=1&id=" + $(del).attr("id");
            <?php $_SESSION["delete"] = "1"; ?>
        }
        // location.reload("true");
        // $("#loading").show();
        // var id1 = $(del).attr("id");
        // $.ajax({
        //     type: "GET",
        //     url: "http://localhost/vs%20code/crud.php",
        //     data: "action=delDetails",

        //     success: function(response) {
        //         $("#loading").hide();
        //         // console.log(response)
        //         // alert(response);
        //         if (response == "allow") {
        //             var cnf = confirm("Are You really want to delete this record?");
        //             if (cnf == true) {

        //                 $.ajax({
        //                     type: "GET",
        //                     url: "http://localhost/vs%20code/crud.php",
        //                     data: "action=del1Details&id=" + id1,

        //                     success: function(response) {
        //                         // console.log(response)
        //                         if (response == "pro") {
        //                             location.reload(true);
        //                             alert("Record Deleted Successfully");

        //                         }
        //                     }
        //                 })
        //             }

        //         } else {
        //             alert("Invalid details");
        //         }
        //     }
        // })

    }

    function allSelect(all1) {
        if ($(all1).is(":checked")) {
            $(".checkboxSingle").prop("checked", true);
        } else {
            $(".checkboxSingle").prop("checked", false);
        }
    }

    function selectBox() {
        if ($('.checkboxSingle:checked').length == $('.checkboxSingle').length) {
            $('#mainCheckbox').prop('checked', true);
        } else {
            $('#mainCheckbox').prop('checked', false);
        }
    }


    function SelectedDelete() {
        // $("#loading").show();

        if ($("input.checkboxSingle:checkbox").is(":checked")) {
            var cnf1 = confirm("Are You really want to delete this record?");
            if (cnf1 == true) {
                // $(".spinner").show();
                var data = [];

                $("input.checkboxSingle:checkbox:checked").each(function(index) {
                    data[index] = this.id;
                });

                // console.log(data);

                $.ajax({
                    type: "POST",
                    url: './crud.php',
                    data: {
                        action: 'DeleteSelectedCustomMenu',
                        data: data,
                    },
                    success: function(response) {
                        console.log(response);
                        location.reload(true);
                        alert("Record Deleted Successfully");
                    }
                });
            } else {
                alert("Record Saved!!")
                location.reload(true);
            }
        } else {

            alert("Please select a option");
        }


    }


    // function row() {
    //     document.href = 'http://localhost/vs%20code/main.php?row=0'
    // }

    function myFunction(hi) {
        var id = $(hi).attr("id");
        $.ajax({
            type: "GET",
            url: "./crud.php",
            data: "action=updateDetails",

            success: function(response) {
                // console.log(response)
                if (response == "pass") {
                    window.location.href = './main1.php?id=' + id;

                } else {
                    alert("Invalid details");
                }
            }
        })
    }

    function pagination(page) {
        if ($('#page').val() <= 0) {
            // window.location.href="?#"
            document.getElementById("example").innerHTML = "<h1 style='color: red;'>Page Doesn't Exist</h1>";
        } else if ($('#page').val() > <?php echo $total_pages; ?>) {
            document.getElementById("example").innerHTML = "<h1 style='color: red;'>Page Doesn't Exist</h1>";
        } else {
            window.location.href = '?pageno=' + $('#page').val();
        }

    }

    $(document).ready(function() {
        $("#rowSelect").change(function() {
            var val = $("#rowSelect option:selected").attr('value');
            window.location.href = './main.php?row=' + val;
        })
    })
</script>