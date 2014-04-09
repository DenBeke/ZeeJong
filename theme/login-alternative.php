<?php
/*
Template part for facebook login page

Created: February 2014
*/

require_once(dirname(__FILE__) . '/../core/openid.php');

?>
<!--
<script>
  window.fbAsyncInit = function() {
  FB.init({
    appId      : '673221049405018',
    status     : true, // check login status
    cookie     : true, // enable cookies to allow the server to access the session
    xfbml      : true  // parse XFBML
  });
  
  
    FB.login(function(response) {
           if (response.authResponse) {
               FB.api('/me', function(response) {
               FB.logout(function(response) {
                               console.log('Logged out.');
                           });
                   });
           } else {
               console.log('User did not authorize.');
           }
       });

  // Here we subscribe to the auth.authResponseChange JavaScript event. This event is fired
  // for any authentication related change, such as login, logout or session refresh. This means that
  // whenever someone who was previously logged out tries to log in again, the correct case below 
  // will be handled. 
  FB.Event.subscribe('auth.authResponseChange', function(response) {
    // Here we specify what we do with the response anytime this event occurs. 
    if (response.status === 'connected') {
throw new Exception("Connected");
      // The response object is returned with a status field that lets the app know the current
      // login status of the person. In this case, we're handling the situation where they 
      // have logged in to the app.
      testAPI();
    } else if (response.status === 'not_authorized') {
throw new Exception("Not Authorized");
      // In this case, the person is logged into Facebook, but not into the app, so we call
      // FB.login() to prompt them to do so. 
      // In real-life usage, you wouldn't want to immediately prompt someone to login 
      // like this, for two reasons:
      // (1) JavaScript created popup windows are blocked by most browsers unless they 
      // result from direct interaction from people using the app (such as a mouse click)
      // (2) it is a bad experience to be continually prompted to login upon page load.
      FB.login();
    } else {
throw new Exception("Else");
      // In this case, the person is not logged into Facebook, so we call the login() 
      // function to prompt them to do so. Note that at this stage there is no indication
      // of whether they are logged into the app. If they aren't then they'll see the Login
      // dialog right after they log in to Facebook. 
      // The same caveats as above apply to the FB.login() call here.
      FB.login();
    }
  });
  };

  // Load the SDK asynchronously
  (function(d){
   var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement('script'); js.id = id; js.async = true;
   js.src = "//connect.facebook.net/en_US/all.js";
   ref.parentNode.insertBefore(js, ref);
  }(document));

  // Here we run a very simple test of the Graph API after login is successful. 
  // This testAPI() function is only called in those cases. 
  function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function(response) {
      console.log('Good to see you, ' + response.name + '.');
    });
  }
</script>
-->
<div class="container">


<?php
    $openid = new LightOpenID("localhost");
    
    $this->loggedIn = false;

    if ($openid->mode) {
        if ($openid->mode == 'cancel') {
            throw new Exception("User has canceled authentication!");
        } elseif($openid->validate()) {
            $data = $openid->getAttributes();
            $this->email = $data['contact/email'];
            $this->name = $data['namePerson/first'];
            $this->id = $openid->identity;
            
            $this->login();
        }
    }

    if ($this->loggedIn) {
?>
            <h2></h2>
		
		    <div class="alert alert-success">
			    <strong><?php echo $this->loginMessage; ?></strong>
			    You are successfully logged in!
		    </div>
<?php
    }
    else {
    
	/*
	if($this->loggedIn) {
		?>
		<h2></h2>
		
		<div class="alert alert-success">
			<strong><?php echo $this->loginMessage; ?></strong>
			You are successfully logged in!
		</div>
		<?php
	}
	else {*/
?>
	
	<h2 id="title-login">Login</h2>
	<!--
	<div class="alert alert-danger">
		<strong>Error</strong> 
		<?php echo $this->loginMessage; ?>
	</div>
	

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
	</div>
	-->
	
	<?php
        $openid->identity = 'https://www.google.com/accounts/o8/id';
        $openid->required = array(
          'namePerson/first',
          'contact/email',
        );

        $openid->returnUrl = 'http://localhost/zeejong/login-alternative/';
    ?>

    <a href="<?php echo $openid->authUrl(); ?>" class="btn btn-default">Login with Google</a>

	
	<!--
	<div class="well">
	    <div class="form-group">
	        <label class="control-label col-sm-2">Username</label>
		    <div class="controls col-sm-10">
			    <div class="input-group">
				    <span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
				    <input type="text" class="form-control input-xlarge" id="username" name="username" placeholder="Username">
			    </div>
		    </div>
	    </div>
	</div>
	-->
	
<?php	
	}
?>

</div>
