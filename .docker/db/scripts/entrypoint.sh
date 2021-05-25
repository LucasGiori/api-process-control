#!/usr/bin/env bash

set -e

# Executar scripts de permissões aqui enquanto o usuário ainda é root
chmod +x /etc/postgresql/scripts/*.sh

# Trocar CRLF por LF pra evitar problema no Linux na hora de executar os scripts
for i in /etc/postgresql/scripts/*.{sh,sql}; do
    dos2unix "$i"
done

# Esse script é criado pelo Dockerfile do Postgres:
# https://github.com/docker-library/postgres/blob/master/10/docker-entrypoint.sh
/usr/local/bin/docker-entrypoint.sh "$@"

# Aqui não executa mais nada, o script vai "travar" no entrypoint
