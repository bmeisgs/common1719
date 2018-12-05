<!DOCTYPE html>

<html>

	<head>
	
		<link href="IA.css?v7" rel="stylesheet" type="text/css"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> <!-- jquery library -->
		
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
	
		<h1 id="titlos"> BME German students manager </h1>
		
		<p id="vassi">
		Welcome to BME German students management database, where you can make notes on each student's progress!
		</p>  
		
		<br/>
		
		<form id="form1" onsubmit="return checkEmpty()" method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">	
		
			<table id="searchTable">
			
				<tr>
					<td> <b> Search student by name: </b> </td> <td> <input type="textarea" id="name" name="name" autocomplete="off" title="Insert first name or first letter of last name"> </input> </td>
					<td> <span id="error-message-name" style="color: red; font-style: italic; display:none"> Only letters, full stops and spaces are allowed! </span> </td>
				</tr>
				
				<tr>
					<td> <b> Search student by year: </b> </td> <td> <input type="textarea" id="year" name="year" autocomplete="off" title="From 9th-12th year"> </input> </td>
					<td> <span id="error-message-year" style="color: red; font-style: italic; display:none"> Only numbers are allowed! </span> </td>
				</tr>
				
				<tr>			
					<td> <b> Search student by school system: </b> </td> 
					
					<td>
						<select id="SchoolSystem" onchange="showDropdown()" style="cursor: pointer" name="SchoolSystem">
							<option value="" disabled selected> ... </option>
							<option> Hungarian System </option>
							<option> IB </option>
							<option> Both </option>							
						</select> 
					</td>
				</tr>
				
				<tr style="display:none" id="CourseLevel">			
					<td> <b> Insert student's IB course level: </b> </td>
					
					<td> 
						<select style="cursor: pointer" name="CourseLevel">
							<option value="" disabled selected> ... </option>
							<option> Higher Level </option>
							<option> Standard Level </option>
							<option> Both </option>
						</select>
					</td>				
				</tr>	
				
				<tr>
					<td> <button type="submit" id="submit" style="cursor: pointer" class="btn btn-primary"> Search </button> </td>
					<td> <button type="reset" id="reset" style="cursor: pointer" onclick="closeDropdown(); hideHint('error-message-name'); hideHint('error-message-year'); enableSearch(); hideResults();"> Reset </button> </td>
				</tr>
				
			</table>
			
		</form>
		
		<br/> </br>
		
		<?php
			if (isset($_REQUEST['name'])){
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
					if(!empty($_REQUEST['name'])) {
						$sql = $sql . " (name LIKE '" . $_REQUEST['name'] . "%' or name LIKE '% " . $_REQUEST['name'] ."%')";
					}
					if(!empty($_REQUEST['year'])){
						if(!empty($_REQUEST['name'])) {
							$sql = $sql . " and";
						}
						$sql = $sql . " year = " . $_REQUEST['year'];
					}
					if(!empty($_REQUEST['SchoolSystem'])){
						if(!empty($_REQUEST['name']) || !empty($_REQUEST['year'])) {
							$sql = $sql . " and";
						}
						if ($_REQUEST['SchoolSystem']=="Both"){
							$sql = $sql . " (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
						}
						
						else if ($_REQUEST['SchoolSystem']=="Hungarian System"){
							$sql = $sql . " (SchoolSystem = 'Hungarian')";
						}
						else{
							$sql = $sql . " SchoolSystem = '" . $_REQUEST['SchoolSystem'] . "'";
						}
					}	
					if(!empty($_REQUEST['CourseLevel'])){						
						if ($_REQUEST['CourseLevel']=="Both"){
							$sql = $sql . " and (SchoolSystem = 'Hungarian' or SchoolSystem = 'IB')";
						}
						else {
							$sql = $sql . " and CourseLevel = '" . $_REQUEST['CourseLevel'] . "'";
						}
					}	
					
					echo $sql;
					
					$result = $conn->query($sql);
						
					if ($result->num_rows > 0) {
		?>
		
		<table id="results">
			<tr>
				<th> Student Name </th>
				<th> Student Year </th>
				<th> School System </th>
				<th> Course Level </th>
				<th colspan="2"> Grades </th>
				<th class="notes"> Notes </th>
			</tr>
		
		<?php 
						while($row = $result->fetch_assoc()) { 
		?>
		
			<tr>
				<td> <?php echo $row['Name'] ?></td>
				<td> <?php echo $row['Year'] ?> </td>
				<td> <?php echo $row['SchoolSystem'] ?> </td>
				<td> <?php if ($row['CourseLevel']=="") echo "-"; else echo $row['CourseLevel'] ?> </td>
				<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px" > First Semester </div> 
					<textarea rows="1" style="width:80%; resize: none; text-align:center;" placeholder="Insert grade.."><?php echo $row['Grades_A'] ?></textarea> 
				</td>
				<td class="grades"> <div style="font-weight: bold; color: #1e058b; margin-bottom: 5px"> Second Semester </div>
					<textarea rows="1" style="width:80%; resize: none; text-align:center;" placeholder="Insert grade.."><?php echo $row['Grades_B'] ?></textarea> 
				</td>
				<td class="notes"> <textarea rows="5" style="width:98%; resize: none; text-align:left;" placeholder="Take notes.."><?php echo $row['Notes'] ?></textarea></td>
			</tr>
		
		<?php
						}
		?>
		
		</table>
		
		<?php
					} 
					else {
						echo "<br> 0 results";
					}
				}
			}			
		?>
		
		<script>
					
			$( "#name" ).on('input', function (evt) {
                var value = evt.target.value
				
				if (value.length === 0) {
					document.getElementById("error-message-name").style.display="none";
					enableSearch();
					return;
				}
				
                if (/^([A-Za-z .]*)$/.test(value)) {
                    document.getElementById("error-message-name").style.display="none";
					enableSearch();
                }
				else {
					document.getElementById("error-message-name").style.display="table-row";
					disableSearch();
				}
            });
			
			function enableSearch(){
				$("#submit").removeAttr("disabled", "disabled");
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
					enableSearch();
					return;
				}
				if ($.isNumeric(value)) {
				  document.getElementById("error-message-year").style.display="none";
				  enableSearch();
			  }
				else{
					document.getElementById("error-message-year").style.display="table-row";
					disableSearch();
				 }
			})
			
			function showDropdown(){
				var option = document.getElementById("SchoolSystem").value;
				if (option == "IB") document.getElementById("CourseLevel").style.display='table-row';
				else if (option == "Both") document.getElementById("CourseLevel").style.display='table-row';
				else document.getElementById("CourseLevel").style.display="none";
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
				var input3 = document.getElementById("SchoolSystem").value;
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
		
	</body>

</html>