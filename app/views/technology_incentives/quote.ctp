<form id="ProposalRequestForm" method="post" action="/proposals/request" accept-charset="utf-8">
	<div class="breadcrumb">Heating and Cooling > Air Conditioners</div>
	<h2>Request a Proposal</h2>
	<div class="form-field-group clearfix">
		<h4>What do you need done?</h4>
		<p>Please contact me to prepare an estimate for the following services:</p>
		<input type="radio" name="data[Proposal][scope_of_work]" id="ProposalScopeOfWorkInstall" value="install" checked="checked">
		<label for="ProposalScopeOfWorkInstall">Install or replace my A/C</label><br />
			<input type="radio" name="data[Proposal][scope_of_work]" id="ProposalScopeOfWorkRepair" value="repair">
			<label for="ProposalScopeOfWorkRepair">Repair or service my A/C</label>
		</div>

	<div class="form-field-group clearfix">
		<h4>Are you ready to hire?</h4>
		<input type="radio" name="data[Proposal][timing]" id="ProposalTimingReady" value="ready" checked="checked">
		<label for="ProposalTimingReady">Yes, I&#146;m ready to hire someone.</label><br />
		<input type="radio" name="data[Proposal][timing]" id="ProposalTimingPlanning" value="planning">
			<label for="ProposalTimingPlanning">Estimating and budgeting</label>
		</div>
	<div class="form-field-group clearfix">
		<h4>How soon do you need the work done?</h4>
		<input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="within a week" checked="checked">
		<label for="ProposalTimingReady">Within 1 week</label><br />
		<input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="1-2 weeks" checked="checked">
		<label for="ProposalTimingReady">In 1 to 2 weeks</label><br />
		<input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="over 3 weeks" checked="checked">
		<label for="ProposalTimingReady">In 3 weeks or more</label><br />
		<input type="radio" name="data[Proposal][urgency]" id="ProposalUrgency" value="flexible" checked="checked">
		<label for="ProposalTimingReady">I&#146;m pretty flexible</label><br />
		</div>

	<div class="form-field-group clearfix">
		<h4>How can we contact you?</h4>
		<p>We&#146;ll need a phone number in case we have any questions about your job.</p>
		<div class="input text phonenumber required">
		  <label for="RequestorPhoneNumber">Primary Phone Number</label>
		  <input name="data[Requestor][phone_number][]" type="text" value="" class="area-code" maxlength="3" id="RequestorPhoneNumber"> -   
		  <input name="data[Requestor][phone_number][]" type="text" value="" class="exchange" maxlength="3" id="RequestorPhoneNumber"> -   
		  <input name="data[Requestor][phone_number][]" type="text" value="" class="number" maxlength="4" id="RequestorPhoneNumber">
		</div>
	</div>
	
	<div class="form-field-group clearfix">
		<h4>Anything else?</h4>
  <div class="input textarea"><textarea name="data[Proposal][comments]" placeholder="Please add instructions ror when you'd like to be reached, or any comments about the job." cols="30" rows="6" id="ProposalComments"></textarea></div><div class="submit"><input type="submit" value="Get a Quote"></div>	
			</div>

</form>

