

<%@ LANGUAGE = VBScript %>
<%  Option Explicit     %>

<HTML>
<HEAD>
<TITLE>ccbnb verify signature Samples </TITLE>
</HEAD>
<BODY>

�����̻�ǩ������<P>
(�ؼ���:  IIS4.0 & asp ) <P>

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
    Response.Write " ǩ������:POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&SUCCESS=Y"
    Response.Write " ǩ�����="
    Response.Write Obj.generateSigature("POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&SUCCESS=Y")


%>

</BODY>
</HTML>
