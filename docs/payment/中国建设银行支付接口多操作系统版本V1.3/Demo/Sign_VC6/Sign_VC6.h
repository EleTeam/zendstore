// Sign_VC6.h : main header file for the SIGN_VC6 application
//

#if !defined(AFX_SIGN_VC6_H__DD6DAB29_10C2_42BF_8149_5F91F6BA4078__INCLUDED_)
#define AFX_SIGN_VC6_H__DD6DAB29_10C2_42BF_8149_5F91F6BA4078__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

#ifndef __AFXWIN_H__
	#error include 'stdafx.h' before including this file for PCH
#endif

#include "resource.h"       // main symbols

/////////////////////////////////////////////////////////////////////////////
// CSign_VC6App:
// See Sign_VC6.cpp for the implementation of this class
//

class CSign_VC6App : public CWinApp
{
public:
	CSign_VC6App();

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CSign_VC6App)
	public:
	virtual BOOL InitInstance();
	//}}AFX_VIRTUAL

// Implementation
	//{{AFX_MSG(CSign_VC6App)
	afx_msg void OnAppAbout();
		// NOTE - the ClassWizard will add and remove member functions here.
		//    DO NOT EDIT what you see in these blocks of generated code !
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};


/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_SIGN_VC6_H__DD6DAB29_10C2_42BF_8149_5F91F6BA4078__INCLUDED_)
