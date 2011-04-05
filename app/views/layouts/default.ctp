<!DOCTYPE html>
<html lang="en">
<head>
  <?php echo $this->element( 'layout/head_content' ) ?>
</head>

<body>
  
<div id="wrapper">
  <!-- BEGIN COMMON HEADER -->
  <?php echo $this->element( 'layout/header' ) ?>
  <!-- END COMMON HEADER -->
  
  <div id="content">
    <!-- BEGIN  FLASH MESSAGES -->
    <?php echo $this->element( 'layout/flash_messages' ) ?>
    <!-- END  FLASH MESSAGES -->
    
    <!-- BEGIN PAGE CONTENT -->
    <?php echo $content_for_layout ?>
    <!-- END PAGE CONTENT -->
  </div>
  
  <!-- BEGIN COMMON FOOTER -->
  <?php echo $this->element( 'layout/footer' ) ?>
  <!-- END COMMON FOOTER -->
</div>
  
<?php echo $this->element( 'layout/include_scripts' ) ?>

<!-- Include any layout scripts -->
<?php echo $scripts_for_layout . "\n" ?>
 
<?php if( isset( $this->params['url']['debug'] ) ): ?>
  <!-- DEBUG INFORMATION -->
  <?php echo $this->element( 'sql_dump' ) ?>
<?php endif; ?>

</body>
</html>
