
(function(fortune, $, undefined)
{
  var $next;
  var $cookie;
  var $spinner;
  var waiting = false;

  function loading(b)
  {
    if (b)
    {
      $cookie.html('');
      $spinner.css('visibility', 'visible');
    } else
    {
      $spinner.css('visibility', 'hidden');
    }
  }

  function updateNext(data)
  {
    $cookie.html(data.text);
    $('#plink').attr('href', data.plink);
    $('#srclink').attr('href', data.source);
  }

  function getNext()
  {
    if (waiting) return;
    loading(true);

    var ajax_req =
    {
      type: 'POST',
      url: document.URL,
      dataType: 'json',
      timeout: 20000,
      error: function(jqXHR, textStatus, errorThrown)
      {
        loading(false);
        waiting = false;
        $cookie.html('error getting cookie');
      },
      success: function(data)
      {
        loading(false);
        waiting = false;
        updateNext(data);
      }
    };
    $.ajax(ajax_req);
    waiting = true;
  }

  function init()
  {
    $next = $('#next');
    $cookie = $('#cookie');
    $spinner = $('#spinner');

    $next.click(function(event)
    {
      if (event.which > 1 || event.metaKey) return true;
      getNext();
      event.preventDefault();
    })
  }

  $(document).ready(function()
  {
    init();
  });
}(window.fortune = window.fortune || {}, jQuery));
