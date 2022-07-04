#!/bin/bash
while true
	do
		echo "Actualizando GPIO..."
		php /var/www/html/home/src/ControlBundle/In_Out/update.php
		sleep 1
		clear
	done
