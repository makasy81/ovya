<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; 
      charset=ISO-8859-1">
<title>Buyer (delete) </title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	<h2>delete buyer</h2>
	
<form action="buyer.php" method="post">
	<fieldset style="margin-top:15px"><legend> Visitor Selection:</legend>
		<div>
			<p>Enter buyer's email and press <em>search</em>.</p>
			
			
			<label for="vEmail"> Buyer's Email:
				<input type="text" name="vEmail_select" id="vEmail" 
						style="width:200px"  value="[%vEmail%]"
				</input>
			</label>
			<br>
			
			<input type="submit" name="search_acq" class="button" value="search">
		</div>
	</fieldset>

	<fieldset style="margin-top:15px"><legend>Visitor:</legend>
		<div>
		Buyer's Email: [%visitor%] <br>
		</div>
		<br>
		<div>Buyer's Name:<br>
			<input type="text" name="visitor_name" class="text" 
				   style="width:400px" value="[%vname%]">
		</div>
		<div>Buyer's id:<br>
			<input type="text" name="visitor_mail" class="text" 
				   style="width:400px" value="[%vid%]">
		</div>
		
		<p>
		<input type="submit" name="delete_acq" class="button" value="deleteBuyer">
		<input type="submit" name="cancel_acq" class="button" value="cancel">
		</p>
		<p><em>Delete buyer and all his visits</em></p>
	</fieldset>	
	
	
	<fieldset><legend>Status:</legend>		
		<div>Message:<br>
			<input type="text" name="message" class="text" 
				   style="width:800px" value="[%error%]">
		</div>
	</fieldset>
	
	
</form>
</body>
</html>