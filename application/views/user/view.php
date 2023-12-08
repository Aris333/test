<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>View User</h3>
      </div>


    </div>
    
    <button onclick="window.location.href = '<?php echo base_url("user"); ?>';" type="reset" class="btn btn-primary" style="float: right;">Go Back</button>

    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_content">
            <br>
            
            
            <table class="table detailViewTable">
              <tbody>
                <tr>
                  <th>Name</th>
                  <td><?php echo $userData->txtName ?></td>

                </tr>
                <tr>
                  <th>Email</th>
                  <td><?php echo $userData->txtEmail ?></td>

                </tr>
                <tr>
                  <th>Phone</th>
                  <td><?php echo $userData->txtPhone ?></td>

                </tr>
                
                 
                
                
              </tbody>
            </table>
            <br>
            <table class = "table table-striped text-center">
                <h3>Promocode Used History</h3>

                <thead>
                   <tr class="text-center">
                     <th class="text-center">Promocode</th>
                     <th class="text-center">Total Credit</th>                      
                     <th class="text-center">Date of Used</th>                      
                   </tr>
                </thead>

                <tbody>
                   
                   <?php 
                   if(sizeof($usersPromoCodeData) > 0){
                       
                    foreach( $usersPromoCodeData as $userPromo ){
                        echo '<tr>';
                            echo '<td>'.$userPromo->txtPromoCode.'</td>';
                            echo '<td>'.$userPromo->txtTotalCredit.'</td>';
                            echo '<td>'.DateFormat($userPromo->txtDateUsed).'</td>';
                        echo '</tr>';
                    }
                   }else{
                    ?>
                    <tr class="text-center">
                      <td colspan="2">No promocode Used</td>                      
                   </tr>
                  <?php
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
<!-- /page content -->