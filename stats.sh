#!/bin/sh

# Tento skript dává jen VELMI PŘIBLIŽNÉ statistiky

cat abc-nourl | awk 'BEGIN { FS=":"; names[""] = 0; }
$0 ~ ": " { names[$1]++; }
$0 ~ "							--" {
  names[substr($0, 10, length($0))]++;
}
END { 
  for (i in names) {
    if (names[i]) printf("%d:	%s\n", names[i], i);
  }
}' | sort -nr | head -20
