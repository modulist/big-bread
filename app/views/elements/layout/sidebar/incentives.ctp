<div id="tips">
    <div id="tiptop"> </div>
    <div id="tip">
      <h3 class="savings"><?php __( 'Helpful Tip' ) ?></h3>
    <p>"<?php __( 'As a minimum, combine the Federal Tax Credit with your state or utility rebate.  In some cases, you can take the federal, state and utility rebate together.' ) ?>"</p>
  </div>
  <div id="tipbtm"> </div>
</div>

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
          <a href="<?php echo Router::url( array( 'action' => 'incentives', $address['Building']['id'] ) ) ?>">
            <?php echo h( $address['Address']['address_1'] ) ?><br />
            <?php if( !empty( $address['Address']['address_2'] ) ): ?>
              <?php echo h( $address['Address']['address_2'] ) ?><br />
            <?php endif; ?>
            <?php echo h( $address['Address']['ZipCode']['city'] ) . ', ' . h( $address['Address']['ZipCode']['state'] ) . ' ' . h( $building['Address']['zip_code'] ) ?>
          </a>
        </td>
        <td class="date"><?php echo date( 'm/d/Y', strtotime( $address['Building']['created'] ) ) ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  </table>
<?php endif; ?>

<?php echo $this->element( 'layout/sidebar/_get_started' ) ?>
