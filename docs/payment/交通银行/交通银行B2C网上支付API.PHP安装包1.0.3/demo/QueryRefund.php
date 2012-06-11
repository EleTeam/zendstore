<?php
    // PHP version of QueryRefund.jsp
    //这是B2CAPI的php调用测试
    //作    者：刘明
    //创建时间：2008-12-03
?>

<html>
    <head>
        <title>退款明细查询测试</title>

        <meta http-equiv = "Content-Type" content = "text/html; charset=gb2312">
    </head>

    <body bgcolor = "#FFFFFF" text = "#000000">
        <?php

            //define("JAVA_DEBUG", true); //调试设置    
            //define("JAVA_HOSTS", "127.0.0.1:8080"); //设置javabridge监听端口，如果开启javabridge.jar设置的端口不是8080，可通过此语句更改

            require_once ("java/Java.inc"); //php调用java的接口，必须的

            $here=realpath(dirname($_SERVER["SCRIPT_FILENAME"]));

            if (!$here)
                $here=getcwd();

            java_set_library_path ("$here/lib"); //设置java开发包路径
            java_set_file_encoding ("GBK");      //设置java编码

            $begDate=$_REQUEST["begDate"];
            $endDate=$_REQUEST["endDate"];
            $refundtype=(int)$_REQUEST["refundtype"];
            $order=$_REQUEST["order"];
            $flag=(int)$_REQUEST["flag"];
            $begIndex=(int)$_REQUEST["begIndex"];

            $client=new java("com.bocom.netpay.b2cAPI.BOCOMB2CClient");
            $ret=$client->initialize("C:/bocommjava/ini/B2CMerchant.xml");
						$ret = java_values($ret);
            if ($ret != "0")
                {
                $err=$client->getLastErr();
                //为正确显示中文对返回java变量进行转换，如果用java_set_file_encoding进行过转换则不用再次转换
                //$err = java_values($err->getBytes("GBK")); 
                $err=java_values($err);
                print "初始化失败,错误信息：" . $err . "<br>";
                exit (1);
                }

            $rep=$client->queryRefund($begDate, $endDate, $refundtype, $order, $flag, $begIndex); //退款明细查询

            if (java_is_null($rep))
                {
                $err=$client->getLastErr();
                //为正确显示中文对返回java变量进行转换，如果用java_set_file_encoding进行过转换则不用再次转换
                //$err = java_values($err->getBytes("GBK")); 
                print "交易错误信息：" . $err . "<br>";
                exit (1);
                }

            $code=$rep->getRetCode(); //得到交易返回码
            $err=$rep->getLastErr();
            $msg=$rep->getErrorMessage();

            if (!java_is_null($msg)) {
            //为正确显示中文对返回java变量进行转换，如果用java_set_file_encoding进行过转换则不用再次转换
                $msg=java_values($msg->getBytes("GBK")); }

            print "交易返回码：" . $code . "<br>";
            print "交易错误信息：" . $msg . "<br>";

            if ($code == "0") //交易成功
                {
                $oprSet=$rep->getOpResultSet();

                $iNum=java_cast($oprSet->getOpresultNum(), "integer"); //转换为整数类型

                print "总交易记录数：";

                print java_values($iNum);

                print "<br>------------------------<br>";

                for ($index=0; $index <= $iNum - 1; $index=$index + 1)
                    {
                    $order=$oprSet->getResultValueByName($index, "order");                     //订单号

                    $orderDate=$oprSet->getResultValueByName($index, "orderDate");             //订单日期		     

                    $curType=$oprSet->getResultValueByName($index, "curType");                 //币种

                    $amount=$oprSet->getResultValueByName($index, "amount");

                    $refundType=$oprSet->getResultValueByName($index, "refundType");           //金额	

                    $state=$oprSet->getResultValueByName($index, "tranState");                 //支付交易状态	

                    $fee=$oprSet->getResultValueByName($index, "fee");                         //手续费		                 

                    $merchantComment=$oprSet->getResultValueByName($index, "merchantComment"); //商户备注

                    $bankComment=$oprSet->getResultValueByName($index, "bankComment");         //银行备注

                    print ("订单号：" . $order);

                    print ("<br>");

                    print ("订单日期：" . $orderDate);

                    print ("<br>");

                    print ("币种：" . $curType);

                    print ("<br>");

                    print ("退款金额：" . $amount);

                    print ("<br>");

                    print ("退款类型：" . $refundType);

                    print ("<br>");

                    print ("退款交易状态：" . $state);

                    print ("<br>");

                    print ("手续费：" . $fee);

                    print ("<br>");

                    print ("商户备注：" . $merchantComment);

                    print ("<br>");

                    print ("银行备注：" . $bankComment);

                    print ("<p></p>");
                    }
                }
        ?>

        <p>
            <a href = "Index.htm">返回首页</a>
        </p>

        <p>
            &nbsp;
        </p>
    </body>
</html>
