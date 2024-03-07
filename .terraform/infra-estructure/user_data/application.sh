#!/bin/bash
hostnamectl set-hostname appserver

#!/bin/bash
service sshd stop
sed -i 's/#Port 22/Port 35222/g' /etc/ssh/sshd_config
sed -i 's/#PubkeyAuthentication/PubkeyAuthentication/g' /etc/ssh/sshd_config
sed -i 's/#AuthorizedKeysFile/AuthorizedKeysFile/g' /etc/ssh/sshd_config
service sshd start

echo "${SSH_PRIVATE_KEY}" > /home/ec2-user/.ssh/keypair.pem
echo -e  "Host *\n\tIdentityFile ~/.ssh/keypair.pem" > /home/ec2-user/.ssh/config
chmod 600 /home/ec2-user/.ssh/keypair.pem
chown ec2-user.ec2-user /home/ec2-user/.ssh/*

yum install -y docker containerd git

curl -SL https://github.com/docker/compose/releases/download/v2.24.7/docker-compose-linux-x86_64  -o /usr/local/bin/docker-compose

chmod +x /usr/local/bin/docker-compose

ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

systemctl enable docker

systemctl start docker