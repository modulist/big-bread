<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body class="no-js">
  
<div id="wrapper">
  <header>
    <?php echo $this->element( 'layout/header' ) ?>
  </header><!-- #header -->
  
  <section  id="page_content">
    <?php echo $this->element( 'layout/header_rebate_bar' ) ?>
  				
    <div id="bodymain">
      
      <aside id="sidebar">
        <?php echo $this->element( 'layout/sidebar/' . $this->action ) ?>
      </aside> <!-- #sidebar -->
  
      <div id="content">
        <?php echo $this->element( 'layout/flash_messages' ) ?>
        
        <?php echo $content_for_layout ?>
      </div>
      <div class="clear"></div>
      
    </div><!-- #bodymain -->
    <div class="clear"></div>
  </section><!-- #page_content -->
  <div class="clear"></div>
  
  <footer>
    <?php echo $this->element( 'layout/footer' ) ?>
  </footer>
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
