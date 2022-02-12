#!/bin/bash
gpio mode 8 out
gpio write 8 1
gpio mode 9 out
gpio write 9 1
gpio mode 7 out
gpio write 7 1
gpio mode 15 out
gpio write 15 1
gpio mode 13 out
gpio write 13 1
gpio mode 6 out
gpio write 6 1
#===============
gpio mode 21 out
gpio write 21 1
gpio mode 21 out
gpio write 21 1
gpio mode 8 out
gpio write 8 1
gpio mode 22 out
gpio write 22 1
gpio mode 26 out
gpio write 26 1
#===============
gpio mode 23 out
gpio write 23 1
gpio mode 24 out
gpio write 24 1
gpio mode 27 out
gpio write 27 1
#===============
gpio mode 25 out
gpio write 25 1
gpio mode 28 out
gpio write 28 1
gpio mode 29 out
gpio write 29 1
#===============
gpio mode 9 out
gpio write 9 1
gpio mode 7 out
gpio write 7 1

#sudo sysctl -w net.ipv4.ip_forward=0
    
#sudo php /var/www/html/home/bin/console gos:websocket:server
