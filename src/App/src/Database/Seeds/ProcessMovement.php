<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class ProcessMovement extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'Process',
            'Attorney'
        ];
    }

    public function run()
    {
        $faker = Factory::create("pt_BR");

        $stmt = $this->query(sql: "select * from process;");
        $process = $stmt->fetchAll();

        $stmt = $this->query(sql: "select * from company limit 10;");
        $office = $stmt->fetchAll();

        $stmt = $this->query(sql: "select * from attorney limit 10;");
        $attorney = $stmt->fetchAll();

        $movements = array_map(callback: function($item) use ($office, $attorney, $faker){
            shuffle($office);
            shuffle($attorney);
            return [
                "processid" => $item["id"],
                "officeid" => $office[0]["id"],
                "attorneyid" =>  $attorney[0]["id"],
                "userid" => 1,
                "links" => 'https://linktest.com.br',
                "stageprocess" => "Estágio Inicial",
                'comment' => $faker->paragraph(2, false)
            ];
        },array: $process);

        $this->insert("processmovement", $movements);
    }
}
