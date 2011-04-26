<?php if( $this->action == 'incentives' ): ?>
  <?php if( !empty( $addresses ) ): ?>
    <table id="address">
    <thead>
      <tr>
        <th scope="col"><?php __( 'Address' ) ?></th>
        <th scope="col"><?php __( 'Date' ) ?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach( $addresses as $address ): ?>
        <tr>
          <td class="adrs">
            <a href="<?php echo $this->Html->url( array( 'action' => $this->action, $address['Building']['id'] ) ) ?>">
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
  <?php endif; ?>
<?php endif; ?>
