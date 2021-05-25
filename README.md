# API Process Control

[![Minimum PHP Version](https://img.shields.io/badge/php-%5E8.0-blue)](https://php.net/)

#### <>

Copie o arquivo `.env.dist` e renomeie para `.env` e inclua as configurações do banco que você deseja utilizar.
```bash
$ cp .env.dist .env
```

Em seguida execute o comando abaixo para dar inicio aos containers:
```bash
$ docker-compose up -d
```

Após o termino da criação do container Instale as dependencias do framework laminas com o seguinte comando:
```bash
$ docker exec api-processcontrol composer install
```

Habilite o modo desenvolvedor em seguida com o comando: **(COMANDO APENAS EM DEV OU HOMOLOGAÇÃO)**
```bash
$ docker exec api-processcontrol composer development-enable
```

Verifique se o modo desenvolvedor foi habilitado
```bash
$ docker exec api-processcontrol composer development-status
```

Pronto, [clique aqui e acesse o projeto](http://localhost:81).

------------
#### Insights
######Sempre após rodar o insights, rodar o codesniffer

```bash
$ docker exec api-processcontrol composer insights
```

#### CodeSniffer

Para verificar se há algo fora do padrão:
```bash
$ docker exec api-processcontrol composer cs-check
```

Para corrigir:
```bash
$ docker exec api-processcontrol composer cs-fix
```

------------
#### Documentação

Para gerar o JSON, execute o seguinte comando:
```bash
$ docker exec api-processcontrol vendor/bin/openapi src -o swagger/openapi.json
```


[documentação local](http://localhost:82).


#### Migrations

Primeiramente é necessário fazer dentro do container, para entrar:
```bash
$ docker exec -it api-processcontrol bash
```

`os próximos comandos devem ser executados dentro do container`

Para criar uma migration:
```bash
$ vendor/bin/phinx create NameMyNewMigration -c config/autoload/migrations.global.php
```
e selecione o módulo desejado.

Para criar um seed:
```bash
$ vendor/bin/phinx seed:create -c config/autoload/migrations.global.php NameMyNewSeed
```
e selecione o módulo desejado.

As vezes é necessario dar permissão no arquivo criado, principalmente no linux:
```bash
$ sudo chown user:group -R src/
```

Linux Pode dar problemas de permissão 
```bash
$ sudo chown -R $(whoami) src/
```
##### Sempre que for necessário criar um pacote novo, deverá ser incluso o caminho no arquivo `config/autoload/migrations.global.php`

Para iniciar a migração, basta executar:
```bash
$ composer migrate
```

Para popular o banco, utilize:
```bash
$ composer seed
```

Caso precise parar o serviço do postgres no linux:
```bash
$ sudo systemctl stop postgresql
```

------------

#### Convenção de commits

- build: Changes that affect the build system or external dependencies (example scopes: gulp, broccoli, npm)
- ci: Changes to our CI configuration files and scripts (example scopes: Travis, Circle, BrowserStack, SauceLabs)
- docs: Documentation only changes
- feat: A new feature
- fix: A bug fix
- perf: A code change that improves performance
- refactor: A code change that neither fixes a bug nor adds a feature
- style: Changes that do not affect the meaning of the code (white-space, formatting, missing semi-colons, etc)
- test: Adding missing tests or correcting existing tests
