#!/bin/sh

cat abc |  sed -n "s%\(^[[]http://.*$\)%___tu___%;t;p;" > abc-nourl
