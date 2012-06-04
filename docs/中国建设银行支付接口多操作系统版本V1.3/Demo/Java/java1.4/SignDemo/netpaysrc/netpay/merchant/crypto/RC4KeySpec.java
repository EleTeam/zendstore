// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   RC4KeySpec.java

package netpay.merchant.crypto;

import java.security.InvalidKeyException;
import java.security.spec.KeySpec;

public class RC4KeySpec
    implements KeySpec
{

    public static final String ident = "$Id: RC4KeySpec.java,v 1.4 1998/10/05 05:47:56 dgh Exp $";
    private byte rc4Key[];

    public RC4KeySpec(byte abyte0[])
        throws InvalidKeyException
    {
        this(abyte0, 0, 16);
    }

    public RC4KeySpec(byte abyte0[], int i)
        throws InvalidKeyException
    {
        this(abyte0, 0, i);
    }

    public RC4KeySpec(byte abyte0[], int i, int j)
        throws InvalidKeyException
    {
        if(abyte0.length - i < j)
        {
            throw new InvalidKeyException("Key too short");
        } else
        {
            rc4Key = new byte[j];
            System.arraycopy(abyte0, i, rc4Key, 0, j);
            return;
        }
    }

    public byte[] getKey()
    {
        return rc4Key;
    }
}
