<?php
	global $wpdb;
	$prefix = $wpdb->prefix;
?>
<div class="wrapper ">
	<!-- content -->
      <div class="content">
        <div class="container-fluid">


          <div class="row">
            <div class="col">
              <h1 class="text-center">Games List</h1>
            </div>
          </div>

          <div class="row">
            <div class="col">
            	<a href="?page=rg_create_game" class="btn btn-primary">Add New</a>
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Game Name</th>
                    <th>Item Name</th>
                    <th>Ticket Price</th>
                    <th>Time Left</th>
                    <th>Active</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $sql_1 = "SELECT * FROM `{$prefix}rg_game_info` ORDER BY id DESC";
                    $result = $wpdb->get_results($sql_1);
                    // echo $result->num_rows;

                    $tx = '';
                    if ($wpdb->num_rows > 0) {
                      foreach ($result as $key) {
                        $tx .= '<tr>';
                        $tx .= '<td>'.$key->game_name.'</td>';
                        $tx .= '<td>'.$key->item_title.'</td>';
                        $tx .= '<td>$'.$key->tk_price.'</td>';

                        $now = new DateTime();
                        $future_date = new DateTime($key->duration);
                        $interval = $future_date->diff($now);
                        if($future_date <= $now){
                          $tx .= '<td>Times Up</td>';
                          $tm = 0;
                        }else{
                          $tx .= '<td>'.$interval->format("%a days, %h hours, %i minutes").'</td>';
                          $tm = 1;
                        }

                        $tx .= '<td><label class="switch">';
                        if ($key->is_active == true) {
                        	$tx .= '<input type="checkbox" id="'.$key->id.'" class="ac_switch" is_active="1" checked>';
                        }else{
                        	$tx .= '<input type="checkbox" id="'.$key->id.'" class="ac_switch"  is_active="0" >';
                        }								  
						$tx .=  '<span class="slider round" game_id="'.$key->id.'"></span>
								</label>';
                        
                        $tx .= '<td><a href="#" game_id="'.$key->id.'" tm="'.$tm.'" id="edit" type="button" class="edit btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" plugin-uri="'.plugins_url( '../', __FILE__ ).'">edit</a>';
                        $tx .= '<a href="#" game_id="'.$key->id.'" id="del" type="button" class="del btn btn-danger ml-3" data-toggle="modal" data-target="#exampleModalCenter_1" plugin-uri="'.plugins_url( '../', __FILE__ ).'">delete</a></td>';
                        $tx .= '</tr>';

                        // echo $key['game_name'];
                      }
                    }else{
                    	$tx .= '<tr><td>No Data</td></tr>';
                    }
                    echo $tx;
                  ?>
                </tbody>
              </table>
              <span class="text-danger have_active"></span>
              <span class="text-success active_sms"></span>
            </div>
          </div>

          <!-- Modal -->
          <div class="modal fade" id="exampleModalCenter_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                	<h5 class="modal-title" id="exampleModalLongTitle_1">Delete Game <span class="del_game_title"></span></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                	<h4>Are you sure you want to delete "<span class="del_game_title"></span>"</h4>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-danger float-left" game_id="" id="delete">Yes Delete</button>
                  <button type="button" class="btn btn-secondary float-right" id="close" data-dismiss="modal">Cancle</button>
                </div>
            	</div>
        		</div>
        	</div>

          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Edit Game Title</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="game_cr" action="../modules/createGame.php" method="post">
                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Game Name</label>
                          <input type="text" name="g_name" id="g_name" class="form-control" placeholder="e.g. Raffle game 1">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Percipients Limit</label>
                          <input type="number" name="p_limit" id="p_limit" class="form-control" placeholder="e.g. 10">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <label>Duration</label>
                          <input type="datetime-local" name="due" id="due" class="form-control">
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Items Title</label>
                          <input type="text" name="i_name" id="i_name" class="form-control"  placeholder="e.g. Nike Air Jordan">
                        </div>
                      </div>
                      <div class="col">
                        <label>Items Image</label><br>
                        <input type="file" onchange="loadFile(event)" style="display:none;" accept="image/*" name="i_img" id="i_img" class="form-control">
                        <button type="button" class="btn img-upload">Change</button>
                        <img src="<?php echo plugins_url( '../assets/img/blank.jpg', __FILE__ ); ?>" id="img_prev">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Ticket Price</label>
                          <input type="number" name="tk_price" id="tk_price" class="form-control"  placeholder="e.g. 5">
                        </div>
                      </div>
                      <div class="col">
                        <div class="form-group">
                          <!-- <label>Ticket Price</label>
                          <input type="number" name="tk_price" id="tk_price" class="form-control"  placeholder=""> -->
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col">
                        <div class="form-group">
                          <label>Winner Declartion Text</label>
                          <input type="text" name="wd_text" id="wd_text" class="form-control"  placeholder="e.g. Todays Winner Is Mr. Jhon">
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="modal-footer">
                  <span class="text-danger"></span>
                  <span class="text-success"></span>
                  <button type="button" class="btn btn-secondary" id="close" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" game_id="" id="change">Save changes</button>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <!-- content end -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/admin.js', __FILE__ ); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/popper.min.js', __FILE__ ); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/bootstrap-material-design.min.js', __FILE__ ); ?>"></script>
<script type="text/javascript" src="<?php echo plugins_url( '../assets/js/perfect-scrollbar.jquery.min.js', __FILE__ ); ?>"></script>