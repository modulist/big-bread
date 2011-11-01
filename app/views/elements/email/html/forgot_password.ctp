<p><?php printf( __( 'Hello, %s:', true ), $user['first_name'] ) ?></p>

<p><?php printf( __( 'To reset your password for the account with the username %s, please visit %s. Once there you will be able to change your password.', true ), $user['email'], $this->Html->url( array( 'controller' => 'users', 'action' => 'reset_password', $invite_code ), true ) ) ?></p>

<p><?php printf( __( ' If you didn\'t request this change, %s.', true ), $this->Html->link( __( 'please let us know', true ), $this->Html->url( array( 'controller' => 'messages', 'action' => 'feedback' ), true ) ) ) ?></p>

<p><?php __( 'Mahalo,' ) ?></p>
<p><?php __( 'The SaveBigBread Crew' ) ?></p>
