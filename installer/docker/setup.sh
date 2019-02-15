#!/bin/sh
##### 關閉防火墻 #####
setenforce 0
sed -i 's/SELINUX=enforcing/SELINUX=disabled/' /etc/selinux/config

##### 修改ssh端口 #####
sed -i 's/#Port 22/Port 2022/' /etc/ssh/sshd_config
systemctl restart sshd.service
echo '.....修改ssh端口完成'

##### 添加用户 #####
USER_NAME="developer"
USER_PASSWORD="developer"
GROUP_NAME="developer"
USER_ID=1000
GROUP_ID=1000
if id -u $USER_NAME >/dev/null 2>&1; then
    echo ".....用户已存在"
else
    groupadd -g $GROUP_ID $GROUP_NAME
    useradd -u $USER_ID -g $GROUP_NAME -m $USER_NAME
    echo $USER_PASSWORD | passwd --stdin $USER_NAME
    echo '.....添加用戶完成'
fi

##### 停止，禁用firewalld服务 #####
systemctl stop firewalld >/dev/null 2>&1;
systemctl mask firewalld >/dev/null 2>&1;
echo '.....停止，禁用firewalld服务完成'

##### 安裝防火墙iptables #####
if yum list installed iptables-services >/dev/null 2>&1; then
    echo '.....已安裝iptables-services'
else
    yum -y install iptables-services
    echo '.....安裝iptables-services完成'
fi
if yum list installed iptables >/dev/null 2>&1; then
    echo '.....已安裝iptables'
else

    yum -y install iptables
    echo '.....安裝iptables完成'
fi

################# 配置iptables #################
# 1.阻隔input forward output链路数据包
# 2.每秒中最多允许5个新连接
#   防止各种端口扫描
#   Ping洪水攻击（Ping of Death）
# 3.允许 ESTABLISHED RELATED状态的数据包入站
#   NEW：主机连接目标主机，在目标主机上看到的第一个想要连接的包
#   ESTABLISHED：主机已与目标主机进行通信，判断标准只要目标主机回应了第一个包，就进入该状态。
#   RELATED：主机已与目标主机进行通信，目标主机发起新的链接方式，例如ftp
#   INVALID：无效的封包，例如数据破损的封包状态
# 4.允许tcp 目标端口为80,20022,3306,27017,443的数据包入站
#   80：http端口
#   2022：ssh端口
#   3306：mysql端口
#   27017：mongodb端口
#   6379：redis端口
#   443：https端口
# 5.允许本地回环地址可以正常使用 本地回环地址：127.0.0。1
# 6.允许外部服务器ping本地主机 协议：icmp
# 7.允许 ESTABLISHED RELATED状态的数据包出站
# 8.允许本地主机发送dns解释数据包 udp 53端口dns
# 9.允许本地主机ping外部服务器
# 10.允许tcp 目标端口为80,25,443的数据包出站
#   25：smtp端口
# 11.保存配置重啟服務
# 12.設置開機啟用服務
IPT="/sbin/iptables"
$IPT --delete-chain
$IPT --flush
$IPT -P INPUT DROP
$IPT -P FORWARD DROP
$IPT -P OUTPUT DROP
$IPT -A FORWARD -p tcp --syn -m limit --limit 1/s --limit-burst 30 -j ACCEPT
$IPT -A FORWARD -p tcp --tcp-flags SYN,ACK,FIN,RST RST -m limit --limit 1/s -j ACCEPT
$IPT -A FORWARD -p icmp --icmp-type echo-request -m limit --limit 1/s -j ACCEPT
$IPT -A INPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
$IPT -A INPUT -p tcp -m tcp --dport 80 -j ACCEPT
$IPT -A INPUT -p tcp -m tcp --dport 2022 -j ACCEPT
$IPT -A INPUT -p tcp -m tcp --dport 3306 -j ACCEPT
$IPT -A INPUT -p tcp -m tcp --dport 27017 -j ACCEPT
$IPT -A INPUT -p tcp -m tcp --dport 443 -j ACCEPT
$IPT -A INPUT -i lo -j ACCEPT
$IPT -A INPUT -p icmp -m icmp --icmp-type 8 -j ACCEPT
$IPT -A INPUT -p icmp -m icmp --icmp-type 11 -j ACCEPT
$IPT -A OUTPUT -m state --state RELATED,ESTABLISHED -j ACCEPT
$IPT -A OUTPUT -p udp -m udp --dport 53 -j ACCEPT
$IPT -A OUTPUT -o lo -j ACCEPT
$IPT -A OUTPUT -p tcp -m tcp --dport 80 -j ACCEPT
$IPT -A OUTPUT -p tcp -m tcp --dport 443 -j ACCEPT
$IPT -A OUTPUT -p tcp -m tcp --dport 25 -j ACCEPT
$IPT -A OUTPUT -p icmp -m icmp --icmp-type 8 -j ACCEPT
$IPT -A OUTPUT -p icmp -m icmp --icmp-type 11 -j ACCEPT
service iptables save
service iptables restart
systemctl enable iptables.service
echo '.....配置iptables完成'

###### 安裝svn #####
if yum list installed subversion >/dev/null 2>&1; then
    echo '.....已安裝svn'
else
    yum -y install svn
    echo '.....安裝svn完成'
fi

###### 安裝nmap #####
if yum list installed nmap >/dev/null 2>&1; then
    echo '.....已安裝nmap'
else
    yum -y install nmap
   echo '.....安裝nmap完成'
fi

################# docker #################
if yum list installed yum-utils >/dev/null 2>&1; then
    echo '.....已安裝yum-utils'
else
    yum -y install yum-utils
    echo '.....安裝yum-utils完成'
fi
if yum list installed device-mapper-persistent-data >/dev/null 2>&1; then
    echo '.....已安裝device-mapper-persistent-data'
else
    yum -y install device-mapper-persistent-data
    echo '.....安裝device-mapper-persistent-data完成'
fi
if yum list installed lvm2 >/dev/null 2>&1; then
    echo '.....已安裝lvm2'
else
    yum -y install lvm2
    echo '.....安裝lvm2完成'
fi
if yum list installed docker-ce >/dev/null 2>&1; then
    echo '.....已安裝docker'
else
    yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
    yum makecache fast
    yum install -y docker-ce
    systemctl enable docker
    service docker start
    curl -L "https://github.com/docker/compose/releases/download/1.22.0/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
    chmod +x /usr/local/bin/docker-compose
    curl -sSL https://get.daocloud.io/daotools/set_mirror.sh | sh -s http://f1361db2.m.daocloud.io
    systemctl daemon-reload
    systemctl restart docker
    echo '.....安裝docker完成'
fi

################# 设置目录权限 #################
#chown -R developer:developer /root/docker
#chmod -R 754 /root/docker