<?php
/*
Template part for facebook login page

Created: February 2014
*/

require_once(dirname(__FILE__) . '/../core/config.php');
require_once(dirname(__FILE__) . '/../core/openid.php');


        $openid = new LightOpenID(SITE_URL);
        
        $this->loggedIn = false;
        
        if(isset($_GET['fblogin'])) {

            $this->id = $_GET['id'];
            $this->name = $_GET['first'];
            $this->email = $_GET['email'];
            
            $this->login();
        }
        else {

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
                        //console.log(response);
                        //alert(response.email);
                        
                
                        //window.location.href = <?php echo '"' . SITE_URL . '"' ?>;
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
    
	    <div class="container">
	    <h2 id="title-login">Login</h2>

        <a onclick="FB.login();"><img src="../img/FacebookLoginButton.png"></img></a>
        <br/>
        <br/>
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
