<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class SearchResults extends AbstractMigration
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
        $table = $this->table('search_results', ['id' => false]);
            $table
                ->addColumn('chat_id','integer', ['null' => false])
                ->addColumn('search_request_id', 'integer', ['null' => false])

                ->addForeignKey('chat_id','chats','id',['delete' => 'CASCADE','update' => 'NO_ACTION'])
                ->addForeignKey('search_request_id','search_requests','id',['delete' => 'CASCADE','update' => 'NO_ACTION'])

                ->addColumn('search_result','json',['null' => false])
                ->addTimestamps()

                ->create();

    }

    public function down(): void
    {
        $this->table('search_results')->drop()->save();
    }

}
