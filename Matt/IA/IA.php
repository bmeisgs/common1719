<!DOCTYPE html>

<html>

	<head>
	
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
		
		<link href="IA.css?v13" rel="stylesheet" type="text/css"/>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title> BME German students manager </title>
		
		<style>
			body {
				cursor: default;
			}
		</style>

	</head>

	<body>	
	
		<div id="mySidenav" class="sidenav" style="width: 0px;">
		  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		  <a href="#home"> Home </a>
		  <a href="#search"> Search students </a>
		  <a href="#edit"> Edit students </a>
		  <a href="#calendar"> Calendar </a>
		</div>
		
		<span style="font-size:35px;cursor:pointer" onclick="openNav()" id="mySlidebar"> &#9776; Menu </span>
		
		<div class="container-fluid" id="main">
		
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
					<input type="text" class="form-control" id="name" autocomplete="off" placeholder="Enter student name" name="name">
					<span id="error-message-name" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only letters, full stops and spaces are allowed! </span>
					<small id="hint" class="form-text" style="margin-left: 1.7%; color: #0d3800;"> Insert first name or first letter of last name </small>
					
					</br>
					
					<label for="year" class="descInput"> Search by year: </label>
					<input type="text" class="form-control" id="year" autocomplete="off" placeholder="Enter student year" name="year">
					<span id="error-message-year" style="color: red; font-style: italic; display:none; margin-left: 1.7%;"> Only numbers are allowed! </span>
					<small id="hint" class="form-text" style="margin-left: 1.7%; color: #0d3800;"> From 9th-12th year </small>
					
					</br>
					
					<label for="SchoolSystem" class="descInput"> Search by school system: </label>
					<select class="form-control" id="sinthiki" onchange="showDropdown()" style="cursor: pointer" name="SchoolSystem">
						<option value="" disabled selected> Select school system </option>
						<option> Hungarian System </option>
						<option> IB </option>
						<option> Both </option>
					</select>
					
					</br>
					
					<div id="hiddenOption" style="display:none">
						<label for="CourseLevel" class="descInput"> Select IB course level: </label>
						<select class="form-control" style="cursor: pointer; margin-bottom: 5%;" name="CourseLevel">
							<option value="" disabled selected> Select German course level </option>
							<option> Higher Level </option>
							<option> Standard Level </option>
							<option> Both </option>
						</select>
					</div>
			
					<button type="submit" id="submit" class="btn btn-primary mb-2" onclick="showSaveChangesButton()"> Search </button>
					<button type="reset" id="reset" class="btn btn-primary mb-2" onclick="enableSearch(); hideHint('error-message-name'); hideHint('error-message-year'); 
																							closeDropdown('hiddenOption'); hideResults(); hideSaveChangesButton();"> Reset
					</button>
				
				</div>
					
			</div>			
					
		</form>
		
		</br>

		</br>
		
		<?php
			if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		?>
		
		<button class="btn btn-primary mb-2" id="saveChangesButton"> Save changes </button>
		<button class="btn btn-primary mb-2" id="sortAlphabeticallyButton" onclick="sortTableAlphabetically()"> Sort alphabetically </button>
		
		<?php
			}
		?>
		
		<div id="resultsArea">
		
	<?php
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
					
					if(isset($_POST["changeFormSubmit"])){
						$result = $conn->query($sql);
						for ( $i = 1 ; $i <= $result->num_rows ; $i++ ) {
							$row = $result->fetch_assoc();
							if (isset($_POST["gradeA_" . $i])){
								if( $_POST["gradeA_" . $i]!=$row['Grades_A'] ){ 
									$sql_updated = "UPDATE students SET `Grades_A`='" . $_POST["gradeA_" . $i] . "' WHERE `Name`='" . $row["Name"] . "'";
									$result_updated = $conn->query($sql_updated);
								}
							}
							if (isset($_POST["gradeB_" . $i])){
								if ( $_POST["gradeB_" . $i]!=$row['Grades_B'] ){ 
									$sql_updated = "UPDATE students SET `Grades_B`='" . $_POST["gradeB_" . $i] . "' WHERE `Name`='" . $row["Name"] . "'";
									$result_updated = $conn->query($sql_updated);
								}
							}
							if (isset($_POST["notes_" . $i])){
								if ( $_POST["notes_" . $i]!=$row['Notes'] ){ 
									$sql_updated = "UPDATE students SET `Notes`='" . $_POST["notes_" . $i] . "' WHERE `Name`='" . $row["Name"] . "'";
									$result_updated = $conn->query($sql_updated);
								}
							}
							
						}
					}
					
					$result = $conn->query($sql);
					
					if ($result){
						
						if ($result->num_rows > 0) {
		?> 
				
		<div class="table-responsive" id="results">
		
		<table class="table" id="myTable">
			<tr>
				<th> Student Name </th>
				<th> Student Year </th>
				<th> School System </th>
				<th> Course Level </th>
				<th colspan="2"> Grades </th>
				<th class="notes"> Notes </th>
			</tr>
			
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			
			<?php 
							$counter = 0;
							while($row = $result->fetch_assoc()) { 
								$counter = $counter + 1;
				?>
			
				<tr>
					<td> <?php echo $row['Name'] ?> </td>
					<td> <?php echo $row['Year'] ?> </td>
					<td> <?php echo $row['SchoolSystem'] ?> </td>
					<td> <?php if ($row['CourseLevel']=="") echo "-"; else echo $row['CourseLevel'] ?> </td>
					<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px" > First Semester </div> 
						<textarea name="gradeA_<?php echo $counter ?>" rows="1" style="width:80%; resize: none; text-align:center;" placeholder="Insert grade.."><?php echo $row['Grades_A'] ?></textarea> 
					</td>
					<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px"> Second Semester </div>
						<textarea name="gradeB_<?php echo $counter ?>" rows="1" style="width:80%; resize: none; text-align:center;" placeholder="Insert grade.."><?php echo $row['Grades_B'] ?></textarea> 
					</td>
					<td class="notes"> 
						<textarea name="notes_<?php echo $counter ?>" rows="5" style="width:98%; resize: none; text-align:left;" placeholder="Take notes.."><?php echo $row['Notes'] ?></textarea>
					</td>
					
				</tr>
		
		<?php
							}
		?>
				<input name="name" style="display: none;" value="<?php if(!empty($_POST['name'])) echo $_POST['name'] ?>"></input>
				<input name="year" style="display: none;" value="<?php if(!empty($_POST['year'])) echo $_POST['year'] ?>"></input>
				<input name="SchoolSystem" style="display: none;" value="<?php if(!empty($_POST['SchoolSystem'])) echo $_POST['SchoolSystem'] ?>"></input>
				<input name="CourseLevel" style="display: none;" value="<?php if(!empty($_POST['CourseLevel'])) echo $_POST['CourseLevel'] ?>"></input>
				<button type="submit" id="invisibleSubmit" name="changeFormSubmit" style="display: none;"></button>
				
			</form>
			
		</table>
		
		<?php
						} 
						else {
							echo "<br> <br> <p id='zeroResults' style='text-align: center; font-size: 130%; color: #0d3800; font-weight: bold;'> Sorry, no matches found! </p>";
						}
					}
					
				}
				
			}			
		?> 
		
		</div>
		
		</div>
		
		<script>
					
			var nameOk = true;
			var yearOk = true;
				
			$("#name" ).on('input', function (evt) {
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
			
			$("#saveChangesButton").click(function(){
				$("#invisibleSubmit").click();
			});
			
			if ($('#zeroResults').is(':visible')) {
				$("#saveChangesButton").attr("disabled", "disabled");
			}
			
			function showSaveChangesButton() {
				document.getElementById("saveChangesButton").style.display="block";
			}
			
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
				}
				
				else {
					document.getElementById("hiddenOption").style.display="none";
				}
			}
			
			function closeDropdown(z){
				document.getElementById(z).style.display="none";
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
				if (document.getElementById("resultsArea").style.display!="none") {
					document.getElementById("resultsArea").style.display="none";
				}
			}
			
			function hideSaveChangesButton() {
				document.getElementById("saveChangesButton").style.display="none";
			}
			
			function enableSearch() {
				$("#submit").removeAttr("disabled", "disabled");
			}

			function openNav() {
				document.getElementById("mySidenav").style.width = "250px";
				document.getElementById("main").style.marginLeft = "250px";
				document.body.style.backgroundColor = "#b4bdc4";
			}

			function closeNav() {
				document.getElementById("mySidenav").style.width = "0px";
				document.getElementById("main").style.marginLeft = "0px";
				document.body.style.backgroundColor = "#dfe3e6";
			}
			
			function sortTableAlphabetically() {
				var table, rows, switching, i, x, y, shouldSwitch;
				table = document.getElementById("myTable");
				switching = true;
				rows = table.rows;

				while (switching) {
					switching = false;
					rows = table.rows;
					
					for (i = 1; i < (rows.length - 1); i++) {
						shouldSwitch = false;
						x = rows[i].getElementsByTagName("TD")[0];
						y = rows[i + 1].getElementsByTagName("TD")[0];
					if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
						shouldSwitch = true;
						break;
						}
					}					
					if (shouldSwitch) {
						rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
						switching = true;
					}					
				}
				
			}
						
		</script>
				
	</div>
	
	</body>

</html>