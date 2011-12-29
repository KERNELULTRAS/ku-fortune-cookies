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
    '<meta http-equiv="content-language" content="cs,en">'.
    '<link href="res/style.css" rel="stylesheet" type="text/css" media="screen">'.
    '<script type="text/javascript" src="res/jquery.js"></script>'.
    '<script type="text/javascript" src="res/loader.js"></script>'.
    '<title>fortune</title>'.
  '</head>'.
  '<body>'.
    '<div class="center">'.
      '<div id="push">&nbsp;</div>'.
      '<div id="screen">$ cat /dev/ka '.
        '<div id="spinner">&nbsp;</div>'.
        '<div id="cookie">'.htmlspecialchars($cookie[0]).'</div>'.
      '</div>'.
      '<div id="source">'.
        '<a id="next" href="'.$_SERVER["REQUEST_URI"].'">další ↻</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        '<a id="srclink" href="'.$cookie[1].'">zdroj ➤</a>'.
      '</div>'.
    '</div>'.
    '<div id="footer">'.
      '<a href="https://www.abclinuxu.cz/"><img src="http://www.abclinuxu.cz/images/site2/abc-dark.gif"></a>'.
      '<a href="http://kernelultras.org/"><img src="res/ku.png"></a>'.
      '<a href="https://github.com/kralyk/ku-fortune-cookies"><img src="res/github.png"></a>'.
    '</div>'.
  '</body>'.
  '</html>';
}

function fortuneAjax()
{
  $cookie = getCookieWithSrc();
  header('Content-type: application/json');
  echo json_encode
  (array(
    "text"    => htmlspecialchars($cookie[0]),
    "source"  => $cookie[1]
  ));
}

function main()
{
  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    fortuneAjax();
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

  fortunePage();
}



main();
//eof
