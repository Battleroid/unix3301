#!/bin/bash
# Casey Weed
read -n 1 -p "Action: " action 
echo # We just need a newline
read -a input -p "Numbers: "
case $action in
	a)
		echo "Addition"
		echo `expr ${input[0]} + ${input[1]}`
		;;
	s)
		echo "Subtraction"
		echo `expr ${input[0]} - ${input[1]}`
		;;
	m)
		echo "Multiplication"
		echo `expr ${input[0]} \* ${input[1]}`
		;;
	d)
		echo "Division"
		echo `expr ${input[0]} / ${input[1]}`
		;;
	*)
		echo "Incorrect action"
		;;
esac
