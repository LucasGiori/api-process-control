<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Company extends AbstractSeed
{
    public const QTD_COMPANY_GENERATE = 15;

    public function getDependencies()
    {
        return [
            'City',
            'CompanyType',
            'Situation'
        ];
    }

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
