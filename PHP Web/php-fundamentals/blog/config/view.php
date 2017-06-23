<?php
//Templating Constants
$viewConfig["VIEW_FOLDER"]  = ROOT.DS."views";      // views folder

$viewConfig["PARTIALS_FOLDER"]     = $viewConfig["VIEW_FOLDER"].DS."partials";  // views folder

$viewConfig["DEFAULT_LAYOUT"] = "layout";           // default layout

$viewConfig["TEMPLATE_EXT"] = ".phtml";             // extension for the views .. i don't know a good one.. but this one alows for using html and php syntax

$viewConfig["TEMPLATE_BODY_TAG"] = "{%body%}";      // this tag shows where the view will be inserted

// This tag shows to View controller where to replace all the Partials in the file
// %VAR_NAME% will be replaced with variable name, so if you edit it you have to put %VAR_NAME%..

$viewConfig["TEMPLATE_PARTIAL"] = "{>%PARTIAL_NAME%}";
// This tag shows to View controller where to replace all the variables given to him
// %VAR_NAME% will be replaced with variable name, so if you edit it you have to put %VAR_NAME%..
$viewConfig["TEMPLATE_VARIABLE"] = "{#%VAR_NAME%}";



// This tag shows to View controller where to replace all the variables given to him
// %VAR_NAME% will be replaced with variable name, so if you edit it you have to put %VAR_NAME%..
$viewConfig["TEMPLATE_GLOBAL_VARIABLE"] = "{@%VAR_NAME%}";

/* match global and local variables as arrays
 * {#varName[1]} - indexed array from local scope
 * {@varName[1]} - indexed array from global scope
 * {#varName["key"]} - assoc array from local scope
 * {@varName["key"]} - assoc array from global scope
 *
*/
$viewConfig["TEMPLATE_VARIABLE_INDEXED_ARRAY"] = '{ *(#|@)(\w+)\[ *(\d+) *\] *}';
$viewConfig["TEMPLATE_VARIABLE_ASSOC_ARRAY"] = '{ *(#|@)(\w+)\[ *(?:\'|") *(\w+) *(?:\'|") *\] *}';

// if else template block patterns
$viewConfig["IF_BLOCK_START"]   = '(?:{{ *)(#if)(?: *)(@|)(\w+)(?: *}})';  // matches "if" and "author" from {{# if author }} {{#if author}}
$viewConfig["IF_BLOCK_END"]     = '(?:{{ *)(\/if)(?: *}})';             // matches "/if" from {{/if}} or {{ /if }}
$viewConfig["IF_BLOCK_ELSE"]    = '(?:{{ *)(else)(?: *}})';             // matches  "else" from {{ else }} or {{else}}


// unless block patterns
$viewConfig["UNLESS_BLOCK_START"] = '(?:{{ *)(#unless)(?: *)(\w+)(?: *}})'; // this matches "#unless" and "bool" from {{ #unless bool }}
$viewConfig["UNLESS_BLOCK_END"]   = '(?:{{ *)(\/unless)(?: *}})';           // this matches "/unless" from {{ /unless }}


// each block patterns and params
$viewConfig["EACH_BLOCK_START"]         = '(?:{{ *)(#each)(?: *)(@|)(\w+)(?: *}})'; // this matches "#each" and "array" from {{ #each array}}
$viewConfig["EACH_BLOCK_END"]           = '(?:{{ *)(\/each)(?: *}})';           // this matches "/each" from {{ /each }}
$viewConfig["EACH_BLOCK_ELSE"]          = '(?:{{ *)(else)(?: *}})';             // matches  "else" from {{ else }} or {{else}}
$viewConfig["EACH_BLOCK_KEY_PARAM"]     = '{{ *key *}}';                 // this matches "key"   from {{ key }}
$viewConfig["EACH_BLOCK_VALUE_PARAM"]   = '{{ *value *}}';               // this matches "value" from {{ value }}
$viewConfig["EACH_BLOCK_VALUE_PARAM_INDEXED"]  = '{{ *value\[ *(\d+) *\] *}}';        // this matches "1" from {{ value[ 1 ] }}
$viewConfig["EACH_BLOCK_VALUE_PARAM_ASSOC"]  = '{{ *value\[ *(?:"|\') *(\w+) *(?:"|\') *\] *}}';    // this matches "valueKey" from {{ value[ " valueKey " ] }}
$viewConfig["EACH_BLOCK_INDEX_PARAM"]   = '{{ *#index *}}'; // index starting from 0
$viewConfig["EACH_BLOCK_NUMBER_PARAM"]  = '{{ *#number *}}'; // number is index +1

return $viewConfig;