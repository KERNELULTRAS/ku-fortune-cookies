<?php
require("data.inc");
$cnt = count($fortunes) - 1;

$root = '/';


function getCookieWithSrc($i)
{
  global $fortunes;
  return $fortunes[$i];
}

function fortunePage($i, $plink)
{
  global $root;
  $cookie = getCookieWithSrc($i);

  echo
  "\n\n".'<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN" "http://www.w3.org/TR/1998/REC-html40-19980424/strict.dtd">'."\n".
  '<html>'.
  '<head>'.
    '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">'.
    '<meta http-equiv="content-language" content="cs,en">'.
    '<link href="'.$root.'res/style.css" rel="stylesheet" type="text/css" media="screen">'.
    '<script type="text/javascript" src="'.$root.'res/jquery.js"></script>'.
    '<script type="text/javascript" src="'.$root.'res/loader.js"></script>'.
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
        '<a '.($plink ? '' : 'id="next"').' href="'.$root.'">další ↻</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        '<a id="plink" href='.$root.'fortune/'.$i.'>odkaz ☍</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.
        '<a id="srclink" href="'.$cookie[1].'">zdroj ➤</a>'.
      '</div>'.
    '</div>'.
    '<div id="footer">'.
      '<a href="https://www.abclinuxu.cz/"><img src="http://www.abclinuxu.cz/images/site2/abc-dark.gif"></a>'.
      '<a href="http://kernelultras.org/"><img src="'.$root.'res/ku.png"></a>'.
      '<a href="https://github.com/kralyk/ku-fortune-cookies"><img src="'.$root.'res/github.png"></a>'.
    '</div>'.
  '</body>'.
  '</html>';
}

function fortuneAjax($i)
{
  global $root;

  $cookie = getCookieWithSrc($i);
  header('Content-type: application/json');
  echo json_encode
  (array(
    "text"    => htmlspecialchars($cookie[0]),
    "plink"   => $root.'fortune/'.$i,
    "source"  => $cookie[1]
  ));
}

function search($q)
{
  echo 'Sorry, not implemented yet';
}

function main()
{
  global $cnt;

  if ($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    fortuneAjax(rand(0, $cnt-1));
    exit;
  }

  if ($_SERVER['REQUEST_METHOD'] != 'GET') exit;

  if (isset($_GET['search'])) search($_GET['search']);
  else if (isset($_GET['fortune'])) fortunePage($_GET['fortune'], true);
  else fortunePage(rand(0, $cnt-1), false);
}



main();
//eof
