#!/usr/bin/env bash
echo "Creating mongo users..."
mongo admin --host localhost -u root -p example --eval "db.createUser({user: 'admin', pwd: 'zonePassWord', roles: [{role: 'dbAdminAnyDatabase', db: 'admin'}]});"
echo "Mongo users created."