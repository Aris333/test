<!-- page content -->
<style type="text/css">
  .lblalign{
    float: left;
  }
</style>
<div class="right_col" role="main">
  <div class="">
    <div class="page-title">
      <div class="col-md-12">
        <h3 class="pull-left">Fax</h3>
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

            <form class="form-horizontal form-label-left" data-parsley-validate="" id="filterby" action="<?php echo base_url("fax/filterby"); ?>/<?php echo $shorting_by; ?>" method="post">
            <input type="hidden" name="sorting_by" value="<?php echo $shorting_by; ?>">
              <div class="form-group">
                <label class="control-label lblalign">Filter By</label>
                <div class="col-md-2">
                  <select id="filter_by" class="form-control" name="filter_by" onchange="changeFilter(this);">
                    <option value="0">Select Filter by</option>
                    <option value="1">Date Range</option>
                    <option value="2">Month</option>
                    <option value="3">Year</option>
                  </select>
                </div>

                <div id="date_range_div" style="display:none;">
                  <label class="control-label lblalign">From Date</label>
                  <div class="col-md-2">
                    <input type="text" name="from_date" id="from_date_id" placeholder="yyyy/mm/dd" class="form-control filterby"> <!-- //filterby -->
                  </div>
                  <label class="control-label lblalign">To Date</label>
                  <div class="col-md-2">
                    <input type="text" name="to_date" id="to_date_id" placeholder="yyyy/mm/dd" class="form-control filterby">
                  </div>
                </div>

                <div id="month_div" style="display:none;">
                  <label class="control-label lblalign">Month</label>
                  <div class="col-md-2">
                    <select id="month_name" class="form-control " name="month_name">
                      <option value="01">January</option>
                      <option value="02">February</option>
                      <option value="03">March</option>
                      <option value="04">April</option>
                      <option value="05">May</option>
                      <option value="06">June</option>
                      <option value="07">July</option>
                      <option value="08">August</option>
                      <option value="09">September</option>
                      <option value="10">October</option>
                      <option value="11">November</option>
                      <option value="12">December</option>
                    </select>
                  </div>
                  <label class="control-label lblalign">Year</label>
                  <div class="col-md-2">
                    <select id="month_year" class="form-control " name="month_year">
                      <?php 
                      $years = range ( date( 'Y' ), date( 'Y') - 10 );
                      foreach ( $years as $yearVal )
                      { ?>
                        <option value="<?php echo $yearVal;?>"><?php echo $yearVal;?></option>
                      <?php 
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div id="year_div" style="display:none;">
                  <label class="control-label lblalign">Year</label>
                  <div class="col-md-2">
                    <select id="year" class="form-control " name="year">
                      <?php 
                      $years = range ( date( 'Y' ), date( 'Y') - 10 );
                      foreach ( $years as $yearVal )
                      { ?>
                        <option value="<?php echo $yearVal;?>"><?php echo $yearVal;?></option>
                      <?php 
                      }
                      ?>
                    </select>
                  </div>
                </div>

              <div class="form-group" id="submitbtn" style="display:none;">
                <div class="col-md-4">
                  <button class="btn btn-success" type="submit" id="savePromoCode">Submit</button>
                  <a href="<?php echo base_url("fax/fax_shorting/"); ?><?php echo $shorting_by; ?>" class="btn btn-primary">Reset</a>
                </div>
              </div>
                
              </div>
            </form>

            <table id="datatable" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Order No.</th>
                  <th>No. of Pages</th>
                  <th>Cost</th>
                  <th>Status</th>
                  <th>Requested At</br>Completed At</th>
                  <th>Total</br>Duration</th>
                  <th>Download</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  foreach ($allfax as $k=>$row) {
                ?>
                        <tr>
                          <td><?php echo $k+1; ?></td>
                          <td><?php echo $row->txtOrderNo; ?></td>
                          <td><?php echo $row->txtNoOfPage; ?></td>
                          <td><?php echo $row->txtCost; ?></td>
                          <td><?php echo $row->txtStatus; ?></td>
                          <td><?php echo $row->txtRequestedAt; ?></br><?php echo $row->txtCompletedAt; ?></td>
                          <td><?php echo $row->txtTotalDuration; ?></td>
                          <td>
                          <a class="btn btn-primary btn-xs sendPromoLink dwnld" href="<?php echo base_url('fax'); ?>/pamfax_download?orderno=<?php echo $row->txtOrderNo; ?>" data-id="227" ordno=<?php echo $row->txtOrderNo; ?>>Download</a>
                          </td>
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
// $(document).ready(function(){
//   $(".dwnld").click(function(){
//     var ordno=$(this).attr('ordno');
//      $.ajax({
//             type: "POST",                 
//             url:"<?php echo base_url('fax'); ?>/fax_download",
//             data: {"orderno":ordno},
//              contentType: "application/download",       
//             cache: false,         
//             processData:false,
//             success: function (response){
//                       alert(response);
//                  uriContent = "data:application/octet-stream," + encodeURIComponent(response);
//                 newWindow=window.open(uriContent, 'filename.pdf');
//             }
//         });
//   });
// });

function changeFilter(sel)
{
  var filterby = sel.value;
  if(filterby == 1)
  {
    $("#filter_by").val('1');
    $("#from_date_id").val('<?php echo $from_date; ?>');
    $("#to_date_id").val('<?php echo $to_date; ?>');
    $("#month_name").val('');
    $("#month_year").val('');
    $("#year").val('<?php echo $year; ?>');

    $("#month_div").css("display", "none");
    $("#year_div").css("display", "none");
    $("#date_range_div").css("display", "block");
    $("#submitbtn").css("display", "block");
  }
  else if(filterby == 2)
  {
    $("#filter_by").val('2');
    $("#month_name").val('<?php echo $month_name; ?>');
    $("#month_year").val('<?php echo $month_year; ?>');
    $("#year").val('<?php echo $year; ?>');
    $("#from_date_id").val('');
    $("#to_date_id").val('');

    $("#date_range_div").css("display", "none");
    $("#year_div").css("display", "none");
    $("#month_div").css("display", "block");
    $("#submitbtn").css("display", "block");
  }
  else if(filterby == 3)
  {
    $("#filter_by").val('3');
    $("#year").val('<?php echo $year; ?>');
    $("#from_date_id").val('');
    $("#to_date_id").val('');
    $("#month_name").val('');
    $("#month_year").val('');

    $("#date_range_div").css("display", "none");
    $("#month_div").css("display", "none");
    $("#year_div").css("display", "block");
    $("#submitbtn").css("display", "block");
  }
  else
  {
    $("#filter_by").val('0');
    $("#year").val('<?php echo $year; ?>');
    $("#from_date_id").val('');
    $("#to_date_id").val('');
    $("#month_name").val('<?php echo $month_name; ?>');
    $("#month_year").val('<?php echo $month_year; ?>');

    $("#date_range_div").css("display", "none");
    $("#month_div").css("display", "none");
    $("#year_div").css("display", "none");
    $("#submitbtn").css("display", "none");
  }
}

$(document).ready(function(){
  var filterby = '<?php echo $filter_by; ?>';
  if(filterby == 1)
  {
    $("#filter_by").val('1');
    $("#from_date_id").val('<?php echo $from_date; ?>');
    $("#to_date_id").val('<?php echo $to_date; ?>');
    $("#month_name").val('');
    $("#month_year").val('');
    $("#year").val('<?php echo $year; ?>');

    $("#month_div").css("display", "none");
    $("#year_div").css("display", "none");
    $("#date_range_div").css("display", "block");
    $("#submitbtn").css("display", "block");
  }
  else if(filterby == 2)
  {
    $("#filter_by").val('2');
    $("#month_name").val('<?php echo $month_name; ?>');
    $("#month_year").val('<?php echo $month_year; ?>');
    $("#year").val('<?php echo $year; ?>');
    $("#from_date_id").val('');
    $("#to_date_id").val('');
    
    $("#date_range_div").css("display", "none");
    $("#year_div").css("display", "none");
    $("#month_div").css("display", "block");
    $("#submitbtn").css("display", "block");
  }
  else if(filterby == 3)
  {
    $("#filter_by").val('3');
    $("#year").val('<?php echo $year; ?>');
    $("#from_date_id").val('');
    $("#to_date_id").val('');
    $("#month_name").val('');
    $("#month_year").val('');

    $("#date_range_div").css("display", "none");
    $("#month_div").css("display", "none");
    $("#year_div").css("display", "block");
    $("#submitbtn").css("display", "block");
  }
  else
  {
    $("#filter_by").val('0');
    $("#year").val('<?php echo $year; ?>');
    $("#from_date_id").val('');
    $("#to_date_id").val('');
    $("#month_name").val('<?php echo $month_name; ?>');
    $("#month_year").val('<?php echo $month_year; ?>');

    $("#date_range_div").css("display", "none");
    $("#month_div").css("display", "none");
    $("#year_div").css("display", "none");
    $("#submitbtn").css("display", "none");
  }
});
</script>