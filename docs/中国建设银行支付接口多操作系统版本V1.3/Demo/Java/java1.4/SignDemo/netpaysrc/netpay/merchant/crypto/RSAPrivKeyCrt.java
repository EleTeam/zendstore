// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   RSAPrivKeyCrt.java

package netpay.merchant.crypto;

import java.io.*;
import java.math.BigInteger;
import java.security.interfaces.RSAPrivateCrtKey;

// Referenced classes of package netpay.merchant.crypto:
//            RSAPrivKey, DER

public class RSAPrivKeyCrt extends RSAPrivKey
    implements RSAPrivateCrtKey
{

    public static final String ident = "$Id: RSAPrivKeyCrt.java,v 1.7 1999/02/02 00:58:02 leachbj Exp $";
    protected BigInteger exponent;
    protected BigInteger p;
    protected BigInteger q;
    protected BigInteger qInv;
    protected BigInteger pMinus1;
    protected BigInteger qMinus1;
    protected BigInteger dP;
    protected BigInteger dQ;

    public RSAPrivKeyCrt()
    {
    }

    public RSAPrivKeyCrt(BigInteger biginteger, BigInteger biginteger1, BigInteger biginteger2, BigInteger biginteger3, BigInteger biginteger4, BigInteger biginteger5, BigInteger biginteger6, 
            BigInteger biginteger7)
    {
        super(biginteger, biginteger2);
        exponent = biginteger1;
        p = biginteger3;
        q = biginteger4;
        dP = biginteger5;
        dQ = biginteger6;
        qInv = biginteger7;
    }

    public RSAPrivKeyCrt(byte abyte0[])
    {
        pkcs8Decode(abyte0);
    }

    public BigInteger getCrtCoefficient()
    {
        return qInv;
    }

    public byte[] getEncoded()
    {
        return pkcs8Encode();
    }

    public String getFormat()
    {
        return "PKCS#8";
    }

    public BigInteger getPrimeExponentP()
    {
        return dP;
    }

    public BigInteger getPrimeExponentQ()
    {
        return dQ;
    }

    public BigInteger getPrimeP()
    {
        return p;
    }

    public BigInteger getPrimeQ()
    {
        return q;
    }

    public BigInteger getPublicExponent()
    {
        return exponent;
    }

    private void pkcs8Decode(byte abyte0[])
    {
        ByteArrayInputStream bytearrayinputstream = new ByteArrayInputStream(abyte0);
        try
        {
            int i = DER.readTag(bytearrayinputstream);
            int j = DER.readLen(bytearrayinputstream);
            bytearrayinputstream.skip(DER.version.length);
            bytearrayinputstream.skip(DER.rsaEncryptionAlgorithmIdentifier.length);
            i = DER.readTag(bytearrayinputstream);
            j = DER.readLen(bytearrayinputstream);
            i = DER.readTag(bytearrayinputstream);
            j = DER.readLen(bytearrayinputstream);
            bytearrayinputstream.skip(DER.version.length);
            modulus = DER.readDERint(bytearrayinputstream);
            exponent = DER.readDERint(bytearrayinputstream);
            d = DER.readDERint(bytearrayinputstream);
            p = DER.readDERint(bytearrayinputstream);
            q = DER.readDERint(bytearrayinputstream);
            dP = DER.readDERint(bytearrayinputstream);
            dQ = DER.readDERint(bytearrayinputstream);
            qInv = DER.readDERint(bytearrayinputstream);
        }
        catch(IOException ioexception)
        {
            ioexception.printStackTrace();
            throw new ExceptionInInitializerError(ioexception);
        }
    }

    private byte[] pkcs8Encode()
    {
        ByteArrayOutputStream bytearrayoutputstream;
        bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(DER.version);
        DER.writeDERint(bytearrayoutputstream, modulus);
        DER.writeDERint(bytearrayoutputstream, exponent);
        DER.writeDERint(bytearrayoutputstream, d);
        DER.writeDERint(bytearrayoutputstream, p);
        DER.writeDERint(bytearrayoutputstream, q);
        DER.writeDERint(bytearrayoutputstream, dP);
        DER.writeDERint(bytearrayoutputstream, dQ);
        DER.writeDERint(bytearrayoutputstream, qInv);
        byte abyte0[] = bytearrayoutputstream.toByteArray();
        bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(DER.SEQUENCE | DER.CONSTRUCTED);
        DER.writeDERlen(bytearrayoutputstream, abyte0.length);
        bytearrayoutputstream.write(abyte0);
        abyte0 = bytearrayoutputstream.toByteArray();
        bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(DER.version);
        bytearrayoutputstream.write(DER.rsaEncryptionAlgorithmIdentifier);
        bytearrayoutputstream.write(DER.OCTET_STRING);
        DER.writeDERlen(bytearrayoutputstream, abyte0.length);
        bytearrayoutputstream.write(abyte0);
        byte abyte1[] = bytearrayoutputstream.toByteArray();
        bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(DER.SEQUENCE | DER.CONSTRUCTED);
        DER.writeDERlen(bytearrayoutputstream, abyte1.length);
        bytearrayoutputstream.write(abyte1);
        return bytearrayoutputstream.toByteArray();
        IOException ioexception;
        ioexception;
        ioexception.printStackTrace();
        throw new ExceptionInInitializerError(ioexception);
    }

    public String toString()
    {
        return modulus.toString(16) + "." + exponent.toString(16) + "." + d.toString(16) + "." + p.toString(16) + "." + q.toString(16) + "." + dP.toString(16) + "." + dQ.toString(16) + "." + qInv.toString(16);
    }
}
