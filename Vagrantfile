# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  # Box Settings
  config.vm.box = "ubuntu/trusty64"

  # Provider Settings
  config.vm.provider "virtualbox" do |vb|
    # vb.memory = 1024
    # vb.cpus = 2
  end

  # Network Settings
  # config.vm.network "forwarded_port", guest: 80, host: 8080
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
  config.vm.network "private_network", ip: "192.168.33.10"
  config.vm.network "forwarded_port", guest: 3306, host: 3306

  # Folder Settings
  config.vm.synced_folder ".", "/home/www_app", :nfs => { :mount_options => ["dmode=777", "fmode=666"] }

  config.vm.provision "shell", path: "bootstrap.sh"
end