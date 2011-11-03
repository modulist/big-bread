<?php printf( __( 'Hi, %s:', true ), $recipient_first_name ) ?> 

<?php printf( __( 'This is a list of My Interests rebates for review by %s as of %s. Note that rebates are changed at the discretion of the program sponsor without any prior notice. As such, it\'s best to rely on the information on the site.', true ), h( $client_name ), date( DATE_FORMAT_LONG_WITH_DAY ) ) ?> 

<?php __( 'In order to access their account, your client has received an invitation email to register on SaveBigBread. They simply need to click on the link in the email. Once they arrive on the site, all they need to do is register a password and they\'ll see your entries and all the current rebates for where they live.' ) ?> 

<?php __( 'Regards,' ) ?> 
<?php __( 'Tony Maull' ) ?> 
<?php __( 'CEO and President' ) ?> 