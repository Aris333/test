<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="col-md-12">
        <h3 class="pull-left">Promo code</h3>
        <?php if( isset($_GET["msg"]) && $_GET["msg"]=="1"){ ?><div  id="message"><div class="col-lg-12 alert alert-danger alert-dismissible fade in" role="alert"><strong>Promocode is deleted..</strong></div></div><?php } ?>
        <!-- hidden<div class="btn-group pull-right" >
          <button class="btn btn-primary" type="button">Generate Promocode</button>
          <button class="btn btn-primary dropdown-toggle arrowDown" type="button">
            <span class="caret "></span>
            <span class="sr-only">Toggle Dropdown</span>
          </button>
          <ul class="dropdown-menu" role="menu" id="randomPromoWrapper" style="display: none;">
            <li>
              <label>How many Promocode ?</label>
              <select id="txtPromoCounter" class="" name="txtPromoCounter" >
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>                
              </select>
            </li>
            <li>
              <button id="btnGeneratePromocode" class="btn btn-success btn-sm">Generate Promocodes</button>
            </li>
          </ul>
        </div> -->
        <div class="pull-right"> <a href="<?php echo base_url("promocode/deleteAll"); ?>"> <button onclick="return confirm('Do you want remove all Promocode?')" class="btn btn-danger " style="margin-right: 5px;"><i class="fa fa-trash"></i> Delete All</button></a> </div>
        <div class="pull-right"><button onclick="window.location.href = '<?php echo base_url("promocode/add"); ?>';" class="btn btn-primary " style="margin-right: 5px;"><i class="fa fa-plus"></i> Add New</button></div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Code</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Total Credit</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                if (sizeof($allPromocodes) > 0) {
                    $i = 1;
                    foreach ($allPromocodes as $promocode) {
                        $checked="";
                        if ($promocode->txtStatus == "Active") {
                            $checked = 'checked="checked"';
                            $hiddenEdit = 'hidden';
                            $hiddenRemove = 'hidden';
                            $hiddenSend = '';
                        } elseif ($promocode->txtStatus == "Inactive") {
                            $checked = "";
                            $hiddenEdit = '';
                            $hiddenRemove = '';
                            $hiddenSend = 'hidden';
                        } else {
                            $checked = "";
                            $hiddenEdit = 'hidden';
                            $hiddenRemove = 'hidden';
                            $hiddenSend = 'hidden';
                        }
                        
                        ?>
                        <tr>
                          <td><?php echo $i; ?></td>
                          <td><?php echo $promocode->txtPromoCode; ?></td>
                          <td><?php echo $promocode->txtStartDate; ?></td>
                          <td><?php echo $promocode->txtEndDate; ?></td>
                          <td><?php echo $promocode->txtTotalCredit; ?></td>
                          <td>
                          <?php
                          if ($promocode->txtStatus == "Used") {
                              echo '<span class="label label-default">'.$promocode->txtStatus.'</span>';
                              ?>                               
                            <?php } else { ?>
                                <label>
                                  <input data-id="<?php echo $promocode->txtPromoID; ?>"  type="checkbox" class="js-switch txtPromoStatus" <?php echo $checked; ?>/>
                                </label>
                           <?php } ?>
                          </td>
                          <td class="actionWrapper">
                            <a href="<?php echo base_url("promocode/edit/" . $promocode->txtPromoID); ?>" class="btn btn-success btn-xs editPromoLink <?php echo $hiddenEdit; ?>">Edit</a>
                            <a onclick="return confirm('Are you sure you want to delete this Promo Code?');" href="<?php echo base_url("promocode/delete/" . $promocode->txtPromoID); ?>" class="btn btn-danger btn-xs removePromoLink <?php echo $hiddenSend; ?>">Delete</a> 
                           <!--  <?php if ($promocode->txtStatus == "Used") { ?>   <a href="<?php echo base_url("promocode/view/" . $promocode->txtPromoID); ?>" class="btn btn-info btn-xs viewPromoLink">View</a><?php } ?>  -->
                           <!--  <a href="#" class="btn btn-primary btn-xs sendPromoLink <?php echo $hiddenSend; ?>" data-id="<?php echo $promocode->txtPromoID; ?>" data-toggle="modal" data-target="#myModal" onclick="popupSendEmail('<?php echo $promocode->txtPromoCode; ?>', '<?php echo $promocode->txtTotalCredit; ?>');">Send</a> --> 

                             <a href="<?php echo base_url("promocode/view/" . $promocode->txtPromoID); ?>" class="btn btn-info btn-xs viewPromoLink">View</a> 
                          </td>
                        </tr>
                        <?php
                        $i++;
                    }
                } else {
                    
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Promocode to User</h4>
      </div>
      <div class="modal-body">
        <div style="" id="message"></div>
        <form class="form-horizontal form-label-left" data-parsley-validate="" id="sendPromoEmailForm" novalidate="">
          <div class="form-group">
            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Promocode <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtEmailPromoCode" readonly="" name="txtEmailPromoCode" >
            </div>
          </div>
          <div class="form-group">
            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Promocode Credit <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <input type="text" class="form-control col-md-7 col-xs-12" required="required" id="txtEmailTotalCredit" readonly="" name="txtEmailTotalCredit" >
            </div>
          </div>
          <div class="form-group">
            <label for="first-name" class="control-label col-md-3 col-sm-3 col-xs-12">Select User <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
              <select class="form-control select2" id="txtEmailUser" required=""> 
                <option value="">Select User</option>
                <?php
                foreach ($allUsers as $user) {
                    ?>
                    <option value="<?php echo $user->txtEmail; ?>"><?php echo $user->txtName; ?></option>
                    <?php
                }
                ?>
              </select>
              <p class="selectedUserEmailWrapper" style="display: none;">Promocode will be sent to below EmailID : <span class="selectedUserEmail"></span></p>
            </div>
          </div>
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
              <button id="sendEmailToUser" class="btn btn-success" type="button">Send</button>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer hidden">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->