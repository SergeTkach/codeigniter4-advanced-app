<?php

namespace denis303\user\Database\Migrations;

class CreateUserTable extends \denis303\user\BaseCreateUserTableMigration
{

    public function getFields()
    {
        $return = parent::getFields();

        $return[static::FIELD_PREFIX . 'password_reset_token'] = [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'unique' => true,
            'null' => true
        ];

        $return[static::FIELD_PREFIX . 'verification_token'] = [
            'type' => 'VARCHAR',
            'constraint' => '255',
            'unique' => true,
            'null' => true
        ];

        $return[static::FIELD_PREFIX . 'verified_at'] = [
            'type' => 'DATETIME',
            'null' => true
        ];

        return $return;
    }


}