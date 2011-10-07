<div id="messages" class="grid_9">
	<h1>Add Equipment</h1>
	<p>Did you know that Big Bread can also help you save big on appliances, doors, windows, and even HVAC systems?</p>
</div><!-- /#messages -->
<form action="/equipment/add" id="EquipmentAddForm" method="post" accept-charset="utf-8">
<div id="my-equipment" class="grid_9">
	<div class="clearfix">
		<h2>Add equipment to Beach House:</h2>
	</div>
	<div class="equipment-wrapper clearfix">
		<div class="location-icon">2</div>
				<div class="location-equipment">
					<h4>Equipment type</h4>
					<div class="input text required">
					<select name="category" id="AddEquipmentCategory">
					<option value="">-- select one --</option>
					<option value="HEATINGCOOLING">HEATING &amp; COOLING</option>
						<option value="ACRoom">&nbsp;&nbsp;A/C: room</option>
						<option value="ACCentral">&nbsp;&nbsp;A/C: central</option>
						<option value="Boiler">&nbsp;&nbsp;Boiler</option>
						<option value="Furnace">&nbsp;&nbsp;Furnace</option>
						<option value="HeatPump">&nbsp;&nbsp;Heat Pump</option>
						<option value="SpaceHeater">&nbsp;&nbsp;Space Heaters</option>
						<option value="Ducts">&nbsp;&nbsp;Ducts</option>

					<option value="BUILDINGSHELL">BUILDING SHELL</option>
						<option value="Doors">&nbsp;&nbsp;Doors</option>
						<option value="Roof">&nbsp;&nbsp;Roof</option>
						<option value="Windows">&nbsp;&nbsp;Windows</option>

					<option value="KITCHEN">KITCHEN</option>
						<option value="Dishwasher">&nbsp;&nbsp;Dishwasher</option>
						<option value="Freezer">&nbsp;&nbsp;Freezer</option>
						<option value="RangeCooktopOven">&nbsp;&nbsp;Range/Cooktop/Oven</option>
						<option value="Refrigerator">&nbsp;&nbsp;Refrigerator</option>

					<option value="LAUNDRY">LAUNDRY</option>
						<option value="Dryer">&nbsp;&nbsp;Dryer</option>
						<option value="Washer">&nbsp;&nbsp;Washer room</option>

					<option value="HOTWATER">HOT WATER</option>
						<option value="SolarWaterHeater">&nbsp;&nbsp;Solar Water Heater</option>
						<option value="WaterHeater">&nbsp;&nbsp;Water Heater room</option>

					<option value="LIGHTING">LIGHTING</option>
						<option value="LightBulbs">&nbsp;&nbsp;Light Bulbs</option>
						<option value="LightFixtures">&nbsp;&nbsp;Light Fixtures room</option>

					</select>
					</div>
					
					<h4>Specifics</h4>
					<div class="grid_4">
						<div class="input text required"><label for="AddEquipmentMake">Make</label><input class="autocomplete active" name="" type="text" placeholder="" maxlength="360" id="AddEquipmentMake" /></div>	
						<div class="input text"><label for="AddEquipmentModelNumber">Model Number<span class="normal"> (from equipment tag)</span></label><input name="" type="text" placeholder="" maxlength="360" id="AddEquipmentModelNumber" /></div>
						<div class="input text"><label for="AddEquipmentSerialNumber">Serial Number<span class="normal"> (from equipment tag)</span></label><input name="" type="text" placeholder="" maxlength="360" id="AddEquipmentSerialNumber" /></div>
						<!--<div class="input text"><label for="AddEquipmentYearInstalled">Year installed</label><input name="" type="text" placeholder="" maxlength="360" id="AddEquipmentYearInstalled" /></div> -->
						<script>
						$(function() {
							$( "#slider" ).slider({
								value:100,
								min: 1998,
								max: 2011,
								step: 1,
								slide: function( event, ui ) {
									$( "#amount" ).val( ui.value );
								}
							});
							$( "#amount" ).val( $( "#slider" ).slider( "value" ) );
						});
						</script>
	
						<p><label for="amount">Year Installed:</label></p>
						<div id="slider"></div>
						<p><input type="text" id="amount" class="year" /></p>
						<div class="checkbox"><input type="checkbox" id="CantSay"><label for="CantSay" class="normal">Can't Say</label></div>
						<div class="input text"><label for="AddEquipmentNotes">Notes</label><textarea name="" type="text" placeholder="" id="AddEquipmentNotes" /></textarea></div>
					</div><!-- /grid-4 -->	
					<h4>Attach a file</h4>
					<p class="small">You can attach invoices, a product manual, or anything else.</p>
					<div class="choose-button"><p>Choose a file</p></div>
					<div><input type="submit" value="Add to Beach House" /></div>
			</div><!-- /location-equipment-->	
			<div class="add-equipment-grid grid_3">
				<div class="clearfix">
					<div class="current-equipment-icon"></div>
					<div class="current-equipment-title">Equipment for Beach House</div>
				</div>
				<table class="current-equipment">
					<tr class="first even">
						<td class="model-name"><a href="#">Kenmore washer</a></td>
						<td class="controls">
							<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
						</td>
					</tr>
					<tr class="even">
						<td class="model-name"><a href="#">Kenmore dryer</a></td>
						<td class="controls">
							<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
						</td>
					</tr>
					<tr class="last even">
						<td class="model-name"><a href="#">Kenmore washer</a></td>
						<td class="controls">
							<a href="#" class="edit-button">edit</a>&nbsp;|&nbsp;<a href="#" class="remove-button">remove</a>
						</td>
					</tr>
				</table>
		</div><!-- /location-equipment-grid -->
	</div><!-- /location-wrapper -->
		
</div><!-- /my-locations -->


</form><!-- /form -->
