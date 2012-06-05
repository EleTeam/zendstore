// Sign_VC6View.h : interface of the CSign_VC6View class
//
/////////////////////////////////////////////////////////////////////////////

#if !defined(AFX_SIGN_VC6VIEW_H__99A1C1D1_7628_4919_90C0_576378F57501__INCLUDED_)
#define AFX_SIGN_VC6VIEW_H__99A1C1D1_7628_4919_90C0_576378F57501__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000


class CSign_VC6View : public CView
{
protected: // create from serialization only
	CSign_VC6View();
	DECLARE_DYNCREATE(CSign_VC6View)

// Attributes
public:
	CSign_VC6Doc* GetDocument();

// Operations
public:

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CSign_VC6View)
	public:
	virtual void OnDraw(CDC* pDC);  // overridden to draw this view
	virtual BOOL PreCreateWindow(CREATESTRUCT& cs);
	virtual BOOL Create(LPCTSTR lpszClassName, LPCTSTR lpszWindowName, DWORD dwStyle, const RECT& rect, CWnd* pParentWnd, UINT nID, CCreateContext* pContext = NULL);
	protected:
	virtual BOOL OnPreparePrinting(CPrintInfo* pInfo);
	virtual void OnBeginPrinting(CDC* pDC, CPrintInfo* pInfo);
	virtual void OnEndPrinting(CDC* pDC, CPrintInfo* pInfo);
	//}}AFX_VIRTUAL

// Implementation
public:
	virtual ~CSign_VC6View();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

protected:

// Generated message map functions
protected:
	//{{AFX_MSG(CSign_VC6View)
	afx_msg void OnSignDemo();
	afx_msg int OnCreate(LPCREATESTRUCT lpCreateStruct);
	afx_msg void OnChar(UINT nChar, UINT nRepCnt, UINT nFlags);
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

#ifndef _DEBUG  // debug version in Sign_VC6View.cpp
inline CSign_VC6Doc* CSign_VC6View::GetDocument()
   { return (CSign_VC6Doc*)m_pDocument; }
#endif

/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_SIGN_VC6VIEW_H__99A1C1D1_7628_4919_90C0_576378F57501__INCLUDED_)
