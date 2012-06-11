<?php
    // PHP version of merchant_result.jsp
    //����B2CAPI��php���ò���
    //��    �ߣ�����
    //����ʱ�䣺2008-12-03
?>

<html>
    <head>
        <title>��ͨ�����̻����Խ��ҳ��</title>

        <meta http-equiv = "Content-Type" content = "text/html; charset=GBK">
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

            print "�̻����ҳ��";
            print "<br>";
            print "--------------------------";
            print "<br>";

            $notifyMsg=$_REQUEST["notifyMsg"];
            $URLDecoder = java("java.net.URLDecoder");
            $notifyMsg = java_values($URLDecoder->decode($notifyMsg,"GBK"));
            
            $lastIndex=strripos($notifyMsg, "|");
            $signMsg=substr($notifyMsg, $lastIndex + 1);   //ǩ����Ϣ
            $srcMsg=substr($notifyMsg, 0, $lastIndex + 1); //ԭ��

            $signMsg=new java("java.lang.String", $signMsg);
            $srcMsg=new java("java.lang.String", $srcMsg);
            $veriyCode=-1;

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
                exit(1);
                }

            $nss=new java("com.bocom.netpay.b2cAPI.NetSignServer");
            $nss->NSDetachedVerify($signMsg->getBytes("GBK"), $srcMsg->getBytes("GBK")); //��ǩ

            $veriyCode=java_values($nss->getLastErrnum());

            if ($veriyCode < 0) { print "�̻�����֤ǩ��ʧ�ܣ�return code:" . $veriyCode;
            //exit(1);
                }

            $arr=preg_split("/\|{1,}/", $srcMsg);
        ?>

        <table width = "75%" border = "0" cellspacing = "0" cellpadding = "0">
            <tr>
                <td width = "14%">
                    �̻��ͻ���
                </td>

                <td width = "86%">

                    <?php
                        print $arr[0];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    �������
                </td>

                <td width = "86%">

                    <?php
                        print $arr[1];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ���׽��
                </td>

                <td width = "86%">

                    <?php
                        print $arr[2];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ���ױ���
                </td>

                <td width = "86%">

                    <?php
                        print $arr[3];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ƽ̨���κ�
                </td>

                <td width = "86%">

                    <?php
                        print $arr[4];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    �̻����κ�
                </td>

                <td width = "86%">

                    <?php
                        print $arr[5];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ��������
                </td>

                <td width = "86%">

                    <?php
                        print $arr[6];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ����ʱ��
                </td>

                <td width = "86%">

                    <?php
                        print $arr[7];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ������ˮ��
                </td>

                <td width = "86%">

                    <?php
                        print $arr[8];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ���׽��
                </td>

                <td width = "86%">
                    <?php
                        print $arr[9];
                    ?>

                    &nbsp;[1:�ɹ�]
                </td>
            </tr>

            <tr>
                <td width = "14%">
                    �������ܶ�
                </td>

                <td width = "86%">

                    <?php
                        print $arr[10];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ���п�����
                </td>

                <td width = "86%">
                    <?php
                        print $arr[11];
                    ?>

                    &nbsp;[0:��ǿ� 1��׼���ǿ� 2:���ǿ�]
                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ���б�ע
                </td>

                <td width = "86%">

                    <?php
                        print $arr[12];
                    ?>

                </td>
            </tr>

            <tr>
                <td width = "14%">
                    ������Ϣ����
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
