<?php if( $this->Session->check( 'Message.success' ) ): ?>
  <div class="flash success">
    <?php echo $session->flash( 'success' ) ?>
  </div>
<?php endif; ?>
<?php if( $this->Session->check( 'Message.info' ) ): ?>
  <div class="flash info">
    <?php echo $this->Session->flash( 'info' ) ?>
  </div>
<?php endif; ?>
<?php if( $this->Session->check( 'Message.warning' ) ): ?>
  <div class="flash warning">
    <?php echo $this->Session->flash( 'warning' ) ?>
  </div>
<?php endif; ?>
<?php if( $this->Session->check( 'Message.error' ) ): ?>
  <div class="flash error">
    <?php echo $this->Session->flash( 'error' ) ?>
  </div>
<?php endif; ?>
<?php if( $this->Session->check( 'Message.validation' ) ): ?>
  <div class="flash validation">
    <?php echo $this->Session->flash( 'validation' ) ?>
  </div>
<?php endif; ?>
<?php if( $this->Session->check( 'Message.auth' ) ): ?>
  <div class="flash error">
    <?php echo $this->Session->flash( 'auth' ) ?>
  </div>
<?php endif; ?>
