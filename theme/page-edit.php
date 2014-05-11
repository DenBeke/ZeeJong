<?php
/*
Template part for referee page

Created: February 2014
*/
?>

<div class="container">


	<h2>Update page</h2>


	<div class="well">
		
	
		<form action="<?php echo SITE_URL . 'page/' . $this->page->getId() . '/edit'; ?>" method="post" role="form" class="form form-horizontal">
			
			
				<div class="form-group">
					
			
					<label class="control-label col-sm-2">Title</label>
					
					<div class="col-sm-10">
						<input name="title" type="text" class="form-control input-xlarge" value="<?php echo $this->page->getTitle(); ?>">
					</div>
				
				</div>
				
				
				
				
				<div class="form-group">
					
				
					<label class="control-label col-sm-2">Content</label>
					
					<div class="col-sm-10">
						<textarea name="content" class="form-control input-xlarge" rows="10"><?php echo $this->page->getContent(); ?></textarea>
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