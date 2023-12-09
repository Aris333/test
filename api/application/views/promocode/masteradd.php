<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Add Promo code Master</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <br>
              <?php if( isset($_GET["msg"]) && $_GET["msg"]=="2"){ ?><div  id="message"><div class="col-lg-12 alert alert-danger alert-dismissible fade in" role="alert"><strong>Promocode is already exist</strong></div></div><?php } ?>
              <form class="form-horizontal form-label-left" data-parsley-validate="" id="addPromocodeForm" novalidate="" action="<?php echo base_url("promocodemaster/addPromo"); ?>" method="post">
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Promo code <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="text" class="form-control col-md-7 col-xs-12"  id="txtPromoCode" name="txtPromoCode" >
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
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                       <?php
                      }
                      ?>
                  </select>
                </div>
              </div>
              <input type="hidden" name="NumberOfUserd" value="0">
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">                  
                  <input type="checkbox" class="js-switch " name="txtStatus" checked="checked"/>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-primary" type="button" onclick="window.location.href = '<?php echo base_url("promocodemaster"); ?>';">Cancel</button>
                  <button class="btn btn-success" type="submit" id="savePromoCode">Submit</button>
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