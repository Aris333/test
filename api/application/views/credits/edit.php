<?php
// echo "<pre>"; print_r($getCreditById); exit();
//echo "<pre>"; print_r($ALL_Country_list); exit();
//echo "<pre>n"; print_r($remain_country); exit();
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Edit Credits</h3>
      </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <br>
              <?php if($this->session->flashdata('credit_edit')){?>
                        <div class="alert alert-success">      
                        <?php echo $this->session->flashdata('credit_edit')?>
                        </div>
               <?php } ?>
              <form class="form-horizontal form-label-left" data-parsley-validate="" id="addPromocodeForm" novalidate="" action="<?php echo base_url("credits/edit"); ?>" method="post">

              <input type="hidden" name="hidenid" value="<?php echo $getCreditById[0]->id; ?>">
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Country <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                  <!-- <input type="text" class="tags tags-input" data-type="tags" name="country[]" required="required"> -->
                  <ul id="myList">
                  <?php
                  $arry_cntryId=explode(',',$getCreditById[0]->county_id);
                  foreach ($ALL_Country_list as $key => $value) {

                    if(in_array($value->id,$arry_cntryId)){ 
                  ?>
                     <li> <input type="checkbox" name="selected_country[]" value="<?php echo $value->id;?>" checked> 
                     <input type="hidden" value="<?php echo $value->id;?>" name="last_one">
                           <?php echo $value->county_name; ?>&nbsp;&nbsp;&nbsp;</li>
                    <?php       
                    }
                 
                  }
                 ?>
                 </ul>

                
                <!--  <select multiple="multiple" name="countryids[]" class="form-control col-md-7 col-xs-12" required="required" >
                 <?php
                 foreach ($remain_country as $key => $value) { 
                    ?>
                  <option value="<?php echo $value[0]->id ?>" ><?php echo $value[0]->county_name ?></option>
                    <?php 
                  }
                  ?>
                 </select> -->


<!-- 
                  <select multiple="multiple" name="countryids[]" class="form-control col-md-7 col-xs-12" required="required" >
                  <?php
                  $arry_cntryId=explode(',',$getCreditById[0]->county_id);
                
                  foreach ($ALL_Country_list as $key => $value) { 
                    ?>
                   
                    <option value="<?php echo $value->id ?>" <?php
                        if(in_array($value->id,$arry_cntryId)){ echo "selected";}

                    ?> ><?php echo $value->county_name ?></option>
                    <?php 
                  }
                  ?>
                  </select> -->  


                </div>
              </div>

              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Remaining Country <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12"> 
                 <ul id="myList2">
                  <?php
                  if($remain_country !='')
                  {
                    foreach ($remain_country as $key => $value) {

                     ?>
                       <li> <input type="checkbox" name="remain_country[]" value="<?php echo $value[0]->id;?>" > 
                             <?php echo $value[0]->county_name; ?>&nbsp;&nbsp;&nbsp;</li>
                      <?php       
                   
                    }
                   }else{

                       echo "<span>No Country</span>";
                   }
                 ?>
                 </ul>
                </div>
              </div>

              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12" >Credits <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="number" class="form-control col-md-7 col-xs-12" required="required" id="txtPromoCode" name="credits" value="<?php echo $getCreditById[0]->credits; ?>" min=0>
                </div>
                </div>
            
              
              
              <div class="form-group">
                <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Status <span class="required">*</span>
                </label>
                <?php if($getCreditById[0]->status==0){
                           $checked="";
                        }else{
                          $checked="checked";
                       }
              
                ?>
                <div class="col-md-6 col-sm-6 col-xs-12">                  
                  <input type="checkbox" class="js-switch " name="txtStatus" <?php echo $checked; ?> />
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                  <button class="btn btn-primary" type="button" onclick="window.location.href = '<?php echo base_url("Credits"); ?>';">Cancel</button>
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
