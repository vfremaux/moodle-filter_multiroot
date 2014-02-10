<?php // $id$
//////////////////////////////////////////////////////////////
//  Multiroot filtering
//  
// This filter filters all texts searching for original 
// wwwroot to translate to the aliased used domain
//
//////////////////////////////////////////////////////////////

class multiroot_filter extends moodle_text_filter{

	function filter($text) {
	    global $CFG, $HOSTS_THEMES;
	    
	    if (empty($CFG->multiroot)) return $text;
	    
	    if (isset($CFG->originalwwwroot) && $CFG->originalwwwroot != $CFG->wwwroot){
	    	// if we are in an alias, translate orignal contents to current alias
	    	$text = preg_replace("#{$CFG->originalwwwroot}#", $CFG->wwwroot, $text);
	    } else {
	    	// if we are in the original domain, bring back all aliases to the original domain when displaying.
	    	// Brings back all Alias1, Alias2, AliasN contents to Original
	    	// this will not solve all crossover situations, specially for content created on Alias1 and 
	    	// accessed through Alias2
			if (!empty($HOSTS_THEMES)){
			    $hostdomains = implode('|', array_keys($HOSTS_THEMES));
			}
	    	$text = preg_replace("#http://{$hostdomains}#", $CFG->originalwwwroot, $text);
	    }
	
		return $text;
	}
}

?>
