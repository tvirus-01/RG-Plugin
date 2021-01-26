<div class="container-fluid" id="buy_ticket_sec">
	<div class="row justify-content-center">
		<div class="col">
			<?php
				if (!is_user_logged_in()) {
			?>
				<div class="alert alert-warning" role="alert">
				  !you are not logged in please <a href="login">login</a> to buy ticket
				</div>
			<?php
				}else{
			?>
				<div class="deposite-content">
					<div class="diposite-box">
						<div class="deposite-table">
							<table>
								<tbody>
									<tr>
										<th>Game Name</th>
										<th>Ticket Left</th>
										<th>Ticket Price</th>
										<th>Last Date</th>
										<th>Prize</th>
										<th>Buy ticket</th>
									</tr>
									<tr>
										<td><?php echo $game_name; ?></td>
										<td><?php echo $total_left; ?></td>
										<td><?php echo $crr_sym.$tk_price; ?></td>
										<td><?php echo $duration; ?></td>
										<td><?php echo $item_title; ?></td>
										<?php
											if ($already_purchased == 1) {
												echo '<td class="alert alert-warning" role="alert">
													  !you already purchased a ticket.
													</td>';
											}else{
												echo '<td id="purch_ticket_td"><button class="btn" id="purch_ticket">Buy Your Ticket</button></td>';
											}
										?>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<form method="post" id="buy_ticket_form">
					<input type="hidden" name="buy_ticket_submit">
				</form>

				<script type="text/javascript">
					$("#purch_ticket").click(function(event) {
					    $("#buy_ticket_form").submit();
					});
					var tic_buy = $("#tic_buy").val();

					if (tic_buy != '0') {
						window.location.href = tic_buy;
					}
				</script>
			<?php } ?>
		</div>
	</div>
</div>