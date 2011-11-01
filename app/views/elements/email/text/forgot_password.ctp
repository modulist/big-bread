<?php printf( __( 'Hello, %s:', true ), $user['first_name'] ) ?> 

<?php printf( __( 'To reset your password for the account with the username %s please visit %s. Once there you will be able to change your password.', true ), $user['email'], $this->Html->url( array( 'controller' => 'users', 'action' => 'reset_password', $invite_code ), true ) ) ?> 

<?php printf( __( ' If you didn\'t request this change, please let us know through our customer service form available at %s.', true ), $this->Html->url( array( 'controller' => 'messages', 'action' => 'feedback' ), true ) ) ?> 

<?php __( 'Mahalo,' ) ?> 
<?php __( 'The SaveBigBread Crew' ) ?> 
