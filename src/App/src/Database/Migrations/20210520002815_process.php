<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class Process extends AbstractMigration
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
        $table = $this->table("process");
        $table->addColumn('number', 'string', ['limit' => 150,'null' => false])
            ->addColumn('companyid','integer',['null' => false])
            ->addColumn('notificationdate', 'timestamp', ['timezone' => true, 'null'=> true])
            ->addColumn('description','string',['null' => true])
            ->addColumn('observation','text',['null' => true])
            ->addColumn('created_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addColumn('updated_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addForeignKey('companyid', 'company', 'id')
            ->create();
    }
}
