<h1><?php __( 'Scope of Work' ) ?></h1>

<p><?php __( 'Tell us a little bit about what you do.' ) ?></p>

<p><?php __( 'Knowing which equipment you service, which manufacturers you work with will help us tailor the leads we send you.' ) ?>

<?php echo $this->Form->create( 'Contractor' ) ?>
  <h2><?php __( 'Serviced Equipment' ) ?></h2>
  
  <?php foreach( $technologies as $i => $technology_chunk ): ?>
    <div class="input select horizontal">
      <?php foreach( $technology_chunk as $id => $name ): ?>
        <div class="checkbox">
          <input type="checkbox" name="data[Technology][]" id="<?php echo 'TechnologyTechnology' . $id ?>" value="<?php echo $id ?>"<?php echo in_array( $id, $technology_scope ) ? ' checked="checked"' : false ?> />
          <label for="TechnologyTechnology<?php echo $id ?>"><?php echo $name ?></label>
        </div>
      <?php endforeach; ?>
    </div>    
  <?php endforeach; ?>
  
  <div class="clear"></div>
  <h2><?php __( 'Manufacturer Relationships' ) ?></h2>
  
  <p><?php __( 'Select an equipment type above and let us know which manufacturers consider you a factory dealer.' ) ?></p>
  <ol id="manufacturer_lists">
    <?php if( !empty( $tech_manufacturers ) ): ?>
      <?php foreach( $tech_manufacturers as $tech ): ?>
        <?php if( !empty( $tech['EquipmentManufacturer'] ) ): ?>
          <li id="manufacturer_<?php echo $tech['Technology']['id'] ?>" class="column">
            <h3><?php echo $tech['Technology']['name'] ?></h3>
            <ol>
              <?php foreach( $tech['EquipmentManufacturer'] as $i => $manufacturer ): ?>
                <?php $input_id = 'Manufacturer' . $manufacturer['id'] ?>
                <li data-manufacturer-id="<?php echo $manufacturer['id'] ?>">
                  <input type="checkbox" data-for="equipment_manufacturer_id" class="manufacturer" name="data[ManufacturerDealer][<?php echo $i ?>][equipment_manufacturer_id]" id="<?php echo $input_id ?>" value="<?php echo $manufacturer['id'] ?>"<?php echo array_key_exists( $manufacturer['id'], $manufacturer_dealer ) ? ' checked="checked"' : false ?> />
                  <label for="<?php echo $input_id ?>"><?php echo $manufacturer['name'] ?></label>
                  
                  <div style="display: <?php echo array_key_exists( $manufacturer['id'], $manufacturer_dealer ) ? 'block' : 'none' ?>; padding-left: 10px;">
                    <input type="checkbox" data-for="incentive_participant" name="data[ManufacturerDealer][<?php echo $i ?>][incentive_participant]" id="IncentiveParticipant<?php echo $manufacturer['id'] ?>" value="1"<?php echo array_key_exists( $manufacturer['id'], $manufacturer_dealer ) && $manufacturer_dealer[$manufacturer['id']]['incentive_participant'] ? ' checked="checked"' : false ?> />
                    <label for="IncentiveParticipant<?php echo $manufacturer['id'] ?>">I am incentive certified</label>
                  </div>
                </li>
              <?php endforeach; ?>
            </ol>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </ol>
  <div class="clear"></div>
  
  <div class="buttons">
    <div class="button">
      <input type="submit" value="<?php __( 'Next' ) ?>" />
    </div>
    <div class="button">
      <input type="reset" value="<?php __( 'Back' ) ?>" class="previous" data-previous="<?php echo Router::url( $previous_url ) ?>" />
    </div>
  </div>
<?php echo $this->Form->end() ?>
