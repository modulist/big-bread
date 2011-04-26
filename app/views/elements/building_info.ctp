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
      <?php if( !empty( $building['Realtor']['email'] ) ): ?>
        <li>
          <b><?php __( 'Realtor' ) ?></b> |
          <?php echo h( $building['Realtor']['full_name'] ) ?> |
          <?php echo $this->Html->link( $building['Realtor']['email'], 'mailto:' . $building['Realtor']['email'] ) ?>
          <?php if( !empty( $edit ) ): ?>
            | <?php echo $this->Html->link( __( 'Change Realtor', true ), '#', array( 'class' => 'toggle-form', 'data-model' => 'Realtor' ) ) ?>
          <?php endif; ?>
        </li>
      <?php endif; ?>
      <?php if( !empty( $building['Inspector']['email'] ) ): ?>
        <li>
          <b><?php __( 'Inspector' ) ?></b> |
          <?php echo h( $building['Inspector']['full_name'] ) ?> |
          <?php echo $this->Html->link( $building['Inspector']['email'], 'mailto:' . $building['Inspector']['email'] ) ?>
          <?php if( !empty( $edit ) ): ?>
            | <?php echo $this->Html->link( __( 'Change Inspector', true ), '#', array( 'class' => 'toggle-form', 'data-model' => 'Inspector' ) ) ?>
          <?php endif; ?>
        </li>
      <?php endif; ?>
    </ul>
  </div>
  <div class="clear"></div>
</div>
