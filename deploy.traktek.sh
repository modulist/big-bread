#!/bin/bash

# project_name=bigbread
# build_root=~/Development/.build
env="traktek"
host="bigbread.traktekpartners.com"
root="/var/www/sites/clients/bigbread"

if [ $# -lt 1 ]; then
  echo "Usage: ./deploy.$env.sh <dbpassword>"
  exit 1
fi

dbpassword=$1

echo "Updating the bigbread database from production..."
ssh root@$host "mysqldump -hbigbread.net -ubigbread -p'$1' --opt --complete-insert bigbread_prd | sed -e s/bigbread_prd/bigbread/ | mysql -udrupal -psql5Serv bigbread"
echo "...complete."

echo "Sync'ing updated files to $root..."
rsync -vcrlDtOzi --progress \
      --exclude ".DS_STORE" \
      --exclude "app/tmp" \
      --exclude "*.komodoproject" \
      --exclude ".komodotools" \
      --exclude ".git" \
      --exclude ".gitignore" \
      --exclude "_meta" \
      --exclude "app/config/bootstrap.*.php" \
      --exclude "app/config/core.php" \
      --exclude "app/config/core.*.php" \
      --exclude "app/config/database.php" \
      --exclude "app/config/database.*.php" \
      --exclude "app/config/sql/bigbread.empty.sql" \
      --exclude "app/webroot/.htaccess*" \
      --exclude "app/webroot/robots.*.txt" \
      --exclude "deploy.*.sh" \
      --exclude "_notes" \
      --exclude "dwsync.xml" \
      --links \
      --delete \
      ./ root@$host:$root

echo "Uploading environment-specific files..."
if [ -f "app/config/core.$env.php" ]; then
  scp app/config/core.$env.php root@$host:$root/app/config/core.php
else
  scp app/config/core.sample.php root@$host:$root/app/config/core.php
fi
scp app/config/bootstrap.$env.php root@$host:$root/app/config/bootstrap.local.php
scp app/config/database.$env.php root@$host:$root/app/config/database.php
scp app/webroot/.htaccess.$env root@$host:$root/app/webroot/.htaccess
scp app/webroot/robots.$env.txt root@$host:$root/app/webroot/robots.txt

echo "...complete."

echo "Clearing cache..."
ssh root@$host "find $root/app/tmp/cache -type f -exec rm {} \;"
echo "...complete."

# Execute the upgrade.sql file
echo "Running upgrade.sql..."
ssh root@$host "cat $root/app/config/sql/upgrade.sample.sql | sed -e s/@DB_NAME@/bigbread/ > $root/app/config/sql/upgrade.sql"
ssh root@$host "cat $root/app/config/sql/upgrade.sql | mysql -udrupal -psql5Serv"
echo "...complete."
echo ""
echo "That's it. Everything should be ready to go"
