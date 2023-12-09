<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Promo code View</h3>
      </div>


    </div>
<button onclick="window.location.href = '<?php echo base_url("promocode"); ?>';" type="reset" class="btn btn-primary" style="float: right;">Go Back</button>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_content">
            <br>
            
            <table class="table detailViewTable">
              <tbody>
                <tr>
                  <th>Promo code</th>
                  
                  <td><?php echo $promocodeData->txtPromoCode ?></td>

                </tr>
                <tr>
                  <th>Total Credit</th>
                  <td><?php echo $promocodeData->txtTotalCredit ?></td>
                </tr>
                <tr>
                  <th>Number Of Times Used</th>
                  <td><?php echo $promocodeData->NumberOfUserd ?></td>
                </tr>
                <!-- <tr>
                  <th>Used By</th>
                  <td><?php //echo $promocodeData->txtName ?></td>

                </tr> -->
                <tr>
                  <th>Status</th>
                  <td><?php echo $promocodeData->txtStatus; //echo DateFormat($promocodeData->txtDateUsed) ?></td>
                </tr>
                
              </tbody>
            </table>


          </div>
        </div>
      </div>


    </div>
  </div>
</div>
<!-- /page content -->