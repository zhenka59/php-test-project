<?php

class m230605_143149_add_user_token extends CDbMigration
{
	public function up()
	{
	    $this->addColumn('tbl_user', 'token', 'string');
	}

	public function down()
	{
		echo "m230605_143149_add_user_token does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}