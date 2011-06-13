<h1><?php __( 'Scope of Work' ) ?></h1>

<p><?php __( 'Tell us a little bit about what you do.' ) ?></p>

<p><?php __( 'Knowing which equipment you service, which manufacturers you work with will help us tailor the leads we send you.' ) ?>

<?php echo $this->Form->create( 'Contractor' ) ?>
  <h2><?php __( 'Serviced Equipment' ) ?></h2>
  
  <?php foreach( $technologies as $i => $technology_chunk ): ?>
    <div class="input select horizontal">
      <?php foreach( $technology_chunk as $id => $name ): ?>
        <div class="checkbox">
          <input type="checkbox" name="data[Technology][]" id="<?php echo 'TechnologyTechnology' . $id ?>" value="<?php echo $id ?>" />
          <label for="TechnologyTechnology<?php echo $id ?>"><?php echo $name ?></label>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
  
  <div class="clear"></div>
  <h2><?php __( 'Manufacturer Relationships' ) ?></h2>
  
  <p><?php __( 'Select an equipment type above and let us know which manufacturers consider you a factory dealer.' ) ?></p>
  <ol id="manufacturer_lists">
    <!-- populated via javascript. @see /js/views/contractors/scope.js -->
  </ol>
  <div class="clear"></div>
<?php echo $this->Form->end( __( 'Next', true ) ) ?>
