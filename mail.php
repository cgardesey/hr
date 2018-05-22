<?php

$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "hrms_basic";


$connect = mysqli_connect($hostname, $username, $password, $databaseName);
$query = "SELECT employee_email FROM employee";
$result = mysqli_query($connect, $query);
$options = "";
?>


<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap Form To Submit To Email - reusable form</title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <link rel="stylesheet" href="form.css" >
        <script src="form.js"></script>
    </head>
<body>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2>Email</h2>
        <p>
            
        </p>
        <form role="form" method="post" id="reused_form"  action="<?php echo $_SERVER['PHP_SELF']?>" name ='mail_form'>
           
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="comments">
                        Body:</label>
                    <textarea class="form-control" type="textarea" name="msg_body" id="msg_body" placeholder="Message Body" maxlength="6000" rows="7"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="name">
                        From:</label>
                    <input type="text" class="form-control" id="name" name="from" required>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="email">
                        To:</label>
                    <select name="to">
					<?php
					while($row = mysqli_fetch_array($result))
					{
					    ?>

					    <option><?php echo $row['employee_email']; ?> </option>
					    <?php
					}

					?>
					</select>
                </div>
            </div>

                        <div class="row">
                <div class="col-sm-12 form-group">
                    <button type="submit" class="btn btn-lg btn-primary btn-block" onclick="mailFunction()" >Send</button>
                </div>
            </div>

        </form>
        <div id="success_message" style="width:100%; height:100%; display:none; ">
            <h3>Posted your feedback successfully!</h3>
        </div>
        <div id="error_message"
                style="width:100%; height:100%; display:none; ">
                    <h3>Error</h3>
                    Sorry there was an error sending your form.

        </div>
    </div>
</div>
<php? 
	if (isset($_POST['mail_form']))
	{
		mail($POST['to'], "",$POST['msg_body']);
	}
?>
</body>
</html>