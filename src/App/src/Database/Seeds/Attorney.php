<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Attorney extends AbstractSeed
{
    public const QTD_ATTORNEY_GENERATE = 15;

    public function getDependencies()
    {
        return [
            'Company'
        ];
    }

    public function run()
    {
        $faker = Factory::create("pt_BR");

        $stmt = $this->query(sql: "select * from company where companytypeid = 2");
        $office = $stmt->fetchAll();

        $attorney = [];

        for ($i = 0; $i < self::QTD_ATTORNEY_GENERATE; $i ++) {
            array_push($attorney, [
                'name' => $faker->name(),
                'cpf' => $faker->cpf(false),
                'oab' => $faker->numberBetween(1, 156515),
                'phone' => $faker->cellphoneNumber(),
                'email' => sprintf("%s@gmail.com", $faker->lastName()),
                'cityid' => $faker->numberBetween(1, 2246),
                'companyid' => $office[$faker->numberBetween(1, count($office))]["id"],
                'situationid' => $faker->numberBetween(1, 2)
            ]);
        }

        $this->insert("attorney", $attorney);
    }
}
