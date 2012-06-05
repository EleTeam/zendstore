package servlet;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

//导入验签类
import CCBSign.*;

public class ServletVerify extends HttpServlet {

	/**
	 * Constructor of the object.
	 */
	public ServletVerify() {
		super();
	}

	/**
	 * Destruction of the servlet. <br>
	 */
	public void destroy() {
		super.destroy(); // Just puts "destroy" string in log
		// Put your code here
	}

	/**
	 * The doGet method of the servlet. <br>
	 *
	 * This method is called when a form has its tag value method equals to get.
	 * 
	 * @param request the request send by the client to the server
	 * @param response the response send by the server to the client
	 * @throws ServletException if an error occurred
	 * @throws IOException if an error occurred
	 */
	public void doGet(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {

			processReq(request,response);
	}

	/**
	 * The doPost method of the servlet. <br>
	 *
	 * This method is called when a form has its tag value method equals to post.
	 * 
	 * @param request the request send by the client to the server
	 * @param response the response send by the server to the client
	 * @throws ServletException if an error occurred
	 * @throws IOException if an error occurred
	 */
	public void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {

			processReq(request,response);
	}

	public void processReq(HttpServletRequest request, HttpServletResponse response)
	throws ServletException, IOException {
	
		String strSrc;
		String strSign;
		String strPubkey;
		boolean bRet;
		String strRet;
		RSASig rsa=new RSASig();
		
		//获得参数
		strSrc=request.getParameter("src");
		strSign=request.getParameter("sign");
		strPubkey=request.getParameter("pubkey");
		
		if( strSrc==null ){
			strSrc="";
		}
		if( strSign==null ){
			strSign="";
		}
		if( strPubkey==null ){
			strPubkey="";
		}
		rsa.setPublicKey(strPubkey);
		bRet=rsa.verifySigature( strSign,strSrc);
		if( bRet ){
			strRet="Y";
		}
		else{
			strRet="N";
		}
		response.setContentType("text/html");
		PrintWriter out = response.getWriter();
		out.println("<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">");
		out.println("<HTML>");
		out.println("  <HEAD><TITLE>A Servlet</TITLE></HEAD>");
		out.println("  <BODY>");
		out.println("<p>src=");
		out.println(strSrc);
		out.println("</p>");

		out.println("<p>sign=");
		out.println(strSign);
		out.println("</p>");
		
		out.println("<p>pubkey=");
		out.println(strPubkey);
		out.println("</p>");
		
		out.println("<p>result=");
		out.println(strRet);
		out.println("</p>");
		
		out.println("  </BODY>");
		out.println("</HTML>");
		out.flush();
		out.close();
	}
	/**
	 * Initialization of the servlet. <br>
	 *
	 * @throws ServletException if an error occure
	 */
	public void init() throws ServletException {
		// Put your code here
	}

}
