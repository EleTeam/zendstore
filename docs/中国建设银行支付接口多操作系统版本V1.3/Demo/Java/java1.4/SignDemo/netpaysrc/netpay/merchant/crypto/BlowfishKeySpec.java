// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   BlowfishKeySpec.java

package netpay.merchant.crypto;

import java.security.InvalidKeyException;
import java.security.spec.KeySpec;

public class BlowfishKeySpec
    implements KeySpec
{

    public static final String ident = "$Id: BlowfishKeySpec.java,v 1.3 1998/10/05 05:47:54 dgh Exp $";
    private byte bfKey[];
    private static int MAXBFKEY_LENGTH = 56;
    private static int MINBFKEY_LENGTH = 16;

    public BlowfishKeySpec(byte abyte0[])
        throws InvalidKeyException
    {
        this(abyte0, 0);
    }

    public BlowfishKeySpec(byte abyte0[], int i)
        throws InvalidKeyException
    {
        int j = abyte0.length - i;
        if(j < MINBFKEY_LENGTH)
            throw new InvalidKeyException("Key too short (min " + MINBFKEY_LENGTH + " bytes)");
        if(j > MAXBFKEY_LENGTH)
            j = MAXBFKEY_LENGTH;
        bfKey = new byte[j];
        System.arraycopy(abyte0, i, bfKey, 0, j);
    }

    public byte[] getKey()
    {
        return bfKey;
    }

}
