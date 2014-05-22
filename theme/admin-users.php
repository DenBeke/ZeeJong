<?php
include (dirname(__FILE__) . '/admin.php');
 ?>

<div class="container">
<?php

if(isAdmin()){


    if(strlen($this-> getErrorMessage())>0){
    // there were errors, let's display them
    ?>
    <div class="alert alert-danger">
        <strong> <?php
        echo nl2br($this -> getErrorMessage());
        ?></strong>
    </div>

    <?php
    }
    if(strlen($this->getSuccessMessage())>0){
    // at least one thing succeeded, let's display what
    ?>
    <div class="alert alert-success">
        <strong> <?php
        echo nl2br($this -> getSuccessMessage());
        ?></strong>
    </div>
    <?php
    }
    // Display 'change settings' form
    ?>



<div class="col-md-5">
<h3>Ban a user</h3>
<div class="well">
    <form id="signup" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>admin/users">
        <div class="form-group">
            <label class="control-label col-sm-2">User name</label>
            <div class="controls col-sm-10">
                <div class="input-group">
                    <span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
                    <input type="text" class="form-control input-xlarge" id="nameBan" name="nameBan" placeholder="name">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2"></label>
            <div class="controls col-sm-10">
                <button type="submit" class="btn btn-success" >
                    Ban
                </button>
            </div>
        </div>
    </form>
</div>




<h3>Make a user admin</h3>
<div class="well">
    <form id="signup" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>admin/users">
        <div class="form-group">
            <label class="control-label col-sm-2">User name</label>
            <div class="controls col-sm-10">
                <div class="input-group">
                    <span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
                    <input type="text" class="form-control input-xlarge" id="nameMakeAdmin" name="nameMakeAdmin" placeholder="name">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2"></label>
            <div class="controls col-sm-10">
                <button type="submit" class="btn btn-success" >
                    Make admin
                </button>
            </div>
        </div>
    </form>
</div>


<h3>Take admin rights from user</h3>
<div class="well">
    <form id="signup" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>admin/users">
        <div class="form-group">
            <label class="control-label col-sm-2">User name</label>
            <div class="controls col-sm-10">
                <div class="input-group">
                    <span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
                    <input type="text" class="form-control input-xlarge" id="nameRemoveAdmin" name="nameRemoveAdmin" placeholder="name">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2"></label>
            <div class="controls col-sm-10">
                <button type="submit" class="btn btn-success" >
                    Remove admin rights
                </button>
            </div>
        </div>
    </form>
</div>


</div>
</div>

<?php } ?>