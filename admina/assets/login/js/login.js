$(document).ready(function(){

		$(".seePass").mousedown(function(){

	Save = $("#txtPassword").val();

	$("#txtPassword").replaceWith('<input class="m-wrap" id="txtVisible" type="text" value="'+ Save +'" placeholder="Your Password"/>');


});

$(".seePass").mouseup(function(){

	Save = $("#txtVisible").val();

	$("#txtVisible").replaceWith('<input class="m-wrap" id="txtPassword" type="password" value="'+ Save +'"  placeholder="Your Password"/>');

});

$(".seePass").mouseout(function(){

	$(this).mouseup();

});

$('#login').click(function()
{
   
      var username=$("#username").val();
      var password=$("#txtPassword").val();
    

      if (username=='' || password=='')
      {
            if (password=='') {
              $("#txtPassword").focus();
          }
          if (username=='') {
              $("#username").focus();
          }

      } else {

        var data_login = {
            username: username,
            password: password,
           
        }
         $('.load').show();
         $('.m-input-prepend').hide();
             $.ajax({
              url: "inc/login.php",
              type : "post",
              data : data_login,
              success: function(data) {
                   console.log(data);
                          $('.load').hide();
                              if (data) {
                                console.log(data);
                                //redirect jika berhasil login
                                window.location="./index.php/";
                              } else {
                                 $('.bad').fadeIn();
                              }

              }
            });
      }

return false;
});

		//kembali ke login
	$("#back").click(function(event) {
	     $('.bad').hide();
	     $('.m-input-prepend').show();
		});

  $.backstretch([
      "assets/login/img/1.jpg"
    , "assets/login/img/03.jpg"
  ], {duration: 3000, fade: 1000});
	})
