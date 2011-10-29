<p><?php echo h( $message ) ?></p>

<p><?php __( 'Additional information:' ) ?></p>
<hr />
<p>
  <?php printf( __( 'Name: %s', true ), $sender['full_name'] ) ?><br />
  <?php printf( __( 'Company: %s', true ), !empty( $sender['company'] ) ? $sender['company'] : __( 'Not specified', true ) ) ?><br />
  <?php printf( __( 'Phone Number: %s', true ), !empty( $sender['phone_number'] ) ? $sender['phone_number'] : __( 'Not specified', true ) ) ?><br />
  <?php printf( __( 'Zip code: %s', true ), $sender['zip_code'] ) ?><br />
  <?php printf( __( 'User Type: %s', true ), $sender['user_type'] ) ?>
</p>