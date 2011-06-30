#!/bin/bash

# project_name=bigbread
# build_root=~/Development/.build
environment="stg"

if [ $# -lt 2 ]; then
  echo "Usage: ./deploy.$env.sh <commit> <dbpassword>"
  exit 1
fi

# commit=$1
dbpassword=$2

# rm -rf $build_root/$project_name
# git archive $commit --prefix=$project_name/ | tar -x -C $build_root

echo "Download a copy of the production database..."
ssh bigbread "scripts/import.sh $env"
echo "...complete."

rsync -vcrlDtOzi --progress \
      --exclude ".DS_STORE" \
      --exclude "app/tmp" \
      --exclude "*.komodoproject" \
      --exclude ".komodotools" \
      --exclude ".git" \
      --exclude ".gitignore" \
      --exclude "_meta" \
      --exclude "app/config/bootstrap.*.php" \
      --exclude "app/config/core.*.php" \
      --exclude "app/config/database.php" \
      --exclude "app/config/database.*.php" \
      --exclude "app/config/sql/bigbread.empty.sql" \
      --exclude "app/webroot/.htaccess*" \
      --exclude "app/webroot/robots.*.txt" \
      --exclude "deploy.*.sh" \
      --links \
      --delete \
      ./ bigbread:www/__subdomains/$env.bigbread.net

echo "Uploading environment-specific files..."
if [ -f "app/config/core.$environment.php" ]; then
  scp app/config/core.$env.php bigbread:www/__subdomains/$env.bigbread.net/app/config/core.php
else
  scp app/config/core.sample.php bigbread:www/__subdomains/$env.bigbread.net/app/config/core.php
fi
scp app/config/bootstrap.$env.php bigbread:www/__subdomains/$env.bigbread.net/app/config/bootstrap.local.php
scp app/config/database.$env.php bigbread:www/__subdomains/$env.bigbread.net/app/config/database.php
scp app/webroot/.htaccess.$env bigbread:www/__subdomains/$env.bigbread.net/app/webroot/.htaccess
scp app/webroot/robots.$env.txt bigbread:www/__subdomains/$env.bigbread.net/app/webroot/robots.txt

echo "...complete."

# Execute the upgrade.sql file
echo "Running upgrade.sql..."
ssh bigbread "cat www/__subdomains/$env.bigbread.net/app/config/sql/upgrade.sample.sql | sed -e s/@DB_NAME@/bigbread_$env/ > www/__subdomains/$env.bigbread.net/app/config/sql/upgrade.sql"
ssh bigbread "cat www/__subdomains/$env.bigbread.net/app/config/sql/upgrade.sql | mysql -ubigbread -p'$dbpassword'"
echo "...complete."
echo ""
echo "That's it. Everything should be ready to go"
