<?php
/***************************************************************************
					class.TypicalConfig.php
					------------
	product			: TypicalConfig
	version			: 1.0 build 1 (Beta)
	released		: Sunday September 7 2003
	copyright		: Copyright © 2001-2003 Jeremy Hubert
	email			: support@typicalgeek.com
	website			: http://www.typicalgeek.com

    Parses and creates a php configuration file, with support for Arrays, 
    Constants and Vars.

***************************************************************************/

class TypicalConfig {

	var $configfile;
	var $vars;
    var $path='';
    var $arrayName='SYSTEM';
    var $topinfo = '';
    
	function TypicalConfig ($configfile) {
		$this->configfile = $configfile;
		$this->vars = array();
		$this->vars['con'] = array();
		$this->vars['arr'] = array();
		$this->vars['var'] = array();
	}

    function setPath($path) {
        $this->path = $path;
    }

    function setArrayName($name) {
        $this->arrayName = $name;
    }

    function getVars($set=0) {
        if ($set) {
            return $this->vars[$set];
        } else {
            return $this->vars;
        }
    }

	function setArray ($name, $value, $ow=true) {
        if (substr($name,0,1) == ".")
            if ($this->path != '') 
                $name = $this->path . $name;
            else 
                $name = substr($name,1);
		if (isset($this->vars['arr'][$name]) && !$ow) {
			if (is_array($this->vars['arr'][$name])) {
				array_push($this->vars['arr'][$name],$value);
			} else {
				$t = $this->vars['arr'][$name];
				$this->vars['arr'][$name] = array($t, $value);
			}
		} else {
			$this->vars['arr'][$name] = $value;
		}
	}

	function addArray ($name, $value) {
        $this->setArray($name,$value,false);
	}
	
	function addConstant ($name, $value) {
        $this->vars['con'][$name] = $value;
	}

	function addVariable ($name, $value) {
        $this->vars['var'][$name] = $value;
	}

	function addValue ($set, $name, $value) {
        switch(strtolower($set)) {
            case "array";
                $this->AddArray ($name, $value);
                break;
            case "constant";
                $this->AddConstant ($name, $value);
                break;
            case "variable";
                $this->AddVariable ($name, $value);
                break;
            default;
                return false;
        }
	}

	function clearValue ($set,$name=0) {
        if ($name) {
            switch (strtolower($set)) {
                case 'array':
                    $set = 'arr';
                break;
                case 'constant':
                    $set = 'con';
                break;
                case 'variable':
                    $set = 'var';
                break;
            }
            if (substr($name,0,1) == ".")
                if ($this->path != '') 
                    $name = $this->path . $name;
                else 
                    $name = substr($name,1);
    		unset($this->vars[$set][$name]);
        } else {
            $this->vars[$set] == array();
        }
	}

    function getValue($set,$name) {
		if (isset($this->vars[$set][$name])) {
			return $this->vars[$set][$name];
		}
		else {
			return null;
		}
    }

	function getArray ($name) {
		return getValue('arr',$name);
	}

	function getConstant ($name) {
		return getValue('con',$name);
	}

	function getVariable ($name) {
		return getValue('var',$name);
	}

	function escape($str) {
		$str = str_replace("\\" , "\\\\", $str); 
		return preg_replace("!(')!i", "\\\\\\1", $str);
	}

	function unescape($str) {
		$str = str_replace("\\\\" , "\\", $str); 
		return str_replace("\\'", "'", $str);
	}

	function loadConfig($conf=null) {
		if ($conf==null) {
			$conf = $this->configfile;
		}
		$handle = fopen ($conf, "r");
		if ($handle) {
			while (!feof ($handle)) {
                $buffer = fgets($handle, 4096);
                if (strpos($buffer,"::BEGIN HEADER::")) {
                    $this->topinfo = $buffer;
                    while ((strpos($buffer,"::END HEADER::") === false)) {
                        $buffer = fgets($handle, 4096);
                        $this->topinfo .= $buffer;
                        if (feof ($handle)) break;
                    }
                }
                if (preg_match("/^\\\$([a-zA-Z][a-zA-Z0-9_]*)\s=\s(\\\".+\\\"|[0-9]+|true|false);/",$buffer,$matches)) {
                    $var = $this->strip($matches[1]);
                    if (is_bool($matches[2]) || $matches[2] == 'true' || $matches[2] == 'false') {
                        $val = ($matches[2] == 'true') ? true : false;
                    } else {
                        $val = $this->unescape($this->strip($matches[2]));
                    }

                    $this->addVariable($var,$val);

                } elseif (preg_match("/^\\\$[a-zA-Z][a-zA-Z0-9_]*\[[\\\"']?(.*)[\\\"']?\]+\s=\s([\\\"|'].+[\\\"|']|[0-9]+|true|false);/",$buffer,$matches)) {
                    $var = str_replace('"]["','.',$matches[1]);
                    if (is_bool($matches[2]) || $matches[2] == 'true' || $matches[2] == 'false') {
                        $val = ($matches[2] == 'true') ? true : false;
                    } else {
                        $val = $this->unescape($this->strip($matches[2]));
                    }
                    if (strpos($var,'"][')) {
                        $pieces = explode('"][',$var);
                        $this->vars['arr'][$pieces[0]][$pieces[1]] = $val;
                    } else {
                        $var = $this->strip($var);
                        $this->vars['arr'][$var] = $val;
                    }
                } elseif (preg_match("/^define\('([a-zA-Z][a-zA-Z0-9_]*)',(\".+\"|[0-9]+|true|false)\);.*$/i",$buffer,$matches)) {
                    $this->addConstant($matches[1], $this->unescape($this->strip($matches[2])));
				}
			}
			fclose ($handle);
		}
		else {
			$this->saveConfig($conf);
		}
	}

	function strip($str) {
        $str = stripslashes($str);
        if (substr($str,0,1) == "'") $str = substr($str,1);
        if (substr($str,-1) == "'") $str = substr($str,0,-1);
        if (substr($str,0,1) == '"') $str = substr($str,1);
        if (substr($str,-1) == '"') $str = substr($str,0,-1);
		return $str; //substr($str,1,strlen($str)-2);
	}

	function saveConfig ($conf=null,$write=true) {

		if ($conf == null) {
			$conf = $this->configfile;
		}
        $cinfo = "<?php \r\n" . $this->topinfo;

		$config = $this->vars;

        ksort( $this->vars );
        ksort( $this->vars['arr'] );
		reset( $this->vars );

    	while (list($name,$value) = each($this->vars['con'])) {
			$cinfo .= $this->newConstantLine($name,$value);
   		}

        $cinfo .= "\$" . $this->arrayName . " = array();\r\n";

        while (list($name,$value) = each($this->vars['arr'])) {
			$cinfo .= $this->newArrayLine("\$" . $this->arrayName . "[\"".str_replace('.','"]["',$name)."\"]",$value);
   		}
		
    	while (list($name,$value) = each($this->vars['var'])) {
			$cinfo .= $this->newVarLine($name,$value);
   		}        
        $cinfo .= "?>\r\n";

        if ($write) {
            $fp = @fopen($conf, "wb");
            if ($fp) {
                flock($fp, LOCK_EX);
                fwrite($fp, $cinfo);
                flock($fp, LOCK_UN);
                fclose($fp);
                return true;
            }
            else {
                return false;
            }
       } else {
            echo nl2br($cinfo);
       }
    }

    function displayConfig () {
        $this->saveConfig (null,false);
    }


    function newArrayLine($var,$val) {
        if ( is_array($val) ) {
            $ret = $var . " = array();\r\n";
            reset($val);
            while(list($k,$v) = each($val)) {
				if(!is_int($k))
			        $k = '"'.$k.'"';
				$ret .= $this->newArrayLine( $var."[".$k."]", $v );                
            }
        } else {
            if (is_bool($val)) {
                $val = ($val) ? "true" : "false";
            }elseif (is_string($val)) {
                $val = '"' . str_replace("\'","'",addslashes($val)) . '"';
            }
            $ret = $var." = ".$val.";\r\n";
        }
        return $ret;
    }

    function newConstantLine($var,$val) {
        if (is_bool($val)) {
            $val = ($val) ? "true" : "false";
        }elseif (is_string($val)) {
            $val = '"' . str_replace("\'","'",addslashes($val)) . '"';
        }
        $ret = "define('" . $var . "',".$val.");\r\n";

        return $ret;
    }

    function newVarLine($var,$val) {
        if (is_bool($val)) {
            $val = ($val) ? "true" : "false";
        }elseif (is_string($val)) {
            $val = '"' . str_replace("\'","'",addslashes($val)) . '"';
        }
        $ret = "$" . $var . " = ".$val.";\r\n";

        return $ret;
    }
}

?>