1.B2C商户端接口说明(ver 2.3).doc
----中国银行支付网关向B2C商户提供的支付接口说明文档

2.pkcs7demo.rar
----中国银行支付网关向商户提供的JAVA签名工具包及使用示例DEMO

3.ibm-jce_policy.rar以及jce_policy-1_5_0.zip
----中国银行支付网关向商户提供的jce-policy无限制策略文件，该文件用于商户如果遇到
java.lang.SecurityException: Unsupported keysize or algorithm parameters异常，
说明jre环境受到美国密码出口政策的限制，无法使用强密码算法。
----ibm-jce_policy.rar 中是IBM提供JDK1.4/JDK1.5/JDK1.6版本下的策略文件
----jce_policy-1_5_0.zip 中是SUN提供的JDK1.5版本的策略文件
----中国银行提供的ibm-jce_policy.rar以及jce_policy-1_5_0.zip仅供参考。
客户可以按照自己JDK版本去SUN或者IBM网站下载对应的jce-policy无限制策略文件
替换到相应的目录下，例如：将下载的包解压出local_policy.jar和US_export_policy.jar，
替换JAVA_HOME\jre\lib\security下同名字的两个jar文件。
