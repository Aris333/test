<?php
$segment=$this->uri->segment(3); 
// echo $segment; 
// echo "<pre>";
//  print_r($allpayment[1]->txtStatus);  echo "</pre>";   
 // $b=$allpayment[1]->txtStatus;
 // if($segment==$b){ echo "matched"; } exit();
// foreach($allpayment as $row){

//    echo $row->txtPaymentID;
// }exit();
?> 
<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="col-md-12">
        <h3 class="pull-left">Payment(s)</h3>
      <!--   <?php if( isset($_GET["msg"]) && $_GET["msg"]=="1"){ ?><div  id="message"><div class="col-lg-12 alert alert-danger alert-dismissible fade in" role="alert"><strong>Promocode is deleted..</strong></div></div><?php } ?>
        
        <div class="btn-group pull-right" >
          
          
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
          
          
        </div>
        <div class="pull-right"><button onclick="window.location.href = '<?php echo base_url("promocode/add"); ?>';" class="btn btn-primary " style="margin-right: 5px;"><i class="fa fa-plus"></i> Add New</button></div>


      </div>
   -->

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
                  <th>Order ID.</th>
                  <th>Date</th>
                  <th>App</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th>Totals</th>
            
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($allpayment as $k=>$row) {
                ?>
                        <tr>
                          <td><?php echo $k+1; ?></td>
                          <td><a href="#"><?php echo $row->txtOrderID; ?></a></td>
                          <td><?php echo $row->txtDate; ?></td>
                          <td><?php echo $row->txtApp; ?></td>
                          <td><?php echo $row->txtType; ?></td>
                          <td><?php echo $row->txtStatus; ?></td>
                          <td><?php echo $row->txtTotal; ?></td>
       
                        </tr>
                <?php
                }
                ?>
              </tbody>

            </table>
            </div><!-- /x_conten -->

          </div><!-- /x_panel -->
        </div><!-- /col-md-12 -->
      </div><!-- /row -->

    </div> <!-- /page-title -->
  </div> <!-- / -->
</div> <!-- /right_col -->




<!-- /page content -->