#! /bin/bash

cd $(dirname $0)

if ! pgrep -x "MAMP" ; then
  echo "running"
else
  echo "stopped"
fi

get_database() {
  if [[ ! -e dump.sql ]] ; then
    echo -n "Enter user name: "
    read user
    echo -n "Enter database password: "
    read password
    echo -n "Enter site name: "
    read server
    echo -n "Enter database name: "
    read database
  else
    echo 'This file already exists'
    rm dump.sql
    return 1
  fi
}

get_database
/Applications/MAMP/Library/bin/mysqldump -u "$user" -p"$password" -h "$server" "$database" > dump.sql
docker-compose up -d
docker ps --format "{{.Names}}"
echo "Enter container name of wordpress db: "
read nameofdbcontainer
docker exec -i "$nameofdbcontainer" mysql -uroot -ppassword wordpress > dump.sql
