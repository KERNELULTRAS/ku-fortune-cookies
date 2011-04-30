#!/bin/sh

cat abc |  sed -n "s%\(^[[]http://.*$\)%%;t;p;" > abc-nourl
