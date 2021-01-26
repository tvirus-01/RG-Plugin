<?php
  global $wpdb;
  $prefix = $wpdb->prefix;
  if (isset($_POST['g_name'])) {
    $g_name = $_POST['g_name'];
    $p_limit = $_POST['p_limit'];
    $due = $_POST['due'];
    $i_name = $_POST['i_name'];
    $tk_price = $_POST['tk_price'];
    $wd_text = $_POST['wd_text'];

    $post_id = wp_insert_post( array(
        "post_title" => "Ticket-{$g_name}",
        "post_name" => "Ticket-{$g_name}",
        "post_type" => "product",
        "post_status" => "Published",
        "post_content" => "Ticket for raffle draw",
        "post_excerpt" => "RG_ticket",
    ));

    wp_set_object_terms( $post_id, 'simple', 'product_type' );
    update_post_meta( $post_id, '_stock_status', 'instock');
    update_post_meta( $post_id, 'total_sales', '0' );
    update_post_meta( $post_id, '_downloadable', 'no' );
    update_post_meta( $post_id, '_virtual', 'yes' );
    update_post_meta( $post_id, '_regular_price', '' );
    update_post_meta( $post_id, '_sale_price', '' );
    update_post_meta( $post_id, '_purchase_note', '' );
    update_post_meta( $post_id, '_featured', 'no' );
    update_post_meta( $post_id, '_price', $tk_price );
    update_post_meta( $post_id, '_stock', $p_limit );
    update_post_meta( $post_id, '_sold_individually', '' );
    update_post_meta( $post_id, '_manage_stock', 'yes' );
    wc_update_product_stock($post_id, $single['qty'], 'set');
    update_post_meta( $post_id, '_backorders', 'no' );
  }
?>
<!-- content -->
<div class="content">
<div class="container-fluid">
  <div class="row">
    <div class="col">
      <h1 class="text-center">Create Game</h1>
    </div>
  </div>

  <div class="row">
    <div class="col">
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
            <button type="button" class="btn img-upload">Upload</button>
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

        <div class="row">
          <div class="col">
            <div class="form-group">
              <button class="btn btn-primary" type="button" id="submit" plugin-uri="<?php echo plugins_url( '../', __FILE__ ); ?>">Create Game</button>
              <a href="?page=rg_plugin" class="btn">Cancle</a>
              <span class="text-danger"></span>
              <span class="text-success"></span>
            </div>
          </div>
        </div>
      </form>
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