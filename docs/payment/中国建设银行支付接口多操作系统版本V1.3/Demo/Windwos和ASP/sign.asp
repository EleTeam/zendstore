

<%@ LANGUAGE = VBScript %>
<%  Option Explicit     %>

<HTML>
<HEAD>
<TITLE>ccbnb verify signature Samples </TITLE>
</HEAD>
<BODY>

建行商户签名测试<P>
(关键词:  IIS4.0 & asp ) <P>

<%

    Dim Obj

    ' Create the Java component
    Set Obj = Server.CreateObject("ccb.pub.RSAsig")

    ' Call the method and print the returned string
    Response.Write Obj.generateKeys()
    Response.Write " privateKey="
    Response.Write Obj.getPrivateKey()
    Response.Write " publicKey="
    Response.Write Obj.getPublicKey()
    Response.Write " 签名数据:POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&SUCCESS=Y"
    Response.Write " 签名结果="
    Response.Write Obj.generateSigature("POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&SUCCESS=Y")


%>

</BODY>
</HTML>
