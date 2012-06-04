// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   RSAPubKey.java

package netpay.merchant.crypto;

import java.io.*;
import java.math.BigInteger;
import java.security.interfaces.RSAPublicKey;

// Referenced classes of package netpay.merchant.crypto:
//            DER

public class RSAPubKey
    implements RSAPublicKey
{

    public static final String ident = "$Id: RSAPubKey.java,v 1.9 1999/02/02 00:56:35 leachbj Exp $";
    protected BigInteger exponent;
    protected BigInteger modulus;

    public RSAPubKey()
    {
    }

    public RSAPubKey(BigInteger biginteger, BigInteger biginteger1)
    {
        modulus = biginteger;
        exponent = biginteger1;
    }

    public RSAPubKey(byte abyte0[])
    {
        x509Decode(abyte0);
    }

    public String getAlgorithm()
    {
        return "RSA";
    }

    public byte[] getEncoded()
    {
        return x509Encode();
    }

    public String getFormat()
    {
        return "X.509";
    }

    public BigInteger getModulus()
    {
        return modulus;
    }

    public BigInteger getPublicExponent()
    {
        return exponent;
    }

    public String toString()
    {
        return modulus.toString(16) + "." + exponent.toString(16);
    }

    private void x509Decode(byte abyte0[])
    {
        ByteArrayInputStream bytearrayinputstream = new ByteArrayInputStream(abyte0);
        try
        {
            DER.readTag(bytearrayinputstream);
            DER.readLen(bytearrayinputstream);
            bytearrayinputstream.skip(DER.rsaEncryptionAlgorithmIdentifier.length);
            DER.readTag(bytearrayinputstream);
            DER.readLen(bytearrayinputstream);
            bytearrayinputstream.skip(1L);
            DER.readTag(bytearrayinputstream);
            DER.readLen(bytearrayinputstream);
            modulus = DER.readDERint(bytearrayinputstream);
            exponent = DER.readDERint(bytearrayinputstream);
        }
        catch(IOException ioexception)
        {
            ioexception.printStackTrace();
            throw new ExceptionInInitializerError(ioexception);
        }
    }

    private byte[] x509Encode()
    {
        ByteArrayOutputStream bytearrayoutputstream;
        bytearrayoutputstream = new ByteArrayOutputStream();
        DER.writeDERint(bytearrayoutputstream, modulus);
        DER.writeDERint(bytearrayoutputstream, exponent);
        byte abyte0[] = bytearrayoutputstream.toByteArray();
        bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(DER.SEQUENCE | DER.CONSTRUCTED);
        DER.writeDERlen(bytearrayoutputstream, abyte0.length);
        bytearrayoutputstream.write(abyte0);
        byte abyte1[] = bytearrayoutputstream.toByteArray();
        bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(DER.BIT_STRING);
        DER.writeDERlen(bytearrayoutputstream, abyte1.length + 1);
        bytearrayoutputstream.write(0);
        bytearrayoutputstream.write(abyte1);
        byte abyte2[] = bytearrayoutputstream.toByteArray();
        bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(DER.SEQUENCE | DER.CONSTRUCTED);
        DER.writeDERlen(bytearrayoutputstream, DER.rsaEncryptionAlgorithmIdentifier.length + abyte2.length);
        bytearrayoutputstream.write(DER.rsaEncryptionAlgorithmIdentifier);
        bytearrayoutputstream.write(abyte2);
        return bytearrayoutputstream.toByteArray();
        IOException ioexception;
        ioexception;
        ioexception.printStackTrace();
        throw new ExceptionInInitializerError(ioexception);
    }
}
