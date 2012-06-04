// Sign_VC6Doc.h : interface of the CSign_VC6Doc class
//
/////////////////////////////////////////////////////////////////////////////

#if !defined(AFX_SIGN_VC6DOC_H__6027D735_DCA4_4914_9A69_731B2C64924A__INCLUDED_)
#define AFX_SIGN_VC6DOC_H__6027D735_DCA4_4914_9A69_731B2C64924A__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000


class CSign_VC6Doc : public CDocument
{
protected: // create from serialization only
	CSign_VC6Doc();
	DECLARE_DYNCREATE(CSign_VC6Doc)

// Attributes
public:

// Operations
public:

// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CSign_VC6Doc)
	public:
	virtual BOOL OnNewDocument();
	virtual void Serialize(CArchive& ar);
	//}}AFX_VIRTUAL

// Implementation
public:
	virtual ~CSign_VC6Doc();
#ifdef _DEBUG
	virtual void AssertValid() const;
	virtual void Dump(CDumpContext& dc) const;
#endif

protected:

// Generated message map functions
protected:
	//{{AFX_MSG(CSign_VC6Doc)
		// NOTE - the ClassWizard will add and remove member functions here.
		//    DO NOT EDIT what you see in these blocks of generated code !
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
};

/////////////////////////////////////////////////////////////////////////////

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_SIGN_VC6DOC_H__6027D735_DCA4_4914_9A69_731B2C64924A__INCLUDED_)
