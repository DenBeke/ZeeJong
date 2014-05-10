<?php
/*
Template part for login page

Created: February 2014
*/

require_once(dirname(__FILE__) . '/../core/config.php');
require_once(dirname(__FILE__) . '/../core/openid.php');
?>


<div class="container">

	<?php
	if($this->loggedIn) {
		?>
		<div class="alert alert-success">
			<strong><?php echo $this->loginMessage; ?></strong><br/>
			You are successfully logged in!
		</div>
		<?php
	}
	else {
	?>

	<script>
        window.fbAsyncInit = function() {
            FB.init({
              appId      : '673221049405018',
              status     : true, // check login status
              cookie     : true, // enable cookies to allow the server to access the session
              xfbml      : true  // parse XFBML
            });

            FB.Event.subscribe('auth.authResponseChange', function(response) {
                if (response.status === 'connected') {

                    FB.api('/me', function(response) {
                        window.location.href = <?php echo '"' . SITE_URL . 'login-alternative/' . '"' ?>
                                               + "?fblogin=1"
                                               + "&id=" + response.id
                                               + "&first=" + response.first_name
                                               + "&email=" + response.email;
                    });
                }
            });
        };

        // Load the Facebook SDK asynchronously
        (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
        }(document));
    </script>

	<h2 id="title-login">Login</h2>

	<?php
	if ($this->loginMessage) {
	?>
	    <div class="alert alert-danger">
		    <strong>Error</strong>
		    <?php echo $this->loginMessage; ?>
	    </div>
	<?php
	}
	?>

	<div class="well">
		<form id="signup" class="form-horizontal" method="post" action="<?php echo SITE_URL; ?>login">

			<div class="form-group">
				<label class="control-label col-sm-2">Username</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
						<input type="text" class="form-control input-xlarge" id="username" name="username" placeholder="Username">
					</div>
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-sm-2">Password</label>
				<div class="controls col-sm-10">
					<div class="input-group">
						<span class="add-on input-group-addon"> <span class="glyphicon glyphicon-lock"></span> </span>
						<input type="Password" class="form-control input-xlarge" id="password" name="password" placeholder="Password">
					</div>
				</div>
			</div>


			<div class="form-group">
				<label class="control-label col-sm-2"></label>
				<div class="controls col-sm-10">
					<button type="submit" class="btn btn-success" >
						Login
					</button>

				</div>
			</div>

		</form>


		<div class="social-buttons">
			
			<a id="facebook" onclick="FB.login();">Facebook</a>
			
			<a id="google" href="?oid=https://www.google.com/accounts/o8/id">Google+</a>
			
			<!-- <a href="?oid=https://openid.stackexchange.com"><img src="<?php echo SITE_URL; ?>/img/StackExchange.png"></img></a> -->
			
			<a id="yahoo" href="?oid=https://me.yahoo.com">Yahoo</a>
			
			<a id="wordpress" href="?oid=https://username.wordpress.com/">Wordpress</a>


			<div class="btn-group">
			<a class="dropdown-toggle" type="button" data-toggle="dropdown" id="openid">OpenId Provider</a>
			  <ul class="dropdown-menu">
				<form role="form" action="<?php echo SITE_URL; ?>login-alternative/" method="get">
					 <div class="form-group">
						<input name="oid" class="form-control" type="text" placeholder="OpenID Provider" id="provider" data-stopPropagation="true">
				
						<button type="submit" class="btn btn-default">Login</button>
					</div>
				</form>
			  </ul>
			</div>

			
		</div>



	</div>


	<?php
	}
	?>

</div>
