<?php echo h( $message ) ?> 

<?php __( 'Additional information:' ) ?> 
=======================
<?php printf( __( 'Name: %s', true ), $sender['full_name'] ) ?> 
<?php printf( __( 'Company: %s', true ), !empty( $sender['company'] ) ? $sender['company'] : __( 'Not specified', true ) ) ?> 
<?php printf( __( 'Phone Number: %s', true ), !empty( $sender['phone_number'] ) ? $sender['phone_number'] : __( 'Not specified', true ) ) ?> 
<?php printf( __( 'Zip code: %s', true ), $sender['zip_code'] ) ?> 
<?php printf( __( 'User Type: %s', true ), $sender['user_type'] ) ?> 