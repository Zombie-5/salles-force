#!/bin/bash

# Esperar pelo banco de dados
echo "Aguardando pelo banco de dados em $DB_HOST:$DB_PORT..."
until nc -z -v -w30 $DB_HOST $DB_PORT; do
  echo "Banco de dados indisponível. Tentando novamente..."
  sleep 5
done

echo "Banco de dados disponível. Continuando..."

# Rodar migrations e seeds (remova se não quiser rodar automaticamente)
php artisan migrate --force
php artisan db:seed --force

# Iniciar o servidor Laravel
exec php artisan serve --host=0.0.0.0 --port=8000
