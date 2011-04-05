<!-- Include universal scripts -->
<?php echo $this->Html->script( 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js' ) . "\n" ?>
<?php echo $this->Html->script( 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js' ) . "\n" ?>
<?php echo $this->Html->script( 'application' ) ?>
<?php echo $this->Html->script( 'jquery/jquery.colorbox.min.js' ) ?>

<!-- Include any page-specific scripts -->
<?php if( file_exists( WWW_ROOT . 'js/views/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) . '.js' ) ): ?>
  <?php echo $this->Html->script( 'views/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) ) ?>
<?php endif; ?>
