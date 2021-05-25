#!/usr/bin/env bash

# Esse arquivo aqui é colocado dentro de uma pasta de configurações especial
# onde todos os scripts que estiverem lá serão executados pelo entrypoint
# da imagem oficial do Postgres.

# Esse arquivo aqui já executa como o usuário postgres, portanto não tem
# permissões de root.

set -e

/etc/postgresql/scripts/execute.sh
