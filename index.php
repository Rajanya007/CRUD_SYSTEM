<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
include_once 'db_connect.php';

?>
<script>
    $(document).ready(function() {
        $("#btn2").click(function() {
            // $("#form2").submit();
            var user= $("#exampleInputEmail1").val();
            var pass= $("#exampleInputPassword1").val();
            // alert(user);
            
            $.ajax({
                type: "GET",
                url: "./crud.php",
                data: "action=checkLoginDetails&user="+user+"&pass="+pass,

                success: function(response){
                    if(response == "yes"){
                        window.location.href = './main.php';
                    }else{
                        alert("Invalid details");
                    }
                }
            })
        })

    })
</script>
<form id="form2" style="justify-content: center;
    display: flex;
    flex-direction: column;
    width: 100%;
    align-items: center;
    height: 100vh;
    margin:0;">
    <h1><b>ADMIN LOGIN</b> </h1>
    <div class="form-group" style="margin-top:10px;">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="mail">
    </div>
    <div class="form-group" style="margin-top:10px;">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="pass">
    </div>
    <button type="button" class="btn btn-primary" id="btn2" style="margin-top:10px;">Log In</button>
</form>
<?php
?>