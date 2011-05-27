#!/bin/bash

# if [ $# -lt 2 ]; then
#  echo "Usage: ./deploy.dev.sh <commit> <dbpassword>"
#  exit 1
# fi

# commit=$1
dbpassword=$2
today=`date "+%Y%m%d"`
# project_name=bigbread
# build_root=~/Development/.build

# rm -rf $build_root/$project_name
# git archive $commit --prefix=$project_name/ | tar -x -C $build_root

# 
# Copies the bigbread production database to dev and staging 
# 
echo "Backing up the production database"
ssh bigbread "mysqldump -ubigbread -p'$dbpassword' --opt --no-create-db --complete-insert --databases bigbread_prd > www/mysqldump.sql"
echo "...complete."
echo "Backing up the production code base"
ssh bigbread "tar jcf backups/bigbread.backup.$today.bz2 www/.htaccess www/app/ www/cake/ www/index.php www/mysqldump.sql www/plugins/ www/vendors/"
echo "...complete."

# NOTE: Can't use the delete flag in production since other webroots exist
# in a subdomain of the main.
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
      --exclude "app/webroot/robots.*.txt" \
      --exclude "deploy.*.sh" \
      --links \
      ./ bigbread:www/

echo "Uploading environment-specific config files..."
scp app/config/bootstrap.prd.php bigbread:www/app/config/bootstrap.local.php
scp app/config/database.prd.php bigbread:www/app/config/database.php
scp app/webroot/robots.prd.txt bigbread:www/app/webroot/robots.txt
echo "...complete."

# Execute the upgrade.sql file
echo "Running upgrade.sql..."
ssh bigbread 'cat www/app/config/sql/upgrade.sample.sql | sed -e s/@DB_NAME@/bigbread_prd/ > www/app/config/sql/upgrade.sql'
ssh bigbread "cat www/app/config/sql/upgrade.sql | mysql -ubigbread -p'$dbpassword'"
echo "...complete."
echo ""
echo "That's it. Everything should be ready to go"

exit 0
