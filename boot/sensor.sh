#!/bin/bash
while true
	do
		echo "Leyendo Sensores..."
		php /var/www/html/home/src/ControlBundle/In_Out/read.php
		sleep 2
		clear
	done
