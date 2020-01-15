# Instalación de Infraestructura

## Docker

Copiar `dist.env` a `.env` y modificar APP_DIR con la ruta de despliegue del proyecto.
```
cp dist.env .env
```

Build de docker
```
docker-compose build --pull
```

Levantar los contenedores
```
docker-compose up -d
```

Agregar entrada al /etc/hosts
```
127.0.0.1 prbtcnccd.local
```

Configurar base de datos
```
docker exec -it prbtcnccd-db mysql -e "CREATE DATABASE prbtcnccd"
docker exec -it prbtcnccd-db mysql -e "GRANT ALL ON prbtcnccd.* TO 'prbtcnccd'@'%' IDENTIFIED BY 'prbtcnccd'"
```

Instalar vendor y configuración
```
docker exec -it prbtcnccd-php bash
composer install
php bin/console doctrine:migrations:migrate
```

Probar: http://prbtcnccd.local/api/docs
