
<%@ page language="java" import="java.util.*,CCBSign.*" pageEncoding="UTF-8"%>
<%
boolean bRet;
RSASig rsa=new RSASig();
String strRet;
String path = request.getContextPath();
String basePath = request.getScheme()+"://"+request.getServerName()+":"+request.getServerPort()+path+"/";
String strSrc=request.getParameter("src");
String strSign=request.getParameter("sign");
String strPubKey=request.getParameter("pubkey");
if( strSrc==null ){
	strSrc="";
}
if( strSign==null ){
	strSign="";
}
if( strPubKey==null ){
	strPubKey="";
}
rsa.setPublicKey(strPubKey);
bRet=rsa.verifySigature(strSign,strSrc);
if( bRet ){
	strRet="Y";
}
else{
	strRet="N";
}
%>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <base href="<%=basePath%>">
    
    <title>My JSP 'VerifySign.jsp' starting page</title>
    
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="cache-control" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta http-equiv="keywords" content="keyword1,keyword2,keyword3">
    <meta http-equiv="description" content="This is my page">
    
    <!--
    <link rel="stylesheet" type="text/css" href="styles.css">
    -->
  </head>
  
  <body>
  <p>SRC=<%=strSrc%></p>
  <p>Sign=<%=strSign%></p>
  <p>PubKey=<%=strPubKey%></p>
  <p>Result=<%=strRet%></p>
  </body>
</html>
