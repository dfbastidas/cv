# Hojas de Vida

Este proyecto tendrá como objetivo crear plantillas de Hojas de Vida (CV) a partir de un perfil profesional previamente diligenciado para eventualmente descargar dicha plantilla en formato PDF.

Las plantillas serán generadas automáticamente y la versión inicial del proyecto permitirá 1 sola pagina por hoja de vida.

## Stack Tecnológico:

- PHP (Con Framework Symfony)
- Docker (Virtualización del proyecto)
- AWS, AWS SDK y AWS CLI: Para ejecutar el proyecto en Cloud y obtener los parametros necesarios para su ejecución.
- Terraform Como Infraestructura como Código.

## ¿Cómo ejecutarlo?

Es importante contar con Docker y AWS CLI instalados y configurados en tu host.

Obtener el .env ejecutando el archivo script y eventualmente ejecutar:

`docker compose up -d`

Esto iniciará la construcción y levantamiento del contenedor, será expuesto en el puerto especificado en el docker-compose.yml