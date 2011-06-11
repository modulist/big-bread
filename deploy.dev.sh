#!/bin/bash

# if [ $# -lt 2 ]; then
#  echo "Usage: ./deploy.dev.sh <commit> <dbpassword>"
#  exit 1
# fi

# commit=$1
dbpassword=$2
# project_name=bigbread
# build_root=~/Development/.build

# rm -rf $build_root/$project_name
# git archive $commit --prefix=$project_name/ | tar -x -C $build_root

echo "Download a copy of the production database..."
ssh bigbread 'scripts/import.sh dev'
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
      --exclude "app/config/database.php" \
      --exclude "app/config/database.*.php" \
      --exclude "app/config/sql/bigbread.empty.sql" \
      --exclude "app/webroot/.htaccess*" \
      --exclude "app/webroot/robots.*.txt" \
      --exclude "deploy.*.sh" \
      --links \
      --delete \
      ./ bigbread:www/__subdomains/dev.bigbread.net

echo "Uploading environment-specific files..."
scp app/config/bootstrap.dev.php bigbread:www/__subdomains/dev.bigbread.net/app/config/bootstrap.local.php
scp app/config/database.dev.php bigbread:www/__subdomains/dev.bigbread.net/app/config/database.php
scp app/webroot/.htaccess.dev bigbread:www/__subdomains/dev.bigbread.net/app/webroot/.htaccess
scp app/webroot/robots.dev.txt bigbread:www/__subdomains/dev.bigbread.net/app/webroot/robots.txt
echo "...complete."

# Execute the upgrade.sql file
echo "Running upgrade.sql..."
ssh bigbread 'cat www/__subdomains/dev.bigbread.net/app/config/sql/upgrade.sample.sql | sed -e s/@DB_NAME@/bigbread_dev/ > www/__subdomains/dev.bigbread.net/app/config/sql/upgrade.sql'
ssh bigbread "cat www/__subdomains/dev.bigbread.net/app/config/sql/upgrade.sql | mysql -ubigbread -p'$dbpassword'"
echo "...complete."
echo ""
echo "That's it. Everything should be ready to go"
