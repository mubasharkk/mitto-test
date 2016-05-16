<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Read TMP</title>

    <!-- Bootstrap -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	<style>
		.text-bold {
		  font-weight: bold;
		}
	</style>
	
  </head>
  <body>
		<div class="container pad">
			<div class="row">
				<div class="col-md-12">
					<h1 class="text-center">PHP Folder Fetch</h1>
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>Name</th>
								<th>Type</th>
								<th>File Size (<?php echo ($fileSizeInKBs) ? "KBs" : "Bytes" ;?>)</th>
								<th>Last Modified</th>
								<th>Owner</th>
								<th>Group</th>
								<th>Permissions</th>
								<th>File Age (Days)</th>
								<th>Download</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($data['dir'] as $dir):?>
							<tr class="bg-info">
								<td><?php echo $dir['dirname'];?></td>
								<td><?php echo $dir['attr']['filetype'];?></td>
								<td><?php echo $dir['attr']['filesize'];?></td>
								<td><?php echo $dir['attr']['last_modified'];?></td>
								<td><?php echo $dir['attr']['fileowner'];?></td>
								<td><?php echo $dir['attr']['filegroup'];?></td>
								<td><?php echo $dir['attr']['fileperms'];?></td>
								<td><?php echo $dir['attr']['file_age'];?></td>
								<td><?php echo "-";?></td>
							</tr>
							<?php endforeach;?>
							<?php foreach($data['files'] as $file):?>
							<tr class="bg-info">
								<td><?php echo $file['filename'];?></td>
								<td><?php echo $file['attr']['filetype'];?></td>
								<td><?php echo $file['attr']['filesize'];?></td>
								<td><?php echo $file['attr']['last_modified'];?></td>
								<td><?php echo $file['attr']['fileowner'];?></td>
								<td><?php echo $file['attr']['filegroup'];?></td>
								<td><?php echo $file['attr']['fileperms'];?></td>
								<td><?php echo $file['attr']['file_age'];?></td>
								<td><a class="btn btn-xs btn-success">Download</a></td>
							</tr>
							<?php endforeach;?>
						</tbody>
					</table>
					
					<?php if($message):?>
					<div class="margin bg-danger">
					  <?php echo $message;?>
					</div>
					<?php endif;?>
				</div>
			</div>
		</div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>


    <script src="display.results.js"></script>
  </body>
</html>