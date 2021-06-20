<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Action extends AbstractSeed
{
    public const QTD_ACTION_GENERATE = 10;

    public function getDependencies()
    {
        return [
            'TyeAction',
        ];
    }

    public function run()
    {
        $faker = Factory::create("pt_BR");

        $actions = [];

        for ($i = 0; $i < self::QTD_ACTION_GENERATE; $i ++) {
            array_push($actions, [
                'description' => sprintf("Ação %s" ,$faker->word()),
                'typeactionid' => $faker->numberBetween(1, 2),
                'situationid' => $faker->numberBetween(1, 2)
            ]);
        }

        $this->insert("action", $actions);
    }
}
