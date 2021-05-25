<?php


use Phinx\Seed\AbstractSeed;

class CompanyType extends AbstractSeed
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
        $companytypes = [
            ['name' => 'Gazin'],
            ['name' => 'Escritório'],
        ];

        $this->insert("companytype", $companytypes);
    }
}
