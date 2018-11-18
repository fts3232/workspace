################# Add user #################
useradd uat
echo s@45579 | passwd uat --stdin
echo '.....Add user done'
################# iptables #################
svn export --force --username uat.deploy --password deploy@24680 http://svn.dtg.hk/svn/it/centos/security/iptables /etc/sysconfig/iptables
echo '.....config iptables done'
################# docker #################
yum install -y yum-utils device-mapper-persistent-data lvm2
yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
yum install docker-ce
systemctl start docker
curl -L "https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
################# install eamil sender #################
cd /usr/local/src
file="/usr/local/src/smtp-cli-3.4-4.1.noarch.rpm"
if [ ! -f "$file" ]
then
	wget http://www.logix.cz/michal/devel/smtp-cli/smtp-cli-3.4-4.1.noarch.rpm
fi
rpm -ivh smtp-cli-3.4-4.1.noarch.rpm
echo '.....install smtp cli done'
################# INSTALL shadowsocks #################
cd /usr/local/src/ && wget https://svn.apache.org/repos/asf/oodt/tools/oodtsite.publisher/trunk/distribute_setup.py
python distribute_setup.py
easy_install pip
pip install shadowsocks
################# get root shellscript #################
mkdir /root/tmp/
svn export --force --username uat.deploy --password deploy@24680 http://svn.dtg.hk/svn/it/centos/shellscript /root/bin
cd /root/bin && chmod 755 *.sh
echo '.....install common script done'
################# DDOS setup #################
svn export --force --username uat.deploy --password deploy@24680 http://svn.dtg.hk/svn/it/centos/security/ddos /usr/local/ddos
cd /usr/local/ddos && chmod 755 *.sh
cp -s /usr/local/ddos/ddos.sh /usr/local/sbin/ddos
/usr/local/ddos/ddos.sh --cron > /dev/null 2>&1
echo '.....install DDOS done'
################# add alias #################
cd /root
sed -i '1 a PS1='\''[\$\(whoami\)@ \$\(pwd\)]# '\''' .bashrc
echo "alias checkatt='netstat -ntu | grep :80 | awk '\''{print \$5}'\'' | cut -d : -f1 | sort | uniq -c | sort -nr'" >> .bashrc
echo "alias hnum='ps -ef | grep -v grep | grep httpd | wc -l'" >> .bashrc
echo "alias cdcrm='cd /home/dtg.hk/domains/crm.dtg.hk/public_html'" >> .bashrc
echo "alias cd202='cd /home/dtg.hk/domains/202.hk/public_html'" >> .bashrc
echo '.....add alias done'
################# add crontab #################
crontab -l > mycron
#echo "*/1 * * * * /root/bin/restart_httpd_500.sh" >> mycron
crontab mycron
rm -f mycron
################# Install webmin #################
cd /usr/local/src
file="/usr/local/src/webmin-1.770-1.noarch.rpm"
if [ ! -f "$file" ]
then
	wget http://prdownloads.sourceforge.net/webadmin/webmin-1.770-1.noarch.rpm
fi
rpm -ivh webmin-1.770-1.noarch.rpm
echo '.....install webmin done'
################# Change port #################
sed -i 's/#Port 22/Port 2022/' /etc/ssh/sshd_config
sed -i 's/Port 22/Port 2022/' /etc/ssh/sshd_config
sed -i 's/PermitRootLogin yes/PermitRootLogin no/' /etc/ssh/sshd_config
sed -i 's/port=10000/port=11223/' /etc/webmin/miniserv.conf
sed -i 's/listen=10000/port=11223/' /etc/webmin/miniserv.conf
echo '.....Change default port done'
################# Start service #################
service iptables restart
service sshd restart
service webmin restart
chkconfig --level 2345 iptables on
chkconfig --level 2345 docker on
echo '.....start service done'
################# stop unuse service #################
service ip6tables stop
service bluetooth stop
service proftpd stop
service named stop
service postfix stop
service dovecot stop
service mailman stop
service spamassassin stop
service clamd stop
service saslauthd stop

chkconfig --level 2345 ip6tables off
chkconfig --level 2345 bluetooth off
chkconfig --level 2345 proftpd off
chkconfig --level 2345 named off
chkconfig --level 2345 postfix off
chkconfig --level 2345 dovecot off
chkconfig --level 2345 usermin off
chkconfig --level 2345 mailman off
chkconfig --level 2345 clamd off
chkconfig --level 2345 spamassassin off
chkconfig --level 2345 saslauthd off

echo '.....stop unuse service done'

################# download jumpsite #################
mkdir /usr/local/src/jumpsite/
svn export --no-auth-cache --force --username uat.deploy --password deploy@24680 http://svn.dtg.hk/svn/it/centos/jumpsite/ /usr/local/src/jumpsite/
cd /usr/local/src/jumpsite/
chmod 755 setup.sh

#####################################################