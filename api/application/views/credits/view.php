<?php
// echo "<pre>df"; print_r($country); exit();
$status=array("InActive","Active");
?>

<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Credits View</h3>
      </div>


    </div>
<button onclick="window.location.href = '<?php echo base_url("credits"); ?>';" type="reset" class="btn btn-primary" style="float: right;">Go Back</button>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_content">
            <br>
            
            <table class="table detailViewTable">
              <tbody>
                <tr>
                  <th>Country</th>
                  
                  <td>
                    <?php 
                     $strTOArry=explode(",",$getCreditById[0]->county_id); 
                     for($i=0;$i<count($strTOArry);$i++){

                           echo $country[$strTOArry[$i]].",";
                     }
                     ?>
                  </td>
                </tr>
                <tr>
                  <th>Credits</th>
                  <td><?php echo $getCreditById[0]->credits ?></td>
                </tr>
                <tr>
                  <th>Status</th>
                  <td><?php echo $status[$getCreditById[0]->status] ?></td>
                </tr>
                <tr>
                  <th>Created</th>
                  <td><?php echo $getCreditById[0]->created;  ?></td>
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