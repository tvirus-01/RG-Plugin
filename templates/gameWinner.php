<?php
  global $wpdb;
  $prefix = $wpdb->prefix;

?>
<!-- content -->
<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <h1 class="text-center">Winner List</h1>
    </div>
  </div>

  <div class="row">
    <div class="col">
  		<table class="table table-bordered">
            <thead>
              <tr>
                <th>Game Name</th>
                <th>Item Name</th>
                <th>Winner Name</th>
              </tr>
            </thead>
            <tbody>
            	<?php
            		$sql = "SELECT {$prefix}rg_game_info.game_name, {$prefix}rg_game_info.item_title, {$prefix}rg_game_winner.user_id FROM `{$prefix}rg_game_info` INNER JOIN {$prefix}rg_game_winner ON {$prefix}rg_game_info.id = {$prefix}rg_game_winner.game_id";
            		$result = $wpdb->get_results($sql);

            		$tx = '';
                    if ($wpdb->num_rows > 0) {
                      foreach ($result as $key) {
                      	$user_id = $key->user_id;
                      	$user = get_userdata( $user_id );
                      	$user_meta = get_user_meta( $user_id );
                      	$tx .= '<tr>';
                      	$tx .= '<td>'.$key->game_name.'</td>';
                        $tx .= '<td>'.$key->item_title.'</td>';
                        $tx .= '<td><a href="#" user_id="'.$user_id.'" type="button" class="user_info btn-link" data-toggle="modal" data-target="#exampleModalCenter">'.$user->display_name.'</a></td>';
                        $tx .= '</tr>';
                      }
                  	}else{
                    	$tx .= '<tr><td>No Winner Yet</td></tr>';
                    }

                    // print_r($user);
                    // echo "</br>";
                    // print_r($user_meta);
                    if (empty($user_meta)) {
                    	$tx .='<input type="hidden" id="'.$user_id.'" info="no" >';
                    }elseif (!isset($user_meta['billing_address_1'][0]) || !isset($user_meta['billing_city'][0]) || !isset($user_meta['billing_postcode'][0]) || !isset($user_meta['billing_country'][0]) || !isset($user_meta['billing_phone'][0]) || !isset($user->display_name) || !isset($user->user_email)) {
                    	$tx .='<input type="hidden" id="'.$user_id.'" info="no" >';
                    }else{
                    	$tx .='<input type="hidden" info="yes" id="'.$user_id.'" user_name="'.$user->display_name.'" user_email="'.$user->user_email.'" street="'.$user_meta['billing_address_1'][0].'" city="'.$user_meta['billing_city'][0].'" post_code="'.$user_meta['billing_postcode'][0].'" country="'.$user_meta['billing_country'][0].'" phone="'.$user_meta['billing_phone'][0].'" >';
                    }

                    echo $tx;
            	?>
            </tbody>
        </table>
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">User Info</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
          	<div class="col">
          		<div id="dump_data">
          			
          		</div>
          	</div>
          </div>
        </div>
        <div class="modal-footer">
          <span class="text-danger"></span>
          <span class="text-success"></span>
          <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
          <!-- <button type="button" class="btn btn-primary" game_id="" id="change">Save changes</button> -->
        </div>
      </div>
    </div>
  </div>
<!-- content end -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/admin.js', __FILE__ ); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/popper.min.js', __FILE__ ); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/bootstrap-material-design.min.js', __FILE__ ); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/perfect-scrollbar.jquery.min.js', __FILE__ ); ?>"></script>