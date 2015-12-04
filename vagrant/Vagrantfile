# encoding: utf-8
# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.require_version ">= 1.6"

###########################################################################
# As this Vagrant box could potentially be used as a submodule and we don't
# want to checkin project-specific changes upstream, you shouldn't need to
# change anything in this file. Instead, use a vagrant_configs.rb file (see
# README for details).
###########################################################################
Vagrant.configure("2") do |config|

  # VM resource settings
  resource_values = {
    memory: 1024,
    cpus:   1
  }

  # Port mappings (vm => your host)
  port_mappings = {
    80 => 8080
  }

  # Enable writing-to these folders by apache. By default, when vagrant
  # mounts the entire project as a shared folder, apache won't be able
  # to write to any of the directories. Definitions here will adjust the
  # permissions on specific subdirectories so you can write to them.
  httpd_writable_dirs = []

  # If parent directory contains vagrant_configs.rb file, load and merge
  # settings.
  if File.exists?('../vagrant_configs.rb')
    require_relative '../vagrant_configs'

    # Merge resource values
    if VM_SETTINGS[:resource_values]
      resource_values.merge!(VM_SETTINGS[:resource_values])
    end

    # Merge port mappings
    if VM_SETTINGS[:port_mappings]
      port_mappings.merge!(VM_SETTINGS[:port_mappings])
    end

    # Merge writable dirs
    if VM_SETTINGS[:httpd_writable_dirs]
      httpd_writable_dirs.concat(VM_SETTINGS[:httpd_writable_dirs])
    end
  end

  # Standard vagrant stuff
  config.vm.box               = "ubuntu/trusty64"
  config.vm.box_check_update  = false
  config.ssh.forward_agent    = true

  # This vagrant directory should always be within the project root; below we mount the parent folder
  # into the vm at /home/vagrant/app
  config.vm.synced_folder "../", "/home/vagrant/app"

  # Ansible chokes when the hosts.local file is marked as executable; so we have
  # to adjust the mount permissions on the vagrant folder (which is auto-mounted by
  # default)
  config.vm.synced_folder ".", "/vagrant", mount_options: ["dmode=775,fmode=664"]

  # Above we mount the parent, but by default no directories are writable-to by apache. This
  # mounts the files/ directory (the ONLY one that should be writable) with different permissions.
  httpd_writable_dirs.each do |dict|
    config.vm.synced_folder dict[:host_relative_path], dict[:vm_absolute_path],
      owner: dict[:owner], group: dict[:group], mount_options: dict[:mount_options]
  end

  # Configure port forwarding list
  port_mappings.each do |from, to|
    config.vm.network :forwarded_port, guest:from, host:to, auto_correct:true
  end

  # Box name and resource settings
  begin
    config.vm.provider :virtualbox do |v|
      v.name    = File.basename(File.expand_path("../"))
      v.memory  = resource_values[:memory]
      v.cpus    = resource_values[:cpus]
    end
  rescue
    $stdout.puts "VM Configuration Error (in Vagrantfile)"
  end

  # Ansible run
  config.vm.provision :shell, :keep_color => true, :path => "provisioning/init.sh"

end