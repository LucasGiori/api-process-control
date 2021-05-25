<?php


use Phinx\Seed\AbstractSeed;

class Situation extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run()
    {
        $situation = [
            ['description' => 'ATIVO'],
            ['description' => 'INATIVO'],
        ];

        $this->insert("situation", $situation);
    }
}
