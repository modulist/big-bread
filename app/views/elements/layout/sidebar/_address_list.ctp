<?php if( !empty( $addresses ) ): ?>
  <?php $addresses = array_chunk( $addresses, 10 ) ?>
  
  <ul id="address-panels">
    <?php foreach( $addresses as $i => $address_page ): ?>
      <li>
        <table id="address-panel">
        <thead>
          <tr>
            <th scope="col"><?php __( 'Address' ) ?> (<?php echo ( $i + 1 ) . ' of ' . count( $addresses) ?>)</th>
            <th scope="col"><?php __( 'Date' ) ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach( $address_page as $address ): ?>
            <?php $tooltip = $this->action == 'incentives'
              ? __( 'Show incentives for this property', true )
              : __( 'View and edit the details of this property', true );
            ?>
            <tr>
              <td class="adrs">
                <a href="<?php echo $this->Html->url( array( 'action' => $this->action, $address['Building']['id'] ) ) ?>" title="<?php echo $tooltip ?>">
                  <?php echo h( $address['Address']['address_1'] ) ?><br />
                  <?php if( !empty( $address['Address']['address_2'] ) ): ?>
                    <?php echo h( $address['Address']['address_2'] ) ?><br />
                  <?php endif; ?>
                  <?php echo h( $address['Address']['ZipCode']['city'] ) . ', ' . h( $address['Address']['ZipCode']['state'] ) . ' ' . h( $address['Address']['zip_code'] ) ?>
                </a>
              </td>
              <td class="date"><?php echo date( 'm/d/Y', strtotime( $address['Building']['created'] ) ) ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
        </table>
      </li>
    <?php endforeach; ?>
  </ul>
  <div id="address-panel-nav">
    <?php echo $this->Html->link( '&laquo; ' . __( 'Previous', true ), '#', array( 'class' => 'previous', 'escape' => false ) ) ?>
    <?php echo $this->Html->link( __( 'Next', true ) . ' &raquo;', '#', array( 'class' => 'next', 'escape' => false ) ) ?>
    <div class="clear"></div>
  </div>
<?php endif; ?>
