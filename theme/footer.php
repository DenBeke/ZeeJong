<?php
/*
Template part for footer

Created: February 2014
*/
?>

	

	<div id="footer">
	  <div class="container">
	  	
	  	<hr />
	  
		<div class="copyright">&copy;2014 ZeeJong Betting System</div>
		
		<?php if(isAdmin()) { ?>
		<ul class="nav nav-pills">
		   <li class=""><a href="<?php echo SITE_URL . 'admin'; ?>">Admin</a></li>
		 </ul>
		 <?php } ?>
		
	  </div>
	  
	  
	</div>

</body>
</html>