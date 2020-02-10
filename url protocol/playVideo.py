#-*- coding:utf-8 -*-
from sys import argv
import subprocess
import urllib.parse

import sys
print(sys.version)
print(sys.version_info)
script, first = argv
first = urllib.parse.unquote(first, encoding='utf-8', errors='replace')
ret = subprocess.Popen('"{path}"'.format(path=first[8:-1]), shell=True)
