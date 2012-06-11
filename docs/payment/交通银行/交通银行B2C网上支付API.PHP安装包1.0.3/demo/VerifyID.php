<?php
    // PHP version of VerifyID.jsp
    //这是B2CAPI的php调用测试
    //作    者：刘明
    //创建时间：2008-12-03
?>

<html>
    <head>
        <title>持卡人身份验证(VIP商户)</title>

        <meta http-equiv = "Content-Type" content = "text/html; charset=gb2312">
    </head>

    <body bgcolor = "#FFFFFF" text = "#000000">
        <?php

            //define("JAVA_DEBUG", true); //调试设置   	
            //define("JAVA_HOSTS", "127.0.0.1:8080"); //设置javabridge监听端口，如果开启javabridge.jar设置的端口不是8080，可通过此语句更改

            require_once("java/Java.inc"); //php调用java的接口，必须的

            $here=realpath(dirname($_SERVER["SCRIPT_FILENAME"]));

            if (!$here)
                $here=getcwd();

            java_set_library_path("$here/lib"); //设置java开发包路径
            java_set_file_encoding("GBK");      //设置java编码

            $card=$_REQUEST["card"];
            $custName=$_REQUEST["custName"];
            $certType=$_REQUEST["certType"];
            $certNo=$_REQUEST["certNo"];

            $client=new java("com.bocom.netpay.b2cAPI.BOCOMB2CClient");
            $ret=$client->initialize("C:/bocommjava/ini/B2CMerchant.xml"); //初始化配置文件
						$ret = java_values($ret);
            if ($ret != "0")
                {
                $err=$client->getLastErr();
                $err=java_values($err->getBytes("GBK")); //为正确显示中文对返回java变量进行转换
                print "初始化失败,错误信息：" . $err . "<br>";
                exit(1);
                }

            //发主机交易
            $rep=$client->verifyCustID($card, $custName, $certType, $certNo); //批量订单查询

            if (java_is_null($rep))
                {
                $err=$client->getLastErr();
                //$err = java_values($err->getBytes("GBK")); //为正确显示中文对返回java变量进行转换
                print "交易错误信息：" . $err . "<br>";
                exit(1);
                }

            $code=$rep->getRetCode(); //得到交易返回码
            $err=$rep->getLastErr();
            $msg=$rep->getErrorMessage();

            if (!java_is_null($msg)) {
            //为正确显示中文对返回java变量进行转换，如果用java_set_file_encoding进行过转换则不用再次转换
                $msg=java_values($msg->getBytes("GBK")); }

            print "交易返回码：" . $code . "<br>";
            print "交易错误信息：" . $msg . "<br>";
        ?>

        <p>
            <a href = "Index.htm">返回首页</a>
        </p>

        <p>
            &nbsp;
        </p>
    </body>
</html>
