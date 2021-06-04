<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class ProcessMovement extends AbstractMigration
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
        $table = $this->table("processmovement");
        $table->addColumn('processid','integer',['null' => false])
            ->addColumn('companyid','integer',['null' => false])
            ->addColumn('officeid','integer',['null' => false])
            ->addColumn('attorneyid','integer',['null' => false])
            ->addColumn('userid','integer',['null' => false])
            ->addColumn('links','text',['null' => true])
            ->addColumn('stageprocess','string',['null' => true])
            ->addColumn('comment','text',['null' => true])
            ->addColumn('created_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addColumn('updated_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addForeignKey('processid', 'process', 'id')
            ->addForeignKey('companyid', 'company', 'id')
            ->addForeignKey('officeid', 'company', 'id')
            ->addForeignKey('attorneyid', 'attorney', 'id')
            ->addForeignKey('userid', 'users', 'id')
            ->create();
    }
}
