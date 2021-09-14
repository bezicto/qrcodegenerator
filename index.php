<?php 
	//set to not display errors for this page to overwrite those on php.ini setting.
	ini_set('display_errors', 0);ini_set('display_startup_errors', 0);

	//start session for collecting user specific history, this is for user only will not be visible to system owner
	session_start();
	
	//check if strText text field is set in the html form
	if (isset($_REQUEST["strText"]))
	{
		//if strText is set, then push the string into $_SESSION["history"] that hold an array
		//then now only push A NEW strText value into the $_SESSION["history"]
		if (!in_array($_REQUEST["strText"], $_SESSION["history"]))
			array_push($_SESSION["history"],$_REQUEST["strText"]);
	}
	else
	{
		//if strText is NOT set, create new empty array then set it to $_SESSION["history"]
		$history_array = array();
		$_SESSION["history"] = $history_array;
	}
?>
<html>
<head>
	<title>Test</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="styles/bootstrap.css" rel="stylesheet" type="text/css"  />	
	<link href="styles/jquery-ui.css" rel="stylesheet" type="text/css"  />
	<script src="scripts/jquery.js" type="text/javascript" ></script>
	<script src="scripts/jquery-ui.js" type="text/javascript" ></script>
	<script src="scripts/jquery.qrcode.min.js" type="text/javascript"></script>
	<script>
	  	$(document).ready(function() {
			var strText = document.thisform.strText.value;
			jQuery('#selecteddiv').qrcode({
				text	: strText
			});	
	  	});

		$( function() {
			$( "#tabs" ).tabs();
		} );
	</script>
</head>

<body style="text-align:center;">

	<div id="tabs" style="width:450;display: inline-block;margin-top:50px;">

		<!-- 3 tabs -->	
		<ul>
			<li><a href="#tabs-1">Main Menu</a></li>
			<li><a href="#tabs-2">History</a></li>
			<li><a href="#tabs-3">Help</a></li>
		</ul>

		<!-- tab #1 : will contains qr codes generated on ENTER when user input a string in the strText field -->
		<div id="tabs-1">
				<span style="color:blue;margin-bottom:10px;display:block;">QR for the input</span> 
				<div align='center' id='selecteddiv'></div>
				<form action="index.php" method="post" name="thisform">
					<span style="color:blue;margin-top:50px;display:block;">Insert Text and Press ENTER:</span>
					<input type="input" name="strText" style="width:50%" value="<?php echo $_REQUEST['strText'];?>"/>
				</form>
		</div>

		<!-- tab #2 : Contains all history that current user type in the strText field. will also contain a button to clear all history for the session. -->
		<div id="tabs-2" style="text-align:center;">
			<?php
				//echo out all values in the array stored in $_SESSION['history']
				foreach($_SESSION['history'] as $key=>$value)
					echo "<a href='index.php?strText=$value'>$value</a><br/>";//whenever user click on the value, it will show the QR code
			
			 	if (!empty($_SESSION['history'])) 
				 	{ 
			?>
						<div style="display: inline-block;margin-top:30px";>
							<input class="btn btn-danger" type="button" value="Remove all" onclick="window.location.href='index.php'">
						</div>
			<?php 	} 
				else {echo "<i>Nothing to show</i>";}
			?>
		</div>
		
		<!-- tab #3 : just an about page -->
		<div id="tabs-3">
			This QR code contains the following implementation:
			<br/><span style="color:blue">jquery, jquery-ui, jquery.qrcode, bootstrap</span>
		</div>

	</div>

</body>
</html>
