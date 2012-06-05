                                       
					            *****************
						    *  注 意 事 项  *
						    *****************

(1) 环境说明: window xp sp2 + Tomcat5.0 + jdk1.5 (jdk1.4应该也没有问题), 
	IDE开发环境为Eclipse3.1 + MyEclipse插件

(2) TomcatSign为Tomcat5.0例子程序,需将其拷贝到tomcat安装目录下的webapps目录下

(3) 例子中使用了jsp和servlet两种方法测试验签

(4) jsp例子的url使用 http://localhost:8080/TomcatSign/input.html

(5) 在页面中输入SRC SIGN PUBKEY,测试数据见上级目录--文档/ccbrsa.txt

(6) servlet例子的url使用 http://localhost:8080/TomcatSign/inputServlet.html

(7) 在页面中输入SRC SIGN PUBKEY,测试数据见上级目录--文档/ccbrsa.txt

(8) TomcatSingSrc为MyEclipse中web project,其发布后形成了TomcatSign例子工程

(9) netpay.jar为验签的jar包,CCBSign.RSASig类是验签的封装类,在jsp和servlet中主要使用这个类
