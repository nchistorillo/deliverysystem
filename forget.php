<?php include("header.php") ?>

<?php if (isset($_POST["forget_email"])) {

  $email = $_POST["forget_email"];

  $error_msg;
  try {

   $m = new MongoClient("mongodb://admin:EIIGMGVVORZLANRD@sl-eu-lon-2-portal.5.dblayer.com:20539,sl-eu-lon-2-portal.0.dblayer.com:20539/admin?ssl=true");
   $db = $m->Pizza;
   $collection = $db->users;

  } catch(Exception $e) {
    #die("Caught Exception failed to Connect".$e->getMessage()."\n");

    $error_msg = "Couldn't Connect to Database";

  }

  if (empty($error_msg)) {

    $result = $collection->findOne(array('email' => $email));
    if (!empty($result)) {





      $msg = "First line of text\nSecond line of text ".$result["password"];

  // use wordwrap() if lines are longer than 70 characters
      $msg = wordwrap($msg,70);

  // send email
      $if_sent = mail($email,"Contains Password", $msg);

      if ($if_sent) {
        $_SESSION["pop_login"] = "Your password has been Successfully sent to the registered emailID.";
        header("Location: .");
      } else {
        $error_msg = "Failed to send email. Please try again!";
      }

  } else {

        $error_msg = "The Provided Email address is not registered. Please Register First!";
      }



    }


}

?>

<style>


.error {color: #FF0000;}
.form
{
 margin-top: 100px;
}
.fp{
color: orange;
}

</style>
</head>
<body>


<div class="container pb-modalreglog-container">
    	<div class="row">
    		    <div class="col-xs-12 col-md-4 col-md-offset-4">
			<div class="form" >
			<legend class="fp">Forgot Password</legend>
			<fieldset>
        <?php if(isset($error_msg)) { ?>
        <div id="error" class="alert alert-danger" role="alert"><?php echo $error_msg ?></div>
      <?php } ?>
			<form method="post" action="#" onsubmit="return checkEmail();">

					<div class="form-group">
                                   		 <label for="email">Email address</label>
                                    		<div class="input-group pb-modalreglog-input-group">
                                        		<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                        		<input type="text" class="form-control" name="forget_email" id="forget_email" placeholder="Email" required>

                                 		</div>

                                	</div>


			<input type="submit" class="btn btn-warning" name="submit" value="Submit"/>
			</form></fieldset>
			</div>



</div></div></div>

<script type="text/javascript" >
function checkEmail() {

    var email = document.getElementById('forget_email');
    var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (filter.test(email.value) == false) {
    alert('Please provide a valid email address');
    email.focus();
    return false;
 }

}
</script>
<?php include("modals.php"); ?>
<?php include("footer.php"); ?>
