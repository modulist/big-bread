<div id="my-locations" class="grid_9">
	<div class="clearfix">
		<a href="#" class="add-location-button">Add a location &rsaquo;</a>
		<h2><?php __( 'Rebates for ' ) ?>Main House</h2>
	</div>
	<div class="location-wrapper clearfix">
		<div class="location-icon">1</div>
		<h4>Main House</h4>
		<div class="location-address">
			<p>
				<?php echo h( $building['Address']['address_1'] ) ?><br />
	      <?php if( !empty( $building['Address']['address_2'] ) ): ?>
	        <?php echo h( $building['Address']['address_2'] ) ?><br />
	      <?php endif; ?>
	      <?php echo h( $building['Address']['ZipCode']['city'] ) . ', ' . h( $building['Address']['ZipCode']['state'] ) . ' ' . h( $building['Address']['zip_code'] ) ?><br />
			</p>
			<a href="#" class="edit-location-button">Edit</a>
		</div>
		<div class="location-equipment-grid grid_5">
			<table class="location-equipment">
				<tr class="first odd">
					<td class="model-name"><a href="#">Kenmore washer</a></td>
					<td class="model-number"><a href="#">110.27087601</a></td>
					<td class="controls">
						<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
					</td>
				</tr>
				<tr class="even">
					<td class="model-name"><a href="#">Kenmore dryer</a></td>
					<td class="model-number"><a href="#">110.67087600</a></td>
					<td class="controls">
						<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
					</td>
				</tr>
				<tr class="last odd">
					<td class="model-name"><a href="#">Kenmore washer</a></td>
					<td class="model-number"></td>
					<td class="controls">
						<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
					</td>
				</tr>
			</table>
			<a class="add-equipment-button" href="#">Add equipment</a>
		</div><!-- /location-equipment-grid -->
	</div><!-- /location-wrapper -->
</div><!-- /my-locations -->

