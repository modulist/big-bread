<div id="contentheader">
  <h3><?php __( 'House Information' ) ?></h3>
  <div id="house_img">
    <?php echo $this->Html->image( '1b_60.png', array( 'title' => __( 'My House', true ) ) ) ?>
  </div>
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
        <b>Client</b> |
        <?php echo h( $building['Client']['full_name'] ) ?> |
        <?php echo $this->Html->link( $building['Client']['email'], 'mailto:' . $building['Client']['email'] ) ?>
      </li>
      
      <?php foreach( array( 'Realtor', 'Inspector' ) as $role ): ?>
        <?php $display = $role == 'Realtor' ? __( 'Realtor', true ) : __( 'Inspector', true ) ?>
        <li>
          <b><?php echo $display ?></b> |
          <?php if( !empty( $building[$role]['email'] ) ): ?>
            <?php echo h( $building[$role]['full_name'] ) ?> |
            <?php echo $this->Html->link( $building[$role]['email'], 'mailto:' . $building[$role]['email'] ) ?>
            <?php if( !empty( $edit ) ): ?>
              <?php $link_text = $role == 'Realtor' ? __( 'Change Realtor', true ) : __( 'Change Inspector', true ) ?>
              | <?php echo $this->Html->link( $link_text, '#', array( 'class' => 'toggle-form', 'data-model' => $role ) ) ?>
            <?php endif; ?>
          <?php else: ?>
            <?php $link_text = $role == 'Realtor' ? __( 'Add Realtor Info', true ) : __( 'Add Inspector Info', true ) ?>
            <?php __( 'Not specified' ) ?>
            | <?php echo $this->Html->link( $link_text, '#', array( 'class' => 'toggle-form', 'data-model' => $role ) ) ?>
          <?php endif; ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="clear"></div>
</div>
