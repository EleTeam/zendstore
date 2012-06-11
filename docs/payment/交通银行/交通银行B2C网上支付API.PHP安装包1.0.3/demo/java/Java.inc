<?php
  

if(!function_exists("java_get_base")) {
  $version = phpversion();
  if ((version_compare("5.1.2", $version, ">"))) {
	$msg = "<br><strong>PHP $version too old.</strong><br>\nPlease set the path to
a PHP 5.1.x executable, see php_exec in the WEB-INF/web.xml";
	die($msg);
  }
  

  function java_get_base() {
	$ar = get_required_files();
	$arLen = sizeof($ar);
	if($arLen>0) {
	  $thiz = $ar[$arLen-1];
	  return dirname($thiz);
	} else {
	  return "java/";
	}
  }
  $JAVA_BASE=java_get_base();
  

  class java_RuntimeException extends Exception {};
  

  class java_IOException extends Exception {};
  

  class java_ConnectException extends java_IOException {};
  

  class java_IllegalStateException extends java_RuntimeException {};
  

  class java_IllegalArgumentException extends java_RuntimeException {
	function __construct($ob) {
	  parent::__construct("illegal argument: ".gettype($ob));
	}
  };
  

  function java_autoload_function5($x) {
	$str=str_replace("_", ".", $x);
	$client=__javaproxy_Client_getClient();
	if(!($client->invokeMethod(0, "typeExists", array($str)))) return false;
	$instance = "class ${x} extends Java {".
	  "static function type(\$sub=null){if(\$sub) \$sub='\$'.\$sub; return java('${str}'.\"\$sub\");}".
	  'function __construct() {$args = func_get_args();'.
	  'array_unshift($args, '."'$str'".'); parent::__construct($args);}}';
	eval ("$instance");
	return true;
  }
  

  function java_autoload_function($x) {
	$idx = strrpos($x, "::"); if (!$idx) return java_autoload_function5($x);
	$str=str_replace("::", ".", $x);
	$client=__javaproxy_Client_getClient();
	if(!($client->invokeMethod(0, "typeExists", array($str)))) return false;
	$package = substr($x,0, $idx);
	$name = substr($x, 2+$idx);
	$instance = "namespace $package; class ${name} extends ::Java {".
	  "static function type(\$sub=null){if(\$sub) \$sub='\$'.\$sub;return ::java('${str}'.\"\$sub\");}".
	  'function __construct() {$args = func_get_args();'.
	  'array_unshift($args, '."'$str'".'); parent::__construct($args);}}';
	eval ("$instance");
	return true;
  }
  

  function java_autoload($libs=null) {
	static $once = false;
	if($once) 
	  throw new java_IllegalStateException("java_autoload called more than once");
	$once = true;
	java_require($libs);
	if(function_exists("spl_autoload_register")) {
	  spl_autoload_register("java_autoload_function");
	} else {
	  function __autoload($x) {
		return java_autoload_function($x);
	  }
	}
  }
  

  function Java($name) { 
	static $classMap = array();
	if(array_key_exists($name, $classMap)) return $classMap[$name];
	return $classMap[$name]=new JavaClass($name);
  }
  

  function java_get_closure() {return java_closure_array(func_get_args());}
  

  function java_wrap() {return java_closure_array(func_get_args());}
  

  function java_get_values($arg) { return java_values($arg); }
  

  function java_unwrap($arg) { return java_values($arg); }
  

  function java_get_session() {return java_session_array(func_get_args());}
  

  function java_get_context() {return java_context(); }
  

  function java_get_server_name() { return java_server_name(); }
  

  function java_isnull($value) { return is_null (java_values ($value)); }
  

  function java_is_null($value) { return is_null (java_values ($value)); }
  

  function java_istrue($value) { return  (boolean)(java_values ($value)); }
  

  function java_is_true($value) { return (boolean)(java_values ($value)); }
  

  function java_isfalse($value) { return !(java_values ($value)); }
  

  function java_is_false($value) { return !(java_values ($value)); }
  

  function java_set_encoding($enc) { return java_set_file_encoding ($enc); }
  

  function java_set_library_path($arg) { return java_require($arg); }




function java_defineHostFromInitialQuery($java_base) {
  if($java_base!="java/") {
	$url = parse_url($java_base);
	if(isset($url["scheme"]) && ($url["scheme"]=="http")) {
	  $host = $url["host"];
	  $port = $url["port"];
	  $path = $url["path"];
	  define ("JAVA_HOSTS", "$host:$port");
	  $dir = dirname($path);
	  define ("JAVA_SERVLET", "$dir/JavaBridge.phpjavabridge"); 
	  return true;
	}
  }
  return false;
}


define ("JAVA_PEAR_VERSION", "5.3.3");
if(!defined("JAVA_SEND_SIZE")) 
  define("JAVA_SEND_SIZE", 8192);
if(!defined("JAVA_RECV_SIZE")) 
  define("JAVA_RECV_SIZE", 8192);
if (defined ("JAVA_PARSE_INI_FILE") && JAVA_PARSE_INI_FILE) {
  $ini=@parse_ini_file("java.ini");
	

  if(array_key_exists("java.hosts", $ini)) define("JAVA_HOSTS", $ini["java.hosts"]);
	

	if(array_key_exists("java.servlet", $ini)) define("JAVA_SERVLET", $ini["java.servlet"]);
	

	  if(array_key_exists("java.log_level", $ini)) define("JAVA_LOG_LEVEL", $ini["java.log_level"]);
 }
 if(!defined("JAVA_HOSTS")) {
  if(!java_defineHostFromInitialQuery($JAVA_BASE)) {
	define("JAVA_HOSTS", "127.0.0.1:8080"); 
  }
 }
 if(!defined("JAVA_SERVLET")) {
  define("JAVA_SERVLET", "On"); 
}
if(!defined("JAVA_LOG_LEVEL"))
  define ("JAVA_LOG_LEVEL", null); 


if(!defined("JAVA_PIPE_DIR")) {
  if (file_exists ("/dev/shm")) define("JAVA_PIPE_DIR", "/dev/shm" );
  elseif (file_exists ("/tmp")) define("JAVA_PIPE_DIR", "/tmp" );
  else						  define ("JAVA_PIPE_DIR", null);
}


if (!defined("JAVA_PREFER_VALUES"))
  define("JAVA_PREFER_VALUES", 0);


if(!defined("JAVA_DEBUG")) 
  define("JAVA_DEBUG", false);
  



class java_SimpleFactory {
  public $client;
  function java_SimpleFactory($client) {
	$this->client = $client;
  }
  function getProxy($result, $signature, $exception, $wrap) {
	if (false) { $signature = $signature; $wrap = $wrap; $exception = $exception; }
  	return $result;
  }
  function checkResult($result) {
  	if (false) $result = $result;
  }
}


class java_ProxyFactory extends java_SimpleFactory {
  function java_ProxyFactory($client) {
	parent::java_SimpleFactory($client);
  }
  function create($result, $signature) {
	return new java_JavaProxy($result, $signature);
  }
  function createInternal($proxy) {
	return new java_InternalJava($proxy);
  }
  function getProxy($result, $signature, $exception, $wrap) {
	if (false) { $exception = $exception; }
	$proxy = $this->create($result, $signature);
	if($wrap) $proxy = $this->createInternal($proxy);
	return $proxy;
  }
}


class java_ArrayProxyFactory extends java_ProxyFactory {
  function java_ArrayProxyFactory($client) {
	parent::java_ProxyFactory($client);
  }
  function create($result, $signature) {
	return new java_ArrayProxy($result, $signature);
  }	
}


class java_IteratorProxyFactory extends java_ProxyFactory {
  function java_IteratorProxyFactory($client) {
	parent::java_ProxyFactory($client);
  }
  function create($result, $signature) {
	return new java_IteratorProxy($result, $signature);
  }	
}


class java_ExceptionProxyFactory extends java_SimpleFactory {
  function java_ExceptionProxyFactory($client) {
	parent::java_SimpleFactory($client);
  }
  function create($result, $signature) {
	return new java_ExceptionProxy($result, $signature);
  }
  function getProxy($result, $signature, $exception, $wrap) {
	$proxy = $this->create($result, $signature);
	if($wrap) $proxy = new java_InternalException($proxy, $exception);
	return $proxy;
  }
}


class java_ThrowExceptionProxyFactory extends java_ExceptionProxyFactory {
  function java_ThrowExceptionProxyFactory($client) {
	parent::java_ExceptionProxyFactory($client);
  }
  function getProxy($result, $signature, $exception, $wrap) {
	if (false) { $wrap = $wrap; }
  	$proxy = $this->create($result, $signature);
	$proxy = new java_InternalException($proxy, $exception);
	return $proxy;
  }
  function checkResult($result) {
	throw $result;
  }
}


class java_CacheEntry {
  public $fmt, $signature, $factory, $java;
  public $resultVoid;
  function java_CacheEntry($fmt, $signature, $factory, $resultVoid) {
	$this->fmt = $fmt;
	$this->signature = $signature;
	$this->factory = $factory;
	$this->resultVoid = $resultVoid;
  }
}


class java_Arg {
  public $client;
  public $exception; 				
  public $factory, $val;
  public $signature; 
  function java_Arg($client) {
	$this->client = $client;
	$this->factory = $client->simpleFactory;
  }
  function linkResult(&$val) {
	$this->val = &$val;
  }
  function setResult($val) {
	$this->val = &$val;
  }
  function getResult($wrap) {
	$rc = $this->factory->getProxy($this->val, $this->signature, $this->exception, $wrap);
	$factory = $this->factory;
	$this->factory = $this->client->simpleFactory;
	$factory->checkResult($rc);
	return $rc;
  }
  function setFactory($factory) {
	$this->factory = $factory;
  }
  function setException($string) {
	$this->exception = $string;
  }
  function setVoidSignature() {
	$this->signature = "@V";
	$key = $this->client->currentCacheKey;
	if($key && $key[0]!='~') {			
	  $this->client->currentArgumentsFormat[6]="3";
	  if(JAVA_DEBUG) {
		echo "ignore further results:";  echo "\n";
	  }
	  if(JAVA_DEBUG) {
		echo "updating cache $key, argformat: {$this->client->currentArgumentsFormat}, classType: {$this->signature}\n";
	  }
	  $cacheEntry = new java_CacheEntry($this->client->currentArgumentsFormat, $this->signature, $this->factory, true);
	  $this->client->methodCache[$key]=$cacheEntry;
	}
  }
  function setSignature($signature) {
	$this->signature = $signature;
	$key = $this->client->currentCacheKey;
	if($key && $key[0]!='~') {			
	  if(JAVA_DEBUG) {
		echo "updating cache $key, argformat: {$this->client->currentArgumentsFormat}, classType: {$this->signature}\n";
	  }
	  $cacheEntry = new java_CacheEntry($this->client->currentArgumentsFormat, $this->signature, $this->factory, false);
	  $this->client->methodCache[$key]=$cacheEntry;
	}
  }
}


class java_CompositeArg extends java_Arg {
  public $parentArg;
  public $idx;						
  public $type;					
  public $counter;
  function java_CompositeArg($client, $type) {
	parent::java_Arg($client);
	$this->type = $type;
	$this->val = array();
	$this->counter = 0;
  }
  function setNextIndex() {
	$this->idx = $this->counter++;
  }
  function setIndex($val) {
	$this->idx = $val;
  }
  function linkResult(&$val) {
	$this->val[$this->idx]=&$val;
  }
  function setResult($val) {
	$this->val[$this->idx]=$this->factory->getProxy($val, $this->signature, $this->exception, true);
	$this->factory = $this->client->simpleFactory;
  }
}


class java_ApplyArg extends java_CompositeArg {
  public $m, $p, $v, $n; 			
  function java_ApplyArg($client, $type, $m, $p, $v, $n) {
	parent::java_CompositeArg($client, $type);
	$this->m = $m;
	$this->p = $p;
	$this->v = $v;
	$this->n = $n;
  }
}


class java_Client 
 {
  public $RUNTIME;
  public $result, $exception;
  public $parser;
  public $simpleArg, $compositeArg;
  public $simpleFactory, 
	$proxyFactory, $iteratorProxyFacroty, 
	$arrayProxyFactory, $exceptionProxyFactory, $throwExceptionProxyFactory;
  public $arg;
  public $asyncCtx, $cancelProxyCreationCounter;
  public $globalRef;
  public $stack;
  public $defaultCache = array(), $asyncCache = array(), $methodCache;
  public $isAsync = 0;
  public $currentCacheKey, $currentArgumentsFormat;
  public $cachedJavaPrototype;
  public $sendBuffer, $preparedToSendBuffer;
  function java_Client() {
	$this->RUNTIME = array();
	$this->RUNTIME["NOTICE"]='***USE echo java_inspect(jVal) OR print_r(java_values(jVal)) TO SEE THE CONTENTS OF THIS JAVA OBJECT!***';
	if(JAVA_PIPE_DIR && function_exists("posix_mkfifo")) 
	  $this->RUNTIME['PIPE_DIR']=JAVA_PIPE_DIR;
	else
	  $this->RUNTIME['PIPE_DIR']=null;
	$this->parser = new java_Parser($this);
	$this->protocol = new java_Protocol($this);
	$this->simpleFactory = new java_SimpleFactory($this);
	$this->proxyFactory = new java_ProxyFactory($this);
	$this->arrayProxyFactory = new java_ArrayProxyFactory($this);
	$this->iteratorProxyFactory = new java_IteratorProxyFactory($this);
	$this->exceptionProxyFactory = new java_ExceptionProxyFactory($this);
	$this->throwExceptionProxyFactory = new java_ThrowExceptionProxyFactory($this);
	$this->cachedJavaPrototype=new java_JavaProxyProxy($this);
	$this->simpleArg = new java_Arg($this);
	$this->globalRef = new java_GlobalRef();
	$this->asyncCtx = $this->cancelProxyCreationCounter = 0;
	$this->methodCache = $this->defaultCache;
  }
  function __destruct() { 
	if(JAVA_DEBUG) echo "the client destroyed\n";
	if (!isset($this->protocol)) return;
	if ($this->sendBuffer) $this->protocol->flush();
	$this->protocol->keepAlive();
  }
  function read($size) {
	return $this->protocol->read($size);
  }
  function setDefaultHandler() {
	$this->methodCache = $this->defaultCache;
  }
  function setAsyncHandler() {
	$this->methodCache = $this->asyncCache;
  }
  function handleRequests() {
	do {
	  $tail_call = false;
	  $this->stack=array($this->arg=$this->simpleArg);
	  $this->idx = 0;
	  $this->parser->parse();
	  

	  if((count($this->stack)) > 1) {
		$arg = array_pop($this->stack);
		$this->apply($arg);
		$tail_call = 1;			
	  } else {
		$tail_call = 0;
	  }
	  $this->stack=null;
	} while($tail_call);
	return 1;
  }
  function getWrappedResult($wrap) {
	return $this->simpleArg->getResult($wrap);
  }
  function getInternalResult() {
	return $this->getWrappedResult(false);
  }
  function getResult() {
	return $this->getWrappedResult(true);
  }
  function getProxyFactory($type) {
	switch($type[0]) {
	case 'E':
	  $factory = $this->exceptionProxyFactory;
	  break;
	case 'C':
	  $factory = $this->iteratorProxyFactory;
	  break;
	case 'A':
	  $factory = $this->arrayProxyFactory;
	  break;
	case 'O':
	  $factory = $this->proxyFactory;
	}
	return $factory;
  }
  function link(&$arg, &$newArg) {
	$arg->linkResult($newArg->val);
	$newArg->parentArg = $arg;
  }
  function getExact($str) {
	return hexdec($str);
  }
  function getInexact($str) {
	$val = null;
  	sscanf($str, "%e", $val);
	return $val;
  }
  function begin($name, $st) {
	$arg = $this->arg;
	switch($name[0]) {
	case 'A':						

	  $object = $this->globalRef->get($this->getExact($st['v']));
	  $newArg = new java_ApplyArg($this, 'A',
								  $this->parser->getData($st['m']),
								  $this->parser->getData($st['p']),
								  $object,
								  $this->getExact($st['n']));
	  $this->link($arg, $newArg);
	  array_push($this->stack, $this->arg = $newArg);
	  break;
	case 'X': 
	  $newArg = new java_CompositeArg($this, $st['t']);
	  $this->link($arg, $newArg);
	  array_push($this->stack, $this->arg = $newArg);
	  break;
	case 'P':
	  if($arg->type=='H') { 

		$s = $st['t'];
		if(JAVA_DEBUG) {echo "setresult prepare hash:"; echo sprintf("%s", $st['t']); echo "\n";}
		if($s[0]=='N') { 

		  $arg->setIndex($this->getExact($st['v']));
		  if(JAVA_DEBUG) {echo "setresult array: index:"; echo sprintf("%s", $st['v']); echo "\n";}
		} else {
		  $arg->setIndex($this->parser->getData($st['v']));
		  if(JAVA_DEBUG) {echo "setresult hash: index:"; echo sprintf("%s", $this->parser->getData($st['v'])); echo "\n";}
		}
	  } else {					

		$arg->setNextIndex();
	  }
	  break;
	case 'S':
	  $arg->setResult($this->parser->getData($st['v']));
	  if(JAVA_DEBUG) {echo "setresult string:"; echo sprintf("%s", $this->parser->getData($st['v'])); echo "\n";}
	  break;
	case 'B':
	  $s=$st['v'];
	  $arg->setResult($s[0]=='T');
	  if(JAVA_DEBUG) {echo "setresult bool:"; echo sprintf("%s", $st['v']); echo "\n";}
	  break;
	case 'L':					
	  $sign = $st['p'];
	  $val = $this->getExact($st['v']);
	  if($sign[0]=='A') $val*=-1;
	  $arg->setResult($val);
	  if(JAVA_DEBUG) {echo "setresult long:"; echo sprintf("%s, sign: %s", $st['v'], $st['p']); echo "\n";}
	  break;
	case 'D':
	  $arg->setResult($this->getInexact($st['v']));
	  if(JAVA_DEBUG) {echo "setresult double:"; echo sprintf("%s", $st['v']); echo "\n";}
	  break;
	case 'V':
	  if ($st['n']!='T') {
		if(JAVA_DEBUG) {echo "setresult VOID:"; echo "\n";}
		$arg->setVoidSignature();
	  }
	case 'N':
	  $arg->setResult(null);
	  if(JAVA_DEBUG) {echo "setresult null\n"; }
	  break;
	case 'F':
	  if(JAVA_DEBUG) {echo "comm. end\n"; }
	  break;
	case 'O': 
	  $arg->setFactory($this->getProxyFactory($st['p']));
	  $arg->setResult($this->asyncCtx=$this->getExact($st['v']));
	  if($st['n']!='T') $arg->setSignature($st['m']);
	  if(JAVA_DEBUG) {echo "setresult object:"; echo sprintf("%x", $this->asyncCtx); echo "\n";}
	  break;
	case 'E':
	  $arg->setFactory($this->throwExceptionProxyFactory);
	  if(JAVA_DEBUG) {echo "setresult exception:"; echo sprintf("%x", $this->asyncCtx); echo "\n";}
	  $arg->setException($this->parser->getData($st['m']));
	  $arg->setResult($this->asyncCtx=$this->getExact($st['v']));
	  break;
	default: 
	  $this->parser->parserError();
	}
  }
  function end($name) {
	switch($name[0]) {
	case 'X':
	  $frame = array_pop($this->stack);
	  $this->arg = $frame->parentArg;
	  break;
	}
  }
  function createParserString() {
	return new java_ParserString();
  }
  function writeArg($arg) {
	if(is_string($arg)) {
	  $this->protocol->writeString($arg);
	} else if(is_object($arg)) {
	  if (!$arg instanceof java_JavaType) throw new java_IllegalArgumentException($arg);
	  $this->protocol->writeObject($arg->__java);
	  return $arg;
	} else if(is_null($arg)) {
	  $this->protocol->writeObject(null);
	} else if(is_bool($arg)) {
	  $this->protocol->writeBoolean($arg);
	} else if(is_integer($arg)) {
	  $this->protocol->writeLong($arg);
	} else if(is_float($arg)) {
	  $this->protocol->writeDouble($arg);
	} else if(is_array($arg)) {
	  $wrote_begin=false;
	  foreach($arg as $key=>$val) {
		if(is_string($key)) {
		  if(!$wrote_begin) {
			$wrote_begin=1;
			$this->protocol->writeCompositeBegin_h(); 		
		  }
		  $this->protocol->writePairBegin_s($key);
		  $this->writeArg($val);
		  $this->protocol->writePairEnd();
		} else {
		  if(!$wrote_begin) {
			$wrote_begin=1;
			$this->protocol->writeCompositeBegin_h();
		  }
		  $this->protocol->writePairBegin_n($key);
		  $this->writeArg($val);
		  $this->protocol->writePairEnd();
		}
	  }
	  if(!$wrote_begin) {
		$this->protocol->writeCompositeBegin_a();
	  }
	  $this->protocol->writeCompositeEnd();
	}
	return null;
  }
  function writeArgs($args) {
	$n = count($args);
	for($i=0; $i<$n; $i++) {
	  $this->writeArg($args[$i]);
	}
  }
  function createObject($name, $args) {
	$this->protocol->createObjectBegin($name);
	$this->writeArgs($args);
	$this->protocol->createObjectEnd();
	$val = $this->getInternalResult();
	return $val;
  }
  function referenceObject($name, $args) {
	$this->protocol->referenceBegin($name);
	$this->writeArgs($args);
	$this->protocol->referenceEnd();
	$val = $this->getInternalResult();
	return $val;
  }
  function getProperty($object, $property) {
	$this->protocol->propertyAccessBegin($object, $property);
	$this->protocol->propertyAccessEnd();
	return $this->getResult();
  }
  function setProperty($object, $property, $arg) {
	$this->protocol->propertyAccessBegin($object, $property);
	$this->writeArg($arg);
	$this->protocol->propertyAccessEnd();
	$this->getResult();
  }
  function invokeMethod($object, $method, $args) {
	$this->protocol->invokeBegin($object, $method);
	$this->writeArgs($args);
	$this->protocol->invokeEnd();
	$val = $this->getResult();
	return $val;
  }
  function unref($object) {
	$this->protocol->writeUnref($object);
  }
  function apply($arg) {
	$name = $arg->p;
	$object = $arg->v;
	$ob = $object ? array(&$object, $name) : $name;
	$isAsync				= $this->isAsync;
	$methodCache			= $this->methodCache;
	$currentArgumentsFormat = $this->currentArgumentsFormat;
	try {
  	$res = $arg->getResult(true);
	  if((!$object && !function_exists($name)) || ($object && !method_exists($object, $name))) throw new JavaException("java.lang.NoSuchMethodException", "$name");
	  $res = call_user_func_array($ob, $res);
	  if (is_object($res) && !($res instanceof java_JavaType)) {
		  trigger_error("object returned from $name() is not a Java object", E_USER_WARNING);
		  $this->protocol->invokeBegin(0, "makeClosure", "5", "6");
		  $this->protocol->writeULong($this->globalRef->add($res)); // proper PHP "long" -> Java 64 bit value conversion
		  $this->protocol->invokeEnd();
		  $res = $this->getResult();
	  }
	  $this->protocol->resultBegin();
	  $this->writeArg($res);
	  $this->protocol->resultEnd();
	} catch (JavaException $e) {
	  $trace = $e->getTraceAsString();
	  $this->protocol->resultBegin();
	  $this->protocol->writeException($e->__java, $trace);
	  $this->protocol->resultEnd();
	} catch(Exception $ex) {
	   die ($ex);
	}	  
	$this->isAsync				= $isAsync;
	$this->methodCache			= $methodCache;
	$this->currentArgumentsFormat = $currentArgumentsFormat;
  }
  function cast($object, $type) {
	switch($type[0]) {
	case 'S': case 's':
	  return $this->invokeMethod(0, "castToString", array($object));
	case 'B': case 'b':
	  return $this->invokeMethod(0, "castToBoolean", array($object));
	case 'L': case 'I': case 'l': case 'i':
	  return $this->invokeMethod(0, "castToExact", array($object));
	case 'D': case 'd': case 'F': case 'f':
	  return $this->invokeMethod(0, "castToInExact", array($object));
	case 'N': case 'n':
	  return null;
	case 'A': case 'a':
	  return $this->invokeMethod(0, "castToArray", array($object));
	case 'O': case 'o':			
	  return $object;
	default: 
	  throw new java_RuntimeException("$type illegal");
	}
  }
  function getContext() {
	return $this->invokeMethod(0, "getContext", array());
  }
  function getSession($args) {
	return $this->invokeMethod(0, "getSession", $args);
  }
  function getServerName() {
	return $this->protocol->getServerName();
  }
}
  

  

class java_GlobalRef {
  public $map;
  function java_GlobalRef() {
	$this->map = array();
  }
  function add($object) {
	if(is_null($object)) return 0;
	return array_push($this->map, $object);
  }
  function get($id) {
	if(!$id) return 0;
	return $this->map[--$id];
  }
}
  



class java_NativeParser {
  public $parser, $handler;
  public $level, $event;
  public $buf;
  function java_NativeParser($handler) {
	$this->handler = $handler;
	$this->parser = xml_parser_create();
	xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, 0);
	xml_set_object($this->parser, $this);
	xml_set_element_handler($this->parser, "begin", "end");
	xml_parse($this->parser, "<F>");
	$this->level = 0;
  }
  function begin($parser, $name, $param) {
  	if (false) $parser = $parser;
	$this->event = true;
	switch($name) {
	case 'X': case 'A': $this->level+=1;
	}
	$this->handler->begin($name, $param);
  }
  function end($parser, $name) {
  	if (false) $parser = $parser;
	$this->handler->end($name);
	switch($name) {
	case 'X': case 'A': $this->level-=1;
	}
  }
  function getData($str) {
	return base64_decode($str);
  }
  function parse() {
	do {
	  $this->event = false;
	  $buf = $this->buf = $this->handler->read(JAVA_RECV_SIZE); 
	  $len = strlen($buf);
	  if(!xml_parse($this->parser, $buf, $len==0)) {
		die(sprintf("protocol error: %s, %s at col %d. Check the back end log for details.",
					$buf,
					xml_error_string(xml_get_error_code($this->parser)),
					xml_get_current_column_number($this->parser)));
	  }
	} while(!$this->event || $this->level>0);
  }
  function parserError() {
	die(sprintf("protocol error: %s. Check the back end log for details.", $this->buf));
  }
}
  



class java_Parser {
  public $ENABLE_NATIVE = true;
  public $DISABLE_SIMPLE= false;
  public $parser;
  function java_Parser($handler) {
	if($this->ENABLE_NATIVE && function_exists("xml_parser_create")) {
	  $this->parser = new java_NativeParser($handler);
	  $handler->RUNTIME["PARSER"]="NATIVE";
	} else {
	  if($this->DISABLE_SIMPLE) die("no parser");
	  $this->parser = new java_SimpleParser($handler);
	  $handler->RUNTIME["PARSER"]="SIMPLE";
	}
  }
  function parse() {
	$this->parser->parse();
  }
  function getData($str) {
	return $this->parser->getData($str);
  }
  function parserError() {
	$this->parser->parserError();
  }
}
  



function java_getHeader($name, $array) {
  if (array_key_exists($name, $array)) return $array[$name];
  $name="HTTP_$name"; 
  if (array_key_exists($name, $array)) return $array[$name];
  return null;
}


class java_SocketChannel {
  public $peer, $protocol;
  private $channelName, $host;
  function java_SocketChannel($peer, $protocol, $host, $channelName) {
	$this->peer = $peer;
	$this->protocol = $protocol;
	$this->host = $host;
	$this->channelName = $channelName;
  }
  function fwrite($data) {
	return fwrite($this->peer, $data);
  }
  function fread($size) {
	return fread($this->peer, $size);
  }
  function keepAlive() {
	$this->fwrite("<F p=\"A\" />");
	$this->fread(10); // <F p="A"/>
  }
}


class java_EmptyPipeChannel {
  function open($handler) {
  	if (false) $handler = $handler;
	throw new java_RuntimeException("protocol error: socket channel names must not start with a slash");
  }
  function getName() {
	return null;
  }
  function keepAlive() {}
}


class java_PipeChannel extends java_EmptyPipeChannel {
  public $peer, $peerr, $peerr_desc, $name;
  public $fifo, $fifor;
  public $iname, $oname;
  function java_PipeChannel($name) {
	$this->name = $name;
	$this->iname = $this->name . ".i";
	$mask = umask(0);
	$this->fifor = posix_mkfifo($this->iname, 0666);
	$this->oname = $this->name . ".o";
	$this->fifo = posix_mkfifo($this->oname, 0666);
	umask($mask);
  }
  function open($handler) {
  	if (false) $handler = $handler;
	$this->peerr = fopen($this->iname, "r");
	$this->peerr_desc = array($this->peerr);
	stream_set_blocking($this->peerr, false);
	stream_set_timeout($this->peerr, -1);
	$this->peer = fopen($this->oname, "w");
	unlink($this->iname);
	unlink($this->oname);
	unlink($this->name);
	stream_set_timeout($this->peer, -1);
	return $this;
  }
  function fwrite($data) {
	  return fwrite($this->peer, $data);
  }
  function fread($size) {
	static $empty = NULL;
	stream_select($this->peerr_desc, $empty, $empty, 1677216);
	return fread($this->peerr, $size);
  }
  function getName() {
	return $this->name;
  }
}


class java_SocketHandler {
  public $protocol, $channel;
  function java_SocketHandler($protocol, $channel) {
	$this->protocol = $protocol;
	$this->channel = $channel;
  }
  function write($data) {
	  return $this->channel->fwrite($data);
  }
  function read($size) {
	return $this->channel->fread($size);
  }
  function redirect() {}
  function keepAlive() {
	$this->channel->keepAlive();
  }
}


class java_HttpHandler extends java_SocketHandler {
  public $headers;
  public $redirect;
  public $context, $ssl, $port; 
  public $host; 
  public $socket; 
  function createPipeChannel($host, $pipe_dir) {
	if(!is_null($pipe_dir) && ($host == "127.0.0.1" || (substr($host,0,9) == "localhost")))
	  return new java_PipeChannel(tempnam($pipe_dir, ".php_java_bridge"));
	return new java_EmptyPipeChannel();
  }
  function close() {
	fclose($this->socket);
  }
  function open() {
  	$errno = null; $errstr = null;
  

	$socket = fsockopen("{$this->ssl}{$this->host}", $this->port, $errno, $errstr, 30);
	if (!$socket) throw new java_ConnectException("Could not connect to the J2EE server {$this->ssl}{$this->host}:{$this->port}. Please start it, for example with the command: \"java -jar JavaBridge.jar SERVLET:8080 3 JavaBridge.log\" or, if the back end has been compiled to native code, with \"modules/java SERVLET:8080 3 JavaBridge.log\". Error message: $errstr ($errno)\n");
	stream_set_timeout($socket, -1);
	return $socket;
  }
  function java_HttpHandler($protocol, $ssl, $host, $port) {
	$this->protocol = $protocol;
	$this->ssl = $ssl;
	$this->host = $host;
	$this->port = $port;
	$this->channel = $this->createPipeChannel($host, $protocol->client->RUNTIME['PIPE_DIR']);
	$this->socket = $this->open();
  }
  function getCookies() {
	$str="";
	$first=true;
	foreach($_COOKIE as $k => $v) {
	  $str .= ($first ? "Cookie: $k=$v":"; $k=$v");
	  $first=false;
	}
	if(!$first) $str .= "\r\n";
	return $str;
  }
  function getContextFromCgiEnvironment() {
	$ctx = java_getHeader('X_JAVABRIDGE_CONTEXT', $_SERVER);
	return $ctx;
  }
  function getChannelName() {
	$name = $this->channel->getName();
	return !is_null($name) ? sprintf("X_JAVABRIDGE_CHANNEL: %s\r\n", $name) : null;
  }
  function getContext() {
	$ctx = $this->getContextFromCgiEnvironment();
	$context = "";
	if($ctx) {
	  $context = sprintf("X_JAVABRIDGE_CONTEXT: %s\r\n", $ctx);
	}
	return $context;
  }
  function getWebAppInternal() {
	$context = $this->protocol->webContext;
	if(isset($context)) return $context;
	

	return (JAVA_SERVLET == "User" &&
			array_key_exists('PHP_SELF', $_SERVER) &&
			array_key_exists('HTTP_HOST', $_SERVER))
	  ? $_SERVER['PHP_SELF']."javabridge"
	  : null;
  }
  function getWebApp() {
	$context = $this->getWebAppInternal();
	if(is_null($context)) $context = JAVA_SERVLET;
	if(is_null($context) || $context[0]!="/") 
	  $context = "/JavaBridge/JavaBridge.phpjavabridge";
	return $context;
  }
  function write($data) {
	$compatibility = $this->protocol->client->RUNTIME["PARSER"]=="NATIVE"
	  ? chr(0103-JAVA_PREFER_VALUES)
	  : chr(0100+JAVA_PREFER_VALUES);
	if(is_int(JAVA_LOG_LEVEL)) {
	  $compatibility |= 128 | (7 & JAVA_LOG_LEVEL)<<2;
	}
	$this->headers = null;
	$socket = $this->socket;
	$len = 2 + strlen($data);
	$webapp = $this->getWebApp();
	$cookies = $this->getCookies();
	$channel = $this->getChannelName();
	$context = $this->getContext();
	$redirect = $this->redirect;
	$res = "PUT ";
	$res .= $webapp;
	$res .= " HTTP/1.0\r\n";
	$res .= "Host: localhost\r\n";
	$res .= "Content-Length: "; $res .= $len; $res .= "\r\n";
	$res .= $context;
	$res .= $cookies;
	$res .= $redirect;
	if(!is_null($channel)) $res .= $channel;
	$res .= "\r\n";
	$res .= "\177";
	$res .= $compatibility;
	$res .= $data;
	$count = fwrite($socket, $res); fflush($socket);
	return $count;
  }
  function doSetCookie($key, $val, $path) {
	$path=trim($path);
	$webapp = $this->getWebAppInternal(); if(!$webapp) $path="/";
	setcookie($key, $val, 0, $path);
  }
  function parseHeaders() {
	$this->headers = array();
	while (($str = trim(fgets($this->socket, JAVA_RECV_SIZE)))) {
	  if($str[0]=='X') {
		if(!strncasecmp("X_JAVABRIDGE_REDIRECT", $str, 21)) {
		  $this->headers["redirect"]=trim(substr($str, 22));
		} else if(!strncasecmp("X_JAVABRIDGE_CONTEXT", $str, 20)) {
		  $this->headers["context"]=trim(substr($str, 21));
		}
	  } else if($str[0]=='S') {	
		if(!strncasecmp("SET-COOKIE", $str, 10)) {
		  $str=substr($str, 12);
		  $ar = explode(";", $str);
		  $cookie = explode("=",$ar[0]);
		  $path = "";
		  if(isset($ar[1])) $p=explode("=", $ar[1]);
		  if(isset($p)) $path=$p[1];
		  $this->doSetCookie($cookie[0], $cookie[1], $path);
		}
	  } else if($str[0]=='C') { 
		if(!strncasecmp("CONTENT-LENGTH", $str, 14)) {
		  $this->headers["content_length"]=trim(substr($str, 15));
		}
	  }
	}
  }
  function read($size) {
  	if (false) $size = $size;
 	if(is_null($this->headers)) $this->parseHeaders();
	$data = fread($this->socket, $this->headers['content_length']);
	return $data;
  }
  function getChannel($channelName) {
  	$errstr = null; $errno = null;
	if($channelName[0]=='/') return $this->channel->open($this);
	
	//将pfsockopen改为fsockopen，脚本执行完毕自动关闭连接
	//原函数可能导致连接的不稳定
	//2009-02-02 by liuming
	$peer = fsockopen($this->host, $channelName, $errno, $errstr, 30); 
	if (!$peer) throw new java_RuntimeException("Could not connect to the context server {$this->host}:{$channelName}. Error message: $errstr ($errno)\n");
	stream_set_timeout($peer, -1);
	return new java_SocketChannel($peer, $this->protocol, $this->host, $channelName);
  }
  function redirect() {
	if(!isset($this->headers["redirect"])) { 
	  throw new java_RuntimeException("no Pipe- or SocketContextServer available.");
	}
	if(!isset($this->protocol->socketHandler)) {
	  $hostVec = java_Protocol::getHost();
	  $this->host = $hostVec[0];
	  $channelName = $this->headers["redirect"];
	  $context = $this->headers["context"];
	  $len = strlen($context);
	  $len0 = chr(0xFF);
	  $len1 = chr($len&0xFF); $len>>=8;
	  $len2 = chr($len&0xFF);
	  $this->protocol->socketHandler=new java_SocketHandler($this->protocol, $this->getChannel($channelName));
	  $this->protocol->write("\177${len0}${len1}${len2}${context}");
	  $this->context = sprintf("X_JAVABRIDGE_CONTEXT: %s\r\n", $context);
	}
	$this->close();
	$this->protocol->handler = $this->protocol->socketHandler;
	$this->protocol->flush(); 
  }
}


class java_Protocol {
  public $client;
  public $webContext;
  public $serverName;
  function getOverrideHosts() {
	  if(array_key_exists('X_JAVABRIDGE_OVERRIDE_HOSTS', $_ENV)) {
		  $override = $_ENV['X_JAVABRIDGE_OVERRIDE_HOSTS'];
		  if(!is_null($override) && $override!='/') return $override;
	  }
	  return 
		java_getHeader('X_JAVABRIDGE_OVERRIDE_HOSTS_REDIRECT', $_SERVER);
  }
  static function getHost() {
	static $host;
	if(!isset($host)) {
	  $hosts = explode(";", JAVA_HOSTS);
	  $host = explode(":", $hosts[0]); 
	}
	return $host;
  }
  function createHttpHandler() {
	$hostVec = java_Protocol::getHost();
	$host = $hostVec[0];
	$port = $hostVec[1];
	$overrideHosts = $this->getOverrideHosts();
	$ssl = "";
	if($overrideHosts) {
	 $s=$overrideHosts;
	 if((strlen($s)>2) && ($s[1]==':')) {
	   if($s[0]=='s')
		 $ssl="ssl://";
	   $s = substr($s, 2);
	 }
	 $webCtx = strpos($s, "//");
	 if($webCtx)
	   $host = substr($s, 0, $webCtx);
	 else
	   $host = $s;
	 $idx = strpos($host, ':');
	 if($idx) {
	   if($webCtx)
		 $port = substr($host, $idx+1, $webCtx);
	   else
		 $port = substr($host, $idx+1);
	   $host = substr($host, 0, $idx);
	 } else {
	   $port = "8080";
	 }
	 if($webCtx) $webCtx = substr($s, $webCtx+1);
	  $this->webContext = $webCtx;
	}
	$this->serverName = "$host:$port";
	return new java_HttpHandler($this, $ssl, $host, $port);
  }
  

  function createSimpleHandler($channelName) {
	if(!is_string($channelName)) {
	  $errno = null; $errstr = null;
	  $peer = pfsockopen($host="127.0.0.1", $channelName, $errno, $errstr, 30);
	} else {
	  $type = $channelName[0];
	  if($type=='@' || $type=='/') {		 
		if($type=='@') $channelName[0]="\0"; 
		$peer = pfsockopen($host="unix://${channelName}", null, $errno, $errstr, 30);
		$channelName = null;
	  }
	  else {					
		list($host, $channelName) = explode(":", $channelName);
		$peer = pfsockopen($host, $channelName, $errno, $errstr, 30);
	  }
	}
	if (!$peer) throw new java_ConnectException("Could not connect to the server $channelName. Error message: $errstr ($errno)\n");
	stream_set_timeout($peer, -1);
	$handler = new java_SocketHandler($this, new java_SocketChannel($peer, $this, $host, $channelName));
	$compatibility = $this->client->RUNTIME["PARSER"]=="NATIVE"
	  ? chr(0103-JAVA_PREFER_VALUES)
	  : chr(0100+JAVA_PREFER_VALUES);
	if(is_int(JAVA_LOG_LEVEL)) {
	  $compatibility |= 128 | (7 & JAVA_LOG_LEVEL)<<2;
	}
	$this->write("\177$compatibility");
	$this->serverName = "127.0.0.1:$channelName";
	return $handler;
  }
  function createHandler() {
	if(!java_getHeader('X_JAVABRIDGE_OVERRIDE_HOSTS_REDIRECT', $_SERVER)
	 && function_exists("java_get_default_channel") &&
	  ($defaultChannel=java_get_default_channel())) {
	  return $this->createSimpleHandler($defaultChannel);
	} else {
	  return $this->createHttpHandler();
	}
  }
  function java_Protocol ($client) {
	$this->client = $client;
	$this->handler = $this->createHandler();
  }
  function redirect() {
	$this->handler->redirect();
  }
  function read($size) {
	return $this->handler->read($size);
  }
  function sendData() {
	$this->handler->write($this->client->sendBuffer);
	$this->client->sendBuffer=null;
  }
  function flush() {
	if(JAVA_DEBUG) {
	  echo "sending::: "; echo $this->client->sendBuffer; echo "\n";
	}
	$this->sendData();
  }
  function keepAlive() {
	$this->handler->keepAlive();
  }
  function handle() {
	$this->client->handleRequests();
  }
  function write($data) {
	$this->client->sendBuffer.=$data;
  }
  function finish() {
	$this->flush();
	$this->handle();
	$this->redirect();
  }
  function referenceBegin($name) {
	$this->client->sendBuffer.=$this->client->preparedToSendBuffer;
	if(JAVA_DEBUG) {
	  echo "flushed preparedToSendBuffer: ".$this->client->preparedToSendBuffer."\n";
	}
	$this->client->preparedToSendBuffer=null;
	$signature=sprintf("<H p=\"1\" v=\"%s\">", $name);
	$this->write($signature);
	$signature[6]="2";
	$this->client->currentArgumentsFormat = $signature;
  }
  function referenceEnd() {
	$this->client->currentArgumentsFormat.=$format="</H>";
	$this->write($format);
	$this->finish();
	$this->client->currentCacheKey=null;
  }
  function createObjectBegin($name) {
	$this->client->sendBuffer.=$this->client->preparedToSendBuffer;
	if(JAVA_DEBUG) {
	  echo "flushed preparedToSendBuffer: ".$this->client->preparedToSendBuffer."\n";
	}
	$this->client->preparedToSendBuffer=null;
	$signature=sprintf("<K p=\"1\" v=\"%s\">", $name);
	$this->write($signature);
	$signature[6]="2";
	$this->client->currentArgumentsFormat = $signature;
  }
  function createObjectEnd() {
	$this->client->currentArgumentsFormat.=$format="</K>";
	$this->write($format);
	$this->finish();
	$this->client->currentCacheKey=null;
  }
  function propertyAccessBegin($object, $method) {
	$this->client->sendBuffer.=$this->client->preparedToSendBuffer;
	if(JAVA_DEBUG) {
	  echo "flushed preparedToSendBuffer: ".$this->client->preparedToSendBuffer."\n";
	}
	$this->client->preparedToSendBuffer=null;
	$this->write(sprintf("<G p=\"1\" v=\"%x\" m=\"%s\">", $object, $method));
	$this->client->currentArgumentsFormat="<G p=\"2\" v=\"%x\" m=\"${method}\">";
  }
  function propertyAccessEnd() {
	$this->client->currentArgumentsFormat.=$format="</G>";
	$this->write($format);
	$this->finish();
	$this->client->currentCacheKey=null;
  }
  function invokeBegin($object, $method) {
	$this->client->sendBuffer.=$this->client->preparedToSendBuffer;
	if(JAVA_DEBUG) {
	  echo "flushed preparedToSendBuffer: ".$this->client->preparedToSendBuffer."\n";
	}
	$this->client->preparedToSendBuffer=null;
	$this->write(sprintf("<Y p=\"1\" v=\"%x\" m=\"%s\">", $object, $method));
	$this->client->currentArgumentsFormat="<Y p=\"2\" v=\"%x\" m=\"${method}\">";
  }
  function invokeEnd() {
	$this->client->currentArgumentsFormat.=$format="</Y>";
	$this->write($format);
	$this->finish();
	$this->client->currentCacheKey=null;
  }
  function resultBegin() {
	$this->client->sendBuffer.=$this->client->preparedToSendBuffer;
	if(JAVA_DEBUG) {
	  echo "flushed preparedToSendBuffer: ".$this->client->preparedToSendBuffer."\n";
	}
	$this->client->preparedToSendBuffer=null;
	$this->write("<R>");
  }
  function resultEnd() {
	$this->client->currentCacheKey=null;
	$this->write("</R>");
	$this->flush();
  }
  function writeString($name) {
	$this->client->currentArgumentsFormat.=$format="<S v=\"%s\"/>";
	$this->write(sprintf($format, htmlspecialchars($name, ENT_COMPAT)));
  }
  function writeBoolean($boolean) {
	$this->client->currentArgumentsFormat.=$format="<T v=\"%s\"/>";
	$this->write(sprintf($format, $boolean));
  }
  function writeLong($l) {
	$this->client->currentArgumentsFormat.="<J v=\"%d\"/>";
	if($l<0) {
	  $this->write(sprintf("<L v=\"%x\" p=\"A\"/>",-$l));
	} else {
	  $this->write(sprintf("<L v=\"%x\" p=\"O\"/>",$l));
	}
  }
  function writeULong($l) {
	$this->client->currentArgumentsFormat.=$format="<L v=\"%x\" p=\"O\"/>";
	$this->write(sprintf($format,$l));
  }
  function writeDouble($d) {
	$this->client->currentArgumentsFormat.=$format="<D v=\"%.14e\"/>";
	$this->write(sprintf($format, $d));
  }
  function writeObject($object) {
	$this->client->currentArgumentsFormat.=$format="<O v=\"%x\"/>";
	$this->write(sprintf($format, $object));
  }
  

  function writeException($object, $str) {
	$this->write(sprintf("<E v=\"%x\" m=\"%s\"/>",$object, htmlspecialchars($str, ENT_COMPAT)));
  }
  function writeCompositeBegin_a() {
	$this->write("<X t=\"A\">");
  }
  function writeCompositeBegin_h() {
	$this->write("<X t=\"H\">");
  }
  function writeCompositeEnd() {
	$this->write("</X>");
  }
  function writePairBegin_s($key) {
	$this->write(sprintf("<P t=\"S\" v=\"%s\">", htmlspecialchars($key, ENT_COMPAT)));
  }
  function writePairBegin_n($key) {
	$this->write(sprintf("<P t=\"N\" v=\"%x\">",$key));
  }
  function writePairBegin() {
	$this->write("<P>");
  }
  function writePairEnd() {
	$this->write("</P>");
  }
  function writeUnref($object) {
	$this->client->sendBuffer.=$this->client->preparedToSendBuffer;
	$this->client->preparedToSendBuffer=null;
	$this->write(sprintf("<U v=\"%x\"/>", $object));
  }
  function getServerName() {
	return $this->serverName;
  }
}
  



class java_ParserString {
  public $string, $off, $length;
  function toString() {
	return $this->getString();
  }
  function getString() {
	return substr($this->string, $this->off, $this->length);
  }
}


class java_ParserTag {
  public $n, $strings;
  function java_ParserTag() {
	$this->strings = array();
	$this->n = 0;
  }
}


class java_SimpleParser {
  public $SLEN=256; 
  public $handler;
  public $tag, $buf, $len, $s;
  public $type;
  function java_SimpleParser($handler) {
	$this->handler = $handler;
	$this->tag = array(new java_ParserTag(), new java_ParserTag(), new java_ParserTag());
	$this->len = $this->SLEN;
	$this->s = str_repeat(" ", $this->SLEN);
	$this->type = $this->VOJD;
  }
  public $BEGIN=0, $KEY=1, $VAL=2, $ENTITY=3, $VOJD=5, $END=6; 
  public $level=0, $eor=0; public $in_dquote, $eot=false;
  public $pos=0, $c=0, $i=0, $i0=0, $e;
  function RESET() {
	$this->type=$this->VOJD;
	$this->level=0;
	$this->eor=0;
	$this->in_dquote=false;
	$this->i=0;
	$this->i0=0;
  }
  function APPEND($c) {
	if($this->i>=$this->len-1) {
	  $this->s=str_repeat($this->s,2);
	  $this->len*=2;
	} 
	$this->s[$this->i++]=$c; 
  }
  function CALL_BEGIN() {
	$pt=&$this->tag[1]->strings;
	$st=&$this->tag[2]->strings;
	$t=&$this->tag[0]->strings[0];
	$name=$t->string[$t->off];
	$n = $this->tag[2]->n;
	$ar = array();
	for($i=0; $i<$n; $i++) {
	  $ar[$pt[$i]->getString()] = $st[$i]->getString();
	}
	$this->handler->begin($name, $ar);
  }
  function CALL_END() {
	$t=&$this->tag[0]->strings[0];
	$name=$t->string[$t->off];
	$this->handler->end($name);
  }
  function PUSH($t) { 
	$str = &$this->tag[$t]->strings;
	$n = &$this->tag[$t]->n;
	$this->s[$this->i]='|';
	if(!isset($str[$n])){$h=$this->handler; $str[$n]=$h->createParserString();}
	$str[$n]->string=&$this->s;
	$str[$n]->off=$this->i0;
	$str[$n]->length=$this->i-$this->i0;
	++$this->tag[$t]->n;
	$this->APPEND('|');
	$this->i0=$this->i;
  }
  function parse() {
	while($this->eor==0) {
	  if($this->c>=$this->pos) { 
		$this->buf=$this->handler->read(JAVA_RECV_SIZE); 
		if(is_null($this->buf) || strlen($this->buf) == 0) die("protocol error. Check the back end log for details.");
		$this->pos=strlen($this->buf);
		if($this->pos==0) break;
		$this->c=0; 
	  }
	  switch(($ch=$this->buf[$this->c])) 
		{

		case '<': if($this->in_dquote) {$this->APPEND($ch); break;}
		  $this->level+=1;
		  $this->type=$this->BEGIN;
		  break;
		case '\t': case '\f': case '\n': case '\r': case ' ': if($this->in_dquote) {$this->APPEND($ch); break;}
		  if($this->type==$this->BEGIN) {
			$this->PUSH($this->type); 
			$this->type = $this->KEY; 
		  }
		  break;
		case '=': if($this->in_dquote) {$this->APPEND($ch); break;}
		  $this->PUSH($this->type);
		  $this->type=$this->VAL;
		  break;
		case '/': if($this->in_dquote) {$this->APPEND($ch); break;}
		  if($this->type==$this->BEGIN) { $this->type=$this->END; $this->level-=1; }
		  $this->level-=1;
		  $this->eot=true; 
		  break;
		case '>': if($this->in_dquote) {$this->APPEND($ch); break;}
		  if($this->type==$this->END){
			$this->PUSH($this->BEGIN);
			$this->CALL_END();
		  } else {
			if($this->type==$this->VAL) $this->PUSH($this->type);
			$this->CALL_BEGIN();
		  }
		  $this->tag[0]->n=$this->tag[1]->n=$this->tag[2]->n=0; $this->i0=$this->i=0;	  		

		  $this->type=$this->VOJD;
		  if($this->level==0) $this->eor=1; 
		  break;
		case ';':
		  if($this->type==$this->ENTITY) {
			switch ($this->s[$this->e+1]) {
			case 'l': $this->s[$this->e]='<'; $this->i=$this->e+1; break; 

			case 'g': $this->s[$this->e]='>'; $this->i=$this->e+1; break; 

			case 'a': $this->s[$this->e]=($this->s[$this->e+2]=='m'?'&':'\''); $this->i=$this->e+1; break; 

			case 'q': $this->s[$this->e]='"'; $this->i=$this->e+1; break; 

			default: $this->APPEND($ch);
			}
			$this->type=$this->VAL; 
		  } else {
			$this->APPEND($ch);
		  }
		  break;
		case '&': 
		  $this->type = $this->ENTITY;
		  $this->e=$this->i;
		  $this->APPEND($ch);
		  break;
		case '"':
		  $this->in_dquote = !$this->in_dquote;
		  if(!$this->in_dquote && $this->type==$this->VAL) {
			$this->PUSH($this->type);
			$this->type = $this->KEY;
		  }
		  break;
		default:
		  $this->APPEND($ch);
		} 

	  $this->c+=1;
	}
   	$this->RESET();
  }
  function getData($str) {
	return $str;
  }
  function parserError() {
	die(sprintf("protocol error: %s. Check the back end log for details.", $this->s));
  }
}
  



interface java_JavaType {};


function __javaproxy_Client_getClient() {
  static $client;
  if(isset($client)) return $client;
  if (function_exists("java_create_client")) $client = java_create_client();
  else $client=new java_Client();
  return $client;
}


function java_last_exception_get() {
  $client=__javaproxy_Client_getClient();
  return $client->getProperty(0, "lastException");
}


function java_last_exception_clear() {
  $client=__javaproxy_Client_getClient();
  $client->setProperty(0, "lastException", null);
}


function java_values_internal($object) {
  if(!$object instanceof java_JavaType) return $object;
  $client=__javaproxy_Client_getClient();
  return $client->invokeMethod(0, "getValues", array($object));
}


function java_values($object) {
  return java_values_internal($object);
}


function java_reset() {
  $client=__javaproxy_Client_getClient();
  user_error("Your script has called the privileged procedure \"java_reset()\" which resets the java back-end to its initial state. Therefore all java caches are gone.");
  return $client->invokeMethod(0, "reset", array());
}


function java_inspect_internal($object) {
  if(!$object instanceof java_JavaType) throw new java_IllegalArgumentException($object);
  $client=__javaproxy_Client_getClient();
  return $client->invokeMethod(0, "inspect", array($object));
}


function java_inspect($object) {
  return java_inspect_internal($object);
}


function java_set_file_encoding($enc) {
  $client=__javaproxy_Client_getClient();
  return $client->invokeMethod(0, "setFileEncoding", array($enc));
}


function java_instanceof_internal($ob, $clazz) {
  if(!$ob instanceof java_JavaType) throw new java_IllegalArgumentException($ob);
  if(!$clazz instanceof java_JavaType) throw new java_IllegalArgumentException($clazz);
  $client=__javaproxy_Client_getClient();
  return $client->invokeMethod(0, "instanceOf", array($ob, $clazz));
}


function java_instanceof($ob, $clazz) {
  return java_instanceof_internal($ob, $clazz);
}


function java_cast_internal($object, $type) { 
	if(!$object instanceof java_JavaType) {
	  switch($type[0]) {
	case 'S': case 's':
	  return (string)$object;
	case 'B': case 'b':
	  return (boolean)$object;
	case 'L': case 'I': case 'l': case 'i':
	  return (integer)$object;
	case 'D': case 'd': case 'F': case 'f':
	  return (float) $object;
	case 'N': case 'n':
	  return null;
	case 'A': case 'a':
	  return (array)$object;
	case 'O': case 'o':
	  return (object)$object;
	  }
	}	
	return $object->__cast($type); 
}


function java_cast($object, $type) { 
  return java_cast_internal($object, $type);
}


function java_require($arg) {
  $client=__javaproxy_Client_getClient();
  return $client->invokeMethod(0, "updateJarLibraryPath", 
							   array($arg, ini_get("extension_dir"), getcwd(), ini_get("include_path")));
}


function java_get_lifetime ()
{
  $session_max_lifetime=ini_get("session.gc_maxlifetime");
  return $session_max_lifetime ? (int)$session_max_lifetime : 1440;
}


function java_session_array($args) {
  $client=__javaproxy_Client_getClient();
  if(!isset($args[0])) $args[0]=null;
  if(!isset($args[1])) $args[1]=false;
  if(!isset($args[2])) {
	$args[2] = java_get_lifetime ();
  }
  return $client->getSession($args);
}


function java_session() {
  return java_session_array(func_get_args());
}


function java_server_name() {
  try {
	$client=__javaproxy_Client_getClient();
	return $client->getServerName();
  } catch (java_ConnectException $ex) {
	return null;
  }
}


function java_context() {
  $client=__javaproxy_Client_getClient();
  return $client->getContext();
}


function java_closure_array($args) {
  if(isset($args[2]) && ((!($args[2] instanceof java_JavaType))&&!is_array($args[2])))
	throw new java_IllegalArgumentException($args[2]);
  $client=__javaproxy_Client_getClient();
  $args[0] = isset($args[0]) ? $client->globalRef->add($args[0]) : 0;
  

  $client->protocol->invokeBegin(0, "makeClosure", "5", "6");
  $n = count($args);
  $client->protocol->writeULong($args[0]); // proper PHP "long" -> Java 64 bit value conversion
  for($i=1; $i<$n; $i++) {
	$client->writeArg($args[$i]);
  }
  $client->protocol->invokeEnd();
  $val = $client->getResult();
  return $val;
}


function java_closure() {
  return java_closure_array(func_get_args());
}


function java_begin_document() {
  $client = __javaproxy_Client_getClient();
  if (!$client->isAsync) {
	$client->invokeMethod(0, "beginDocument", array());
	$client->setAsyncHandler();
  }
  $client->isAsync+=1;
}


function java_end_document() {
  $client = __javaproxy_Client_getClient();
  if ($client->isAsync==1) {
	$client->setDefaultHandler();
	$client->invokeMethod(0, "endDocument", array());
  }
  if ($client->isAsync > 0) $client->isAsync-=1;
}


class java_JavaProxy implements java_JavaType {
  public $__serialID, $__java;
  public $__signature;
  public $__client;
  public $__tempGlobalRef;
  function java_JavaProxy($java, $signature){ 
	$this->__java=$java;
	$this->__signature=$signature;
	$this->__client = __javaproxy_Client_getClient();
  }
  function __cast($type) {
	return $this->__client->cast($this, $type);
  }
  function __sleep() {
	$args = array($this, java_get_lifetime());
	$this->__serialID = $this->__client->invokeMethod(0, "serialize", $args);
	$this->__tempGlobalRef = $this->__client->globalRef;
	if(JAVA_DEBUG) echo "proxy sleep called for $this->__java, $this->__signature\n";
	return array("__serialID", "__tempGlobalRef");
  }
  function __wakeup() {
	$args = array($this->__serialID, java_get_lifetime());
	if(JAVA_DEBUG) echo "proxy wakeup called for $this->__java, $this->__signature\n";
	$this->__client = __javaproxy_Client_getClient();
	if($this->__tempGlobalRef)
		$this->__client->globalRef = $this->__tempGlobalRef;
	$this->__tempGlobalRef = null;
	$this->__java = $this->__client->invokeMethod(0, "deserialize", $args);
  }
  function __destruct() { 
	if(isset($this->__client)) 
	  $this->__client->unref($this->__java);
  }
  function __get($key) { 
	return $this->__client->getProperty($this->__java, $key);
  }
  function __set($key, $val) {
	$this->__client->setProperty($this->__java, $key, $val);
  }
  function __call($method, $args) { 
	return $this->__client->invokeMethod($this->__java, $method, $args);
  }
  function __toString() {
	try {
	  return $this->__client->invokeMethod(0,"ObjectToString",array($this));
	} catch (JavaException $ex) {
	  trigger_error("Exception in Java::__toString(): ". (string)$ex, E_USER_WARNING);
	  return "";
	}
  }
}


class java_objectIterator implements Iterator {
  private $var;
  function java_ObjectIterator($javaProxy) {
	$this->var = java_cast ($javaProxy, "A");
  }
  function rewind() {
	reset($this->var);
  }
  function valid() {
	return $this->current() !== false;
  }
  function next() {
	return next($this->var);
  }
  function key() {
	return key($this->var);
  }
  function current() {
	return current($this->var);
  }
}


class java_IteratorProxy extends java_JavaProxy implements IteratorAggregate {
  function java_IteratorProxy($java, $signature) {
	parent::java_JavaProxy($java, $signature);
  }
  function getIterator() {
	return new java_ObjectIterator($this);
  }
}


class java_ArrayProxy extends java_IteratorProxy implements ArrayAccess {
  function java_ArrayProxy($java, $signature) {
	parent::java_JavaProxy($java, $signature);
  }
  function offsetExists($idx) {
	$ar = array($this, $idx);
	return $this->__client->invokeMethod(0,"offsetExists", $ar);
  }  
  function offsetGet($idx) {
	$ar = array($this, $idx);
	return $this->__client->invokeMethod(0,"offsetGet", $ar);
  }
  function offsetSet($idx, $val) {
	$ar = array($this, $idx, $val);
	return $this->__client->invokeMethod(0,"offsetSet", $ar);
  }
  function offsetUnset($idx) {
	$ar = array($this, $idx);
	return $this->__client->invokeMethod(0,"offsetUnset", $ar);
  }
}


class java_ExceptionProxy extends java_JavaProxy {
  function java_ExceptionProxy($java, $signature){ 
	parent::java_JavaProxy($java, $signature);
  }
  function __toExceptionString($trace) {
	$args = array($this, $trace);
	return $this->__client->invokeMethod(0,"ObjectToString",$args);
  }
}


abstract class java_AbstractJava implements IteratorAggregate,ArrayAccess,java_JavaType {
  public $__client;
  public $__delegate;
  public $__serialID;
  public $__factory;
  public $__java, $__signature;
  public $__cancelProxyCreationTag;
  function __createDelegate() {
	$proxy = $this->__delegate = 
	  $this->__factory->create($this->__java, $this->__signature);
	$this->__java = $proxy->__java;
	$this->__signature = $proxy->__signature;
  }
  function __cast($type) {
	if(!isset($this->__delegate)) $this->__createDelegate();
	return $this->__delegate->__cast($type);
  }
  function __sleep() {
	if(!isset($this->__delegate)) $this->__createDelegate();
	$this->__delegate->__sleep();
	return array("__delegate");
  }
  function __wakeup() {
	if(!isset($this->__delegate)) $this->__createDelegate();
	$this->__delegate->__wakeup();
	$this->__java = $this->__delegate->__java;
	$this->__client = $this->__delegate->__client;
  }
  function __get($key) { 
 	if(!isset($this->__delegate)) $this->__createDelegate();
	return $this->__delegate->__get($key);
  }
  function __set($key, $val) {
 	if(!isset($this->__delegate)) $this->__createDelegate();
	$this->__delegate->__set($key, $val);
  }
  function __call($method, $args) { 
	if(!isset($this->__delegate)) $this->__createDelegate();
	return $this->__delegate->__call($method, $args);
  }
  function __toString() {
	if(!isset($this->__delegate)) $this->__createDelegate();
	return $this->__delegate->__toString();
  }
  function getIterator() {
	if(!isset($this->__delegate)) $this->__createDelegate();
	if(func_num_args()==0) return $this->__delegate->getIterator();
	$args = func_get_args(); return $this->__call("getIterator", $args);
  }
  function offsetExists($idx) {
	if(!isset($this->__delegate)) $this->__createDelegate();
	if(func_num_args()==1) return $this->__delegate->offsetExists($idx);
	$args = func_get_args(); return $this->__call("offsetExists", $args);
  }
  function offsetGet($idx) {
	if(!isset($this->__delegate)) $this->__createDelegate();
	if(func_num_args()==1) return $this->__delegate->offsetGet($idx);
	$args = func_get_args(); return $this->__call("offsetGet", $args);
  }
  function offsetSet($idx, $val) {
	if(!isset($this->__delegate)) $this->__createDelegate();
	if(func_num_args()==2) return $this->__delegate->offsetSet($idx, $val);
	$args = func_get_args(); return $this->__call("offsetSet", $args);
  }
  function offsetUnset($idx) {
	if(!isset($this->__delegate)) $this->__createDelegate();
	if(func_num_args()==1) return $this->__delegate->offsetUnset($idx);
	$args = func_get_args(); return $this->__call("offsetUnset", $args);
  }
}


class Java extends java_AbstractJava {
  

  function Java() {
	$client = $this->__client = __javaproxy_Client_getClient();
	$args = func_get_args();
	$name = array_shift($args);
	if(is_array($name)) {$args = $name; $name = array_shift($args);}
	$sig="&{$this->__signature}@{$name}";
	$len = count($args);
	$args2 = array();
	for($i=0; $i<$len; $i++) {
	  switch(gettype($val = $args[$i])) {
	  case 'boolean': array_push($args2, $val); $sig.='@b'; break; 
	  case 'integer': array_push($args2, $val); $sig.='@i'; break; 
	  case 'double': array_push($args2, $val); $sig.='@d'; break; 
	  case 'string': array_push($args2, htmlspecialchars($val, ENT_COMPAT)); $sig.='@s'; break; 
	  case 'array':$sig="~INVALID"; break; 
	  case 'object':
		if($val instanceof java_JavaType) {
		  array_push($args2, $val->__java);
		  $sig.="@o{$val->__signature}"; 
		}
		else {
		  $sig="~INVALID";
		}
		break;
	  case 'resource': array_push($args2, $val); $sig.='@r'; break; 
	  case 'NULL': array_push($args2, $val); $sig.='@N'; break; 
	  case 'unknown type': array_push($args2, $val); $sig.='@u'; break;
	  default: throw new java_IllegalArgumentException($val);
	  }
	}
	if(array_key_exists($sig, $client->methodCache)) {
	  if(JAVA_DEBUG) { echo "cache hit for new Java: $sig\n"; }
	  $cacheEntry = &$client->methodCache[$sig];
	  $client->sendBuffer.= $client->preparedToSendBuffer;
	  if(strlen($client->sendBuffer)>=JAVA_SEND_SIZE) {
		  if($client->protocol->handler->write($client->sendBuffer)<=0) 
			 throw new java_IllegalStateException("Connection out of sync, check backend log for details.");
		  $client->sendBuffer=null;
	  }
	  $client->preparedToSendBuffer=vsprintf($cacheEntry->fmt, $args2);
	  if(JAVA_DEBUG) {
		print_r($args2);
		echo "set prepared to send buffer: $client->preparedToSendBuffer, $cacheEntry->fmt, for key: $sig\n";
	  }
	  $this->__java = ++$client->asyncCtx;
	  if(JAVA_DEBUG) {echo "setresult from new Java cache: object:"; echo sprintf("%x", $client->asyncCtx); echo "\n";}
	  $this->__factory = $cacheEntry->factory;
  	  $this->__signature = $cacheEntry->signature;
	  $this->__cancelProxyCreationTag = ++$client->cancelProxyCreationTag;
	} else {
	  if(JAVA_DEBUG) { echo "cache miss for new Java: $sig\n"; }
		  $client->currentCacheKey = $sig;
	  $delegate = $this->__delegate = $client->createObject($name, $args);
	  $this->__java = $delegate->__java;
	  $this->__signature = $delegate->__signature;
	}
  }
  

  function __destruct() {
	if(!isset($this->__client)) return;
	$client = $this->__client;
	$preparedToSendBuffer = &$client->preparedToSendBuffer;
	if($preparedToSendBuffer &&
	   $client->cancelProxyCreationTag==$this->__cancelProxyCreationTag) {
	  $preparedToSendBuffer[6]="3";
	  if(JAVA_DEBUG) {
		echo "cancel result proxy creation:"; echo $this->__java; echo " {$client->preparedToSendBuffer}"; echo "\n";
	  }
	  $client->sendBuffer.=$preparedToSendBuffer;
	  $preparedToSendBuffer = null;
	  $client->asyncCtx -= 1;
	} else {
	  if(!$this->__delegate) { 
		if(JAVA_DEBUG) {
		  echo "unref java:"; echo $this->__java; echo "\n";
		}
		$client->unref($this->__java);
	  }
	}	
  }
  

  function __call($method, $args) { 
	$client = $this->__client;
	$sig="@{$this->__signature}@$method";
	$len = count($args);
	$args2=array($this->__java);
	for($i=0; $i<$len; $i++) {
	  switch(gettype($val = $args[$i])) {
	  case 'boolean': array_push($args2, $val); $sig.='@b'; break; 
	  case 'integer': array_push($args2, $val); $sig.='@i'; break; 
	  case 'double': array_push($args2, $val); $sig.='@d'; break; 
	  case 'string': array_push($args2, htmlspecialchars($val, ENT_COMPAT)); $sig.='@s'; break; 
	  case 'array':$sig="~INVALID"; break; 
	  case 'object':
		if($val instanceof java_JavaType) {
		  array_push($args2, $val->__java);
		  $sig.="@o{$val->__signature}"; 
		}
		else {
		  $sig="~INVALID";
		}
		break;
	  case 'resource': array_push($args2, $val); $sig.='@r'; break; 
	  case 'NULL': array_push($args2, $val); $sig.='@N'; break; 
	  case 'unknown type': array_push($args2, $val); $sig.='@u'; break; 
	  default: throw new java_IllegalArgumentException($val);
	  }
	}
	if(array_key_exists($sig, $client->methodCache)) {
	  if(JAVA_DEBUG) { echo "cache hit for __call: $sig\n"; }
	  $cacheEntry = &$client->methodCache[$sig];
	  $client->sendBuffer.=$client->preparedToSendBuffer;
	  if(strlen($client->sendBuffer)>=JAVA_SEND_SIZE) {
		  if($client->protocol->handler->write($client->sendBuffer)<=0) 
			 throw new java_IllegalStateException("Out of sync. Check backend log for details.");
		  $client->sendBuffer=null;
	  }
	  $client->preparedToSendBuffer=vsprintf($cacheEntry->fmt, $args2);
	  if(JAVA_DEBUG) {
		print_r($args2);
		echo "set prepared to send buffer: {$client->preparedToSendBuffer}, {$cacheEntry->fmt}\n";
	  }
	  if($cacheEntry->resultVoid) {
		$client->cancelProxyCreationTag += 1; 
		return null;
	  } else {
		$result = clone($client->cachedJavaPrototype);
		$result->__factory = $cacheEntry->factory;
		$result->__java = ++$client->asyncCtx;
		if(JAVA_DEBUG) {echo "setresult from __call cache: object:"; echo sprintf("%x", $client->asyncCtx); echo "\n";}
		$result->__signature = $cacheEntry->signature;
		$result->__cancelProxyCreationTag = ++$client->cancelProxyCreationTag;
		return $result;
	  }
	} else {
	  if(JAVA_DEBUG) { echo "cache miss for __call: $sig\n"; }
	  $client->currentCacheKey = $sig;
	  $retval = parent::__call($method, $args);
	  return $retval;
	}
  }
}


class java_InternalJava extends Java {
  function java_InternalJava($proxy) {
	$this->__delegate = $proxy;
	$this->__java = $proxy->__java;
	$this->__signature = $proxy->__signature;
	$this->__client = $proxy->__client;
  }
}


class java_class extends Java {
  function java_class() {
	$this->__client = __javaproxy_Client_getClient();
	$args = func_get_args();
	$name = array_shift($args);
	if(is_array($name)) { $args = $name; $name = array_shift($args); }
	$delegate = $this->__delegate = $this->__client->referenceObject($name, $args);
	$this->__java = $delegate->__java;
	$this->__signature = $delegate->__signature;
  }
}


class JavaClass extends java_class{}


class java_exception extends Exception implements java_JavaType {
  

  public $__serialID, $__java, $__client;
  

  public $__delegate;
  

  public $__signature;
  

  function java_exception() {
	$this->__client = __javaproxy_Client_getClient();
	$args = func_get_args();
	$name = array_shift($args);
	if(is_array($name)) { $args = $name; $name = array_shift($args); }
	if (count($args) >= 1) Exception::__construct($args[0]);
	$delegate = $this->__delegate = $this->__client->createObject($name, $args);
	$this->__java = $delegate->__java;
	$this->__signature = $delegate->__signature;
  }
  

  function __cast($type) {
	return $this->__delegate->__cast($type);
  }
  

  function __sleep() {
	$this->__delegate->__sleep();
	return array("__delegate");
  }
  

  function __wakeup() {
	$this->__delegate->__wakeup();
	$this->__java = $this->__delegate->__java;
	$this->__client = $this->__delegate->__client;
  }
  

  function __get($key) { 
	return $this->__delegate->__get($key);
  }
  

  function __set($key, $val) {
	$this->__delegate->__set($key, $val);
  }
  

  function __call($method, $args) { 
	return $this->__delegate->__call($method, $args);
  }
  

  function __toString() {
	return $this->__delegate->__toExceptionString($this->getTraceAsString());
  }
}


class JavaException extends java_exception {}


class java_InternalException extends JavaException {
  function java_InternalException($proxy, $exception) {
	Exception::__construct($exception);
	$this->__delegate = $proxy;
	$this->__java = $proxy->__java;
	$this->__signature = $proxy->__signature;
	$this->__client = $proxy->__client;
  }
}


class java_JavaProxyProxy extends Java {
  function java_JavaProxyProxy($client) {
	$this->__client = $client;
  }
}
}
?>
