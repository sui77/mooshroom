#!/bin/sh

apt-get install php supervisor git openjdk-8-jre-headless tar

adduser --disabled-password -gecos "" minecraft
mkdir /home/minecraft/.ssh
mkdir /home/minecraft/mcadmin_files
mkdir /home/minecraft/mcadmin_files/supervisor.conf.d
chown -R minecraft:minecraft /home/minecraft/.ssh

echo "ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAACAQC3FjynviIGOFYPORzuJROh/yrb15r4hF5NlkbYJaRPnLjW3KHpBRyr5yvnMzj6z8KCQVoeDNhpbMdWbqNfK0UP8dlEGtlwBMYI0RflnO3SrZ2j7NI7ixfBv4R001FbsNByDpCsz8nKV8rfPA6fbAk+FDkln3+6ASmMnN9q9uqNSxxSdQFDG/lLTS3V3mhmBVPD5utsho1ibhR4zTxQevIFjk5SQV5ZkfRBxApD5+OkmMwnrFvJp/VSuc/61LJ2HE23iSES/3BScUDAdYbt2cKW1gEwGh/7ApzdplXqp3spGSh0ANdC1s6LnzooUsHKbYgKghD3/dzzAvMXT1/2QlsaPxBHdjWTdnFwhxqnMLMBZr91iE8Q8oXSuplpAHUcs3nLJEHkUDlt8tjdLqH3KbiDBWlrPhDivjqbMqH+pOPyTNGzNJDEjUb4ASxCYAAxlD8H2uKf8XV42WoX4Aim8Zq/ZOQIdiSu0z6Ph9NMxWVYjH9sye1E045cyF6FCv/U/sKBikudKFzG+0rY4P/8rLUgA7ZnQTHt8FbmZ5sfjC/roOplPxOa88UBI9vDWwpCF1eB6AWCO/TSqMQcRm8GYQKm/UPbmUQFwk0E7N4xnycOch1klWrcXZdn4P/Waqh7NkX6/24ina3EoXSpZ91uLLvaMpfaaGBNxkmEUdsQDkvU+w== minecraft@mcadmin" >> /home/minecraft/.ssh/authorized_keys

chmod 700 /home/minecraft/.ssh
chmod 644 /home/minecraft/.ssh/authorized_keys

USER=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 8 | head -n 1)
PASS=$(cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 24 | head -n 1)
echo "[inet_http_server]" > /home/minecraft/mcadmin_files/supervisor.conf.d/inet_http_server.conf
echo "port = 7777" >> /home/minecraft/mcadmin_files/supervisor.conf.d/inet_http_server.conf
echo "username = $USER"  >> /home/minecraft/mcadmin_files/supervisor.conf.d/inet_http_server.conf
echo "password = $PASS"  >> /home/minecraft/mcadmin_files/supervisor.conf.d/inet_http_server.conf