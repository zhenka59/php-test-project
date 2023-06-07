<?php

class m230604_093335_create_users_table extends CDbMigration
{
	public function up()
	{
        $this->createTable('tbl_user', array(
            'id' => 'pk',
            'email' => 'string NOT NULL',
            'username' => 'string NOT NULL',
            'password' => 'string NOT NULL',

        ));
	}

	public function down()
	{
		echo "m230604_093335_create_users_table does not support migration down.\n";
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