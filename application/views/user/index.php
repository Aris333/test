<!-- page content -->
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="title_left">
        <h3>Users</h3>
        
      </div>


    </div>
    <button onclick="window.location.href = '<?php echo base_url("user/addUser"); ?>';" type="reset" class="btn btn-primary" style="float: right;"><i class="fa fa-plus"></i> Add New</button>
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_content">

            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Total Credits</th>
                  <th>Free Credits</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                if( sizeof($allUser) > 0){
                    $i=1;
                    foreach( $allUser as $user){
                    ?>
                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $user->txtName; ?></td>
                      <td><?php echo $user->txtEmail; ?></td>
                      <td><?php echo $user->txtPhone; ?></td>
                      <td><?php echo $user->txtTotalCredit; ?></td>
                      <td>
                      <?php echo $user->txtFreeCredit; ?>
                        
                      <a onclick="return confirm('Do you want send 300 Free Credits to this user ?')" href="<?php echo base_url("user/freeCredit/".$user->txtUID); ?>" class="btn btn-success btn-xs">Credit</a>
                    </td>
                      <td>
                        <a href="<?php echo base_url("user/view/".$user->txtUID); ?>" class="btn btn-info btn-xs">View</a>                        
                        <a onclick="return confirm('Do you want remove this user ?')" href="<?php echo base_url("user/delete/".$user->txtUID); ?>" class="btn btn-danger btn-xs">Delete</a>
                      </td>
                    </tr>
                    <?php    
                    $i++;
                    }
                }else{
                    
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