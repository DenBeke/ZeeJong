<?php
/*
 Template part for the create group page

 Created: April 2014
 */
?>

<div class="container">

    <h1>Invite a user to one of your groups</h1>
    <?php
    if(!loggedIn()){
    // User is not logged in

    ?>
    <div class="alert alert-danger">
        <strong>You are not logged in.</strong>
    </div>
    <?php
    }else{
    if(strlen($this->getErrorMessage())>0){
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
    // Display 'invite user' form
    ?>



    <div class="well">
        <form id="inviteUser" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL ?>invite-user">
            <div class="form-group">
                <label class="control-label col-sm-2">User to invite</label>
                <div class="controls col-sm-10">
                    <div class="input-group">
                        <span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
                        <input type="text" class="form-control input-xlarge" id="userName" name="userName" placeholder="Username">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Group</label>
                <div class="controls col-sm-10">
                    <div class="input-group">
                        <span class="add-on input-group-addon"> <span class="glyphicon glyphicon-user"></span> </span>
                        <select class="form-control" name="groupName" >
                            <?php
                            foreach($this->getGroups() as $groupName){
                                ?>
                                    <option value="<?php echo $groupName ?>"><?php echo $groupName ?></option>
                                <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2"></label>
                <div class="controls col-sm-10">
                    <button type="submit" class="btn btn-success" >
                        Invite!
                    </button>

                </div>
            </div>
        </form>
    </div>

</div>
<?php
}
?>
