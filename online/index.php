<?php
require("data.inc");
$cnt = count($fortunes) - 1;

$root = '/';            //Should always contain trailing slash
$pageTitle = 'fortune.kral.hk';
$pageSubTitle = 'Kolekce fortunek uživatelů <a href="https://www.abclinuxu.cz/">AbcLinuxu.cz</a>';


function getCookieWithSrc($i)
{
  global $fortunes;
  return $fortunes[$i];
}

function page($html)
{
  global $root, $pageTitle, $pageSubTitle;

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
    '<div id="header">'.
      '<div id=header-l>'.
        '<h1><a href="'.$root.'">'.htmlspecialchars($pageTitle).'</a></h1>'.
        '<h2>'.$pageSubTitle.'</h2>'.
      '</div>'.
      '<div id="header-r">'.
      '<a id="list" href="'.$root.'list">seznam všech</a>'.
      '<a href="http://kernelultras.org/">KU</a>'.
      '<a href="https://github.com/kralyk/ku-fortune-cookies" class="last">github</a>'.
      '</div>'.
    '</div>'.
    '<div class="center">'.
      $html.
    '</div>'.
  '</body>'.
  '</html>';
}

function fortuneHtml($i, $plink)
{
  global $root;
  $cookie = getCookieWithSrc($i);

  return
    '<div id="screen">$ cat /dev/ka '.
      '<div id="spinner">&nbsp;</div>'.
      '<div id="cookie">'.htmlspecialchars($cookie[0]).'</div>'.
    '</div>'.
    '<div id="source">'.
      '<a '.($plink ? '' : 'id="next"').' href="'.$root.'">další ↻</a>'.
      '<a id="plink" href='.$root.$i.'>odkaz ☍</a>'.
      '<a id="srclink" href="'.$cookie[1].'" target="_blank">zdroj ➤</a>'.
    '</div>';
}

function fortuneAjax($i)
{
  global $root;

  $cookie = getCookieWithSrc($i);
  header('Content-type: application/json');
  echo json_encode
  (array(
    "text"    => htmlspecialchars($cookie[0]),
    "plink"   => $root.$i,
    "source"  => $cookie[1]
  ));
}

function listAll()
{
  global $root, $cnt;

  $html = '<div id="screen" class="list-screen">';

  for ($i = 0; $i < $cnt; $i++)
  {
    $cookie = getCookieWithSrc($i);
    $html .=
        '<div class="list-cookie">'.htmlspecialchars($cookie[0]).'</div>'.
        '<div class="list-source"><a href="'.$root.$i.'">odkaz</a> | <a href="'.$cookie[1].'">zdroj</a></div>'.
        '<div class="hr"></div>';
  }

  $html .= '</div>';

  page($html);
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

  if (isset($_GET['list'])) listAll();
  else if (isset($_GET['fortune'])) page(fortuneHtml($_GET['fortune'], true));
  else page(fortuneHtml(rand(0, $cnt-1), false));
}



main();
//eof
