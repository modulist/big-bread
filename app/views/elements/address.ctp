<div class="address">
  <?php echo h( $address['address_1'] ) ?><br />
  <?php if( !empty( $address['address_2'] ) ): ?>
    <?php echo h( $address['address_2'] ) ?><br />
  <?php endif; ?>
  <?php printf( '%s, %s %s', h( $address['ZipCode']['city'] ), h( $address['ZipCode']['state'] ), h( $address['zip_code'] ) ) ?>
</div>