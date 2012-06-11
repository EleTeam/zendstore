<?php
    // PHP version of QueryRefund.jsp
    //����B2CAPI��php���ò���
    //��    �ߣ�����
    //����ʱ�䣺2008-12-03
?>

<html>
    <head>
        <title>�˿���ϸ��ѯ����</title>

        <meta http-equiv = "Content-Type" content = "text/html; charset=gb2312">
    </head>

    <body bgcolor = "#FFFFFF" text = "#000000">
        <?php

            //define("JAVA_DEBUG", true); //��������    
            //define("JAVA_HOSTS", "127.0.0.1:8080"); //����javabridge�����˿ڣ��������javabridge.jar���õĶ˿ڲ���8080����ͨ����������

            require_once ("java/Java.inc"); //php����java�Ľӿڣ������

            $here=realpath(dirname($_SERVER["SCRIPT_FILENAME"]));

            if (!$here)
                $here=getcwd();

            java_set_library_path ("$here/lib"); //����java������·��
            java_set_file_encoding ("GBK");      //����java����

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
                //Ϊ��ȷ��ʾ���ĶԷ���java��������ת���������java_set_file_encoding���й�ת�������ٴ�ת��
                //$err = java_values($err->getBytes("GBK")); 
                $err=java_values($err);
                print "��ʼ��ʧ��,������Ϣ��" . $err . "<br>";
                exit (1);
                }

            $rep=$client->queryRefund($begDate, $endDate, $refundtype, $order, $flag, $begIndex); //�˿���ϸ��ѯ

            if (java_is_null($rep))
                {
                $err=$client->getLastErr();
                //Ϊ��ȷ��ʾ���ĶԷ���java��������ת���������java_set_file_encoding���й�ת�������ٴ�ת��
                //$err = java_values($err->getBytes("GBK")); 
                print "���״�����Ϣ��" . $err . "<br>";
                exit (1);
                }

            $code=$rep->getRetCode(); //�õ����׷�����
            $err=$rep->getLastErr();
            $msg=$rep->getErrorMessage();

            if (!java_is_null($msg)) {
            //Ϊ��ȷ��ʾ���ĶԷ���java��������ת���������java_set_file_encoding���й�ת�������ٴ�ת��
                $msg=java_values($msg->getBytes("GBK")); }

            print "���׷����룺" . $code . "<br>";
            print "���״�����Ϣ��" . $msg . "<br>";

            if ($code == "0") //���׳ɹ�
                {
                $oprSet=$rep->getOpResultSet();

                $iNum=java_cast($oprSet->getOpresultNum(), "integer"); //ת��Ϊ��������

                print "�ܽ��׼�¼����";

                print java_values($iNum);

                print "<br>------------------------<br>";

                for ($index=0; $index <= $iNum - 1; $index=$index + 1)
                    {
                    $order=$oprSet->getResultValueByName($index, "order");                     //������

                    $orderDate=$oprSet->getResultValueByName($index, "orderDate");             //��������		     

                    $curType=$oprSet->getResultValueByName($index, "curType");                 //����

                    $amount=$oprSet->getResultValueByName($index, "amount");

                    $refundType=$oprSet->getResultValueByName($index, "refundType");           //���	

                    $state=$oprSet->getResultValueByName($index, "tranState");                 //֧������״̬	

                    $fee=$oprSet->getResultValueByName($index, "fee");                         //������		                 

                    $merchantComment=$oprSet->getResultValueByName($index, "merchantComment"); //�̻���ע

                    $bankComment=$oprSet->getResultValueByName($index, "bankComment");         //���б�ע

                    print ("�����ţ�" . $order);

                    print ("<br>");

                    print ("�������ڣ�" . $orderDate);

                    print ("<br>");

                    print ("���֣�" . $curType);

                    print ("<br>");

                    print ("�˿��" . $amount);

                    print ("<br>");

                    print ("�˿����ͣ�" . $refundType);

                    print ("<br>");

                    print ("�˿��״̬��" . $state);

                    print ("<br>");

                    print ("�����ѣ�" . $fee);

                    print ("<br>");

                    print ("�̻���ע��" . $merchantComment);

                    print ("<br>");

                    print ("���б�ע��" . $bankComment);

                    print ("<p></p>");
                    }
                }
        ?>

        <p>
            <a href = "Index.htm">������ҳ</a>
        </p>

        <p>
            &nbsp;
        </p>
    </body>
</html>
