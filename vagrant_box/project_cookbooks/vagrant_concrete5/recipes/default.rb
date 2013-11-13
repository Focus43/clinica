# install php xdebug from pecl
php_pear "xdebug" do
    # Specify that xdebug.so must be loaded as zend extension
    zend_extensions ['xdebug.so']
    action :install
end

# xdebug configuration template
template "/etc/php5/conf.d/xdebug.ini" do
    source "xdebug.ini.erb"
    owner "root"
    group "root"
    mode 0644
end

# ditch "could not reliably determine hostname" warning
cookbook_file '/etc/apache2/httpd.conf' do
    owner 'root'
    group 'root'
    mode '0644'
    source 'httpd.conf'
end

# copy self-signed SSL certificate
cookbook_file '/etc/ssl/certs/vagrant_apache_ssl.pem' do
    owner 'root'
    group 'root'
    mode '0644'
    source 'vagrant_apache_ssl.pem'
end

# disable default apache vhost
apache_site "000-default" do
  enable false
end

# setup vhost to link to /home/vagrant/app/web
web_app "default" do
	server_name node[:app][:server_name]
	docroot node[:app][:docroot]
	php_timezone node[:app][:php_timezone]
end

# install node dependencies (uses package.json file in node_grunt)
execute "npm dependencies installation" do
	cwd "/home/vagrant/app/build/"
	user "root"
	command "/usr/local/bin/npm install; /usr/local/bin/npm install -g grunt-cli"
	action :run
end

# set pear channel auto-discover and install PHPunit
execute "Pear channel auto-discover and install PHPUnit" do
    user "root"
    command "pear config-set auto_discover 1 && pear install pear.phpunit.de/PHPUnit"
    action :run
    not_if "which phpunit"
end