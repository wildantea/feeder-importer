$(document).ready(function(){
  //date 
                
$("#tgl").datepicker( {
    format: "yyyy-mm-dd",
});
$("#tgl1").datepicker( {
    format: "yyyy-mm-dd",
});
$("#tgl2").datepicker( {
    format: "yyyy-mm-dd",
});
$("#tgl3").datepicker( {
    format: "yyyy-mm-dd",
});
$("#tgl4").datepicker( {
    format: "yyyy-mm-dd",
});
$("#tgl5").datepicker( {
    format: "yyyy-mm-dd",
});

 $("#input_import").validate({
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },

            submitHandler: function(form) {
               $('#loadnya').show();
                   $(form).ajaxSubmit({
                          type: "post",
                          url: $(this).attr('action'),
                          data: $("#input_import").serialize(),
                       //  enctype:  'multipart/form-data'
                        success: function(data){
                          $("#isi_informasi").html(data);
                          $('#informasi').modal('show');
                          
                          $('#loadnya').hide();
                     
                      }
                    });
            }

        });  


    $("#input").validate({
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },

            submitHandler: function(form) {
               $('#loadnya').show();
                   $(form).ajaxSubmit({
                          type: "post",
                          url: $(this).attr('action'),
                          data: $("#input").serialize(),
                       //  enctype:  'multipart/form-data'
                        success: function(data){
                          console.log(data);
                          $('#loadnya').hide();
                              if (data=='good') { 
                          $('.notif_top').fadeIn(1000);
                         $(".notif_top").fadeOut(1000,function(){
                           window.history.back();
                        });

                              } else {
                                 $('.errorna').fadeIn();
                               
                              }
                      }
                    });
            }

        });  
   $("#input_user").validate({
        errorClass: 'help-block',
        errorElement: 'span',
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error').addClass('has-success');
        },

            submitHandler: function(form) {
               $('#loadnya').show();
                   $(form).ajaxSubmit({
                          type: "post",
                          url: $(this).attr('action'),
                          data: $("#input_user").serialize(),
                       //  enctype:  'multipart/form-data'
                        success: function(data){
                  $('#loadnya').hide();
                              if (data=='false') { 
                         $('.user_exist').focus(); 
                         $('.user_exist').fadeIn();
                                //$('.sukses').html(data);
                              } else {
                                $('.notif_top').fadeIn(1000);
                                 setTimeout(function () {
                                 window.location.href = "./"; //will redirect to your blog page (an ex: blog.html)
                              }, 2000); //will call the function after 2 secs.
                                //redirect jika berhasil login
                              }
                      }
                    });
            }

        });  

 $("#input_page").validate({
             submitHandler: function(form) {
               $('#loadnya').show();
                   $(form).ajaxSubmit({
                          type: "post",
                          url: $(this).attr('action'),
                          data: $("#input_page").serialize(),
                       //  enctype:  'multipart/form-data'
                        success: function(data){
                          $('#loadnya').hide();
                              if (data) { 
                          $('.notif_top').fadeIn(1000);
                         $(".notif_top").fadeOut(1000,function(){
                           window.history.back();
                      
                          });

                              }
                      }
                    });
            }

        });  

	})