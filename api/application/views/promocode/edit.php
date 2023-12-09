<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Promo code</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <br>
            <form class="form-horizontal form-label-left" data-parsley-validate="" id="editPromoCpdeForm" novalidate="" method="post" action="<?php echo base_url("promocode/updatePromoCode/".$promocodeData->txtPromoID);?>">
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Promo code <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12" required="required" disabled="" id="txtPromoCode" value="<?php echo $promocodeData->txtPromoCode ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Start Date <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12 dateTimePicker" required="required" readonly="" id="txtStartDate" name="txtStartDate" value="<?php echo DateFormat($promocodeData->txtStartDate) ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">End Date <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12 dateTimePicker" required="required" readonly="" id="txtEndDate" name="txtEndDate" value="<?php echo DateFormat($promocodeData->txtEndDate) ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Total Credit <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <select id="txtTotalCredit" class="form-control col-md-7 col-xs-12" name="txtTotalCredit">
                      <?php 
                      for( $i=10;$i<=100;$i=$i+10 ){
                       ?>
                        <option value="<?php echo $i; ?>" <?php echo ($promocodeData->txtTotalCredit == $i ? 'selected' : ''); ?>><?php echo $i; ?></option>
                       <?php
                      }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Number Of Times Used<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                   <select id="NumberOfUserd" class="form-control col-md-7 col-xs-12" name="NumberOfUserd">
                      <?php 
                      for( $i=1;$i<=5;$i++ ){
                       ?>
                        <option value="<?php echo $i; ?>" <?php echo ($promocodeData->NumberOfUserd == $i ? 'selected' : ''); ?>><?php echo $i; ?></option>
                       <?php
                      }
                      ?>
                  </select>
                </div>
              </div>
              <?php 
              if( $promocodeData->txtStatus == "Active"){
                    $checked = 'checked="checked"';
                }elseif( $promocodeData->txtStatus == "Inactive"){
                    $checked = "";
                }else{
                    $checked = "";
                }
              ?>
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="checkbox" class="js-switch" name="txtStatus"  <?php echo $checked; ?>  />
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-primary" type="reset" onclick="window.location.href = '<?php echo base_url("promocode"); ?>';">Cancel</button>  
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