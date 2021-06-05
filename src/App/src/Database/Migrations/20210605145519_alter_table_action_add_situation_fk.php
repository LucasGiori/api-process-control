<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterTableActionAddSituationFk extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table("action");
        $table->addColumn('situationid', 'integer', ['null' => false])
            ->addForeignKey('situationid', 'situation', 'id')
            ->update();
    }
}
