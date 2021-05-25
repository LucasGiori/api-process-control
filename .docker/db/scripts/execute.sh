#!/usr/bin/env bash

set -e

CURRENT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

execute-sql() {
    echo "executing $1..."
    command psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" -f "$1"
}

#sempre que criar um arquivo .sql, incluir aqui
execute-sql "$CURRENT_DIR"/init.sql
