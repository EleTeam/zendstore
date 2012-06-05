// Sign_VC6View.cpp : implementation of the CSign_VC6View class
//

#include "stdafx.h"
#include "Sign_VC6.h"

#include "Sign_VC6Doc.h"
#include "Sign_VC6View.h"
#include "ccbrsa.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6View

IMPLEMENT_DYNCREATE(CSign_VC6View, CView)

BEGIN_MESSAGE_MAP(CSign_VC6View, CView)
	//{{AFX_MSG_MAP(CSign_VC6View)
	ON_COMMAND(ID_SIGN_DEMO, OnSignDemo)
	ON_WM_CREATE()
	ON_WM_CHAR()
	//}}AFX_MSG_MAP
	// Standard printing commands
	ON_COMMAND(ID_FILE_PRINT, CView::OnFilePrint)
	ON_COMMAND(ID_FILE_PRINT_DIRECT, CView::OnFilePrint)
	ON_COMMAND(ID_FILE_PRINT_PREVIEW, CView::OnFilePrintPreview)
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6View construction/destruction

CSign_VC6View::CSign_VC6View()
{
	// TODO: add construction code here

}

CSign_VC6View::~CSign_VC6View()
{
}

BOOL CSign_VC6View::PreCreateWindow(CREATESTRUCT& cs)
{
	// TODO: Modify the Window class or styles here by modifying
	//  the CREATESTRUCT cs

	return CView::PreCreateWindow(cs);
}

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6View drawing

void CSign_VC6View::OnDraw(CDC* pDC)
{
	CSign_VC6Doc* pDoc = GetDocument();
	ASSERT_VALID(pDoc);
	// TODO: add draw code for native data here
}

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6View printing

BOOL CSign_VC6View::OnPreparePrinting(CPrintInfo* pInfo)
{
	// default preparation
	return DoPreparePrinting(pInfo);
}

void CSign_VC6View::OnBeginPrinting(CDC* /*pDC*/, CPrintInfo* /*pInfo*/)
{
	// TODO: add extra initialization before printing
}

void CSign_VC6View::OnEndPrinting(CDC* /*pDC*/, CPrintInfo* /*pInfo*/)
{
	// TODO: add cleanup after printing
}

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6View diagnostics

#ifdef _DEBUG
void CSign_VC6View::AssertValid() const
{
	CView::AssertValid();
}

void CSign_VC6View::Dump(CDumpContext& dc) const
{
	CView::Dump(dc);
}

CSign_VC6Doc* CSign_VC6View::GetDocument() // non-debug version is inline
{
	ASSERT(m_pDocument->IsKindOf(RUNTIME_CLASS(CSign_VC6Doc)));
	return (CSign_VC6Doc*)m_pDocument;
}
#endif //_DEBUG

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6View message handlers

void CSign_VC6View::OnSignDemo() 
{
	//com组件库初始化
	::CoInitialize(NULL);

	BOOL bRet;
	CString strRet;
	RSASig_Dispatch rsasig;
	bRet=rsasig.CreateDispatch(_T("CCBRSA.RSASig"));
	if( !bRet ){
		goto CleanUp;
	}

	//下面是成功的验签
	//1
	rsasig.SetPublicKey(_T("30819c300d06092a864886f70d010101050003818a003081860281807d1e98e9c10625239ad9116488accf18a95125c83f5ac52f055be47614087b1bc55f1d475ddb0516b6339f7c2a8fd4def86519087cc6ecd8ea4657a5cef26d84890d00772d216e95d0aba1ea9fd39fb02202c82b71333b104e715da5de65be4cf5b83e3c0ba459777fe83a39485f145fccc94b471981348db5beab735c5889f1020111"));
	strRet=rsasig.StringVerifySigature(_T("5bf88c409a13963286904e8954a4d825108f9b5bb60a8c8e5cfc05355fe4e247c777b521c7d68b8d51968285d51d1a0da0c5bd55e19268949a20dd7bd14f17422e41f3e6f7446d2136e10e796abc8b8a6f752bed5091374551d84d02f185aa3f9b516ac77ca319b06a8269389de6d7f677c619bfc0c89ccbcb125ae6dd7cc646"),_T("POSID=000000000&BRANCHID=330000000&ORDERID=2004010061&PAYMENT=0.01&CURCODE=01&REMARK1=&REMARK2=&SUCCESS=N"));
	strRet.MakeLower();
	if( strRet.Compare(_T("y"))==0 ){
		AfxMessageBox("Sign OK");
	}
	else{
		AfxMessageBox("Sign failed");
	}
	
	//2
	rsasig.SetPublicKey(_T("30819f300d06092a864886f70d010101050003818d0030818902818100b466e3a0fa097b57a1bc63c1fd5d97d4ef8d270d538a5aee3d1061f579f02a19cf1543701d94d81f46ce56adb84dca440a7e8f5af40538bb7a88efaf9991ead0fabc63d48fd1f12de658229e30e38ccbd9a631ec9c2d95b8590ea1a01d0931221e062544023a1ed2eb7050853fe56bf8cfd0f18243192d38855a36a87badba790203010001"));
	strRet=rsasig.StringVerifySigature(_T("43680d00f5097caae18b7af3fc936cc79feb621fb166e25affbb52721e2c5c1e656f030dff46e6f0298ef82cf2fd10b6cef34fb2aa270716c30708aeb1abf0520418449614562e891cd5aede8f83b1dd65f76cc81ad5aabfd4aba409da3523ef8e82a7d19055dbb6d9241171893bf282bf64f239677ecd84abbe55fd855f48f3"),_T("POSID=000000000&BRANCHID=110000000&ORDERID=20041031&PAYMENT=0.01&CURCODE=01&REMARK1=ccb&REMARK2=test&SUCCESS=Y"));
	strRet.MakeLower();
	if( strRet.Compare(_T("y"))==0 ){
		AfxMessageBox("Sign OK");
	}
	else{
		AfxMessageBox("Sign failed");
	}

	//3
	rsasig.SetPublicKey(_T("30819f300d06092a864886f70d010101050003818d0030818902818100d0e57a2ebbc82801980de2ad7101c67dc137432bb6ced45882b8d41cbfec7519ae8bf18b2584ae460d7d437aec069ec907935e4b39c72a6291e43a6a88c3405565357dc23c46b7072e6e50b1da4cd9cfdec616cb6ad43f0b013040307973d63b889e78fdd1389714adec663acefe5c974e513a063ba9acb96f590139b0fc571b0203010001"));
	strRet=rsasig.StringVerifySigature(_T("3183a60f887937846008f4ecfea725af5d65ecaefebea828459193343df7d0943f0fa9e44a298cc9a8e335bece72f8bfce8da3975e21fe4ce4d6c96894d5428e05e896b7da03f7519551b8a09bf1286ea48975b3cd49978eefbb628cc98f4f064feb898518dfb783acdd25eb6f5507fc00c16d1ae69d801a8cb970c4b7e0959b"),_T("POSID=000000000&BRANCHID=110000000&ORDERID=20041031&PAYMENT=0.01&CURCODE=01&REMARK1=ccb&REMARK2=test&SUCCESS=Y"));
	strRet.MakeLower();
	if( strRet.Compare(_T("y"))==0 ){
		AfxMessageBox("Sign OK");
	}
	else{
		AfxMessageBox("Sign failed");
	}

	//4
	rsasig.SetPublicKey(_T("30819d300d06092a864886f70d010101050003818b00308187028181009ba4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111"));
	strRet=rsasig.StringVerifySigature(_T("02bfadfe6c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557"),_T("POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11"));
	strRet.MakeLower();
	if( strRet.Compare(_T("y"))==0 ){
		AfxMessageBox("Sign OK");
	}
	else{
		AfxMessageBox("Sign failed");
	}

	//接下来是错误的验签
	//1 修改正确签名4的源串,注意比较POSID号
	rsasig.SetPublicKey(_T("30819d300d06092a864886f70d010101050003818b00308187028181009ba4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111"));
	strRet=rsasig.StringVerifySigature(_T("02bfadfe6c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557"),_T("POSID=000000001&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11"));
	strRet.MakeLower();
	if( strRet.Compare(_T("y"))==0 ){
		AfxMessageBox("Sign OK");
	}
	else{
		AfxMessageBox("Sign failed");
	}
	//2 修改公钥,同样根据正确签名验证4来修改
	rsasig.SetPublicKey(_T("30819d300d06092a864886f70d010101050003818b00308187028181009bb4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111"));
	strRet=rsasig.StringVerifySigature(_T("02bfadfe6c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557"),_T("POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11"));
	strRet.MakeLower();
	if( strRet.Compare(_T("y"))==0 ){
		AfxMessageBox("Sign OK");
	}
	else{
		AfxMessageBox("Sign failed");
	}

	//3 修改签名串,同样根据正确签名4来修改
	rsasig.SetPublicKey(_T("30819d300d06092a864886f70d010101050003818b00308187028181009ba4951169c5deecf03a8ddb2fd934f53747c03a211f63bccc84773182bdd8f7159634705041087e4c9053df05326952a143e1aab5e8ba75ed891a91c2db484b66a064abba6605418944d8763814ff23c161101948ec9ef2dfac735b4bb7c7dac18fbf87157b424780eb7080a3e7c9e79dd4841e44a001edfe497b9e3d2181b9020111"));
	strRet=rsasig.StringVerifySigature(_T("02afadfe6c64847325f8a1bfc2a5820a65a17ad1e6da7c789c7215eefb7e5b5dfabe4f8b87d093e033128d4a0bbf9e6b818ae5ac9ba4bd12af827fb9b3ff3754b73c0283443fa5bf850bac7a048908b07965def9b9420682d67bdbf57eaeac4a70004e16db30fe91d368bde675cd70f3c62f1e39a65c8483acc890a806ab5557"),_T("POSID=000000000&BRANCHID=110000000&ORDERID=19991101234&PAYMENT=500.00&CURCODE=01&REMARK1=19991101&REMARK2=北京商户&SUCCESS=Y&ACC_TYPE=11"));
	strRet.MakeLower();
	if( strRet.Compare(_T("y"))==0 ){
		AfxMessageBox("Sign OK");
	}
	else{
		AfxMessageBox("Sign failed");
	}
CleanUp:
	//资源释放,当然com初始化和反初始化可以在更高的作用域中进行,此处是例子
	rsasig.ReleaseDispatch();
	::CoUninitialize();

	
}

BOOL CSign_VC6View::Create(LPCTSTR lpszClassName, LPCTSTR lpszWindowName, DWORD dwStyle, const RECT& rect, CWnd* pParentWnd, UINT nID, CCreateContext* pContext) 
{
	// TODO: Add your specialized code here and/or call the base class
	
	return CWnd::Create(lpszClassName, lpszWindowName, dwStyle, rect, pParentWnd, nID, pContext);
}

int CSign_VC6View::OnCreate(LPCREATESTRUCT lpCreateStruct) 
{
	if (CView::OnCreate(lpCreateStruct) == -1)
		return -1;
	
	// TODO: Add your specialized creation code here
	
	return 0;
}

void CSign_VC6View::OnChar(UINT nChar, UINT nRepCnt, UINT nFlags) 
{
	// TODO: Add your message handler code here and/or call default
	
	CView::OnChar(nChar, nRepCnt, nFlags);
}
