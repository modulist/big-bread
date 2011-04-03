<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title><?php echo __( 'Federated Power', true ) ?><?php echo !empty( $title_for_layout ) ? ' : ' . $title_for_layout : '' ?></title>
  
  <?php echo $this->Html->meta( 'icon' ) . "\n" ?>
  
  <!--[if lt IE 9]>
  <?php echo $this->Html->script( 'http://html5shim.googlecode.com/svn/trunk/html5.js' ) . "\n" ?>
  <![endif]-->
  
  <?php echo $this->Html->css( 'screen', 'stylesheet', array( 'media' => 'screen' ) ) ?>
  
  <!-- Colorbox creates a nice looking modal that might be useful -->
  <?php # echo $this->Html->css( '/js/vendors/jquery-colorbox.css' ) ?>
</head>

<body>
  
<div id="wrapper">
  <div id="topheader">
    <div id="version"><?php echo $this->Html->image( 'beta.png', array( 'title' => 'beta' ) ) ?></div>
    <div id="logo">
      <?php echo $this->Html->image( 'logo.png', array( 'url' => Router::url( '/' ), 'title' => 'beta' ) ) ?>
    </div>
    <div id="nav-links">
      <ul id="menu">
        <li class="first"><?php echo $this->Html->link( 'Invite Friends', '#' ) ?></li>
        <li><?php echo $this->Html->link( 'Manage Profile', '#' ) ?></li>
        <li><?php echo $this->Html->link( 'Contact', Router::url( '/contact' ) ) ?></li>
        <li class="last"><?php echo $this->Html->link( 'Logout', Router::url( '/logout' ) ) ?></li>
      </ul>
    </div>
  </div>
  
  <div class="menu">
    <div id="menubar">
      <a href="#"><?php echo $this->Html->image( 'menubtn1.png' ) ?></a>
      <a href="#" ><?php echo $this->Html->image( 'menubtn2.png' ) ?></a>  
    </div>
  </div>
  <div class="clear"></div>
  
  <div id="pagebody"> <div id="bodyheader"> 
    <div id="bodyheaderhead">23</div>
    <ul>
      <li ><div class="savings">$23</div><a href="#"><div id="eq1">2</div></a></li>
      <li ><div class="savings">$23</div><a href="#"><div id="eq2">2</div></a></li>
      <li ><div class="savings">$23</div><a href="#"><div id="eq3">2</div></a></li>
      <li ><div class="savings">$23</div><a href="#"><div id="eq4">2</div></a></li>
      <li ><div class="savings">$23</div><a href="#"><div id="eq5">2</div></a></li>
      <li ><div class="savings">$23</div><a href="#"><div id="eq6">2</div></a></li>
      <li ><div class="savings">$23</div><a href="#"><div id="eq7">2</div></a></li>
      <li ><div class="savings">$23</div><a href="#"><div id="eq8">2</div></a></li>
    </ul>
    </div><div class="clear"></div>
    <div id="bodymain">
      <div id="sidebar">
        <div id="tips">
        <div id="tiptop"></div>
        <div id="tip">
          <h3>Helpful Tip #4</h3>
          <p>"Make sure you Cras sed ante. Phasellus in massa. Curabitur dolor eros, gravida et, hendrerit ac, cursus non, massa."</p>
        </div>
        <div id="tipbtm"></div>
</div>
<table id="address" cellspacing="0">
  <tr>

    <th scope="col">Address</th>
    <th scope="col">date</th>
 
  </tr>
  <tr>
    <td class="adrs">725 Sunllower Court<br>
Purcellville, VA 20132
</td>
    <td >12/09/12</td>

  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>
Purcellville, VA 20132
</td>
    <td>12/09/12</td>
  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>

Purcellville, VA 20132
</td>
    <td>12/09/12</td>
  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>
Purcellville, VA 20132
</td>
    <td>12/09/12</td>

  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>
Purcellville, VA 20132
</td>
    <td>12/09/12</td>
  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>

Purcellville, VA 20132
</td>
    <td>12/09/12</td>
  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>
Purcellville, VA 20132
</td>
    <td>12/09/12</td>

  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>
Purcellville, VA 20132
</td>
    <td>12/09/12</td>
  </tr>
    <tr>
    <td class="adrs">725 Sunllower Court<br>

Purcellville, VA 20132
</td>
    <td>12/09/12</td>
  </tr>
</table>

</div>
<div id="content">
<div id="contentheader"><h3>House Information</h3><div id="house_img"><img alt="" src="/img/1b_60.png"></div><div id="house_info">
<p><b>725 Sunflower Court<br>
Purcellville, VA 20132<br>

703-555-5040</b></p>
<br>
<ul><li><b>Home Owner</b> | Brian Johndson | <a href="#" >brian@mac.com</a>
</li><li><b>Realtor</b> | Brian Murphy | <a href="#" >brian@realtor.com</a>
</li><li><b>Inspector</b> | Bob Deene | <a href="#" >bob@inspect.com</a>

</li></ul>
</div><div class="clear"></div></div>
  
  
  
  
  
  
  
  
  
  
  <div id="pagebody">
    <div id="bodygeneral">
      <div id="general_content">
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
        
        <?php echo $content_for_layout ?>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <div id="footer">
    <div id="footerright">
      <a href="#" ><?php echo $this->Html->image( 'versing.png' ) ?></a>
      <a href="#" ><?php echo $this->Html->image( 'truste.png' ) ?></a>
      <a href="#" ><?php echo $this->Html->image( 'mcAfee.png' ) ?></a>
    </div>
    <div id="footerleft">
      <a href="#" ><?php echo $this->Html->image( 'poweredBy.png' ) ?></a>
      <p><a href="#" >Why BigBread.net </a> | <a href="#" >Our Background</a> | <a href="#" >Privacy & Security</a> | <a href="#" >Terms of Use</a></p><p>
      © 2009-2011 Federated Power, Inc. | Beta 1.0</p>
    </div>
  </div>
</div>
  
<!-- Include universal scripts -->
<?php echo $this->Html->script( 'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js' ) . "\n" ?>
<?php echo $this->Html->script( 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js' ) . "\n" ?>
<?php # echo $this->Html->script( 'application' ) ?>
<?php # echo $this->Html->script( 'vendors/jquery-colorbox.min.js' ) ?>

<!-- Include any layout scripts -->
<?php echo $scripts_for_layout . "\n" ?>
 
<!-- Include any page-specific scripts -->
<?php if( file_exists( WWW_ROOT . 'js/views/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) . '.js' ) ): ?>
  <?php echo $this->Html->script( 'views/' . Inflector::underscore( $this->name ) . '/' . Inflector::underscore( $this->action ) ) ?>
<?php endif; ?>

<?php if( isset( $this->params['url']['debug'] ) ): ?>
  <!-- DEBUG INFORMATION -->
  <?php echo $this->element( 'sql_dump' ) ?>
<?php endif; ?>

</body>
</html>
