<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Process extends AbstractSeed
{
    public const QTD_PROCESS_GENERATE = 15;

    public function getDependencies()
    {
        return [
            'Company'
        ];
    }

    public function run()
    {
        $faker = Factory::create("pt_BR");

        $stmt = $this->query(sql: "select * from company limit 10;");
        $companies = $stmt->fetchAll();

        $stmt = $this->query(sql: "select * from action limit 10;");
        $actions = $stmt->fetchAll();

        $companyTypeGazin = array_filter(array: $companies,callback: function($company) {
           return $company["companytypeid"] === 1;
        });

        $companyTypeOffice = array_filter(array: $companies,callback: function($company) {
            return $company["companytypeid"] === 2;
        });


        $process = [];
        $processMovement = [];

        for ($i = 0; $i < self::QTD_PROCESS_GENERATE; $i ++) {
            array_push($attorney, [
                'number' => $faker->unique()->randomNumber(5, false),
                'companyid' => array_rand(array: $companyTypeGazin)["id"],
                'notificationdate' => $faker->date('Y-m-d'),
                'description' => $faker->sentence(4),
                'observation' => $faker->paragraph(2, false),
                'email' => sprintf("%s@gmail.com", $faker->lastName()),
                'cityid' => $faker->numberBetween(1, 2246),

                'situationid' => $faker->numberBetween(1, 2)
            ]);
        }

        $this->insert("attorney", $attorney);
    }
}
