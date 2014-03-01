<?php
$script = '
    $(document).ready(
    	function()
	    {
	        loadContent();
	    }
    );
	
	function hideAlert()
	{
		$(this).stop(true, true).animate({ opacity: 0,right: "-20" }, 500, function() { $(this).hide(); });
	}
    
    function loadContent()
    {
    	alertHide();
    	loading("Loading");
        $("#getcontent2").load(
        	"'.$this->Html->url(array("action" => "factureClient", $this->request->params['pass'][0], $this->request->params['pass'][1])).'",
            function() { unloading(); }
		).fadeIn(400);
    }
';
echo $this->Html->scriptBlock($script, array('inline' => true));
?>

<div id="getcontent2"></div>