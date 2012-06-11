<?php
    // PHP version of merchant_result.jsp
    //这是B2CAPI的php调用测试
    //作    者：刘明
    //创建时间：2008-12-03
?>

<html>
    <head>
        <title>交通银行商户测试结果页面</title>

        <meta http-equiv = "Content-Type" content = "text/html; charset=GBK">
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

            print "商户结果页面";
            print "<br>";
            print "--------------------------";
            print "<br>";

            $notifyMsg=$_REQUEST["notifyMsg"];
            $URLDecoder = java("java.net.URLDecoder");
            $notifyMsg = java_values($URLDecoder->decode($notifyMsg,"GBK"));
            
            $lastIndex=strripos($notifyMsg, "|");
            $signMsg=substr($notifyMsg, $lastIndex + 1);   //签名信息
            $srcMsg=substr($notifyMsg, 0, $lastIndex + 1); //原文

            $signMsg=new java("java.lang.String", $signMsg);
            $srcMsg=new java("java.lang.String", $srcMsg);
            $veriyCode=-1;

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

            $nss=new java("com.bocom.netpay.b2cAPI.NetSignServer");
            $nss->NSDetachedVerify($signMsg->getBytes("GBK"), $srcMsg->getBytes("GBK")); //验签

            $veriyCode=java_values($nss->getLastErrnum());

            if ($veriyCode < 0) { print "商户端验证签名失败：return code:" . $veriyCode;
            //exit(1);
                }

            $arr=preg_split("/\|{1,}/", $srcMsg);
        ?>

        <table width = "75%" border = "0" cellspacing = "0" cellpadding = "0">
            <tr>
                <td width = "14%">
                    商户客户号
                </td>

                <td width = "86%">

                    <?php
                        print $arr[0];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    订单编号
                </td>

                <td width = "86%">

                    <?php
                        print $arr[1];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    交易金额
                </td>

                <td width = "86%">

                    <?php
                        print $arr[2];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    交易币种
                </td>

                <td width = "86%">

                    <?php
                        print $arr[3];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    平台批次号
                </td>

                <td width = "86%">

                    <?php
                        print $arr[4];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    商户批次号
                </td>

                <td width = "86%">

                    <?php
                        print $arr[5];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    交易日期
                </td>

                <td width = "86%">

                    <?php
                        print $arr[6];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    交易时间
                </td>

                <td width = "86%">

                    <?php
                        print $arr[7];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    交易流水号
                </td>

                <td width = "86%">

                    <?php
                        print $arr[8];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    交易结果
                </td>

                <td width = "86%">
                    <?php
                        print $arr[9];
                    ?>

                    &nbsp;[1:成功]
                </td>
            </tr>

            <tr>
                <td width = "14%">
                    手续费总额
                </td>

                <td width = "86%">

                    <?php
                        print $arr[10];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    银行卡类型
                </td>

                <td width = "86%">
                    <?php
                        print $arr[11];
                    ?>

                    &nbsp;[0:借记卡 1：准贷记卡 2:贷记卡]
                </td>
            </tr>

            <tr>
                <td width = "14%">
                    银行备注
                </td>

                <td width = "86%">

                    <?php
                        print $arr[12];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    错误信息描述
                </td>

                <td width = "86%">

                    <?php
                        print $arr[13];
                    ?>

                </td>
            </tr>
            <tr>
                <td width = "14%">
                    IP
                </td>

                <td width = "86%">

                    <?php
                        print $arr[14];
                    ?>

                </td>
            </tr>
            <tr>
                <td width = "14%">
                    Referer
                </td>

                <td width = "86%">

                    <?php
                        print $arr[15];
                    ?>

                </td>
            </tr>
        </table>

        <p>
            &nbsp;
        </p>
    </body>
</html>
