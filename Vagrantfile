# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  # Box Settings
  config.vm.box = "ubuntu/trusty64"
  config.vm.boot_timeout = 600

  # Provider Settings
  config.vm.provider "virtualbox" do |vb|
    vb.memory = 700
    vb.cpus = 2
    vb.name = "puko"
  end

  # Network Settings
  config.vm.network "private_network", ip: "192.168.33.10", auto_correct: true

  # Database Settings
  config.vm.network "forwarded_port", guest: 3306, host: 3306, auto_correct: true

  # Folder Settings
  config.vm.synced_folder ".", "/home/www_app", :nfs => { :mount_options => ["dmode=777", "fmode=666"] }

  # Hosts Settings
  if defined?(VagrantPlugins::HostsUpdater)
    config.vm.hostname = "puko.com"
    config.hostsupdater.aliases = [
      "www.puko.com"
    ]
  end

  # Provision Settings
  config.vm.provision "shell", path: "bootstrap.sh"
end