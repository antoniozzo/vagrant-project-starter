#!/usr/bin/env bash
 
echo "Installing composer.."
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer