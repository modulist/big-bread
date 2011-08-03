#!/bin/bash

# project_name=bigbread
# build_root=~/Development/.build
env="dev"
root="www/__subdomains/$env.bigbread.net"

if [ $# -lt 1 ]; then
  # The dev database will not be updated from production data
  updatedb=false
else
  updatedb=true
  dbpassword=$1
fi


if $updatedb; then
  echo "Download a copy of the production database..."
  ssh bigbread "scripts/import.sh $env"
  echo "...complete."
else
  echo "No arguments passed. Data will not be updated from production."
fi

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
      --links \
      --delete \
      ./ bigbread:$root

echo "Uploading environment-specific files..."
if [ -f "app/config/core.$env.php" ]; then
  scp app/config/core.$env.php bigbread:$root/app/config/core.php
else
  scp app/config/core.sample.php bigbread:$root/app/config/core.php
fi
scp app/config/bootstrap.$env.php bigbread:$root/app/config/bootstrap.local.php
scp app/config/database.$env.php bigbread:$root/app/config/database.php
scp app/webroot/.htaccess.$env bigbread:$root/app/webroot/.htaccess
scp app/webroot/robots.$env.txt bigbread:$root/app/webroot/robots.txt

echo "...complete."

echo "Clearing cache..."
ssh bigbread "find $root/app/tmp/cache -type f -exec rm {} \;"
echo "...complete."

# Execute the upgrade.sql file
if $updatedb; then
  echo "Running upgrade.sql..."
  ssh bigbread "cat $root/app/config/sql/upgrade.sample.sql | sed -e s/@DB_NAME@/bigbread_$env/ > $root/app/config/sql/upgrade.sql"
  ssh bigbread "cat $root/app/config/sql/upgrade.sql | mysql -ubigbread -p'$dbpassword'"
  echo "...complete."
fi

echo ""
echo "That's it. Everything should be ready to go"
