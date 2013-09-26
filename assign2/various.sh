#!/bin/bash
# Casey Weed
read -p "Input: " action
case $action in
	1)
		date
		;;
	2)
		ls .
		;;
	3)
		who | cut -d' ' -f1 | sort | uniq
		;;
	*)
		echo "Incorrect usage"
		;;
esac
