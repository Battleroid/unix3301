#!/bin/bash
# Casey Weed
read -n 1 -p "Action: " action 
echo # We just need a newline
read -a input -p "Numbers: "
case $action in
	[aA])
		echo "Addition"
		echo `expr ${input[0]} + ${input[1]}`
		;;
	[sS])
		echo "Subtraction"
		echo `expr ${input[0]} - ${input[1]}`
		;;
	[mM])
		echo "Multiplication"
		echo `expr ${input[0]} \* ${input[1]}`
		;;
	[dD])
		echo "Division"
		echo `expr ${input[0]} / ${input[1]}`
		;;
	*)
		echo "Incorrect action"
		;;
esac
