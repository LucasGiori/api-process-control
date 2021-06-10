<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Company extends AbstractSeed
{
    public const QTD_COMPANY_GENERATE = 15;
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
        $faker = Factory::create("pt_BR");

        $companies = [];

        for ($i = 0; $i < self::QTD_COMPANY_GENERATE; $i ++) {
            array_push($companies, [
                'namefantasy' => $faker->company(),
                'companyname' => $faker->company(),
                'cityid' => $faker->numberBetween(1, 2246),
                'companytypeid' => $faker->numberBetween(1, 2),
                'situationid' => $faker->numberBetween(1, 2),
                'cnpj' => strval(value: $faker->cnpj(false))
            ]);
        }

        $this->insert("company", $companies);
    }
}
