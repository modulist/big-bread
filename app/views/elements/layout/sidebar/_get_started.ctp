<div id="getstart">
  <h2><?php __( 'Let\'s Get Started' ) ?></h2>
  <?php echo $this->Html->image( 'DownloadQ.png', array( 'url' => '/buildings/download_questionnaire' ) ) ?>
  <?php if( $this->Session->read( 'Auth.User.user_type_id' ) == UserType::OWNER || $this->action != 'questionnaire' ): ?>
    <?php echo $this->Html->image( 'AddAnotherQ.png', array( 'url' => Router::url( '/questionnaire' ) ) ) ?>
  <?php endif; ?>
</div>
