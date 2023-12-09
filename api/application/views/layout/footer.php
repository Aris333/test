   <!-- footer content -->
        <footer>
          <div class="pull-right">
             &copy;<?php  echo date("Y");?> SpeedyFax. All rights reserved.
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo base_url(); ?>assests/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assests/vendors/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- NProgress -->
    <script src="<?php echo base_url(); ?>assests/vendors/nprogress/nprogress.js"></script>
    <!-- Datatables -->
    <script src="<?php echo base_url(); ?>assests/vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url(); ?>assests/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assests/vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>assests/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assests/vendors/parsleyjs/dist/parsley.min.js"></script>
   <script src="<?php echo base_url(); ?>assests/vendors/bootstrap-datepicker/js/datepicker.js"></script> 
   <script src="<?php echo base_url(); ?>assests/js/formvalidation.js"></script>
    <script src="<?php echo base_url(); ?>assests/js/select2.min.js"></script>
    <script src="<?php echo base_url(); ?>assests/vendors/switchery/dist/switchery.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assests/vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>

    



    <script src="<?php echo base_url(); ?>assests/js/tags-input.js"></script>
    <script src="<?php echo base_url(); ?>assests/js/tags-input-init.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?php echo base_url(); ?>assests/js/custom.min.js"></script>
    <script type="text/javascript">
        var baseurl = "<?php echo base_url(); ?>";
    </script>
    <script src="<?php echo base_url(); ?>assests/js/speedyfax.js"></script>

<!-- add on 6th dec -->
   <script src="<?php echo base_url(); ?>assests/slick/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- .. -->

    <!-- Datatables -->
    <script>
      $(document).ready(function() {
        $(".select2").select2();
          
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();
        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        var table = $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        TableManageButtons.init();
      });
    </script>
    <!-- /Datatables -->

<script>
$(document).ready(function() {
     
   $("#countryids").change(function(){
 
      var counter_id=$(this).val();
      var lastEl = counter_id[counter_id.length-1];
      //var selector='#countryids option[value='+lastEl+']'; 
      $("#savecredits").attr("disabled", true);
      $.ajax({        
            type: "POST",  
            dataType: "json",                
            url:"<?php echo base_url();?>/credits/check_for_assign",
            data: {"counter_id":counter_id},
            // contentType: false,       
            // cache: false,         
            // processData:false,
            success: function (response){
                  //alert(response);
                  if(response.code=='200'){
                   // alert(response.data);
                     var selector='#countryids option[value='+response.data+']';
                     $(selector).removeAttr('selected');
                     $("#msg_4_present").show().fadeOut(3000);
                     
                     setTimeout(function(){ $("#savecredits").removeAttr("disabled"); }, 3000); 
                  }else{

                    $("#msg_4_present").hide();
                    $("#savecredits").removeAttr("disabled"); 
                  }
                 
            }
   
        });
       });
    });
   </script>

<script type="text/javascript">
  
$(document).ready(function() {
var numitems =  $("#myList li").length;

// $("ul#myList").css("column-count",Math.round(numitems/2));
$("ul#myList_index").css("column-count",3);
$("ul#myList").css("column-count",3); 
$("ul#myList").css("width","630px");
$("ul#myList li").css("width","500px");



});

</script>

<script type="text/javascript">
  
$(document).ready(function() {
var numitems =  $("#myList2 li").length;

// $("ul#myList").css("column-count",Math.round(numitems/2));
$("ul#myList2").css("column-count",3);
$("ul#myList2").css("width","630px");
$("ul#myList2 li").css("width","500px");



});

</script>
 <script>
        $(function () {
            $('#startdate,#enddate').datetimepicker({
                useCurrent: false,
                minDate: moment()
            });
            $('#startdate').datetimepicker().on('dp.change', function (e) {
                var incrementDay = moment(new Date(e.date));
                incrementDay.add(1, 'days');
                $('#enddate').data('DateTimePicker').minDate(incrementDay);
                $(this).data("DateTimePicker").hide();
            });

            $('#enddate').datetimepicker().on('dp.change', function (e) {
                var decrementDay = moment(new Date(e.date));
                decrementDay.subtract(1, 'days');
                $('#startdate').data('DateTimePicker').maxDate(decrementDay);
                 $(this).data("DateTimePicker").hide();
            });

        });
    </script>
<script type="text/javascript">
// $(document).ready(function(){

//      $("#StartDate").datepicker({

// numberOfMonths: 1,

// onSelect: function(selected) {

// $("#EndDate").datepicker("option","minDate", selected)

// }

// });

// $("#EndDate").datepicker({ 

// numberOfMonths: 1,

// onSelect: function(selected) {

// $("#StartDate").datepicker("option","maxDate", selected)

// }

// }); 

// });
</script>


  </body>
</html>