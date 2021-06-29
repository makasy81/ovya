<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; 
      charset=ISO-8859-1">
<title>Visit (create)</title>
<link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>
	<h2>Create new Visit</h2>
	
<form action="client.php" method="post">
	<fieldset style="margin-top:15px"><legend> Customer Selection:</legend>
		<div>
			<p>Enter a customer id and press <em>search</em>.</p>

			<label for="cnumber"> Customer Id:
				<input type="number" name="cnumber_select" id="cnumber" 
						style="width:200px"  value="[%cnumber%]"
				</input>
			</label>
			<br>
			
			<input type="submit" name="search" class="button" value="search">
			
		
		</div>
	</fieldset>

	<fieldset style="margin-top:15px"><legend>Customer:</legend>
		<div>
		<p>CustomerId: [%cnumber%] </p>
		</div>
		<div>Customer Name:<br>
			<input type="text" name="cname" class="text" 
				   style="width:400px" value="[%cname%]">
		</div>
		<div>Customer email:<br>
			<input type="text" name="cmail" class="text" 
				   style="width:400px" value="[%cmail%]">
		</div>
	</fieldset>	
	
	<fieldset><legend>Visit:</legend>
	    <br>
		<div>Date: <br>
			<input type="date" name="date"  value="[%Date%]">
		</div>
		<div>Start time: <br>
			<input type="time" name="start-time"  id="start-time" value="[%startTime%]">
		</div>
		<div>End time:<br>
			<input type="time" name="end-time"  value="[%endTime%]">
		</div>
		<div>Visitor email:<br>
			<input type="text" name="visitorMail"  style="width:200px" value="[%visitorEmail%]">
		</div>
		dknuth@fsf.org
		<p>
		<input type="submit" name="createVisit" class="button" value="create">
		<input type="submit" name="cancelVisit" class="button" value="cancel">
		</p>
		
		<div>Dossier:<br>
			<input type="text" name="did" class="text" 
				   style="width:400px" value="[%dossier%]">
		</div>
	</fieldset>
	
	<fieldset><legend>Status:</legend>		
		<div>Message:<br>
			<input type="text" name="did" class="text" 
				   style="width:800px" value="[%error%]">
		</div>
	</fieldset>
	
	
</form>
</body>
</html>