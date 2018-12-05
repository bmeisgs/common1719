<!DOCTYPE html>

<html>

	<head>
	
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		
		<link href="IA_showinclass.css" rel="stylesheet" type="text/css"/>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title> BME German students manager </title>
		
		<style>
			.koumpia {
				cursor: pointer;
			}
			
			body {
				cursor: default;
			}
		</style>

	</head>

	<body>
	
	<div class="container-fluid">
		
		<h1 id="mytitle"> BME German students manager </h1>
		
		<br>
		
		<p id="mybase">
			Welcome to BME German students management database, where you can make notes on each student's progress!
		</p>
		
		<br/>
		
			
		<form id="form1" onsubmit="return checkEmpty()" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">	
		
			
			<div class="form-group">
				
				<div class="col-sm-4">
				
					<label for="name" class="descInput">Search by name:</label>
					<input type="text" class="form-control" id="name" autocomplete="off" placeholder="Enter student name">
					<span id="error-message-name" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only letters, full stops and spaces are allowed! </span>
					<small id="hint" class="form-text text-muted" style="margin-left: 1.7%;"> Insert first name or first letter of last name </small>
					
					</br>
					
					<label for="year" class="descInput"> Search by year: </label>
					<input type="text" class="form-control" id="year" autocomplete="off" placeholder="Enter student year">
					<span id="error-message-year" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only numbers are allowed! </span>
					<small id="hint" class="form-text text-muted" style="margin-left: 1.7%;"> From 9th-12th year </small>
					
					</br>
					
					<label for="SchoolSystem" class="descInput"> Search by school system: </label>
					<select class="form-control" id="sinthiki" onchange="showDropdown()" style="cursor: pointer">
						<option value="" disabled selected> Select school system </option>
						<option> Hungarian System </option>
						<option> IB </option>
						<option> Both </option>
					</select>
					
					</br>
					
					<label for="CourseLevel" id="hiddenOption2" class="descInput" style="display:none"> Select IB course level: </label>
					<select class="form-control" id="hiddenOption" style="display: none; cursor: pointer; margin-bottom: 5%;">
						<option value="" disabled selected> Select German course level </option>
						<option> Higher Level </option>
						<option> Standard Level </option>
						<option> Both </option>
					</select>
			
			
					<button type="submit" id="submit" class="btn btn-primary mb-2"> Search </button>
					<button type="reset" id="reset" class="btn btn-primary mb-2" onclick="closeDropdown(); hideHint('error-message-name'); hideHint('error-message-year'); 
																							tryToEnableSearch(); hideResults();"> Reset

					</button>
				
				</div>
					
			</div>				
			
			
		</form>
		
		<br/> </br>
		
	<!--?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "German_Class";

				$conn = new mysqli($servername, $username, $password, $dbname);

				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				} 
				
				else{
					$sql = "SELECT * FROM students WHERE";
					if(!empty($_POST['name'])) {
						$sql = $sql . " (name LIKE '" . $_POST['name'] . "%' or name LIKE '% " . $_POST['name'] ."%')";
					}
					if(!empty($_POST['year'])){
						if(!empty($_POST['name'])) {
							$sql = $sql . " and";
						}
						$sql = $sql . " year = " . $_POST['year'];
					}
					if(!empty($_POST['SchoolSystem'])){
						if(!empty($_POST['name']) || !empty($_POST['year'])) {
							$sql = $sql . " and";
						}
						if ($_POST['SchoolSystem']=="Both"){
							$sql = $sql . " (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
						}						
						else if ($_POST['SchoolSystem']=="Hungarian System"){
							$sql = $sql . " (SchoolSystem = 'Hungarian')";
						}
						else{
							$sql = $sql . " SchoolSystem = '" . $_POST['SchoolSystem'] . "'";
						}
					}	
					if(!empty($_POST['CourseLevel'])){						
						if ($_POST['CourseLevel']=="Both"){
							$sql = $sql . " and (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
						}
						else {
							$sql = $sql . " and CourseLevel = '" . $_POST['CourseLevel'] . "'";
						}
					}	
					
					echo $sql;
					
					$result = $conn->query($sql);
					
					if ($result){
						
					if ($result->num_rows > 0) {
		?> -->
		
		
		
		<!--?php 
						while($row = $result->fetch_assoc()) { 
		?> -->
		
		<div class="table-responsive">
		
		<table class="table">
			<tr>
				<th> Student Name </th>
				<th> Student Year </th>
				<th> School System </th>
				<th> Course Level </th>
				<th colspan="2"> Grades </th>
				<th class="notes"> Notes </th>
			</tr>
			<tr>
				<td> Matthaios Pelekis </td>
				<td> 12 </td>
				<td> IB </td>
				<td> SL </td>
				<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px" > First Semester </div> 
					<textarea rows="1" style="width:80%; resize: none; text-align:center;" placeholder="Insert grade.."></textarea> 
				</td>
				<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px"> Second Semester </div>
					<textarea rows="1" style="width:80%; resize: none; text-align:center;" placeholder="Insert grade.."></textarea> 
				</td>
				<td class="notes"> <textarea rows="5" style="width:98%; resize: none; text-align:left;" placeholder="Take notes.."></textarea></td>
			</tr>
		
		<!--?php
						}		
		?> -->
		
		</table>
		
		<!--?php
					} 
					}
					else {
						echo "<br> 0 results";
					}
				}
			}			
		?> -->
		
		</div>
		
		<script>
					
			var nameOk = true;
			var yearOk = true;
				
			$( "#name" ).on('input', function (evt) {
                var value = evt.target.value
				
				if (value.length === 0) {
					document.getElementById("error-message-name").style.display="none";
					$("#name").removeClass('error');
					nameOk = true;
					tryToEnableSearch();
					return;
				}
				
                if (/^([A-Za-z .]*)$/.test(value)) {
                    document.getElementById("error-message-name").style.display="none";
					$("#name").removeClass('error');
					nameOk = true;
					tryToEnableSearch();
                }
				else {
					document.getElementById("error-message-name").style.display="block";
					$("#name").addClass('error');
					nameOk = false;
					disableSearch();
				}
            });
			
			function tryToEnableSearch(){
				if (yearOk && nameOk){
					$("#submit").removeAttr("disabled", "disabled");
				}
			}
			
			function disableSearch() {
				$("#submit").attr("disabled", "disabled");
			}
			
			function hideHint(hint) {
				document.getElementById(hint).style.display="none";
			}
			
			$('#year').on('input', function (evt) {
			  var value = evt.target.value

				if (value.length === 0) {
					document.getElementById("error-message-year").style.display="none";
					$("#year").removeClass('error');
					yearOk = true;
					tryToEnableSearch();
					return;
				}
				if ($.isNumeric(value)) {
					document.getElementById("error-message-year").style.display="none";
					$("#year").removeClass('error');
					yearOk = true;
					tryToEnableSearch();
				}
				else{
					document.getElementById("error-message-year").style.display="block";
					$("#year").addClass('error');
					yearOk = false;
					disableSearch();
				}
			})
			
			function showDropdown(){
				var option = document.getElementById("sinthiki").value;
				if (option == "IB") {
					document.getElementById("hiddenOption").style.display='block';
					document.getElementById("hiddenOption2").style.display='block';
				}
				else {
					document.getElementById("hiddenOption").style.display="none";
					document.getElementById("hiddenOption2").style.display='none';
				}
			}
			
			function closeDropdown(){
				document.getElementById("CourseLevel").style.display="none";
			}
			
			function showForm(x){
				document.getElementById("form1").style.display="block";
				document.getElementById("description").innerHTML="Enter " + x;
				document.getElementById("searchInput").name=x;
			}
			
			function changeCursor(){
				document.body.style.cursor = "pointer";
			}
			
			function checkEmpty(){
				var input1 = document.getElementById("name").value;
				var input2 = document.getElementById("year").value;
				var input3 = document.getElementById("sinthiki").value;
				if ( input1 == "" && input2 == "" && input3 == "" )
				{
					alert("Please complete at least one field!");
					return false;
				}
			}
			
			function hideResults(){
				document.getElementById("results").style.display="none";
			}
						
		</script>
		
		
	</div>
	
	</body>

</html>