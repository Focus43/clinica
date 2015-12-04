#!/usr/bin/env bash

#####################################################################################
# This file is modified slightly from the reference here:
# http://akrabat.com/computing/provisioning-with-ansible-within-the-vagrant-guest/
#####################################################################################

export PYTHONUNBUFFERED=1

if [ $(dpkg-query -W -f='${Status}' ansible 2>/dev/null | grep -c "ok installed") -eq 0 ];
then
    echo "Add APT repositories"
    export DEBIAN_FRONTEND=noninteractive
    apt-get install -qq software-properties-common &> /dev/null || exit 1
    apt-add-repository ppa:ansible/ansible &> /dev/null || exit 1

    apt-get update -qq

    echo "Installing Ansible"
    apt-get install -qq ansible &> /dev/null || exit 1
    echo "Ansible installed"
fi

# NOTE: if you run --connection=local flag, ansible's git clone fails in current version,
# so that's why we add all the bullshit info above to the hosts file (eg. "ansible_ssh_pass...")
# instead of just running connection=local.
cd /vagrant/provisioning && ansible-playbook -i hosts.local setup.yml