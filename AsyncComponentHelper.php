<?php
/**
 * AsyncComponentHelper.
 *
 * Requirement jQuery.
 *
 * @package    symfony-custom
 * @subpackage helper
 * @author     Kohki Makimoto <kohki.makimoto@gmail.com>
 */

/**
 * Include async component.
 *
 * @param  string $url  url
 * @param  array  $vars variables to pass the url using get parameters.
 */
function include_asynccomponent($url, $vars = array())
{
  echo get_asynccomponent($url, $vars);
}

function get_asynccomponent($url, $vars = array())
{
  $p1 = base_convert(sha1($url), 16, 36);
  $p2 = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);
  $cid = $p1.$p2;

  if (count($vars) > 0) {
    $jsvars = json_encode($vars);
  } else {
    $jsvars = 'null';
  }

  $scripts = <<< END
<span id="$cid" style="display: none;"></span>
<script type="text/javascript">
//<![CDATA[
$(function () {
  $.ajax({
    type : "GET",
    url : "$url",
    data : $jsvars,
    success : function(data, dataType) {
      $('#$cid').after(data).remove();
    },
    error : function(XMLHttpRequest, textStatus, errorThrown) {
      $('#$cid').after("<span>Request Error</span>").remove();
    }
  });
});
//]]>
</script>
END;
  return $scripts;
}