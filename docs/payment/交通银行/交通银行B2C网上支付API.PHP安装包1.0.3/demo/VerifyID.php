<?php
    // PHP version of VerifyID.jsp
    //����B2CAPI��php���ò���
    //��    �ߣ�����
    //����ʱ�䣺2008-12-03
?>

<html>
    <head>
        <title>�ֿ��������֤(VIP�̻�)</title>

        <meta http-equiv = "Content-Type" content = "text/html; charset=gb2312">
    </head>

    <body bgcolor = "#FFFFFF" text = "#000000">
        <?php

            //define("JAVA_DEBUG", true); //��������   	
            //define("JAVA_HOSTS", "127.0.0.1:8080"); //����javabridge�����˿ڣ��������javabridge.jar���õĶ˿ڲ���8080����ͨ����������

            require_once("java/Java.inc"); //php����java�Ľӿڣ������

            $here=realpath(dirname($_SERVER["SCRIPT_FILENAME"]));

            if (!$here)
                $here=getcwd();

            java_set_library_path("$here/lib"); //����java������·��
            java_set_file_encoding("GBK");      //����java����

            $card=$_REQUEST["card"];
            $custName=$_REQUEST["custName"];
            $certType=$_REQUEST["certType"];
            $certNo=$_REQUEST["certNo"];

            $client=new java("com.bocom.netpay.b2cAPI.BOCOMB2CClient");
            $ret=$client->initialize("C:/bocommjava/ini/B2CMerchant.xml"); //��ʼ�������ļ�
						$ret = java_values($ret);
            if ($ret != "0")
                {
                $err=$client->getLastErr();
                $err=java_values($err->getBytes("GBK")); //Ϊ��ȷ��ʾ���ĶԷ���java��������ת��
                print "��ʼ��ʧ��,������Ϣ��" . $err . "<br>";
                exit(1);
                }

            //����������
            $rep=$client->verifyCustID($card, $custName, $certType, $certNo); //����������ѯ

            if (java_is_null($rep))
                {
                $err=$client->getLastErr();
                //$err = java_values($err->getBytes("GBK")); //Ϊ��ȷ��ʾ���ĶԷ���java��������ת��
                print "���״�����Ϣ��" . $err . "<br>";
                exit(1);
                }

            $code=$rep->getRetCode(); //�õ����׷�����
            $err=$rep->getLastErr();
            $msg=$rep->getErrorMessage();

            if (!java_is_null($msg)) {
            //Ϊ��ȷ��ʾ���ĶԷ���java��������ת���������java_set_file_encoding���й�ת�������ٴ�ת��
                $msg=java_values($msg->getBytes("GBK")); }

            print "���׷����룺" . $code . "<br>";
            print "���״�����Ϣ��" . $msg . "<br>";
        ?>

        <p>
            <a href = "Index.htm">������ҳ</a>
        </p>

        <p>
            &nbsp;
        </p>
    </body>
</html>
