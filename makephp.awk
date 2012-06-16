BEGIN {
  print "<?php\n$fortunes = array(\n  array(";
}

{
  if ($0 ~ /^%$/)
  {
    gsub(/'/, "\\'", prev);
    url = substr(prev, 2, length(prev)-2);
    printf "'', '%s'),\n  array(", url;
  }
  else if (!($0 ~ /^\[https?:\/\/.*\]$/))
  {
    gsub(/'/, "\\'", $0);
    printf "'%s'.%s", $0, "\"\\n\".\n";
  }

  prev = $0;
}

END {
  print ")\n);";
}
