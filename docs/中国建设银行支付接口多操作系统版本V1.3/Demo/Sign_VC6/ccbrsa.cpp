// Machine generated IDispatch wrapper class(es) created with ClassWizard

#include "stdafx.h"
#include "ccbrsa.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif



/////////////////////////////////////////////////////////////////////////////
// RSASig_Dispatch properties

/////////////////////////////////////////////////////////////////////////////
// RSASig_Dispatch operations

VARIANT RSASig_Dispatch::wait(VARIANT* v_1, VARIANT* v_2)
{
	VARIANT result;
	static BYTE parms[] =
		VTS_PVARIANT VTS_PVARIANT;
	InvokeHelper(0x64, DISPATCH_METHOD, VT_VARIANT, (void*)&result, parms,
		v_1, v_2);
	return result;
}

void RSASig_Dispatch::setPublicKey(LPCTSTR v_3)
{
	static BYTE parms[] =
		VTS_BSTR;
	InvokeHelper(0x65, DISPATCH_METHOD, VT_EMPTY, NULL, parms,
		 v_3);
}

void RSASig_Dispatch::SetPrivateKey(LPCTSTR lpszNewValue)
{
	static BYTE parms[] =
		VTS_BSTR;
	InvokeHelper(0x66, DISPATCH_PROPERTYPUT, VT_EMPTY, NULL, parms,
		 lpszNewValue);
}

CString RSASig_Dispatch::GetPrivateKey()
{
	CString result;
	InvokeHelper(0x66, DISPATCH_PROPERTYGET, VT_BSTR, (void*)&result, NULL);
	return result;
}

long RSASig_Dispatch::hashCode()
{
	long result;
	InvokeHelper(0x67, DISPATCH_METHOD, VT_I4, (void*)&result, NULL);
	return result;
}

BOOL RSASig_Dispatch::generateKeys()
{
	BOOL result;
	InvokeHelper(0x68, DISPATCH_METHOD, VT_BOOL, (void*)&result, NULL);
	return result;
}

CString RSASig_Dispatch::generateSigature(LPCTSTR v_4)
{
	CString result;
	static BYTE parms[] =
		VTS_BSTR;
	InvokeHelper(0x69, DISPATCH_METHOD, VT_BSTR, (void*)&result, parms,
		v_4);
	return result;
}

CString RSASig_Dispatch::strGenerateKeys()
{
	CString result;
	InvokeHelper(0x6a, DISPATCH_METHOD, VT_BSTR, (void*)&result, NULL);
	return result;
}

CString RSASig_Dispatch::testVerifyString(LPCTSTR v_5, LPCTSTR v_6)
{
	CString result;
	static BYTE parms[] =
		VTS_BSTR VTS_BSTR;
	InvokeHelper(0x6b, DISPATCH_METHOD, VT_BSTR, (void*)&result, parms,
		v_5, v_6);
	return result;
}

CString RSASig_Dispatch::toString()
{
	CString result;
	InvokeHelper(0x6c, DISPATCH_METHOD, VT_BSTR, (void*)&result, NULL);
	return result;
}

BOOL RSASig_Dispatch::equals(LPDISPATCH v_7)
{
	BOOL result;
	static BYTE parms[] =
		VTS_DISPATCH;
	InvokeHelper(0x6d, DISPATCH_METHOD, VT_BOOL, (void*)&result, parms,
		v_7);
	return result;
}

CString RSASig_Dispatch::getPublicKey()
{
	CString result;
	InvokeHelper(0x6e, DISPATCH_METHOD, VT_BSTR, (void*)&result, NULL);
	return result;
}

BOOL RSASig_Dispatch::verifySigature(LPCTSTR v_8, LPCTSTR v_9)
{
	BOOL result;
	static BYTE parms[] =
		VTS_BSTR VTS_BSTR;
	InvokeHelper(0x6f, DISPATCH_METHOD, VT_BOOL, (void*)&result, parms,
		v_8, v_9);
	return result;
}

CString RSASig_Dispatch::StringVerifySigature(LPCTSTR v_10, LPCTSTR v_11)
{
	CString result;
	static BYTE parms[] =
		VTS_BSTR VTS_BSTR;
	InvokeHelper(0x70, DISPATCH_METHOD, VT_BSTR, (void*)&result, parms,
		v_10, v_11);
	return result;
}

void RSASig_Dispatch::notify()
{
	InvokeHelper(0x71, DISPATCH_METHOD, VT_EMPTY, NULL, NULL);
}

LPDISPATCH RSASig_Dispatch::getClass()
{
	LPDISPATCH result;
	InvokeHelper(0x72, DISPATCH_METHOD, VT_DISPATCH, (void*)&result, NULL);
	return result;
}

void RSASig_Dispatch::notifyAll()
{
	InvokeHelper(0x73, DISPATCH_METHOD, VT_EMPTY, NULL, NULL);
}

void RSASig_Dispatch::setPrivateKey(LPCTSTR v_12)
{
	static BYTE parms[] =
		VTS_BSTR;
	InvokeHelper(0x74, DISPATCH_METHOD, VT_EMPTY, NULL, parms,
		 v_12);
}

void RSASig_Dispatch::SetPublicKey(LPCTSTR lpszNewValue)
{
	static BYTE parms[] =
		VTS_BSTR;
	InvokeHelper(0x75, DISPATCH_PROPERTYPUT, VT_EMPTY, NULL, parms,
		 lpszNewValue);
}

CString RSASig_Dispatch::GetPublicKey()
{
	CString result;
	InvokeHelper(0x75, DISPATCH_PROPERTYGET, VT_BSTR, (void*)&result, NULL);
	return result;
}

CString RSASig_Dispatch::getPrivateKey()
{
	CString result;
	InvokeHelper(0x76, DISPATCH_METHOD, VT_BSTR, (void*)&result, NULL);
	return result;
}
