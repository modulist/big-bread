<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<?php $classes = array( Inflector::underscore( $this->name ), Inflector::underscore( $this->action ) ) ?>
<?php if( $this->Session->check( 'Auth.User' ) ): ?>
  <?php $classes = array_merge( $classes, array( 'authenticated', strtolower( UserType::$lookup[$this->Session->read( 'Auth.User.user_type_id' )] ) ) ) ?>
<?php endif; ?>

<body class="layout-default <?php echo  join( ' ', $classes ) ?>">
  
<div id="wrapper" class="container_12">
  <header class="clearfix">
    <?php echo $this->element( 'layout/header' ) ?>
  </header><!-- #header -->
  
  <section id="page_content"> 				
    <div id="bodymain" class="clearfix">
      <aside id="sidebar">
        <!-- page-specific sidebar -->
        <?php if( file_exists( ELEMENTS . 'layout/sidebar/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) . '.ctp' ) ): ?>
          <?php echo $this->element( 'layout/sidebar/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) ) ?>
        <?php endif; ?>
      </aside> <!-- #sidebar -->
      
      <div id="content" class="grid_9 clearfix">
        <?php echo $this->element( 'layout/flash_messages' ) ?>
        
        <?php echo $content_for_layout ?>
      </div> <!-- #content -->
      
    </div> <!-- #bodymain -->
  </section> <!-- #page_content -->
  
  <footer id="footer">
    <?php echo $this->element( 'layout/footer' ) ?>
  </footer> <!-- #footer -->
</div> <!-- #wrapper -->
  
<?php echo $this->element( 'layout/include_scripts' ) ?>

<!-- Include any layout scripts -->
<?php echo $scripts_for_layout . "\n" ?>
 
<?php if( isset( $this->params['url']['debug'] ) ): ?>
  <!-- DEBUG INFORMATION -->
  <?php echo $this->element( 'sql_dump' ) ?>
<?php endif; ?>

</body>
</html>
