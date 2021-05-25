<?php


use Phinx\Seed\AbstractSeed;

class City extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'State'
        ];
    }

    public function run()
    {


        $handle = fopen(__DIR__.'/../../../../../tmp/Estados-Cidades-IBGE/csv/municipios.csv','r');

        $states = [];

        while ( ($data = fgetcsv($handle) ) !== FALSE ) {
            $stmt = $this->query(sprintf("select id from state where uf='%s'",$data[3]));

            array_push($states,["name"=>$data[2],"state_id"=>$stmt->fetch()["id"]]);
        }
        fclose($handle);

        $this->insert("city", $states);
    }
}
