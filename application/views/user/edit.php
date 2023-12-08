<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit User</h3>
      </div>


    </div>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_content">
            <br>
            <form class="form-horizontal form-label-left" data-parsley-validate="" id="demo-form2" novalidate="">
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Name <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtName" readonly="" name="txtName" value="<?php echo $userData->txtName ?>">
                </div>
              </div>
              
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Email <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtEmail" readonly="" name="txtEmail" value="<?php echo $userData->txtEmail ?>">
                </div>
              </div>
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Credit <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtTotalCredit" readonly="" name="txtTotalCredit" value="<?php echo $userData->txtTotalCredit ?>">
                </div>
              </div>
              
              

              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-primary" type="submit">Cancel</button>
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