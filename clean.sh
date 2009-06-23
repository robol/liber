#!/bin/bash

echo " => Ripulisco i sorgenti dai file di backup"
echo ""
for file in `find ./ | grep "~"`
	do echo "Rimuovo $file..."
	rm $file
done

echo ""
echo " => Sorgenti ripuliti"
