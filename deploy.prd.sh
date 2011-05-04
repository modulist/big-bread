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

# NOTE: Can't use the delete flag in production since other webroots exist
# in a subdomain of the main.
rsync -vcrlDtOzi --progress \
      --exclude ".DS_STORE" \
      --exclude "app/tmp" \
      --exclude "*.komodoproject" \
      --exclude ".komodotools" \
      --exclude ".git" \
      --exclude ".gitignore" \
      --exclude "app/config/bootstrap.*.php" \
      --exclude "app/config/database.php" \
      --exclude "app/config/database.*.php" \
      --exclude "app/config/sql/bigbread.empty.sql" \
      --exclude "deploy.*.sh" \
      --links \
      ./ bigbread:www/

echo "Uploading environment-specific config files..."
scp app/config/bootstrap.prd.php bigbread:www/app/config/bootstrap.local.php
scp app/config/database.prd.php bigbread:www/app/config/database.php
echo "...complete."

# Execute the upgrade.sql file
echo "Running upgrade.sql..."
ssh bigbread 'cat www/app/config/sql/upgrade.sample.sql | sed -e s/@DB_NAME@/bigbread_prd/ > www/app/config/sql/upgrade.sql'
ssh bigbread 'cat www/app/config/sql/upgrade.sql | mysql -ubigbread -p"cPd123011!!"'
echo "...complete."
echo ""
echo "That's it. Everything should be ready to go"
