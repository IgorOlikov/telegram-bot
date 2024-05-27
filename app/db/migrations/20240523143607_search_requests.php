<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SearchRequests extends AbstractMigration
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
        $table = $this->table('search_requests');

        $table
            ->addColumn('chat_id','integer',['null' => false])
            ->addForeignKey('chat_id','chats','id',['delete' => 'CASCADE','update' => 'NO_ACTION'])
            ->addColumn('search_request', 'string',['limit' => 255])
            ->addTimestamps()

            ->create();



    }

    public function down(): void
    {
        $this->table('search_requests')->drop()->save();
    }
}
