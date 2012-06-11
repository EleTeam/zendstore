<?php
    // PHP version of Batchorderquery.jsp
    //这是B2CAPI的php调用测试
    //作    者：刘明
    //创建时间：2008-12-03
?>

<html>
    <head>
        <title>批量订单查询测试</title>

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

            $orders=$_REQUEST["orders"];
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
                exit(1);
                }

            $rep=$client->queryOrder($orders); //批量订单查询

            if (java_is_null($rep))
                {
                $err=$client->getLastErr();
                //为正确显示中文对返回java变量进行转换，如果用java_set_file_encoding进行过转换则不用再次转换
                //$err = java_values($err->getBytes("GBK")); 
                print "交易错误信息：" . $err . "<br>";
                exit(1);
                }

            $code=java_values($rep->getRetCode()); //得到交易返回码
            $msg=java_values($rep->getErrorMessage());

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

                    $orderTime=$oprSet->getResultValueByName($index, "orderTime");             //订单时间

                    $curType=$oprSet->getResultValueByName($index, "curType");                 //币种

                    $amount=$oprSet->getResultValueByName($index, "amount");                   //金额

                    $tranDate=$oprSet->getResultValueByName($index, "tranDate");               //交易日期

                    $tranTime=$oprSet->getResultValueByName($index, "tranTime");               //交易时间

                    $tranState=$oprSet->getResultValueByName($index, "tranState");             //支付交易状态

                    $orderState=$oprSet->getResultValueByName($index, "orderState");           //订单状态

                    $fee=$oprSet->getResultValueByName($index, "fee");                         //手续费

                    $bankSerialNo=$oprSet->getResultValueByName($index, "bankSerialNo");       //银行流水号

                    $bankBatNo=$oprSet->getResultValueByName($index, "bankBatNo");             //银行批次号

                    $cardType=$oprSet->getResultValueByName($index, "cardType");               //交易卡类型0:借记卡 1：准贷记卡 2:贷记卡

                    $merchantBatNo=$oprSet->getResultValueByName($index, "merchantBatNo");     //商户批次号

                    $merchantComment=$oprSet->getResultValueByName($index, "merchantComment"); //商户备注
                    $merchantComment=java_values($merchantComment->getBytes("GBK"));           //中文编码转换

                    $bankComment=$oprSet->getResultValueByName($index, "bankComment");         //银行备注
                    $bankComment=java_values($bankComment->getBytes("GBK"));                   //中文编码转换

                    print("订单号：" . $order);

                    print("<br>");

                    print("订单日期：" . $orderDate);

                    print("<br>");

                    print("订单时间：" . $orderTime);

                    print("<br>");

                    print("币种：" . $curType);

                    print("<br>");

                    print("金额：" . $amount);

                    print("<br>");

                    print("交易日期：" . $tranDate);

                    print("<br>");

                    print("交易时间：" . $tranTime);

                    print("<br>");

                    print("支付交易状态[1:成功]：" . $tranState);

                    print("<br>");

                    print("定单状态[0 所有 1 已支付 2 已撤销 3 部分退货 4退货处理中 5 全部退货]：" . $orderState);

                    print("<br>");

                    print("手续费：" . $fee);

                    print("<br>");

                    print("银行流水号：" . $bankSerialNo);

                    print("<br>");

                    print("银行批次号：" . $bankBatNo);

                    print("<br>");

                    print("交易卡类型[0:借记卡 1：准贷记卡 2:贷记卡]：" . $cardType);

                    print("<br>");

                    print("商户批次号：" . $merchantBatNo);

                    print("<br>");

                    print("商户备注：" . $merchantComment);

                    print("<br>");

                    print("银行备注：" . $bankComment);

                    print("<p></p>");
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
