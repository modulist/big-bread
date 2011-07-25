#!/bin/bash

# project_name=bigbread
# build_root=~/Development/.build
env="prd"
root="www"

if [ $# -lt 2 ]; then
  echo "Usage: ./deploy.$env.sh <commit> <dbpassword>"
  exit 1
fi

# commit=$1
dbpassword=$2
today=`date "+%Y%m%d"`

# rm -rf $build_root/$project_name
# git archive $commit --prefix=$project_name/ | tar -x -C $build_root

# 
# Copies the bigbread production database to dev and staging 
# 
echo "Backing up the production database"
ssh bigbread "mysqldump -ubigbread -p'$dbpassword' --opt --no-create-db --complete-insert --databases bigbread_$env > www/mysqldump.sql"
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
      --exclude "app/config/core.php" \
      --exclude "app/config/core.*.php" \
      --exclude "app/config/database.php" \
      --exclude "app/config/database.*.php" \
      --exclude "app/config/sql/bigbread.empty.sql" \
      --exclude "app/webroot/.htaccess*" \
      --exclude "app/webroot/robots.*.txt" \
      --exclude "deploy.*.sh" \
      --links \
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
echo "Running upgrade.sql..."
ssh bigbread "cat $root/app/config/sql/upgrade.sample.sql | sed -e s/@DB_NAME@/bigbread_$env/ > $root/app/config/sql/upgrade.sql"
ssh bigbread "cat $root/app/config/sql/upgrade.sql | mysql -ubigbread -p'$dbpassword'"
echo "...complete."
echo ""
echo "That's it. Everything should be ready to go"

exit 0
