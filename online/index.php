<?php
require("fortune.php");
$f = new Fortune;



function getCookieWithSrc()
{
  global $f;
  $cookie = $f->getRandomQuote("abc.dat");
  return preg_split("/\[(http:\/\/.*)\]/", $cookie, -1, PREG_SPLIT_DELIM_CAPTURE);
}

function fortunePage()
{
  $cookie = getCookieWithSrc();

  echo
  "\n\n".'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN" "http://www.w3.org/TR/1998/REC-html40-19980424/strict.dtd">'."\n".
  '<html>'.
  '<head>'.
    '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'.
    '<link href="style.css" rel="stylesheet" type="text/css" media="screen">'.
    '<script type="text/javascript" src="js.js"></script>'.
    '<title>fortune</title>'.
  '</head>'.
  '<body>'.
    '<div class="center">'.
      '<div id="push">&nbsp;</div>'.
      '<div id="screen">$ cat /dev/ka'."\n".$cookie[0].
        //~ "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n"  .
        '</div>'.
      '<div id="source"><a href="'.$cookie[1].'">zdroj →</a></div>'.
    '</div>'.
    '<div id="footer">'.
      '<a href="https://www.abclinuxu.cz/"><img src="http://www.abclinuxu.cz/images/site2/abc-dark.gif"></a>'.
      '<a href="http://kernelultras.org/"><img src="ku.png"></a>'.
      '<a href="https://github.com/kralyk/ku-fortune-cookies"><img src="github.png"></a>'.
    '</div>'.
  '</body>'.
  '</html>'.
  '';

}

function fortuneAjax()
{
}

function main()
{
  //~ if ($_SERVER['REQUEST_METHOD'] == 'POST')
  //~ {
  //~ }

  if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

  fortunePage();
}



main();
//eof
