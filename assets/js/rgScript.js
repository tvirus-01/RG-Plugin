$(".add_to_cart_button").click(function(event) {
	// window.location.href = "wp-content/plugins/raffle-game/modules/getInfo.php";
});

if (window.location.pathname.search("shop") == -1) {
	//nothing
}else{
	infoLoc = "../wp-content/plugins/raffle-game/modules/getInfo.php";
	f = 0

	if (f == 0) {
		$.ajax({
	      url: infoLoc,
	      type: 'post',
	      data: {get_id:"kk"},
	      success: function(data){
	      	var obj = $.parseJSON(data);
	        for (var i in obj) {
	        	$(".post-"+obj[i]).hide();
	        }
	      },
	   	});
	}
}

var is_home = $("#is_home").val();

if (is_home == '1') {
	infoLoc = "wp-content/plugins/raffle-game/modules/getInfo.php";
	$.ajax({
      url: infoLoc,
      type: 'post',
      data: {get_id:"kk"},
      success: function(data){
      	var obj = $.parseJSON(data);
        for (var i in obj) {
        	$(".post-"+obj[i]).hide();
        }
      },
   	});
}	