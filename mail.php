<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h2>Email</h2>
        <p>
            
        </p>
        <form role="form" method="post" id="reused_form">
           
            <div class="row">
                <div class="col-sm-12 form-group">
                    <label for="comments">
                        Body:</label>
                    <textarea class="form-control" type="textarea" name="comments" id="comments" placeholder="Message Body" maxlength="6000" rows="7"></textarea>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 form-group">
                    <label for="name">
                        Your Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-sm-6 form-group">
                    <label for="email">
                        Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
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
</body>
</html>