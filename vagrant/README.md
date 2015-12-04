### Vagrant (Ubuntu 14.04)
This uses Ansible as the provisioner in a different way than as documented on Vagrant's website. Instead of needing to install Ansible on your host machine, this will download and build Ansible inside the VM, and then execute on itself. This makes it a helluvalot more portable.

Out of the box, if you run `vagrant up` right away, the whole kit and kaboodle includes:

* Apache (2.4+, latest stable for Ubuntu14)
* MySQL (5.6)
* Redis (latest stable for Ubuntu14)
* PHP 5.6 (using ondrej/php5-5.6 PPA)
* NodeJS (latest stable for Ubuntu14)
* Rbenv/Ruby @ 2.2.1

#### Usage

1. Clone this repo and put it in a `vagrant` dir in your project root. Ideally, check out as a submodule into your master project: `git submodule add -b master git@github.com:jhartman86/vagrant-ansible.git vagrant`. The `-b` flag will force it to track only the master branch. (Good reference: http://www.vogella.com/tutorials/Git/article.html#submodules).
	```
	MyProjectRoot/
		vagrant/
			README.MD (this file)
	```

2. In the `vagrant/provisioning` directory, copy or rename the file `setup.sample.yml` to `setup.yml`. Then modify the setup.yml file per your project needs. Documentation is included in the comments and hopefully its fairly straight forward. Note that the setup.yml file will NOT be tracked in version control by default; if you are working on a project team you probably want it saved somewhere (OUTSIDE the vagrant directory, b/c its a submodule) that can just be copied in. Something
like `vagrant-setup.copy-me.yml` in the project root.

3. Optionally, copy and rename the file `vagrant_configs.sample.rb` to the PARENT directory (probably your project root)
and rename to `vagrant_configs.rb`. You can put Vagrant customizations in here and check into your project for tracking.
Regarding port mappings: port 80 inside the VM will map to 8080 on your host machine and is setup as a default; 443 to 4433 
(if you want to test w/ SSL), and 3306 to 3307 (for accessing MySQL from a GUI on your host machine). If you want to 
adjust/add/remove any of these, feel free. Read the Vagrant docs on port mapping if you need help.

4. `$: cd vagrant && vagrant up` will build and provision the VM with everything install :)