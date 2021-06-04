<?php


use App\Utils\Constants;
use Phinx\Seed\AbstractSeed;

class User extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            'UserType'
        ];
    }

    public function run()
    {
        $user = [
            [
                'name' => 'Administrador',
                'login' => 'admin',
                'email' => 'lucasgioricesconetto@gmail.com',
                'cpf' => '00000000000',
                'password' => password_hash(password: "admin", algo: PASSWORD_BCRYPT),
                'status' => true,
                'usertypeid' => Constants::USERTYPE_ADMIN
            ],
        ];

        $this->insert("users", $user);
    }
}
