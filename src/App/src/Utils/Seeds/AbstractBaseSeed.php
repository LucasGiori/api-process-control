<?php


namespace App\Utils\Seeds;


use Phinx\Seed\AbstractSeed;

use function array_key_last;
use function array_merge;
use function preg_split;
use function sprintf;
use function substr;

abstract class AbstractBaseSeed extends AbstractSeed
{
    private array $default = [
        "idcompany" => 1,
    ];

    public function insertItens(
        array $dados,
        string $tableName,
        bool $hasCompany = true,
        string $columnName = "description"
    ): void {
        if (! $this->hasDataTable($tableName, $columnName, $dados[0])) {
            return;
        }

        $table = $this->table($tableName);
        $table->getAdapter()->execute(
            sprintf(
                "TRUNCATE TABLE %s CASCADE",
                $table->getAdapter()->quoteTableName($tableName)
            )
        );

        foreach ($dados as $key => $item) {
            $data = [
                "id"        => $key + 1,
                $columnName => $item,
            ];

            if ($hasCompany) {
                $data = array_merge($data, $this->default);
            }

            $table
                ->insert($data)
                ->saveData();
        }

        $table->getAdapter()->execute(
            sprintf(
                "ALTER SEQUENCE %s_id_seq RESTART WITH %s",
                $tableName,
                array_key_last($dados) + 2
            )
        );
    }

    public function insertIfNotFound(string $tableName, array $dados, string $key): void
    {
        if ($this->hasDataTable($tableName, $key, $dados[$key])) {
            $table = $this->table($tableName);
            $table->insert($dados)->saveData();
        }
    }

    public function hasDataTable(string $tableName, string $key, string $value): bool
    {
        [, $nameWithoutSchema] = preg_split("/[.]/", $tableName);
        $alias                 = substr($nameWithoutSchema, 0, 1);

        $stmt = $this->query(
            sprintf(
                "SELECT %s.* FROM %s %s WHERE %s.%s = '%s'",
                $alias,
                $tableName,
                $alias,
                $alias,
                $key,
                $value
            )
        );

        return empty($stmt->fetchAll());
    }
}
