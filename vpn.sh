#!/bin/sh

##### 修改ssh端口 #####
sed -i 's/#Port 22/Port 2022/' /etc/ssh/sshd_config
sed -i 's/PermitRootLogin yes/PermitRootLogin no/' /etc/ssh/sshd_config
systemctl restart sshd.service
echo '.....修改ssh端口完成,禁止root登陆'

##### 添加用户 #####
USER_NAME="fengtianshuo"
USER_PASSWORD="tian.32"
GROUP_NAME="developer"
USER_ID=1000
GROUP_ID=1000
if id -u $USER_NAME >/dev/null 2>&1; then
    echo ".....用户已存在"
else
    groupadd -g $GROUP_ID $GROUP_NAME
    useradd -u $USER_ID -g $GROUP_NAME -m $USER_NAME
    echo "$USER_NAME:$USER_PASSWORD" | chpasswd
    echo '.....添加用戶完成'
fi

###### 通过rrsmu.sh脚本安装ShadowsocksR #####
wget -N --no-check-certificate https://raw.githubusercontent.com/ToyoDAdoubi/doubi/master/ssrmu.sh && chmod +x ssrmu.sh && bash ssrmu.sh