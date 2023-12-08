<?php
// echo "<pre>";
//   print_r($recent_fax);  exit();

//print_r($sent); 
// echo "</pre>"; exit();
// foreach($recent_fax as $row){

//    echo $row->txtOrderNo."<br>";
// }exit();
$month_of_yr=array("1"=>"Jan","2"=>"Feb","3"=>"March","4"=>"April","5"=>"May","6"=>"June","7"=>"July","8"=>"Aug","9"=>"Sept","10"=>"Oct","11"=>"Nov","12"=>"Dec")
?>
<?php //echo json_encode($sent_week,JSON_NUMERIC_CHECK);  exit(); ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="col-md-12">
                <h3 class="pull-left">Dashboard</h3>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">  
                    <div class="col-md-6 col-sm-6 col-xs-6">      
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Recent Fax <small>Sessions</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                            <?php  
                            foreach($recent_fax as $row){
                            ?> 
                                <article class="media event">
                                    <a class="pull-left date">
                                        <p class="month"> 
                                          <?php  
                                          $complate_date=$row->txtCompletedAt; 
                                          $d = date_parse_from_format("Y-m-d", $complate_date);
                                          echo $month_of_yr[$d["month"]];
                                          ?>
                                        </p>
                                        <p class="day">
                                          <?php  
                                          $complate_date=$row->txtCompletedAt;  
                                          $d = date_parse_from_format("Y-m-d", $complate_date);
                                          echo $d["day"];
                                          ?>
                                        </p>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Order NO : <?php  echo $row->txtOrderNo;  ?></a>
                                        <p>
                                          No Of Page : <?php  echo $row->txtNoOfPage;  ?> |
                                          Cost : <?php  echo $row->txtCost;  ?> |
                                          Status : <?php  echo $row->txtStatus;  ?>
                                        </p>
                                    </div>
                                </article>
                             <?php } ?>  <!--end of foreach  -->
                            </div>

                        </div><!-- /x_panel -->
                    </div><!-- /col-md-6 1st-->
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Recent Payment <small>Sessions</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                 <?php  
                            foreach($recent_payment as $row){
                            ?> 
                                <article class="media event">
                                    <a class="pull-left date">
                                        <p class="month"> 
                                          <?php  
                                          $complate_date=$row->txtDate;  
                                          $d = date_parse_from_format("Y-m-d", $complate_date);
                                          echo $month_of_yr[$d["month"]];
                                          ?>
                                        </p>
                                        <p class="day">
                                          <?php  
                                          $complate_date=$row->txtDate;  
                                          $d = date_parse_from_format("Y-m-d", $complate_date);
                                          echo $d["day"];
                                          ?>
                                        </p>
                                    </a>
                                    <div class="media-body">
                                        <a class="title" href="#">Order ID : <?php  echo $row->txtOrderID;  ?></a>
                                        <p>
                                          App : <?php  echo $row->txtApp;  ?> |
                                          Type : <?php  echo $row->txtType;  ?>
                                        </p>
                                        <p>
                                          Status : <?php  echo $row->txtStatus;  ?> | 
                                          Total : <?php  echo $row->txtTotal;  ?>
                                        </p>
                                    </div>
                                </article>
                              <?php } ?>  <!--end of foreach  -->
                            </div>
                        </div><!-- /x_panel -->
                    </div><!-- /col-md-6 2nd -->
                </div><!-- /col-md-12 -->

          
           
                <div class="col-md-12 col-sm-12 col-xs-12">  
                    <div class="col-md-6 col-sm-6 col-xs-6">      
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Fax Chart<small>Sessions</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                              <div class="pull-right">
                              <select id="fax_shortby">
                               <option value="Month">Month</option>
                               <option value="Week">Week</option>
                               <option value="Day">Day</option>
                              </select>
                            </div>
                            <div class="" id="month_div"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                            <canvas id="mybarChart_bymonth" style="width: 465px; height: 232px;" width="465" height="232"></canvas>
                           </div>
                            <div class="" id="week_div" style="display: none;"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                            <canvas id="mybarChart_byweek" style="width: 465px; height: 232px;" width="465" height="300"></canvas>
                           </div>
                            <div class="" id="day_div" style="display: none;"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                            <canvas id="mybarChart_byday" style="width: 465px; height: 232px;" width="465" height="232"></canvas>
                           </div>
                           </div><!-- /x_content -->
                        </div><!-- /x_panel -->
                    </div><!-- /col-md-6 1st-->
                    <div class="col-md-6 col-sm-6 col-xs-6"> 
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Payment Chart <small>Sessions</small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                           
                           <div class="x_content">  
                             <div class="pull-right">
                             <select id="payment_shortby">
                               <option value="Month">Month</option>
                               <option value="Week">Week</option>
                               <option value="Day">Day</option>
                             </select>
                             </div>
                           <div class="" id="month_div_p"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                            <canvas id="mybarChart_bymonth_p" style="width: 465px; height: 232px;" width="465" height="232"></canvas>
                            </div>
                            <div class="" id="week_div_p" style="display: none;"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                            <canvas id="mybarChart_byweek_p" style="width: 465px; height: 232px;" width="465" height="300"></canvas>
                           </div>
                            <div class="" id="day_div_p" style="display: none;"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px none; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                            <canvas id="mybarChart_byday_p" style="width: 465px; height: 232px;" width="465" height="232"></canvas>
                           </div>
                           </div><!-- /x_content -->
                        </div><!-- /x_panel -->
                    </div><!-- /col-md-6 2nd -->
                </div><!-- /col-md-12 -->
               

            </div><!-- /row -->
        </div> <!-- /page-title -->
    </div> <!-- / -->
</div> <!-- /right_col -->

<?php
  /*-- use for x -axis of mybarChart_byday --*/
  $current= date('Y-m-d');
  $past1= date('Y-m-d', strtotime('-1 days'));
  $past2= date('Y-m-d', strtotime('-2 days'));
  $past3= date('Y-m-d', strtotime('-3 days'));
  $past4= date('Y-m-d', strtotime('-4 days'));
  $past5= date('Y-m-d', strtotime('-5 days'));
  $past6= date('Y-m-d', strtotime('-6 days'));
  $last_seven_days=[$past6,$past5,$past4,$past3,$past2,$past1,$current];
 /*-- use for x -axis of mybarChart_byday --*/

 /*-- use for x -axis of mybarChart_byweek --*/
$signupdate=date('Y-m-d');
$signupweek=date("W",strtotime($signupdate));
$year=date("Y",strtotime($signupdate));
$currentweek = date("W");
$k=0;
for($i=($signupweek-6);$i<=$signupweek;$i++) {
    $result=getWeek($i,$year);
    $week_array[$k]['start']=$result['start'];
    $week_array[$k]['end']=$result['end'];
    $k++;
}



// $last_seven_weeks=[$week_array[0]['start'] .' to '. $week_array[0]['end'],
//                    $week_array[1]['start'] .' to '. $week_array[1]['end'],
//                    $week_array[2]['start'] .' to '. $week_array[2]['end'],
//                    $week_array[3]['start'] .' to '. $week_array[3]['end'],
//                    $week_array[4]['start'] .' to '. $week_array[4]['end'],
//                    $week_array[5]['start'] .' to '. $week_array[5]['end'],
//                    $week_array[6]['start'] .' to '. $week_array[6]['end'],
//                   ];  

if(date("M", strtotime($week_array[0]['start']))==date("M", strtotime($week_array[0]['end']))){
$week7=date("d",strtotime($week_array[0]['start']))."-".date("d",strtotime($week_array[0]['end']))." ". date("M", strtotime($week_array[0]['end']))." ".date('Y', strtotime($week_array[0]['start']));
}else{
  $week7=date("d",strtotime($week_array[0]['start'])).date("M", strtotime($week_array[0]['start'])) ."-".date("d",strtotime($week_array[0]['end'])).date("M", strtotime($week_array[0]['end']))." ".date('Y', strtotime($week_array[0]['start']));
}

if(date("M", strtotime($week_array[1]['start']))==date("M", strtotime($week_array[1]['end']))){
$week6=date("d",strtotime($week_array[1]['start']))."-".date("d",strtotime($week_array[1]['end']))." ". date("M", strtotime($week_array[1]['end']))." ".date('Y', strtotime($week_array[1]['start']));
}else{
  $week6=date("d",strtotime($week_array[1]['start'])).date("M", strtotime($week_array[1]['start'])) ."-".date("d",strtotime($week_array[1]['end'])).date("M", strtotime($week_array[1]['end']))." ".date('Y', strtotime($week_array[1]['start']));
}

if(date("M", strtotime($week_array[2]['start']))==date("M", strtotime($week_array[2]['end']))){
$week5=date("d",strtotime($week_array[2]['start']))."-".date("d",strtotime($week_array[2]['end']))." ". date("M", strtotime($week_array[2]['end']))." ".date('Y', strtotime($week_array[2]['start']));
}else{
  $week5=date("d",strtotime($week_array[2]['start'])).date("M", strtotime($week_array[2]['start'])) ."-".date("d",strtotime($week_array[2]['end'])).date("M", strtotime($week_array[2]['end']))." ".date('Y', strtotime($week_array[1]['start']));
}

if(date("M", strtotime($week_array[3]['start']))==date("M", strtotime($week_array[3]['end']))){
$week4=date("d",strtotime($week_array[3]['start']))."-".date("d",strtotime($week_array[3]['end']))." ". date("M", strtotime($week_array[3]['end']))." ".date('Y', strtotime($week_array[3]['start']));
}else{
  $week4=date("d",strtotime($week_array[3]['start'])).date("M", strtotime($week_array[3]['start'])) ."-".date("d",strtotime($week_array[3]['end'])).date("M", strtotime($week_array[3]['end']))." ".date('Y', strtotime($week_array[1]['start']));
}

if(date("M", strtotime($week_array[4]['start']))==date("M", strtotime($week_array[4]['end']))){
$week3=date("d",strtotime($week_array[4]['start']))."-".date("d",strtotime($week_array[4]['end']))." ". date("M", strtotime($week_array[4]['end']))." ".date('Y', strtotime($week_array[4]['start']));
}else{
  $week3=date("d",strtotime($week_array[4]['start'])).date("M", strtotime($week_array[4]['start'])) ."-".date("d",strtotime($week_array[4]['end'])).date("M", strtotime($week_array[4]['end']))." ".date('Y', strtotime($week_array[1]['start']));
}

if(date("M", strtotime($week_array[5]['start']))==date("M", strtotime($week_array[5]['end']))){
$week2=date("d",strtotime($week_array[5]['start']))."-".date("d",strtotime($week_array[5]['end']))." ". date("M", strtotime($week_array[5]['end']))." ".date('Y', strtotime($week_array[5]['start']));
}else{
  $week2=date("d",strtotime($week_array[5]['start'])).date("M", strtotime($week_array[5]['start'])) ."-".date("d",strtotime($week_array[5]['end'])).date("M", strtotime($week_array[5]['end']))." ".date('Y', strtotime($week_array[1]['start']));
}
if(date("M", strtotime($week_array[6]['start']))==date("M", strtotime($week_array[6]['end']))){
$week1=date("d",strtotime($week_array[6]['start']))."-".date("d",strtotime($week_array[6]['end']))." ". date("M", strtotime($week_array[6]['end']))." ".date('Y', strtotime($week_array[6]['start']));
}else{
  $week1=date("d",strtotime($week_array[6]['start'])).date("M", strtotime($week_array[6]['start'])) ."-".date("d",strtotime($week_array[6]['end'])).date("M", strtotime($week_array[6]['end']))." ".date('Y', strtotime($week_array[1]['start']));
}

// $week6=date("d",strtotime($week_array[1]['start']))."-".date("d",strtotime($week_array[1]['end']))." ". date("M", strtotime($week_array[1]['end']))." ".date('Y', strtotime($week_array[1]['start']));
// $week5=date("d",strtotime($week_array[2]['start']))."-".date("d",strtotime($week_array[2]['end']))." ". date("M", strtotime($week_array[2]['end']))." ".date('Y', strtotime($week_array[2]['start']));
// $week4=date("d",strtotime($week_array[3]['start']))."-".date("d",strtotime($week_array[3]['end']))." ". date("M", strtotime($week_array[3]['end']))." ".date('Y', strtotime($week_array[3]['start']));
// $week3=date("d",strtotime($week_array[4]['start']))."-".date("d",strtotime($week_array[4]['end']))." ". date("M", strtotime($week_array[4]['end']))." ".date('Y', strtotime($week_array[4]['start']));
// $week2=date("d",strtotime($week_array[5]['start']))."-".date("d",strtotime($week_array[5]['end']))." ". date("M", strtotime($week_array[5]['end']))." ".date('Y', strtotime($week_array[5]['start']));
// $week1=date("d",strtotime($week_array[6]['start']))."-".date("d",strtotime($week_array[6]['end']))." ". date("M", strtotime($week_array[6]['end']))." ".date('Y', strtotime($week_array[6]['start']));

$last_seven_weeks=[$week7,
                   $week6,
                   $week5,
                   $week4,
                   $week3,
                   $week2,
                   $week1,
                  ];             

function getWeek($week, $year) {
  $dto = new DateTime();
  $result['start'] = $dto->setISODate($year, $week, 0)->format('Y-m-d');
  $result['end'] = $dto->setISODate($year, $week, 6)->format('Y-m-d');
  return $result;
}
/*-- use for x -axis of mybarChart_byweek --*/

 
?>
<!-- Chart.js -->
    <script src="<?php echo base_url(); ?>assests/js/Chart.min.js"></script>
    <script type="text/javascript">
     Chart.defaults.global.legend = {
        enabled: false
      };
      // Bar chart
      var ctx = document.getElementById("mybarChart_bymonth");

      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["January", "February", "March", "April", "May", "June", "July","August","september","october","November","December"],
          datasets: [{
            label: ' Success',
            backgroundColor: "#26B99A",
            data: <?php echo json_encode($sent,JSON_NUMERIC_CHECK); ?>
          }, {
            label: ' Draft',
            backgroundColor: "#03586A",
            data: <?php echo json_encode($draft,JSON_NUMERIC_CHECK); ?>  
          }, {
            label: 'Failure',
            backgroundColor: "#03594D",
            data: <?php echo json_encode($failed,JSON_NUMERIC_CHECK); ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });



var ctx = document.getElementById("mybarChart_byweek");

      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($last_seven_weeks);?>,
          datasets: [{
            label: ' Sent',
            backgroundColor: "#26B99A",
            data:<?php echo json_encode($sent_week,JSON_NUMERIC_CHECK); ?>
          }, {
            label: ' Draft',
            backgroundColor: "#03586A",
            data: []  
          }, {
            label: 'Failed',
            backgroundColor: "#03594D",
            data: <?php echo json_encode($fail_week,JSON_NUMERIC_CHECK); ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

var ctx = document.getElementById("mybarChart_byday");

      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels:<?php echo json_encode($last_seven_days);?>,
          datasets: [{
            label: ' Sent',
            backgroundColor: "#26B99A",
            data:<?php echo json_encode($sent_day,JSON_NUMERIC_CHECK); ?>
          }, {
            label: ' Draft',
            backgroundColor: "#03586A",
            data: []  
          }, {
            label: 'Failed',
            backgroundColor: "#03594D",
            data: <?php echo json_encode($fail_day,JSON_NUMERIC_CHECK); ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

// Bar chart 2
  var ctx = document.getElementById("mybarChart_bymonth_p");

      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ["January", "February", "March", "April", "May", "June", "July","August","september","october","November","December"],
          datasets: [{
            label: 'Payment Charged',
            backgroundColor: "#26B99A",
            data: <?php echo json_encode($payment_charged,JSON_NUMERIC_CHECK); ?>
          },  {
            label: 'Payment Declined',
            backgroundColor: "#03594D",
            data: <?php echo json_encode($payment_declined,JSON_NUMERIC_CHECK); ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });



var ctx = document.getElementById("mybarChart_byweek_p");

      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: <?php echo json_encode($last_seven_weeks);?>,
          datasets: [{
            label: ' Payment Charged',
            backgroundColor: "#26B99A",
            data:<?php echo json_encode($payment_charged_W,JSON_NUMERIC_CHECK); ?>
          }, {
            label: 'Payment Declined',
            backgroundColor: "#03594D",
            data: <?php echo json_encode($payment_declined_W,JSON_NUMERIC_CHECK); ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

var ctx = document.getElementById("mybarChart_byday_p");

      var mybarChart = new Chart(ctx, {
        type: 'bar',
        data: {
          labels:<?php echo json_encode($last_seven_days);?>,
          datasets: [{
            label: 'Payment Charged',
            backgroundColor: "#26B99A",
            data:<?php echo json_encode($payment_charged_D,JSON_NUMERIC_CHECK); ?>
          },  {
            label: 'Payment Declined',
            backgroundColor: "#03594D",
            data: <?php echo json_encode($payment_declined_D,JSON_NUMERIC_CHECK); ?>
          }]
        },

        options: {
          scales: {
            yAxes: [{
              ticks: {
                beginAtZero: true
              }
            }]
          }
        }
      });

    </script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  
$(document).ready(function(){
  $("#fax_shortby").change(function(){
    var a=$(this).val(); //alert(a);
    if(a=='Week'){
      $("#month_div").hide();
      $("#day_div").hide();
      $("#week_div").show();
    }
     if(a=='Day'){
      $("#month_div").hide();
      $("#week_div").hide();
      $("#day_div").show();
    }
    if(a=='Month'){
      $("#day_div").hide();
      $("#week_div").hide();
      $("#month_div").show();
    }
  });

 $("#payment_shortby").change(function(){
      var a=$(this).val();
      if(a=='Week'){
        $("#month_div_p").hide();
        $("#day_div_p").hide();
        $("#week_div_p").show();
      }
     if(a=='Day'){
        $("#month_div_p").hide();
        $("#week_div_p").hide();
        $("#day_div_p").show();
     }
    if(a=='Month'){
        $("#day_div_p").hide();
        $("#week_div_p").hide();
        $("#month_div_p").show();
     }

 });

});


</script>