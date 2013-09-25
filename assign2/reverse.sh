#!/bin/bash
# Casey Weed
read -a input -p "Input: "
for (( i = ${#input[@]} - 1; i >= 0; i--)); do
	echo ${input[$i]}
done
