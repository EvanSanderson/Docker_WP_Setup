# Docker_WP_Setup

Basic Docker setup for Wordpress (using the nclud Wordpress skeleton).

1. Make sure you have docker compose installed. https://docs.docker.com/compose/install/
2. Clone this repo
3. Run the command `docker-compose up -d`
4. Run the command `docker exec -i nameofdbcontainer mysql -uroot -ppassword wordpress > wp.sql` (replace nameofcontainer with the name of whatever your DB container is, which you can find with docker ps)
5. Visit localhost:3000
6. Rejoice!

The themes, plugins, and sql can be replaced with project specific material.
