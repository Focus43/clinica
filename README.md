## Clinica Development ##
Development for this project should always be handled with the bundled vagrant
stuff. Assuming your in the directory where you keep all your sites, and you
want to name the site directory 'Clinica'...

#### Setup ####

1. `git clone --recursive {git_clone_url_here} Clinica`
2. `cd Clinica/vagrant && vagrant up`. If its your first time running this,
it'll take a while. Subsequent `vagrant up`s are quick.
3. Get a copy of the latest database from production (recommended to use Sequel
if you're on a mac, and the `File > export` tool).
4. Access the local MySQL database in the vagrant machine. Assuming you're using
the Sequel client, these are the credentials for the given fields:
	* host: `127.0.0.1`
	* username: `dev_user`
	* password: `dev_pass`
	* database: `dev_site`
	* port: `3307`
5. Import the database dump (you should be connected to `dev_site` in the Sequel
client). **Word of Caution**: Make sure you're connected to the local VAGRANT
machine and NOT the production database before you run import!
6. This is where it differs from the normal process: because Clinica requires
an SSL cert, we need to test locally that it uses SSL properly. Instead of
accessing the site on `localhost:8080`, you'll be using `localhost:4433` - the
port SSL will use in development. In order to do so, you need to configure a
local domain in your system's HOSTS file. This is easy:
	* From your terminal (any directory), run `sudo nano /etc/hosts`.
	* On a new line, add `127.0.0.1 lo.cal`.
	* Save

#### Access It Locally ####
Because Clinica needs the SSL port, after following steps in item 6 above,
you should hit `http://lo.cal:4433` and see the site.
