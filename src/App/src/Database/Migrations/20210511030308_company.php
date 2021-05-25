<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class Company extends AbstractMigration
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
        $table = $this->table("company");
        $table->addColumn('namefantasy', 'string', ['limit' => 180,'null' => true])
            ->addColumn("companyname", 'string',['limit' => 180, 'null' => false])
            ->addColumn('cityid', 'integer', ['null' => false])
            ->addColumn('companytypeid', 'integer', ['null' => false])
            ->addColumn('situationid','integer',['null' => false])
            ->addColumn('created_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addColumn('updated_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addForeignKey('cityid', 'city', 'id')
            ->addForeignKey('companytypeid', 'companytype', 'id')
            ->addForeignKey('situationid', 'situation', 'id')
            ->create();
    }
}
