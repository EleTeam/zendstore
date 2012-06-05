// Machine generated IDispatch wrapper class(es) created with ClassWizard
/////////////////////////////////////////////////////////////////////////////
// RSASig_Dispatch wrapper class

class RSASig_Dispatch : public COleDispatchDriver
{
public:
	RSASig_Dispatch() {}		// Calls COleDispatchDriver default constructor
	RSASig_Dispatch(LPDISPATCH pDispatch) : COleDispatchDriver(pDispatch) {}
	RSASig_Dispatch(const RSASig_Dispatch& dispatchSrc) : COleDispatchDriver(dispatchSrc) {}

// Attributes
public:

// Operations
public:
	VARIANT wait(VARIANT* v_1, VARIANT* v_2);
	void setPublicKey(LPCTSTR v_3);
	void SetPrivateKey(LPCTSTR lpszNewValue);
	CString GetPrivateKey();
	long hashCode();
	BOOL generateKeys();
	CString generateSigature(LPCTSTR v_4);
	CString strGenerateKeys();
	CString testVerifyString(LPCTSTR v_5, LPCTSTR v_6);
	CString toString();
	BOOL equals(LPDISPATCH v_7);
	CString getPublicKey();
	BOOL verifySigature(LPCTSTR v_8, LPCTSTR v_9);
	CString StringVerifySigature(LPCTSTR v_10, LPCTSTR v_11);
	void notify();
	LPDISPATCH getClass();
	void notifyAll();
	void setPrivateKey(LPCTSTR v_12);
	void SetPublicKey(LPCTSTR lpszNewValue);
	CString GetPublicKey();
	CString getPrivateKey();
};
