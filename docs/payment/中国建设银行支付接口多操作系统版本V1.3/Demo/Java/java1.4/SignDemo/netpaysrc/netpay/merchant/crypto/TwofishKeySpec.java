// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   TwofishKeySpec.java

package netpay.merchant.crypto;

import java.security.InvalidKeyException;
import java.security.spec.KeySpec;

public class TwofishKeySpec
    implements KeySpec
{

    public static final String ident = "$Id: TwofishKeySpec.java,v 1.1 1998/10/13 07:57:50 leachbj Exp $";
    private byte tfKey[];
    private static int MAXTFKEY_LENGTH = 32;

    public TwofishKeySpec(byte abyte0[])
        throws InvalidKeyException
    {
        this(abyte0, 0);
    }

    public TwofishKeySpec(byte abyte0[], int i)
        throws InvalidKeyException
    {
        int j = abyte0.length - i;
        if(j > MAXTFKEY_LENGTH)
            j = MAXTFKEY_LENGTH;
        tfKey = new byte[j];
        System.arraycopy(abyte0, i, tfKey, 0, j);
    }

    public byte[] getKey()
    {
        return tfKey;
    }

}
