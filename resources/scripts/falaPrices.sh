#!/bin/bash
# Script captura de precios
dateR=$(date +%Y-%m-%d);
db="mrtsaser_bot"
host="69.16.228.4"
user="mrtsaser_bot"
pass="Mrtbot26*"
mysql --batch --raw -u$user -p$pass -h$host -D$db -e "SELECT id, link FROM listado_productos WHERE retailer LIKE '%falabella%' AND date LIKE '%$dateR%' LIMIT 1;" | while read -a row; do
    id="${row[0]}"
    link="${row[1]}"
    echo "Tomando precio de lista de... $link"
    falaList=$(/var/www/html/mbot_screens/phantomjs/bin/phantomjs /var/www/html/mbot_screens/falaList.js "$link");
    echo "Tomando precio de oferta de... $link"
    falaOfer=$(/var/www/html/mbot_screens/phantomjs/bin/phantomjs /var/www/html/mbot_screens/falaOfer.js "$link");
    echo "El precio de lista del producto $id es $falaList y el precio de oferta es $falaOfer";
    mysql --batch --raw -u$user -p$pass -h$host -D$db -e "UPDATE listado_productos SET precio_lista = '$falaList', precio_oferta = '$falaOfer' WHERE id = '$id';"
    echo "Fue actualizado en la base de datos";
    done