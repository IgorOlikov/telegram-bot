<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Chats extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $table = $this->table('chats'); //['id' => false]

        $table
            //->addColumn('id', 'integer', ['null' => false])
            ->addColumn('username', 'string')
            ->addColumn('first_name', 'string', ['null' => true]) //nullable
            ->addColumn('last_name', 'string', ['null' => true]) //nullable
            ->addTimestamps()

            ->create();

    }

    public function down()
    {
        $this->table('chats')->drop()->save();
    }

}
