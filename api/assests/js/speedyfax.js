jQuery(document).ready(function ($) {
    // Generate Random Numbers
    $("#btnGeneratePromocode").on("click", function(){
      $.ajax({
        url : baseurl+"promocode/generateAllPromo",
        data : "txtPromoCounter="+$("#txtPromoCounter").val(),
       // dataType : "json",
        success : function(sc){
            console.log(sc);
            $("#result").html( sc );
            alert("New Promocodes are generated...Please reload to see new Promocodes..");
        }
        
      });
    });
    
    // Inline edit for Promocode
    $(".txtPromoStatus").on( "change", function(){
      var isCheck = 0;
      if( $(this).is(":checked") == true ){
       // console.log("Checked");
        isCheck = 1;
        $(this).parents("td").siblings(".actionWrapper").find(".sendPromoLink").removeClass("hidden");
        $(this).parents("td").siblings(".actionWrapper").find(".editPromoLink").addClass("hidden");
        $(this).parents("td").siblings(".actionWrapper").find(".removePromoLink").addClass("hidden");
      }else{
       // console.log("Unchecked");
        isCheck = 0;
        $(this).parents("td").siblings(".actionWrapper").find(".sendPromoLink").addClass("hidden");
        $(this).parents("td").siblings(".actionWrapper").find(".editPromoLink").removeClass("hidden");
        $(this).parents("td").siblings(".actionWrapper").find(".removePromoLink").removeClass("hidden");
      }
      //console.log(isCheck);
      
      var txtStatus = ( isCheck == 1 ?"Active":"Inactive" );
      var txtPromoID = $(this).attr("data-id");
     
      $.ajax({
            url : baseurl+"promocode/changePromoCodeStatus",
            type : "post",
            data : "txtPromoID="+txtPromoID+"&txtStatus="+txtStatus,
            success : function(sc){
              
            }
      });
    });
    
    
    
    
    
    // Notify for Email sent
    $("#txtEmailUser").on( "change", function(){
      if( $(this).val() != "" ){        
        $(".selectedUserEmail").html( "<strong>"+$(this).val()+"</strong>" );
        $(".selectedUserEmailWrapper").show();
      }else{
        $(".selectedUserEmailWrapper").hide();
      }
      
    });
    
    // Send Promocode to Email
   
    $('#sendPromoEmailForm #sendEmailToUser').on('click', function () {
        // $('#sendPromoEmailForm').parsley().validate();
       // validateFront();
       if( $('#sendPromoEmailForm').parsley().validate() == true ){
         
          var promocodeData = {};
          promocodeData["txtEmailPromoCode"] = jQuery("#txtEmailPromoCode").val();
          promocodeData["txtEmailTotalCredit"] = jQuery("#txtEmailTotalCredit").val();
          promocodeData["txtEmailUser"] = jQuery("#txtEmailUser").val();

          $.ajax({
            url : baseurl+"promocode/sendPromoEmailToUser",
            type : "post",
            data : {"promocodeData":promocodeData},
            dataType: "json",
            success : function(sc){
              console.log( sc );
              if( sc == 1 ){
                //alert("Email sent successfully.. Please check your email");
                $("#message").html('<div class="col-lg-12 alert alert-success alert-dismissible fade in" role="alert"><strong>Email has been sent..Please check your inbox</strong></div>');
              }else{
                //alert("Error while sending mail");
                $("#message").html('<div class="col-lg-12 alert alert-danger alert-dismissible fade in" role="alert"><strong>Error while sending email</strong></div>');
              }
            }
          });
       }
        
    });
    
    // DatePicker
    // $(".dateTimePicker").datepicker({
    //   format:"mm/dd/yyyy"
    // });

    // $('.filterby').datepicker({
    //   format:"yyyy-mm-dd"
    // });

    var today=new Date();
   
  
    
    /* -- for promocode add page --*/


    $('#startDateTimePicker')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true,
            startDate: today
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#addPromocodeForm').formValidation('revalidateField', 'txtStartDate');
        });

    $('#endDateTimePicker')
        .datepicker({
            format: 'mm/dd/yyyy',
            autoclose: true,
            startDate: today
        })
        .on('changeDate', function(e) {
            $('#addPromocodeForm').formValidation('revalidateField', 'txtEndDate');
        });

    $('#addPromocodeForm')
        .formValidation({
            framework: 'bootstrap',
            // icon: {
            //     valid: 'glyphicon glyphicon-ok',
            //     invalid: 'glyphicon glyphicon-remove',
            //     validating: 'glyphicon glyphicon-refresh'
            // },
            fields: {
                txtStartDate: {
                    validators: {
                        notEmpty: {
                            message: 'The start date is required'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            max: 'txtEndDate',
                            message: 'The start date is not a valid'
                        }
                    }
                },
                txtEndDate: {
                    validators: {
                        notEmpty: {
                            message: 'The end date is required'
                        },
                        date: {
                            format: 'MM/DD/YYYY',
                            min: 'txtStartDate',
                            message: 'The end date is not a valid'
                        }
                    }
                },
                txtPromoCode: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        }
                        
                    }
                }
            }
        })
        .on('success.field.fv', function(e, data) {
            if (data.field === 'txtStartDate' && !data.fv.isValidField('txtEndDate')) {
                // We need to revalidate the end date
                data.fv.revalidateField('txtEndDate');
            }

            if (data.field === 'txtEndDate' && !data.fv.isValidField('txtStartDate')) {
                // We need to revalidate the start date
                data.fv.revalidateField('txtStartDate');
            }
        });

  
/*--   fax short by daterange    ---*/

    $('#from_date_id')
        .datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            startDate: today
        })
        .on('changeDate', function(e) {
            // Revalidate the start date field
            $('#filterby').formValidation('revalidateField', 'from_date');
        });

    $('#to_date_id')
        .datepicker({
            format: 'yyyy/mm/dd',
            autoclose: true,
            startDate: today
        })
        .on('changeDate', function(e) {
            $('#filterby').formValidation('revalidateField', 'to_date');
        });

    $('#filterby')
        .formValidation({
            framework: 'bootstrap',
            // icon: {
            //     valid: 'glyphicon glyphicon-ok',
            //     invalid: 'glyphicon glyphicon-remove',
            //     validating: 'glyphicon glyphicon-refresh'
            // },
            fields: {
                from_date: {
                    validators: {
                        notEmpty: {
                            message: 'The start date is required'
                        },
                        date: {
                            format: 'YYYY/MM/DD',
                            max: 'to_date',
                            message: 'The start date is not a valid'
                        }
                    }
                },
                to_date: {
                    validators: {
                        notEmpty: {
                            message: 'The end date is required'
                        },
                        date: {
                            format: 'YYYY/MM/DD',
                            min: 'from_date',
                            message: 'The end date is not a valid'
                        }
                    }
                }
            }
        })
        .on('success.field.fv', function(e, data) {
            if (data.field === 'from_date' && !data.fv.isValidField('to_date')) {
                // We need to revalidate the end date
                data.fv.revalidateField('to_date');
            }

            if (data.field === 'to_date' && !data.fv.isValidField('from_date')) {
                // We need to revalidate the start date
                data.fv.revalidateField('from_date');
            }
        });







    // Check for Promocode existant 
    $("#savePromoCode").on( function(e){
      e.preventDefault();
      $.ajax({
            url : baseurl+"promocode/checkForPromocode",
            type : "post",
            data : "txtPromoCode="+$("#txtPromoCode").val(),
            dataType: "json",
            success : function(sc){
              console.log( sc );
              if( sc == 1 ){
                $("#message").html('<div class="col-lg-12 alert alert-success alert-dismissible fade in" role="alert"><strong>Promocode is already exist</strong></div>');
              }
            }
          });
    });
    
    // Open Dropdown
    $(".arrowDown").on( "click", function(){
        if( $("#randomPromoWrapper").css("display") == "none" ){
          $("#randomPromoWrapper").show();
        }else{
          $("#randomPromoWrapper").hide();
        }
    });
    
});


// Popup for Email Send
    function popupSendEmail( promocode, promocodeCredit ){
      jQuery("#txtEmailPromoCode").val( promocode );
      jQuery("#txtEmailTotalCredit").val( promocodeCredit );
    }
    