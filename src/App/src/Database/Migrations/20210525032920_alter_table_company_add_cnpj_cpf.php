<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterTableCompanyAddCnpjCpf extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table("company");
        $table->addColumn('cnpj', 'string', ['limit'=> 14,'null' => true])
            ->update();
    }

    public function down()
    {

    }
}
