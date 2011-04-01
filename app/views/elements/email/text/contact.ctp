<?php echo $message . "\n\n" ?>

<?php echo __( 'Additional information:', true ) . "\n" ?>
=======================
<?php echo __( 'Name: ', true ) . $name . "\n" ?>
<?php echo __( 'Company: ', true ) . ( !empty( $company ) ? $company : __( 'Not specified', true ) ) . "\n" ?>
<?php echo __( 'Phone Number: ', true ) . ( !empty( $this->data['Contact']['phone_number'] ) ? $this->data['Contact']['phone_number'] : 'Not specified' ) . "\n" ?>
<?php echo __( 'Zip code: ', true ) . $zip_code . "\n" ?>
<?php echo __( 'Org. Type: ', true ) . $organization_type . "\n" ?>
