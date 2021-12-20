# PREPARE VIRTUAL MACHINE
## official docs https://laravel.com/docs/8.x/homestead#first-steps
## INSTALL VIRTUALBOX
sudo apt update
sudo apt install virtualbox

## Check that installed
virtualbox --help | head -n 1

my output:
Oracle VM VirtualBox VM Selector v6.1.16_Ubuntu

## The Extension Pack enhances VirtualBox by adding USB 2.0 and 3.0 support, remote desktop, and encryption.
## when licence text - press ESC, then agree license
sudo apt install virtualbox—ext–pack

## INSTALL VAGRANT
curl -fsSL https://apt.releases.hashicorp.com/gpg | sudo apt-key add -
sudo apt-add-repository "deb [arch=amd64] https://apt.releases.hashicorp.com $(lsb_release -cs) main"
sudo apt update
sudo apt install vagrant

## Check that installed
vagrant --version
# my output
# Vagrant 2.2.16


# install git
sudo apt install git

#install composer
manaual: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-composer-on-ubuntu-20-04-ru
sudo apt update
sudo apt install php-cli unzip
cd ~
curl -sS https://getcomposer.org/installer -o composer-setup.php

HASH=`curl -sS https://composer.github.io/installer.sig`
php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

Output: Installer verified

sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
Check in terminal:
composer


# get project: run in folder where you want the project to be
git clone https://github.com/rndrep/microscope-php.git

#install some php extensions
sudp apt install php-curl
sudp apt install php-dom

#go to microscope-php folder
composer require --dev laravel/homestead 11.2.4

if you see error like:
```
Problem 1
    - phpunit/phpunit[9.3.3, ..., 9.5.x-dev] require ext-dom * -> it is missing from your system. Install or enable PHP's dom extension.
```
you need to install php extension ("dom" in this case)

# In project folder:
copy Homestead-example.yaml as Homestead.yaml
add Homestead.yaml in .gitignore

copy .env-example as .env
add .env in .gitignore
update APP_URL= in .env

copy frontend/.env-example as frontend/.env

# add to hosts /etc/hosts (ip from Homestead.yaml):
192.168.10.10 microscope.test

# prepare homestead
php vendor/bin/homestead make

# set your project folder in Homestead.yaml
map: {YOUR_PATH}/microscope-php

# run virtual machine and server:
vagrant up

# Go to vagrant VM
vagrant ssh
cd ~/code

# change php version
php73

# install packages
## php
composer update

## node
sudo npm install -g npm@8.2.0


### in folder /frontend
npm install
gulp

### in project folder
npm install
npm run dev (for development)

# prepare db
php artisan migrate
php artisan db:seed


###################################################
	SERVER SETTINGS
###################################################
# Set in nginx config /etc/nginx/nginx.conf or /etc/nginx/sites-available/..
	server {
		...
		client_max_body_size 100M;
		...
	}
Then run:
sudo service nginx reload

# change php.ini (in /etc/php/7.3/fpm?)
post_max_size = 100M
upload_max_filesize = 100M
max_file_uploads = 200

Then run:
sudo systemctl restart php7.3-fpm
###################################################
	END SERVER SETTINGS
###################################################

# SITE URL
http://microscope.test/


# NOTE:

## turn off the VM
vagrant halt

## After change "sites" in Homestead.yaml run:
vagrant reload --provision

## Remove virtual machine (DATABASE WILL BE REMOVED!!!)
vagrant destroy

## Accesss to VM
vagrant ssh

SSH address: 127.0.0.1:2222
SSH login/pass: vagrant/vagrant

## database access
127.0.0.1:54320
homestead / secret
