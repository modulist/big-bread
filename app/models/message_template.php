<?php

class MessageTemplate extends AppModel {
	public $name = 'MessageTemplate';

	public $hasMany = array( 'Message' );

  const TYPE_NEW_USER        = 'new_user';
  const TYPE_NEW_REALTOR     = 'new_realtor';
  const TYPE_NEW_INSPECTOR   = 'new_inspector';
  const TYPE_FEEDBACK        = 'feedback';
  const TYPE_INVITE          = 'invite';
  const TYPE_PROPOSAL        = 'proposal_request';
  const TYPE_FORGOT_PASSWORD = 'forgot_password';
}
