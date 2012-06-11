<?php
    // PHP version of BallanceQuery.jsp
    //这是B2CAPI的php调用测试
    //作    者：刘明
    //创建时间：2008-12-03
?>

<html>
    <head>
        <title>预订单生成测试</title>

        <meta http-equiv = "Content-Type" content = "text/html; charset=gb2312">
    </head>

    <body bgcolor = "#FFFFFF" text = "#000000">
        <?php
        
           define("JAVA_DEBUG", true); //调试设置
            define("JAVA_RECV_SIZE", 8192);

            //define("JAVA_HOSTS", "127.0.0.1:8080"); //设置javabridge监听端口，如果开启javabridge.jar设置的端口不是8080，可通过此语句更改
            require_once("java/Java.inc"); //php调用java的接口，必须的
            $here=realpath(dirname($_SERVER["SCRIPT_FILENAME"]));

            if (!$here)
                $here=getcwd();

            java_set_library_path("$here/lib");                            //设置java开发包位置
            java_set_file_encoding("GBK");                                 //设置java编码

            $client=new java("com.bocom.netpay.b2cAPI.BOCOMB2CClient");
            $ret=$client->initialize("C:/bocommjava/ini/B2CMerchant.xml"); //初始化配置文件
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
            
            //获得表单传过来的数据
		        $interfaceVersion=$_REQUEST["interfaceVersion"];
		        $merID=java_values($BOCOMSetting->MerchantID); //商户号为固定
		        $orderid=$_REQUEST["orderid"];
		        $orderDate=$_REQUEST["orderDate"];
		        $orderTime=$_REQUEST["orderTime"];
		        $tranType=$_REQUEST["tranType"];
		        $amount=$_REQUEST["amount"];
		        $curType=$_REQUEST["curType"];
		        $orderContent=$_REQUEST["orderContent"];
		        $orderMono=$_REQUEST["orderMono"];
		        $phone = $_REQUEST["phone"];
		        $period = $_REQUEST["period"];
		        $phdFlag=$_REQUEST["phdFlag"];
		        $notifyType=$_REQUEST["notifyType"];
		        $merURL=$_REQUEST["merURL"];
		        $goodsURL=$_REQUEST["goodsURL"];
		        $jumpSeconds=$_REQUEST["jumpSeconds"];
		        $payBatchNo=$_REQUEST["payBatchNo"];
		        $proxyMerName=$_REQUEST["proxyMerName"];
		        $proxyMerType=$_REQUEST["proxyMerType"];
		        $proxyMerCredentials=$_REQUEST["proxyMerCredentials"];
		        $netType=$_REQUEST["netType"];
		        $source="";
            
       			$tran = new java("com.bocom.netpay.b2cAPI.PreOrder",$orderid,$orderDate,$orderTime,$amount,$curType,$orderContent,$orderMono,$phone,$period,$phdFlag,$notifyType,$merURL,$goodsURL,$jumpSeconds,$payBatchNo,$proxyMerName,$proxyMerType,$proxyMerCredentials,$netType);
        	
            $rep = $client->createPreOrder($tran); //结算帐户查询
						
						
            if (java_is_null($rep)) {
                $err=$client->getLastErr();
                //为正确显示中文对返回java变量进行转换，如果用java_set_file_encoding进行过转换则不用再次转换
                //$err = java_values($err->getBytes("GBK")); 
                $err=java_values($err);
                print "交易错误信息：" . $err . "<br>";
                exit(1);
            }

            $code=$rep->getRetCode();
            $msg=$rep->getErrorMessage();

            if (!java_is_null($msg)) {
            //为正确显示中文对返回java变量进行转换，如果用java_set_file_encoding进行过转换则不用再次转换
                $msg=java_values($msg->getBytes("GBK")); }

            print "交易返回码：" . $code . "<br>";
            print "交易错误信息：" . $msg . "<br>";

            if ($code == "0") //交易成功
                {
									 print "<br>------------------------------<br>";
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
