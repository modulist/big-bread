<?php $this->set( 'title_for_layout', __( 'My House', true ) ) ?>

<?php echo $this->Html->script( array( 'jquery/jquery.editable-1.3.3.min.js' ), array( 'inline' => false ) ) ?>
<?php echo $this->Html->css( 'jqueryui/themes/aristo/jquery-ui-1.8.7.custom.css', null, array( 'inline' => false ) ) ?>

<?php echo $this->element( 'building_info', array( 'edit' => true ) ) ?>

<div id="general_Info">
  <div id="info">
    <div class="sliding-panel" id="realtor">
      <h1><?php __( 'Change Realtor' ) ?></h1>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'realtor' ) ) ) ?>
        <?php echo $this->element( '../buildings/_realtor_inputs' ) ?>
        <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
        </div>
      <?php echo $this->Form->end() ?>
    </div>
    <div class="sliding-panel" id="inspector">
      <h1><?php __( 'Change Inspector' ) ?></h1>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'inspector' ) ) ) ?>
        <?php echo $this->element( '../buildings/_inspector_inputs' ) ?>
        <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
        </div>
      <?php echo $this->Form->end() ?>
    </div>
    
    <div id="demographics">
      <h1><?php __( 'Demographics' ) ?></h1>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'occupant' ) ) ) ?>
        <?php echo $this->Form->input( 'Occupant.id' ) ?>
        <?php echo $this->element( '../buildings/_demographic_inputs' ) ?>
        
        <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
        </div>
      <?php echo $this->Form->end() ?>
    </div> <!-- #demographics -->
    
    <div id="equipment_listing">
      <h1><?php __( 'Equipment Listing' ) ?></h1>
      <table>
      <thead>
        <tr>
          <th><?php __( 'Technology' ) ?></th>
          <th><?php __( 'Make' ) ?></th>
          <th><?php __( 'Model' ) ?></th>
          <th><?php __( 'Serial' ) ?></th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php if( !empty( $this->data['BuildingProduct'] ) ): ?>
          <?php foreach( $this->data['BuildingProduct'] as $building_product ): ?>
            <tr>
              <td><?php echo h( $building_product['Product']['Technology']['name'] ) ?></td>
              <td><?php echo h( $building_product['Product']['make'] ) ?></td>
              <td><?php echo h( $building_product['Product']['model'] ) ?></td>
              <td><?php echo h( $building_product['serial_number'] ) ?></td>
              <td>
                <?php echo $this->Html->link( __( 'edit', true ), '#', array( 'class' => 'toggle-form', 'data-model' => 'Product', 'data-id' => $building_product['id'] ) ) ?>
                | <?php echo $this->Html->link( __( 'retire', true ), array( 'controller' => 'BuildingProducts', 'action' => 'retire', $building_product['id'] ), array( 'class' => 'action delete retire' ), __( 'Are you sure you want to retire this piece of equipment?', true ) ) ?></td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <td colspan="4">No equipment has been added. <?php echo $this->Html->link( __( 'Add something now', true ), '#', array( 'class' => 'toggle-form', 'data-model' => 'Product' ) ) ?>.</td>
        <?php endif; ?>
      </tbody>
      <?php if( !empty( $this->data['BuildingProduct'] ) ): ?>
      <tfoot>
        <tr>
          <td colspan="4"><?php echo $this->Html->link( __( 'Add a new piece of equipment', true ), '#', array( 'class' => 'toggle-form', 'data-model' => 'Product' ) ) ?></td>
        </tr>
      </tfoot>
      <?php endif; ?>
      </table>
      
      <div class="sliding-panel" id="product">
        <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'product' ) ) ) ?>
          <?php echo $this->Form->input( 'BuildingProduct.id' ) ?>
          
          <?php echo $this->element( '../buildings/_building_product_inputs' ) ?>
          
          <div class="buttons">
            <div class="button">
              <input type="submit" value="Save" />
            </div>
            <div class="button">
              <input type="reset" value="Cancel" />
            </div>
          </div>
        <?php echo $this->Form->end() ?>
      </div>
      
      <?php foreach( $this->data['BuildingProduct'] as $i => $building_product ): ?>
        <div class="sliding-panel" id="product-<?php echo $building_product['id'] ?>">
          <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'product' ) ) ) ?>
            <?php echo $this->Form->input( 'BuildingProduct.' . $i . '.id' ) ?>
            
            <?php echo $this->element( '../buildings/_building_product_inputs', array( 'index' => $i, 'product' => $building_product ) ) ?>
            
            <div class="buttons">
              <div class="button">
                <input type="submit" value="Save" />
              </div>
              <div class="button">
                <input type="reset" value="Cancel" />
              </div>
            </div>
          <?php echo $this->Form->end() ?>
        </div>
      <?php endforeach; ?>
    </div> <!-- #equipment_listing -->
    
    <div id="building_characteristics">
      <h1><?php __( 'Building Characteristics' ) ?></h1>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'building_wall_system' ) ) ) ?>
        <?php echo $this->Form->input( 'BuildingWallSystem.id' ) ?>
        <?php echo $this->element( '../buildings/_building_characteristics_inputs' ) ?>
        
        <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
        </div>
      <?php echo $this->Form->end() ?>
    </div> <!-- #building_characteristics -->
    
    <div id="building_envelope">
      <h1><?php __( 'Insulation, Windows &amp; Doors' ) ?></h1>
      
      <h3><?php __( 'Windows' ) ?></h3>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'building_window_system' ) ) ) ?>
        <?php echo $this->Form->input( 'BuildingWindowSystem.0.id' ) ?>
        
        <label>Window Pane Type</label>
        <?php echo $this->element( '../buildings/_window_inputs' ) ?>
        
        <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
        </div>
      <?php echo $this->Form->end() ?>
      
      <h3><?php __( 'Air Tightness' ) ?></h3>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'building' ) ) ) ?>
        <?php echo $this->element( '../buildings/_air_tightness_inputs' ) ?>
        
        <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
        </div>
      <?php echo $this->Form->end() ?>
      
      <h3><?php __( 'Roof' ) ?></h3>
      <?php echo $this->Form->create( 'Building', array( 'url' => array( 'action' => 'edit', $this->data['Building']['id'], 'building_roof_system' ) ) ) ?>
        <?php echo $this->element( '../buildings/_roof_inputs' ) ?>
        
        <div class="buttons">
          <div class="button">
            <input type="submit" value="Save" />
          </div>
          <div class="button">
            <input type="reset" value="Cancel" />
          </div>
        </div>
      <?php echo $this->Form->end() ?>
    </div> <!-- #building_envelope -->
  </div>
</div>
