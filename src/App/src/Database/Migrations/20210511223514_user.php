<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class User extends AbstractMigration
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
        $table = $this->table("user");
        $table->addColumn('name', 'string', ['limit' => 150,'null' => true])
            ->addColumn("login", 'string',['limit' => 50, 'null' => false])
            ->addColumn('email', 'string', ['null' => false])
            ->addColumn('cpf', 'string', ['null' => false])
            ->addColumn('password', 'string', ['null' => false])
            ->addColumn('status','boolean',['default' => true,'null' => false])
            ->addColumn('usertypeid','integer',['null' => false])
            ->addColumn('created_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addColumn('updated_at', 'timestamp', [
                'timezone' => true,
                'default' => Literal::from('now()')
            ])
            ->addForeignKey('usertypeid', 'usertype', 'id')
            ->create();
    }
}
