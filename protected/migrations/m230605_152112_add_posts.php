<?php

class m230605_152112_add_posts extends CDbMigration
{
	public function up()
	{
	    $this->createTable('tbl_post', [
	       'id' => 'pk',
           'title' => 'string not null',
            'content' => 'string not null',
            'author_id' => 'integer not null',
            'status' => 'integer not null default 0',
            'created_at' => 'timestamp not null default now()',
        ]);
	}

	public function down()
	{
		echo "m230605_152112_add_posts does not support migration down.\n";
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