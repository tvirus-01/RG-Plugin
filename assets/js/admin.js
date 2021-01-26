$(".edit").each(function(index, el) {
	tm = $(this).attr('tm');
	game_id = $(this).attr('game_id');
	is_active = $("#"+game_id).attr('is_active');
	
	if (tm == 0 && is_active == 1) {
		$(this).removeClass('btn-primary');
		$(this).addClass('btn-disable');
		$(this).attr('data-target', 'none');
	}
});

$(".img-upload").click(function(event) {
	$("#i_img").trigger('click');
});

var loadFile = function(event) {
    var output = document.getElementById('img_prev');
    output.src = URL.createObjectURL(event.target.files[0]);
    output.onload = function() {
      URL.revokeObjectURL(output.src) // free memory
    }
};

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

$("#submit").click(function(event) {
	/* Act on the event */
	plugin_uri = $(this).attr('plugin-uri');
	uri = plugin_uri+'modules/createGame.php';
	console.log(uri);
	var fd = new FormData();

	g_name = $("#g_name").val();
	p_limit = $("#p_limit").val();
	due = $("#due").val();
	i_name = $("#i_name").val();
	i_img = $("#i_img")[0].files;
	tk_price = $("#tk_price").val();
	wd_text = $("#wd_text").val();

	if (g_name == '' || p_limit == '' || due == '' || i_name == '' || wd_text == '' || i_img['length'] == 0 || tk_price == '') {
	// if (g_name == 'kkkk') {
		$('.text-danger').text('All filed must be filled');
	}else{
		// console.log('kkk');
		$('.text-danger').text('');

		// $("#game_cr").submit();

		fd.append('i_img',i_img[0]);
		fd.append('g_name',g_name);
		fd.append('p_limit',p_limit);
		fd.append('due',due);
		fd.append('i_name',i_name);
		fd.append('tk_price',tk_price);
		fd.append('wd_text',wd_text);
		// console.log(i_img[0]);

		$.ajax({
			type: 'post',
	      	data: fd,
	      	contentType: false,
          	processData: false,
	      	success: function(data){
	      		console.log("product success")
	      	},
		});
		//await sleep(3000);
		$.ajax({
          url: uri,
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data){
            console.log(data)
            if (data == 'success') {
            	$('.text-danger').text('');
            	$(".text-success").text(data);
            	setTimeout(function(){
            		window.location.reload();
            	}, 2500);
            }else{
            	$('.text-success').text('');
            	$('.text-danger').text('error');
            }
          },
       });
	}
});

// $('#game_cr').on('submit',(function(e) {
//     e.preventDefault();

//     var formData = new FormData(this);
// 	console.log($(this).validationEngine());


// }));

$(".user_info").click(function(event) {
	user_id = $(this).attr('user_id');
	user_data = $("#"+user_id);

	if (user_data.attr('info') == 'no') {
		$("#dump_data").html("NO data");
	}else{
		tx = '';
		tx += '<div class="form-group"> <label>User Name</label><br>';
		tx += '<input type="text" readonly value="'+user_data.attr('user_name')+'"></div>';
		tx += '<div class="form-group"> <label>User E-mail</label><br>';
		tx += '<input type="text" readonly value="'+user_data.attr('user_email')+'"></div>';
		tx += '<div class="form-group"> <label>User Phone</label><br>';
		tx += '<input type="text" readonly value="'+user_data.attr('phone')+'"></div>';
		tx += '<div class="form-group"> <label>Street</label><br>';
		tx += '<input type="text" readonly value="'+user_data.attr('street')+'"></div>';
		tx += '<div class="form-group"> <label>City</label><br>';
		tx += '<input type="text" readonly value="'+user_data.attr('city')+'"></div>';
		tx += '<div class="form-group"> <label>Postal Code</label><br>';
		tx += '<input type="text" readonly value="'+user_data.attr('post_code')+'"></div>';
		tx += '<div class="form-group"> <label>Country</label><br>';
		tx += '<input type="text" readonly value="'+user_data.attr('country')+'"></div>';
		$("#dump_data").html(tx);
	}

	console.log(user_data.attr('info'));
});

$(".edit").click(function(event) {
	/* Act on the event */
	game_id = $(this).attr('game_id');
	plugin_uri = $(this).attr('plugin-uri');
	uri = plugin_uri+'modules/editGame.php';
	img_uri = plugin_uri+'assets/img/upload/';
	// console.log(uri);

	$.ajax({
      url: uri,
      type: 'post',
      data: {"game_id":game_id, "get_data":"gm"},
      success: function(data){
      	var obj = $.parseJSON(data);
        $("#exampleModalLongTitle").text(obj['game_name']); 
        $("#g_name").val(obj['game_name']); 
        $("#p_limit").val(obj['percipient_limit']); 
        $("#due").val(obj['duration'].replace(" ", "T")); 
        $("#i_name").val(obj['item_title']); 
        $("#img_prev").attr("src", img_uri+obj['item_image']); 
        $("#tk_price").val(obj['tk_price']); 
        $("#wd_text").val(obj['declartion_text']);
        $("#change").attr({
        	game_id: game_id,
        	plugin_uri: plugin_uri
        });; 
        // console.log(obj); 
      },
   });
});

$(".del").click(function(event) {
	/* Act on the event */
	game_id = $(this).attr('game_id');
	plugin_uri = $(this).attr('plugin-uri');
	uri = plugin_uri+'modules/editGame.php';
	img_uri = plugin_uri+'assets/img/upload/';
	// console.log(uri);

	$.ajax({
      url: uri,
      type: 'post',
      data: {"game_id":game_id, "get_data":"gm"},
      success: function(data){
      	var obj = $.parseJSON(data);
        $(".del_game_title").text(obj['game_name']); 
        $("#delete").attr({
        	game_id: game_id,
        	plugin_uri: plugin_uri
        });; 
        // console.log(obj); 
      },
   });
});

$("#delete").click(function(event) {
	game_id = $(this).attr('game_id');
	plugin_uri = $(this).attr('plugin_uri');
	uri = plugin_uri+'modules/editGame.php';

	$.ajax({
      url: uri,
      type: 'post',
      data: {del:'del', game_id:game_id},
      success: function(data){
        console.log(data)
        window.location.reload();
      },
   	});
});

$("#change").click(function(event) {
	/* Act on the event */
	var fd = new FormData();

	g_name = $("#g_name").val();
	p_limit = $("#p_limit").val();
	due = $("#due").val();
	i_name = $("#i_name").val();
	i_img = $("#i_img")[0].files;
	tk_price = $("#tk_price").val();
	wd_text = $("#wd_text").val();
	game_id = $(this).attr('game_id');
	plugin_uri = $(this).attr('plugin_uri');
	uri = plugin_uri+'modules/editGame.php';
	// console.log(uri);

	if (g_name == '' || p_limit == '' || due == '' || i_name == '' || wd_text == '' || tk_price == '') {
	// if (g_name == 'kkkk') {
		$('.text-danger').text('All filed must be filled');
	}else{
		// console.log('kkk');
		$('.text-danger').text('');

		// $("#game_cr").submit();

		if (i_img['length'] == 0) {
			fd.append('i_img','no_change');
		}else{
			fd.append('i_img',i_img[0]);
		}
		fd.append('g_name',g_name);
		fd.append('p_limit',p_limit);
		fd.append('due',due);
		fd.append('i_name',i_name);
		fd.append('tk_price',tk_price);
		fd.append('wd_text',wd_text);
		fd.append('update',"up");
		fd.append('game_id',game_id);
		// console.log(i_img[0]);

		$.ajax({
          url: uri,
          type: 'post',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data){
            // console.log(data)
            if (data == 'success') {
            	$('.text-danger').text('');
            	$(".text-success").text(data);
            	setTimeout(function(){
            		window.location.reload();
            	}, 2500);
            }else{
            	$('.text-success').text('');
            	$('.text-danger').text('error');
            }
          },
       });
	}
});

$('.slider').click(function(event) {
	game_id = $(this).attr('game_id');
	plugin_uri = $('.edit').attr('plugin-uri');
	uri = plugin_uri+'modules/editGame.php';

	$.ajax({
      url: uri,
      type: 'post',
      data: {check_active:"ac", game_id:game_id},
      success: function(data){
      	sd_ajax = 0;
      	// if($('#'+game_id).is(':checked')){
      	// 	console.log("checked");
      	// }else{
      	// 	console.log("unchecked");
      	// }
      	console.log(data);

      	if($('#'+game_id).is(':checked')){
			ac = true;
			if (data == 'has_active') {
	        	$('.have_active').text("Already has one active game can't add more");
	        	setTimeout(function(){
	        		$('.have_active').text("");
	        	}, 4000);
	        	$('#'+game_id).prop( "checked", false );
	        	sd_ajax = 0
	        }
	        else if(data == 'has_winner'){
	        	$('.have_active').text("This game already has a winner can't make it active again");
	        	setTimeout(function(){
	        		$('.have_active').text("");
	        	}, 4000);
	        	$('#'+game_id).prop( "checked", false );
	        	sd_ajax = 0
	        }
	        else if(data == 'activate_this'){
	        	$('.have_active').text("");
	        	sd_ajax = 1;
	        }
		}else{
			ac = false;
			sd_ajax = 1;
		}

		if (sd_ajax == 1) {
			$.ajax({
		      url: uri,
		      type: 'post',
		      data: {ac:ac, game_id:game_id},
		      success: function(data){
		        console.log(data)
		      },
		   	});
		}
      },
   });
});