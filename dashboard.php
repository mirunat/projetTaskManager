<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="js/jquery-1.11.0.js"></script>
	<link href="css/test.css" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap.css">
    <script src="js/bootstrap.min.js"></script>
    
    <title>Dashboard</title>

    <script>
    $(document).ready(function(){
	    $("img#edit").click(function() { 
		    $(this).parentsUntil("div").next().first().slideToggle();
		    return false;
  	}); 


});
    </script>
</head>

<body>
	<?php include('includes/navbar.php'); ?>

	<div class="section-header-pagina">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<?php include('includes/menu.php'); ?>	
				</div>
			</div>
					
	    	<?php
	    	
	    	$currentuser = $_SESSION['user']['id'];
	    	
	    	$query = "SELECT * FROM tasks inner join projects on tasks.project_id = projects.project_id
	    	where tasks.is_deleted = 0 and tasks.deadline = CURRENT_DATE and tasks.user_id = $currentuser";
	    	$data = mysql_query($query) or die(mysql_error());

			echo '<div class="col-lg-6 col-md-offset-3">'; 
			echo '<h3>Today tasks</h3>'; 

			while($row = mysql_fetch_assoc($data)){ ?>
	        
		    <div id="pri_<?php echo $row["priority"] ?>"class="list-group-item">
	            <p class="editpara"><?php echo $row["task"] ?></p>
	            <p class="editpara"><?php $row["priority"] ?></p>
	            <p class="editpara">(Tag: <?php echo $row["project"] ?>)</p>
	            <a href="detailstask.php?task_id=<?php echo $row["task_id"] ?>" target="_blank">
	            	<img title="Advanced Task" id="advanced" task="<?php echo $row["task_id"] ?>" src="img/advanced.png">
	            </a>
	            <a href="deletetask.php?task_id=<?php echo $row["task_id"] ?>">
	            	<img title="Delete Task" id="delete" task="<?php echo $row["task_id"] ?>" src="img/delete.png">
	            </a>
	            <a href="#">
	            	<img title="Edit Task" id="edit" task="<?php echo $row["task_id"] ?>" src="img/edit.png">
	            </a>

		        <div role="edit" id="edit_<?php echo $row["task_id"] ?>" class="list-group-item">
		            <h5>Edit Task</h5>
		            <form action="" name="taskForm" role="form" method="post">

		              	<?php
		              		if (isset($_POST['edit'])) {
		              			if ((isset($_POST['task']))&&(!empty($_POST['task']))) $task = $_POST['task'];
		              			if ((isset($_POST['priority']))&&(!empty($_POST['priority']))) $priority = $_POST['priority'];
		              			if ((isset($_POST['task_id']))&&(!empty($_POST['task_id']))) $task_id = $_POST['task_id'];
		              			if ((isset($_POST['deadline']))&&(!empty($_POST['deadline']))) $deadline = $_POST['deadline'];
		              			if ((isset($_POST['time']))&&(!empty($_POST['time']))) $time = $_POST['time'];

		  					$query = "UPDATE tasks SET task='$task', priority='$priority', deadline='$deadline', time='$time' WHERE task_id='$task_id'";
							$res = mysql_query($query) or die(mysql_error());
							
							}
		              	?>

						<?php include 'includes/form.php'; 
						
						?>
		                <input type="submit" class="btn btn-default" id="edit-btn" name="edit" value="Edit" /><br>
		            </form>
		    	</div>
			</div>

			<?php } $matches = mysql_num_rows($data); 
			if ($matches == 0) { 
				echo "No results"; 
			} ?>
									    							  
		</div>
		</div>
	</div>
</div>

	<?php include('includes/footer.php'); ?>

</body>
</html>