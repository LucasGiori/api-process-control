<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Process extends AbstractSeed
{
    public const QTD_PROCESS_GENERATE = 15;

    public function getDependencies()
    {
        return [
            'Company',
            'User'
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

        $process = [];

        for ($i = 0; $i < self::QTD_PROCESS_GENERATE; $i ++) {
            shuffle($companyTypeGazin);
            array_push($process, [
                'number' => $faker->unique()->randomNumber(5, false),
                'companyid' => $companyTypeGazin[0]["id"],
                'notificationdate' => $faker->date('Y-m-d'),
                'description' => $faker->sentence(4),
                'observation' => $faker->paragraph(2, false),
                'status' => $faker->boolean(),
                'userid' => 1
            ]);
        }

        $this->insert("process", $process);
    }
}
