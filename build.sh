#!/bin/bash

workDir=$(pwd)
num=$(find ../ -maxdepth 1 -type d -print | wc -l | sed -e 's/^[ \t]*//')

# METHODS
###########################################

insert() {
	sed -i '' "s|${2}|${3}|g" $1
}

getValue() {
	local value
	if [[ $2 =~ ^[Yy] ]]; then
		if [[ ! -z $1 ]]; then
			read -p "${3} [Default: ${1}]: " value
		else
			read -p "${3}: " value
		fi
	fi
	value=${value:-$1}
	echo $value
}

yesOrNo() {
	local value
	value=$(getValue $1 $2 "${3}")
	if [[ $value =~ ^[Yy] ]]; then
		echo 1
	else
		echo 0
	fi
}

# PROMPTS
###########################################

while true; do
	name=$(getValue "" yes "Enter project name")

	if [ -z $name ]; then
		echo "No project name entered."
	else
		dir=$(getValue $name yes "Enter project dir")

		if [ -d $dir ]; then
			echo "This directory already exists."
		else
			break
		fi
	fi
done

vagrant=$(yesOrNo yes yes "Do you want to start vagrant after install? (HIGH CPU USAGE)")
ask=$(getValue no yes "Do you wish to configure the VM yourself?")
boxName=$(getValue ubuntu/trusty64 $ask "Enter box name")
boxUrl=$(getValue https://vagrantcloud.com/ubuntu/trusty64 $ask "Enter box URL")
syncDir=$(getValue /var/www $ask "Enter synced folder")
memory=$(getValue 1024 $ask "Enter memory size")
ip=$(getValue 192.168.80.$num $ask "Enter private network IP (Required for vhosting)")

if [ ! -z $ip ]; then
	vhost=$(getValue $name.dev $ask "Enter vhost name (Requires sudo)")
fi

git=$(yesOrNo yes $ask "Install GIT on the VM?")
node=$(yesOrNo yes $ask "Install NODE on the VM?")
php=$(yesOrNo yes $ask "Install PHP on the VM?")
pubDir=$(getValue ${syncDir} $ask "Enter public dir")

if [ $php == 1 ]; then
	composer=$(yesOrNo yes $ask "Install COMPOSER on the VM? (Needed for Wordpress)")
fi

if [ $composer == 1 ]; then
	wordpress=$(yesOrNo yes $ask "Install Wordpress?")
fi

if [ $node == 1 ]; then
	gulp=$(yesOrNo yes $ask "Use gulp?")
fi

mysql=$(yesOrNo yes $ask "Install MYSQL on the VM?")

if [ $mysql == 1 ]; then
	dbName=$(getValue db $ask "Enter database name")
	dbPass=$(getValue root $ask "Enter database password")
fi

forward=$(yesOrNo no $ask "Use port forwarding?")

if [ $forward == 1 ]; then
	if [ $php == 1 ]; then
		apachePort=$(getValue "" yes "apache port")
	fi

	if [ $mysql == 1 ]; then
		mysqlPort=$(getValue "" yes "mysql port")
	fi

	sshPort=$(getValue "" yes "ssh port")
fi

assetDir=$dir
if [ $wordpress == 1 ]; then
	assetDir=wp-content/themes/$name/assets
fi

assetDir=$(getValue $assetDir $ask "Enter asset dir")

# INSERTS
###########################################

echo $workDir/$dir/tmp/
mkdir -p $workDir/$dir/tmp/

git clone https://github.com/antoniozzo/vagrant-project-starter.git $workDir/$dir/tmp/
cd $workDir/$dir/
shopt -s dotglob

mv tmp/vagrant/* ./
inserts=( name boxName boxUrl syncDir memory ip vhost git node php pubDir composer mysql dbName dbPass apachePort mysqlPort sshPort app )
for i in ${inserts[@]}; do
	insert Vagrantfile "\[${i}\]" ${!i}
done

if [ $wordpress == 1 ]; then
	mv tmp/wordpress/* ./
	mkdir -p $workDir/$dir/wp-content/plugins
	mkdir -p $workDir/$dir/wp-content/themes/$name
	mkdir -p $workDir/$dir/$assetDir
	mv theme/* $workDir/$dir/wp-content/themes/$name/; rm -rf theme/
	echo -e "/*!\nTheme Name: ${name}\nVersion: 0.0.1\n*/" > $workDir/$dir/wp-content/themes/$name/style.css
	insert composer.json "\[name\]" $name
fi

if [ $gulp == 1 ]; then
	cd $workDir/$dir/$assetDir/
	mv $workDir/$dir/tmp/assets/* ./
	insert package.json "\[name\]" $name
	insert bower.json "\[name\]" $name
	sudo npm i; bower install; gulp build
	cd $workDir/$dir/
fi

rm -rf tmp/

if [ ! -z $ip -a ! -z $vhost ]; then
	echo "Will create a vhost in /etc/hosts, please provide password"
	sudo bash -c "echo -e '\n${ip}\t${vhost}' >> /etc/hosts"
fi

if [ $vagrant == 1 ]; then
	vagrant up
	echo -e "\n\nYour project is running at http://${vhost}\n\n"
	open http://$vhost
	open http://$vhost/$assetDir/dist/styleguide
fi
