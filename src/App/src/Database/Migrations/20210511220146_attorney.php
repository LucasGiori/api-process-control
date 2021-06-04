<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class Attorney extends AbstractMigration
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
        $table = $this->table("attorney");
        $table->addColumn('name', 'string', ['limit' => 150,'null' => false])
            ->addColumn("cpf", 'string',['limit' => 11, 'null' => false])
            ->addColumn('oab', 'string', ['limit' => 50,'null' => false])
            ->addColumn('phone', 'string', ['null' => false])
            ->addColumn('email', 'string', ['null' => false])
            ->addColumn('cityid','integer',['null' => false])
            ->addColumn('companyid','integer',['null' => false])
            ->addColumn('created_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addForeignKey('cityid', 'city', 'id')
            ->addForeignKey('companyid', 'company', 'id')
            ->create();
    }
}
