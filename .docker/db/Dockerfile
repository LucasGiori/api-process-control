FROM postgres:11.2

# Instalar alguns programas úteis
RUN apt-get update && apt-get install -y \
    nano \
    dos2unix && \
    rm -rf /var/lib/apt/lists/*

# Copiar script init-db.sh dentro da pasta de scripts que executam automático
# da imagem oficial do Postgres. Esse script vai chamar o execute.sh com os
# comandos para criação do banco
COPY scripts/init-db.sh /docker-entrypoint-initdb.d/init-user-db.sh
# Copiar script "ponto de entrada" do container
COPY scripts/entrypoint.sh /usr/local/bin/entrypoint.sh
# Link simbólico criado para manter a compatibilidade reversa
RUN ln -s usr/local/bin/entrypoint.sh /

# Evitar problemas de permissão com o owner dos scripts
RUN usermod -aG www-data postgres && \
	dos2unix /usr/local/bin/entrypoint.sh && \
    chmod +x /usr/local/bin/entrypoint.sh && \
	dos2unix /usr/local/bin/entrypoint.sh && \
    chmod +x /docker-entrypoint-initdb.d/init-user-db.sh

CMD ["postgres"]
ENTRYPOINT ["entrypoint.sh"]
