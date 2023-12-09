<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Add User</h3>
      </div>


    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_content">
            <br>
            <?php if( isset($_GET["msg"]) && $_GET["msg"]=="2"){ ?><div  id="message"><div class="col-lg-12 alert alert-danger alert-dismissible fade in" role="alert"><strong>This email id is already exist</strong></div></div><?php } ?>
            <form class="form-horizontal form-label-left" data-parsley-validate="" id="addUserForm" novalidate="" action="<?php echo base_url("user/insertUser"); ?>" method="post">
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtName"  name="txtName" >
                </div>
              </div>
              
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtEmail" name="txtEmail" >
                </div>
              </div>
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Phone <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtPhone" name="txtPhone" >
                </div>
              </div>
              
             
              
              

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button onclick="window.location.href = '<?php echo base_url("user"); ?>';" type="reset" class="btn btn-primary">Cancel</button>
                  <button class="btn btn-success" type="submit">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<!-- /page content -->