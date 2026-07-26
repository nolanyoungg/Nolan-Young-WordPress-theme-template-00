#!/usr/bin/env bash

set -euo pipefail

wp_version="${WP_VERSION:-7.0}"
database_name="${WP_TESTS_DB_NAME:-wordpress_tests}"
database_user="${WP_TESTS_DB_USER:-root}"
database_password="${WP_TESTS_DB_PASSWORD:-root}"
database_host="${WP_TESTS_DB_HOST:-127.0.0.1}"
wordpress_directory="${WP_CORE_DIR:-/tmp/wordpress}"
tests_directory="${WP_TESTS_DIR:-/tmp/wordpress-tests-lib}"
develop_directory="$(mktemp -d)"

git clone \
  --branch "$wp_version" \
  --depth 1 \
  https://github.com/WordPress/wordpress-develop.git \
  "$develop_directory/wordpress-develop"

mkdir -p "$wordpress_directory" "$tests_directory"
cp -R "$develop_directory/wordpress-develop/src/." "$wordpress_directory/"
cp -R "$develop_directory/wordpress-develop/tests/phpunit/." "$tests_directory/"
cp "$develop_directory/wordpress-develop/wp-tests-config-sample.php" "$tests_directory/wp-tests-config.php"

sed -i.bak \
  -e "s/youremptytestdbnamehere/$database_name/" \
  -e "s/yourusernamehere/$database_user/" \
  -e "s/yourpasswordhere/$database_password/" \
  -e "s|localhost|$database_host|" \
  -e "s|dirname( __FILE__ ) . '/src/'|'$wordpress_directory/'|" \
  "$tests_directory/wp-tests-config.php"

rm -f "$tests_directory/wp-tests-config.php.bak"

mysql \
  --host="$database_host" \
  --user="$database_user" \
  --password="$database_password" \
  --execute="CREATE DATABASE IF NOT EXISTS \`$database_name\`;"

echo "Installed WordPress $wp_version test libraries in $tests_directory."
