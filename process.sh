#!/bin/sh

cat abc | sed -n "s%^[[]https\?://.*$%%;t;p;" > abc-nourl

strfile abc abc.dat
strfile abc-nourl abc-nourl.dat

cat abc | awk -f 'makephp.awk' > 'online/data.inc'
