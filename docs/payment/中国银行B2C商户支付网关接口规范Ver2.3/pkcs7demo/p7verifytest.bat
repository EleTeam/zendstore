rem 验签名，不验签名证书dn
java -cp pkcs7.jar com.bocnet.common.security.P7Verify BOCCA.cer sign.txt text.txt


rem 验签名，并验签名证书dn
java -cp pkcs7.jar com.bocnet.common.security.P7Verify BOCCA.cer sign2.txt text.txt "CN=淘宝网TEST, O=BANK OF CHINA, C=CN"