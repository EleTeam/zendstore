



<HTML>
<HEAD>
<TITLE>ccbnb verify signature Samples </TITLE>
</HEAD>
<BODY>
<%
	dim strSrc
	dim strSign
	dim strPubKey
	dim obj
	dim strRet

	strSrc=request("src")
	strSign=request("sign")
	strPubKey=request("pubkey")
	
	set obj=server.createobject("CCBRSA.RSASig")
	obj.setpublickey(strPubkey)
	strRet=obj.StringVerifySigature(strSign,strSrc)

	response.write "<p>src="
	response.write strSrc
	response.write "</p>"

	response.write "<p>sign="
	response.write strSign
	response.write "</p>"	
	
	response.write "<p>pubkey="
	response.write strPubKey
	response.write "</p>"
	
	response.write "<p>verify result="
	response.write strRet
	response.write "</p>"
	
	set obj=nothing
	
%>

</BODY>
</HTML>
