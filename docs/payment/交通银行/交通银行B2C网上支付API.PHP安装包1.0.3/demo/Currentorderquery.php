<?php
    // PHP version of Currentorderquery.jsp
    //����B2CAPI��php���ò���
    //��    �ߣ�����
    //����ʱ�䣺2008-12-03
?>

<html>
    <head>
        <title>����������ѯ����</title>

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
						
            $begTime="";                         //��ʼʱ��[yyyyMMddHHmmss]
            $endTime="";                         //����ʱ��[yyyyMMddHHmmss]
            $flag=0;                             //����״̬ 0 ���� 1 ��֧�� 2 �ѳ��� 3 �����˻� 4�˻������� 5 ȫ���˻� 
            $begIndex=0;                         //��ʼ�����ţ���ΪNULL,Ĭ����0
            $begOrder="";                        //��ʼ�����ţ���ΪNULL
            $endOrder="";                        //���������ţ���ΪNULL
            $sortField=1;                        //�����ֶ�1�������ţ�2����3��ʱ��
            $sortOrder=1;                        //1������2������
            $code="";
            $err="";
            $msg="";

            $begTime=$_REQUEST["begTime"];
            $endTime=$_REQUEST["endTime"];
            $flag=(integer)$_REQUEST["flag"];
            $begIndex=(integer)$_REQUEST["begIndex"];
            $begOrder=$_REQUEST["begOrder"];
            $endOrder=$_REQUEST["endOrder"];
            $sortField=$_REQUEST["sortField"];
            $sortOrder=$_REQUEST["sortOrder"];

            //����java����
            $client=new java("com.bocom.netpay.b2cAPI.BOCOMB2CClient");

            //��ʼ���������
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

            //����������
            //���ö��������������ѯ����
            $rep=$client->queryCurOrder($begTime, $endTime, $flag, $begIndex, $begOrder, $endOrder, $sortField,
                                        $sortOrder); //����������ѯ

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
                $oprSet=$rep->getOpResultSet();

                $opr=$rep->getOpResult();

                $total=$opr->getValueByName("totalNumber");            //�õ����ؼ�¼����

                $iNum=java_cast($oprSet->getOpresultNum(), "integer"); //ת��Ϊ��������

                print "�ܽ��׼�¼����";

                print $total . "<br>";

                print "���η��ؼ�¼����";

                print java_values($iNum);

                print "<br>------------------------<br>";

                for ($index=0; $index <= $iNum - 1; $index=$index + 1)
                    {
                    $order=$oprSet->getResultValueByName($index, "order");                     //������

                    $orderDate=$oprSet->getResultValueByName($index, "orderDate");             //��������

                    $orderTime=$oprSet->getResultValueByName($index, "orderTime");             //����ʱ��

                    $curType=$oprSet->getResultValueByName($index, "curType");                 //����

                    $amount=$oprSet->getResultValueByName($index, "amount");                   //���

                    $tranDate=$oprSet->getResultValueByName($index, "tranDate");               //��������

                    $tranTime=$oprSet->getResultValueByName($index, "tranTime");               //����ʱ��

                    $tranState=$oprSet->getResultValueByName($index, "tranState");             //֧������״̬

                    $orderState=$oprSet->getResultValueByName($index, "orderState");           //����״̬

                    $fee=$oprSet->getResultValueByName($index, "fee");                         //������

                    $bankSerialNo=$oprSet->getResultValueByName($index, "bankSerialNo");       //������ˮ��

                    $bankBatNo=$oprSet->getResultValueByName($index, "bankBatNo");             //�������κ�

                    $cardType=$oprSet->getResultValueByName($index, "cardType");               //���׿�����0:��ǿ� 1��׼���ǿ� 2:���ǿ�

                    $merchantBatNo=$oprSet->getResultValueByName($index, "merchantBatNo");     //�̻����κ�

                    $merchantComment=$oprSet->getResultValueByName($index, "merchantComment"); //�̻���ע
                    $merchantComment=java_values($merchantComment->getBytes("GBK"));           //���ı���ת��

                    $bankComment=$oprSet->getResultValueByName($index, "bankComment");         //���б�ע
                    $bankComment=java_values($bankComment->getBytes("GBK"));                   //���ı���ת��

                    print ("�����ţ�" . $order);

                    print ("<br>");

                    print ("�������ڣ�" . $orderDate);

                    print ("<br>");

                    print ("����ʱ�䣺" . $orderTime);

                    print ("<br>");

                    print ("���֣�" . $curType);

                    print ("<br>");

                    print ("��" . $amount);

                    print ("<br>");

                    print ("�������ڣ�" . $tranDate);

                    print ("<br>");

                    print ("����ʱ�䣺" . $tranTime);

                    print ("<br>");

                    print ("֧������״̬[1:�ɹ�]��" . $tranState);

                    print ("<br>");

                    print ("����״̬[0 ���� 1 ��֧�� 2 �ѳ��� 3 �����˻� 4�˻������� 5 ȫ���˻�]��" . $orderState);

                    print ("<br>");

                    print ("�����ѣ�" . $fee);

                    print ("<br>");

                    print ("������ˮ�ţ�" . $bankSerialNo);

                    print ("<br>");

                    print ("�������κţ�" . $bankBatNo);

                    print ("<br>");

                    print ("���׿�����[0:��ǿ� 1��׼���ǿ� 2:���ǿ�]��" . $cardType);

                    print ("<br>");

                    print ("�̻����κţ�" . $merchantBatNo);

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
