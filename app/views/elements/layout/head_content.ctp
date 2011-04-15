<meta charset="utf-8" />
<title><?php echo 'BigBread.net' . ( !empty( $title_for_layout ) ? ' : ' . $title_for_layout : '' ) ?></title>

<?php echo $this->Html->meta( 'icon' ) . "\n" ?>

<!--[if lt IE 9]>
<?php echo $this->Html->script( 'http://html5shiv.googlecode.com/svn/trunk/html5.js' ) . "\n" ?>
<![endif]-->

<?php echo $this->Html->css( 'screen', 'stylesheet', array( 'media' => 'screen' ) ) ?>
<?php echo $this->Html->css( 'print', 'stylesheet', array( 'media' => 'print' ) ) ?>

<!-- Colorbox creates a nice looking modal -->
<?php echo $this->Html->css( '/js/jquery/colorbox/colorbox.css' ) ?>
