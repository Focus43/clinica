VM_SETTINGS = {
	resources_values: {
		memory: 768,
		cpus: 	2,
	},

	port_mappings: {
		443		=> 4433,
		3306	=> 3307
	},

	# See Vagrantfile for definition
	httpd_writable_dirs: [
		{ # Ex. for setting up a writable directory for Concrete5
			host_relative_path: '../web/application/files',
			vm_absolute_path: '/home/vagrant/app/web/application/files',
			owner: 'vagrant',
			group: 'www-data',
			mount_options: ['dmode=775,fmode=664']
	    }
	]
}