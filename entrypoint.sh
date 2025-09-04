#!/bin/bash
set -e

php bin/doctrine orm:schema-tool:update --force

exec apache2-foreground
