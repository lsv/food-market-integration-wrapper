#!/usr/bin/env bash
set -e

SCRIPT_DIR="$( cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd )"

composer --working-dir=$SCRIPT_DIR require --dev \
  sebastian/phpcpd \
  friendsofphp/php-cs-fixer \
  phpstan/phpstan \
  infection/infection \
  rregeer/phpunit-coverage-check

$SCRIPT_DIR/vendor/bin/phpcpd src tests
$SCRIPT_DIR/vendor/bin/php-cs-fixer --allow-risky=yes fix
$SCRIPT_DIR/vendor/bin/phpstan analyse -c phpstan.neon
$SCRIPT_DIR/../vendor/bin/phpunit --coverage-text --coverage-clover=$SCRIPT_DIR/../.build/coverage/clover.xml --coverage-xml=$SCRIPT_DIR/../.build/coverage/coverage-xml --log-junit=$SCRIPT_DIR/../.build/coverage/junit.xml --coverage-html=$SCRIPT_DIR/../.build/coverage-html
$SCRIPT_DIR/vendor/bin/coverage-check $SCRIPT_DIR/../.build/coverage/clover.xml 100

CHANGED_FILES=$(cd $SCRIPT_DIR/.. && git diff origin/master --diff-filter=AM --name-only | grep -E 'src/' | paste -sd "," -);
INFECTION_FILTER="--filter=${CHANGED_FILES} --ignore-msi-with-no-mutations";

if test ! -z "$CHANGED_FILES"
then
  $SCRIPT_DIR/vendor/bin/infection -j$(nproc) --skip-initial-tests --coverage=$SCRIPT_DIR/../.build/coverage --configuration=$SCRIPT_DIR/infection.json $INFECTION_FILTER
else
  echo "Infection not run because no files changed"
fi
