#!/usr/bin/env bash
 
sudo service apache2 restart

if [ -f $1/composer.json ]; then
	echo "Installing composer packages.."
	cd $1; composer update --prefer-dist
fi
