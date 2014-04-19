<?php
/*
Template part for facebook login page

Created: February 2014
*/

require_once(dirname(__FILE__) . '/../core/config.php');
require_once(dirname(__FILE__) . '/../core/openid.php');

/*
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
-->*/
        $openid = new LightOpenID(SITE_URL);
        
        $this->loggedIn = false;

        if ($openid->mode) {
            if ($openid->mode == 'cancel') {
                throw new Exception("User has canceled authentication!");
            } elseif($openid->validate()) {
                $data = $openid->getAttributes();
                $this->email = $data['contact/email'];
                
                if (array_key_exists('namePerson/first', $data)) {
                    $this->name = $data['namePerson/first'];
                }
                else {
                    $this->name = $this->email;
                }
                
                $this->id = $openid->identity;
                
                $this->login();
            }
        }
        else {
            if(isset($_GET['oid'])) {
                $oid = $_GET['oid'];

                $openid->identity = $oid;
            
                $openid->required = array(
                  'namePerson/first',
                  'contact/email',
                );

                $openid->returnUrl = SITE_URL . 'login-alternative/';
                header('Location: ' . $openid->authUrl());
            }
        }

        if ($this->loggedIn) {

                header("refresh:2;url=" . SITE_URL);
    ?>
                <div class="container">
                <h2>Login</h2>
		
		        <div class="alert alert-success">
			        <strong><?php echo $this->loginMessage; ?></strong>
			        You are successfully logged in!
		        </div>
    <?php
        }
        else {
    ?>
	    <div class="container">
	    <h2 id="title-login">Login</h2>

        <a href="?oid=https://www.google.com/accounts/o8/id"><img src="../img/Google.png"></img></a>
        <br/>
        <br/>
        <a href="?oid=https://openid.stackexchange.com"><img src="../img/StackExchange.png"></img></a>
        <br/>
        <br/>
        <a href="?oid=https://me.yahoo.com"><img src="../img/Yahoo.png"></img></a>
        <br/>
        <br/>
        <a href="?oid=https://username.wordpress.com/"><img src="../img/Wordpress.png"></img></a>
        <br/>
        <br/>
        <form role="form" action="<?php echo SITE_URL; ?>login-alternative/" method="get">
       		 <div class="form-group">
       			<input name="oid" class="form-control" type="text" placeholder="OpenID Provider" id="provider">
       			
       			<button type="submit" class="btn btn-default">Login</button>
       		</div>
       	</form>
         

    <?php	
	    }
?>

</div>
