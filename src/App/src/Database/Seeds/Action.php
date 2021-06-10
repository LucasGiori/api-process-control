<?php


use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class Action extends AbstractSeed
{
    public const QTD_ACTION_GENERATE = 10;
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
