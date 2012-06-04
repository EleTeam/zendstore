// Sign_VC6Doc.cpp : implementation of the CSign_VC6Doc class
//

#include "stdafx.h"
#include "Sign_VC6.h"

#include "Sign_VC6Doc.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6Doc

IMPLEMENT_DYNCREATE(CSign_VC6Doc, CDocument)

BEGIN_MESSAGE_MAP(CSign_VC6Doc, CDocument)
	//{{AFX_MSG_MAP(CSign_VC6Doc)
		// NOTE - the ClassWizard will add and remove mapping macros here.
		//    DO NOT EDIT what you see in these blocks of generated code!
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6Doc construction/destruction

CSign_VC6Doc::CSign_VC6Doc()
{
	// TODO: add one-time construction code here

}

CSign_VC6Doc::~CSign_VC6Doc()
{
}

BOOL CSign_VC6Doc::OnNewDocument()
{
	if (!CDocument::OnNewDocument())
		return FALSE;

	// TODO: add reinitialization code here
	// (SDI documents will reuse this document)

	return TRUE;
}



/////////////////////////////////////////////////////////////////////////////
// CSign_VC6Doc serialization

void CSign_VC6Doc::Serialize(CArchive& ar)
{
	if (ar.IsStoring())
	{
		// TODO: add storing code here
	}
	else
	{
		// TODO: add loading code here
	}
}

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6Doc diagnostics

#ifdef _DEBUG
void CSign_VC6Doc::AssertValid() const
{
	CDocument::AssertValid();
}

void CSign_VC6Doc::Dump(CDumpContext& dc) const
{
	CDocument::Dump(dc);
}
#endif //_DEBUG

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6Doc commands
