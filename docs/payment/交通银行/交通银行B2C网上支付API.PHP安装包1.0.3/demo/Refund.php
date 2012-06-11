<?php
    // PHP version of Refund.jsp
    //����B2CAPI��php���ò���
    //��    �ߣ�����
    //����ʱ�䣺2008-12-03
?>

<html>
    <head>
        <title>�˿�¼�����</title>

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

            java_set_library_path ("$here/lib"); //���ÿ�����·��
            java_set_file_encoding ("GBK");      //����java����

            $operator=$_REQUEST["operator"];
            $order=$_REQUEST["order"];
            $orderdate=$_REQUEST["date"];
            $amount=$_REQUEST["amount"];
            $comment=$_REQUEST["comment"];

            $client=new java("com.bocom.netpay.b2cAPI.BOCOMB2CClient");    //���java����
            $ret=$client->initialize("C:/bocommjava/ini/B2CMerchant.xml"); //���������ļ�
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

            //����������
            $rep=$client->Refund($operator, $order, $orderdate, $amount, $comment); //����������ѯ

            if (java_is_null($rep))
                {
                $err=$client->getLastErr();
                //Ϊ��ȷ��ʾ���ĶԷ���java��������ת���������java_set_file_encoding���й�ת�������ٴ�ת��
                //$err = java_values($err->getBytes("GBK")); 
                print "���״�����Ϣ��" . $err . "<br>";
                exit (1);
                }

            $code=$rep->getRetCode(); //�õ����׷�����
            $msg=$rep->getErrorMessage();

            if (!java_is_null($msg)) {
            //Ϊ��ȷ��ʾ���ĶԷ���java��������ת���������java_set_file_encoding���й�ת�������ٴ�ת��
                $msg=java_values($msg->getBytes("GBK")); }

            print "���׷����룺" . $code . "<br>";
            print "���״�����Ϣ��" . $msg . "<br>";

            if ($code == "0") //���׳ɹ�
                {
                print "<br>------------------------<br>";

                $opr=$rep->getOpResult();

                $serial=$opr->getValueByName("serial");   //�˿���ˮ��

                $account=$opr->getValueByName("account"); //�˿��˺�

                print "�˿���ˮ��" . $serial;

                print "<br>";

                print "�˿��˺�" . $account;

                print "<br>";

                print "<p></p>";
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
