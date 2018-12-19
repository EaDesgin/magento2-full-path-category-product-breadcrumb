#!/bin/sh

INPUT=.

find $INPUT -name "*.php" -exec sed -i -e '2,/\*\//d; 1r copyright.txt' {} \;
