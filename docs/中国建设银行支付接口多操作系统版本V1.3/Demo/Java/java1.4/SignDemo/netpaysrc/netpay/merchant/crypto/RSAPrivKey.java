// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   RSAPrivKey.java

package netpay.merchant.crypto;

import java.math.BigInteger;
import java.security.interfaces.RSAPrivateKey;

public class RSAPrivKey
    implements RSAPrivateKey
{

    public static final String ident = "$Id: RSAPrivKey.java,v 1.6 1999/01/24 23:03:51 leachbj Exp $";
    protected BigInteger modulus;
    protected BigInteger d;

    public RSAPrivKey()
    {
    }

    public RSAPrivKey(BigInteger biginteger, BigInteger biginteger1)
    {
        modulus = biginteger;
        d = biginteger1;
    }

    public String getAlgorithm()
    {
        return "RSA";
    }

    public byte[] getEncoded()
    {
        return toString().getBytes();
    }

    public String getFormat()
    {
        return "ASCII";
    }

    public BigInteger getModulus()
    {
        return modulus;
    }

    public BigInteger getPrivateExponent()
    {
        return d;
    }

    public String toString()
    {
        return modulus.toString(16) + "." + d.toString(16);
    }
}
