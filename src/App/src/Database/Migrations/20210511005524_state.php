<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class State extends AbstractMigration
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
    public function change(): void
    {
        /** //Caso precise mudar o id
        use Phinx\Migration\AbstractMigration;
        class MyNewMigration extends AbstractMigration
        {
        public function change()
        {
        $table = $this->table('followers', ['id' => false, 'primary_key' => ['user_id', 'follower_id']]);
        $table->addColumn('user_id', 'integer')
        ->addColumn('follower_id', 'integer')
        ->addColumn('created', 'datetime')
        ->create();
        }
        }
         */
        $table = $this->table("state");
        $table->addColumn('name', 'string', ['limit' => 50,'null' => false])
            ->addColumn('uf', 'string', ['limit' => 2, 'null' => false])
            ->create();
    }
}
