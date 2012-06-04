<HTML>
<HEAD>
<TITLE>ccbnb verify signature Samples </TITLE>
</HEAD>
<BODY>
<?

	$strSrc=$_POST['src'];
	$strSign=$_POST['sign'];
	$strPubKey=$_POST['pubkey'];
	
	$rsasig=new COM("CCBRSA.RSASig");
	$rsasig->setpublickey($strPubKey);
	$strRet=$rsasig->StringVerifySigature($strSign,$strSrc);

	//obj.setpublickey(strPubkey)
	//strRet=obj.StringVerifySigature(strSign,strSrc)

	echo "<p>src=";
	echo $strSrc;
	echo "</p>";

	echo "<p>sign=";
	echo $strSign;
	echo "</p>";	
	
	echo "<p>pubkey=";
	echo $strPubKey;
	echo "</p>";
	
	echo "<p>verify result=";
	echo $strRet;
	echo"</p>";
	

	
?>

</BODY>
</HTML>