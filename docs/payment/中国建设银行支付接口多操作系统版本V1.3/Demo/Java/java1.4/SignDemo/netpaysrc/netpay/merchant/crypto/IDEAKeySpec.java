// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   IDEAKeySpec.java

package netpay.merchant.crypto;

import java.security.InvalidKeyException;
import java.security.spec.KeySpec;

public class IDEAKeySpec
    implements KeySpec
{

    public static final String ident = "$Id: IDEAKeySpec.java,v 1.4 1998/10/05 05:47:55 dgh Exp $";
    private byte ideaKey[];
    public static final int IDEA_KEY_LEN = 16;

    public IDEAKeySpec(byte abyte0[])
        throws InvalidKeyException
    {
        this(abyte0, 0);
    }

    public IDEAKeySpec(byte abyte0[], int i)
        throws InvalidKeyException
    {
        if(abyte0.length - i < 16)
        {
            throw new InvalidKeyException("Key too short");
        } else
        {
            ideaKey = new byte[16];
            System.arraycopy(abyte0, i, ideaKey, 0, 16);
            return;
        }
    }

    public byte[] getKey()
    {
        return ideaKey;
    }
}
