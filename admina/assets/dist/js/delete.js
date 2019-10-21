$(function(){

   $(".table").on('click','.hapus',function(event) {

    event.preventDefault();
    var currentBtn = $(this);

		uri = currentBtn.attr('data-uri');
		id = currentBtn.attr('data-id');


    $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
			    type: "POST",
          data : 'id='+id,
			    url: uri+"?act=delete&id="+id,
			    success: function(data){
			        $("#line_"+id).fadeOut("slow");
			    }
			    });
          $('#ucing').modal('hide');

        });



  });

    $(".table").on('click','.hapus_feeder_kelas',function(event) {

    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id'); 
    

    $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {
        $("#loadnya").show();
                $.ajax({
          type: "POST",
          url: uri+"?act=delete&id="+id,
          success: function(data){
             $("#loadnya").hide();
            console.log(data);

              $("#line_"+id).fadeOut("slow");
          }
          });
          $('#ucing').modal('hide');

        });

  });

    //hapus data error
      $("#hapus_data_error").click(function(event){

          event.preventDefault();
          var currentBtn = $(this);

          uri = currentBtn.attr('data-uri');
          id = currentBtn.attr('data-id');

          $('#hapus_error')
              .modal({ keyboard: false })
              .one('click', '#delete', function (e) {
                console.log(e);
              $("#loadnya").show();
              $('#hapus_error').modal('hide');
                      $.ajax({
                type: "POST",
                data: {id:id},
                url: uri+"?act=delete_error",
                success: function(data){
                  //console.log(data);
                    window.location.reload();
                }
                });
             
                

              });

      });

      


       //hapus semua data
      $("#hapus_massal").click(function(event){

          event.preventDefault();
          var currentBtn = $(this);

          uri = currentBtn.attr('data-uri');
          id = currentBtn.attr('data-id');
          



          $('#mass_info')
              .modal({ keyboard: false })
              .one('click', '#delete', function (e) {
                sem = $("#sem_delete").val();
              //  alert(id);
                
              $("#loadnya").show();
              $('#mass_info').modal('hide');
                      $.ajax({
                type: "POST",
                data: {sem:sem,id:id},
                url: uri+"?act=delete_all",
                success: function(data){
                  //console.log(data);
                    window.location.reload();
                }
                });
             
                

              });

      });

       //hapus semua data
      $("#kosongkan_data").click(function(event){

          event.preventDefault();
          var currentBtn = $(this);

          uri = currentBtn.attr('data-uri');
          id = currentBtn.attr('data-id');
          tahun = currentBtn.attr('data-tahun');

          $('#kosong')
              .modal({ keyboard: false })
              .one('click', '#delete', function (e) {
                console.log(e);
              $("#loadnya").show();
              $('#kosong').modal('hide');
                      $.ajax({
                type: "POST",
                data: {id:id,tahun:tahun},
                url: uri+"?act=delete_all",
                success: function(data){
                  console.log(data);
                    window.location.reload();
                }
                });
             
                

              });

      });



$('body').on('click', '.hapus_foto', function(event) {

    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    id = currentBtn.attr('data-id');

    $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
          type: "POST",
          url: uri+"?act=hapus_foto&id="+id,
          success: function(data){
            console.log(data);


              $("#foto_"+id).remove();
          }
          });
          $('#ucing').modal('hide');
          //location.reload();
        });



  });

$('body').on('click', '.hapus_album', function(event) {

    event.preventDefault();
    var currentBtn = $(this);

    uri = currentBtn.attr('data-uri');
    gallery_uri = currentBtn.attr('data-gallery');
    id = currentBtn.attr('data-id');

    $('#ucing')
        .modal({ keyboard: false })
        .one('click', '#delete', function (e) {

                $.ajax({
          type: "POST",
          url: uri+"?act=hapus_album&id="+id,
          success: function(data){
            console.log(data);
          }
          });
          $('#ucing').modal('hide');
         window.location=gallery_uri;
        });



  });

$(document).on('mouseenter','[rel=tooltip]', function(){
    $(this).tooltip('show');
});

$("#ok_info").click(function(){
      window.location.reload();
  });
$("#ok_info2").click(function(){
      $('#informasi2').modal('hide');
  });
});


