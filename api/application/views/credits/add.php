<?php
//echo "<pre>"; print_r($ALL_Country_list); exit();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Add Credits</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <br>
              <?php if($this->session->flashdata('credit_add')){?>
                        <div class="alert alert-success">      
                        <?php echo $this->session->flashdata('credit_add')?>
                        </div>
               <?php } ?>
               <div class="alert alert-success" id="msg_4_present" style="display:none;">      
                        <span>credit alredy assign to this country</span>
               </div>
              <form class="form-horizontal form-label-left" data-parsley-validate="" id="addPromocodeForm" novalidate="" action="<?php echo base_url("credits/add"); ?>" method="post">
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Country <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <!-- <input type="text" class="tags tags-input" data-type="tags" name="country[]" required="required"> -->
                  <select multiple="multiple" name="countryids[]" class="form-control col-md-7 col-xs-12 countryids" id="countryids" required="required">
                  <?php
                  foreach ($ALL_Country_list as $key => $value) {  
                    echo "<option id='countryids' value='".$value->id."'>".$value->county_name."</option>";
                  }
                  ?>
                  </select>  
                </div>
              </div>
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12" >Credits <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" class="form-control col-md-7 col-xs-12" required="required" id="txtPromoCode" name="credits" min=0>
                </div>
                </div>
            
              
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">                  
                  <input type="checkbox" class="js-switch " name="txtStatus" />
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-primary" type="button" onclick="window.location.href = '<?php echo base_url("Credits"); ?>';">Cancel</button>
                  <button class="btn btn-success" type="submit" id="savecredits">Submit</button>
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

