rem 使用jks格式证书库签名
java -cp pkcs7.jar com.bocnet.common.security.P7Sign taobao.jks 11111111 text.txt sign.txt

rem 使用pfx格式证书库签名
java -cp pkcs7.jar com.bocnet.common.security.P7Sign taobao.pfx 11111111 text.txt sign2.txt
