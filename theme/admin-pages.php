<?php include(dirname(__FILE__) . '/admin.php'); ?>

<?php
if(isAdmin()){
?>

<p></p>

<div class="container">




	<div class="panel panel-default">
		
		<div class="panel-heading hidden-click">
		
			<h3 class="panel-title">Edit page</h3>
			
		</div>
		
		<div class="hidden-content panel-body">
			
			
											
		</div>
		
	</div>





	<div class="panel panel-default">
		
		<div class="panel-heading hidden-click">
		
			<h3 class="panel-title">Create new page</h3>
			
		</div>
		
		<div class="hidden-content panel-body">
			
			<div class="well">
				
			
				<form action="" method="post" role="form" class="form form-horizontal">
					
					
						<div class="form-group">
							
					
							<label class="control-label col-sm-2">Title</label>
							
							<div class="col-sm-10">
								<input name="title" type="text" class="form-control input-xlarge" value="">
							</div>
						
						</div>
						
						
						
						
						<div class="form-group">
							
						
							<label class="control-label col-sm-2">Content</label>
							
							<div class="col-sm-10">
								<textarea name="content" class="form-control input-xlarge editor" rows="10"></textarea>
							</div>
						
						</div>
					
					
						<div class="form-group">
							<label class="control-label col-sm-2"></label>
							<div class="controls col-sm-10">
								<button type="submit" class="btn btn-success">
									Publish
								</button>
						
							</div>
						</div>
					
				</form>
			
			
			</div>
											
		</div>
		
	</div>
	
	
	
	
	
	
	<div class="panel panel-default">
		
		<div class="panel-heading hidden-click">
		
			<h3 class="panel-title">Analytics</h3>
			
		</div>
		
		<div class="hidden-content panel-body">
			
			
			<div class="well">
	
	
				<form action="" method="post" role="form" class="form form-horizontal">
					
						
						
						<div class="form-group">
							
						
							<label class="control-label col-sm-2">Analytics</label>
							
							<div class="col-sm-10">
								<textarea name="content" class="form-control input-xlarge" rows="10"></textarea>
							</div>
						
						</div>
					
					
						<div class="form-group">
							<label class="control-label col-sm-2"></label>
							<div class="controls col-sm-10">
								<button type="submit" class="btn btn-success">
									Save
								</button>
						
							</div>
						</div>
					
				</form>

	
			</div>
	
	
	
											
		</div>
		
	</div>
	
	
	
	
	
	
</div>

<?php } ?>