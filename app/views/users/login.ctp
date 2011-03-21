<h1>LOGIN</h1>

<?php echo $this->Form->create( 'User', array ( 'action' => 'login' ) ) ?>
  <?php echo $this->Form->input( 'User.email' ) ?>
  <?php echo $this->Form->input( 'User.password' ) ?>
<?php echo $this->Form->end( 'Login' ) ?> or <?php echo $this->Html->link( 'Register', array( 'controller' => 'users', 'action' => 'register' ) ) ?></p>

