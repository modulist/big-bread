<!-- start legacy code -->
<!-- <div id="my-locations" class="grid_9">
  <h3><?php __( 'Rebates for ' ) ?>Main House</h3>
  <div id="house_info">
    <p><b>
      <?php echo h( $building['Address']['address_1'] ) ?><br />
      <?php if( !empty( $building['Address']['address_2'] ) ): ?>
        <?php echo h( $building['Address']['address_2'] ) ?><br />
      <?php endif; ?>
      <?php echo h( $building['Address']['ZipCode']['city'] ) . ', ' . h( $building['Address']['ZipCode']['state'] ) . ' ' . h( $building['Address']['zip_code'] ) ?><br />
    </b></p>
    <br />
    <ul>
      <li>
        <b><?php echo h( $building['Client']['UserType']['name'] ) ?></b> |
        <?php echo h( $building['Client']['full_name'] ) ?> |
        <?php echo $this->Html->link( $building['Client']['email'], 'mailto:' . $building['Client']['email'] ) ?>
      </li>
      
      <?php if( !User::client( $this->Session->read( 'Auth.User.id' ) ) ): # ignore this stuff for clients ?>
        <?php foreach( array( 'Realtor', 'Inspector' ) as $role ): ?>
          <?php $user_type_id = $role == 'Realtor' ? UserType::REALTOR : UserType::INSPECTOR ?>
          <?php $display = $role == 'Realtor' ? __( 'Realtor', true ) : __( 'Inspector', true ) ?>
          <li>
            <b><?php echo $display ?></b> |
            <?php if( !empty( $building[$role]['email'] ) ): ?>
              <?php echo h( $building[$role]['full_name'] ) ?> |
              <?php echo $this->Html->link( $building[$role]['email'], 'mailto:' . $building[$role]['email'] ) ?>
              <?php if( !empty( $editable ) && $this->Session->read( 'Auth.User.user_type_id' ) != $user_type_id ): ?>
                <?php $link_text = $role == 'Realtor' ? __( 'Change Realtor', true ) : __( 'Change Inspector', true ) ?>
                | <?php echo $this->Html->link( $link_text, '#', array( 'class' => 'toggle-form', 'data-model' => $role ) ) ?>
              <?php endif; ?>
            <?php else: ?>
              <?php $link_text = $role == 'Realtor' ? __( 'Add Realtor Info', true ) : __( 'Add Inspector Info', true ) ?>
              <?php __( 'Not specified' ) ?>
              <?php if( !empty( $editable ) ): ?>
              | <?php echo $this->Html->link( $link_text, '#', array( 'class' => 'toggle-form', 'data-model' => $role ) ) ?>
              <?php endif; ?>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
      <?php endif; ?>
    </ul>
  </div>
</div>--><!-- end legacy code -->

<!-- new html code follows here -->
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

