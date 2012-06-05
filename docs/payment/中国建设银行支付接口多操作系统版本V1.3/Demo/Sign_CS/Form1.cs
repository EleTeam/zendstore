using System;
using System.Drawing;
using System.Collections;
using System.ComponentModel;
using System.Windows.Forms;
using System.Data;

//添加组件的引用
using CCBRSA;
namespace Sing_CS
{
	/// <summary>
	/// Form1 的摘要说明。
	/// </summary>
	public class Form1 : System.Windows.Forms.Form
	{
		private System.Windows.Forms.Button button1;
		/// <summary>
		/// 必需的设计器变量。
		/// </summary>
		private System.ComponentModel.Container components = null;

		public Form1()
		{
			//
			// Windows 窗体设计器支持所必需的
			//
			InitializeComponent();

			//
			// TODO: 在 InitializeComponent 调用后添加任何构造函数代码
			//
		}

		/// <summary>
		/// 清理所有正在使用的资源。
		/// </summary>
		protected override void Dispose( bool disposing )
		{
			if( disposing )
			{
				if (components != null) 
				{
					components.Dispose();
				}
			}
			base.Dispose( disposing );
		}

		#region Windows 窗体设计器生成的代码
		/// <summary>
		/// 设计器支持所需的方法 - 不要使用代码编辑器修改
		/// 此方法的内容。
		/// </summary>
		private void InitializeComponent()
		{
			this.button1 = new System.Windows.Forms.Button();
			this.SuspendLayout();
			// 
			// button1
			// 
			this.button1.Location = new System.Drawing.Point(104, 160);
			this.button1.Name = "button1";
			this.button1.TabIndex = 0;
			this.button1.Text = "签名验签";
			this.button1.Click += new System.EventHandler(this.button1_Click);
			// 
			// Form1
			// 
			this.AutoScaleBaseSize = new System.Drawing.Size(6, 14);
			this.ClientSize = new System.Drawing.Size(292, 266);
			this.Controls.Add(this.button1);
			this.Name = "Form1";
			this.Text = "Form1";
			this.ResumeLayout(false);

		}
		#endregion

		/// <summary>
		/// 应用程序的主入口点。
		/// </summary>
		[STAThread]
		static void Main() 
		{
			Application.Run(new Form1());
		}

		private void button1_Click(object sender, System.EventArgs e)
		{
			RSASig rsa;
			rsa=new CCBRSA.RSASigClass();
			string strRet;
			bool bRet;
			//接下来是几个正确的签名
			
			//1
			rsa.setPublicKey("30819c300d06092a864886f70d010101050003818a003081860281807d1e98e9c10625239ad9116488accf18a95125c83f5ac52f055be47614087b1bc55f1d475ddb0516b6339f7c2a8fd4def86519087cc6ecd8ea4657a5cef26d84890d00772d216e95d0aba1ea9fd39fb02202c82b71333b104e715da5de65be4cf5b83e3c0ba459777fe83a39485f145fccc94b471981348db5beab735c5889f1020111");
			bRet=rsa.verifySigature("5bf88c409a13963286904e8954a4d825108f9b5bb60a8c8e5cfc05355fe4e247c777b521c7d68b8d51968285d51d1a0da0c5bd55e19268949a20dd7bd14f17422e41f3e6f7446d2136e10e796abc8b8a6f752bed5091374551d84d02f185aa3f9b516ac77ca319b06a8269389de6d7f677c619bfc0c89ccbcb125ae6dd7cc646","POSID=000000000&BRANCHID=330000000&ORDERID=2004010061&PAYMENT=0.01&CURCODE=01&REMARK1=&REMARK2=&SUCCESS=N");
			if( bRet )
			{
				this.Text="Sign Ok";
			}
			else
			{
				this.Text="Sign failed";
			}

			//2 
			rsa.setPublicKey("30819d300d06092a864886f70d010101050003818b00308187028181009ba4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111");
			bRet=rsa.verifySigature("02bfadfe6c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557","POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11");
			if( bRet )
			{
				this.Text="Sign Ok";
			}
			else
			{
				this.Text="Sign failed";
			}

			//接下来是一些错误的验签例子
			//1 修改原串 注意POSID号的变化，根据正确例子2来做的修改
			rsa.setPublicKey("30819d300d06092a864886f70d010101050003818b00308187028181009ba4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111");
			bRet=rsa.verifySigature("02bfadfe6c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557","POSID=000000001&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11");
			if( bRet )
			{
				this.Text="Sign Ok";
			}
			else
			{
				this.Text="Sign failed";
			}

			//2 修改公钥，同样根据正确例子2做的修改
			rsa.setPublicKey("30819d300d06092a864886f70d010101050003818b0030818702818100bba4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111");
			bRet=rsa.verifySigature("02bfadfe6c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557","POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11");
			if( bRet )
			{
				this.Text="Sign Ok";
			}
			else
			{
				this.Text="Sign failed";
			}

			//3 修改签名串，根据正确例子2做的修改
			rsa.setPublicKey("30819d300d06092a864886f70d010101050003818b00308187028181009ba4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111");
			bRet=rsa.verifySigature("02bfadfe5c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557","POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11");
			if( bRet )
			{
				this.Text="Sign Ok";
			}
			else
			{
				this.Text="Sign failed";
			}


		}
	}
}
