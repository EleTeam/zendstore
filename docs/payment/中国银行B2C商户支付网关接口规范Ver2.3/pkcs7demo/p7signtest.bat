rem ʹ��jks��ʽ֤���ǩ��
java -cp pkcs7.jar com.bocnet.common.security.P7Sign taobao.jks 11111111 text.txt sign.txt

rem ʹ��pfx��ʽ֤���ǩ��
java -cp pkcs7.jar com.bocnet.common.security.P7Sign taobao.pfx 11111111 text.txt sign2.txt
