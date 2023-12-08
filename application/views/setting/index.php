<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="col-md-12">
        <h3 class="pull-left">Setting</h3>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
                    <br>
                    <div id="appnd" class="text-center"></div>
                    <form id="mobile_form1" class="form-horizontal form-label-left" data-parsley-validate=""  novalidate="" action="<?php echo base_url("setting/save"); ?>" method="post">
                        <?php 
                        foreach ($allSettings as $setting) { ?>
                          <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name"><?php echo $setting['txtlable']; ?><span class="required">*</span>
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <input id="<?php echo $setting['txtkey']; ?>" class="form-control col-md-7 col-xs-12" required="required" type="text" name="<?php echo $setting['txtkey']; ?>" value="<?php echo $setting['txtvalue']; ?>" pattern="[+]?\d*">
                            </div>
                          </div>
                        <?php 
                        }
                        ?>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                           <button class="btn btn-success" type="submit" id="savePromoCode">Submit</button>
                        </div>
                      </div>
                    </form>  
            </div><!-- /x_conten -->
          </div><!-- /x_panel -->
        </div><!-- /col-md-12 -->
      </div><!-- /row -->
    </div> <!-- /page-title -->
  </div> <!-- / -->
</div> <!-- /right_col -->

<!-- /page content -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.16.0/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assests/js/form-validate.js"></script>
<script type="text/javascript">
    
$(document).ready(function(){
  $( "#mobile_form" ).submit(function( event ) {
  event.preventDefault();
  var mobile=$("#txtvalue").val();
  var mobile2=$("#txtvalue2").val();
  $.ajax({  
            url:"<?php echo base_url("setting"); ?>/add_mobile_num",
            type: "post", 
            data: {'txtvalue':mobile,'txtvalue2':mobile2},                 
            success: function (response){
                  if(response==true)
                  {
                    $("#appnd").html("Mobile Number is added Successfully").css("color", "green");
                    $("#txtvalue").val("");
                    $("#txtvalue2").val("");
                  }
                  else
                  {
                     $("#appnd").html("Sorry Try Again !").css("color", "green").fadeOut(8000);
                  }
            }
        });
     });
  }); // end of doc ready
</script>