// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   MD5withRSA.java

package netpay.merchant.crypto;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.security.*;

// Referenced classes of package netpay.merchant.crypto:
//            RSA

public class MD5withRSA extends Signature
{

    private MessageDigest md5Digest;
    private RSA rsaCipher;
    private static final SecureRandom rand = new SecureRandom();
    private static final byte md5DigestInfo[] = {
        48, 32
    };
    private static final byte md5Identifier[] = {
        48, 12
    };
    private static final byte id_md5[] = {
        6, 8, 42, -122, 72, -122, -9, 13, 2, 5
    };
    private static final byte NULL[] = {
        5, 0
    };
    private static final byte digestHdr[] = {
        4, 16
    };

    public MD5withRSA()
    {
        super("MD5withRSA");
        try
        {
            md5Digest = MessageDigest.getInstance("MD5", "ABA");
            rsaCipher = new RSA();
        }
        catch(Exception exception)
        {
            throw new ExceptionInInitializerError(exception);
        }
    }

    private byte[] encodeDigest(byte abyte0[])
        throws IOException
    {
        ByteArrayOutputStream bytearrayoutputstream = new ByteArrayOutputStream();
        bytearrayoutputstream.write(md5DigestInfo);
        bytearrayoutputstream.write(md5Identifier);
        bytearrayoutputstream.write(id_md5);
        bytearrayoutputstream.write(NULL);
        bytearrayoutputstream.write(digestHdr);
        bytearrayoutputstream.write(abyte0);
        return bytearrayoutputstream.toByteArray();
    }

    protected Object engineGetParameter(String s)
        throws InvalidParameterException
    {
        throw new InvalidParameterException("The parameter " + s + " is invalid for this algorithm.");
    }

    protected void engineInitSign(PrivateKey privatekey)
        throws InvalidKeyException
    {
        md5Digest.reset();
        rsaCipher.engineInit(1, privatekey, rand);
    }

    protected void engineInitVerify(PublicKey publickey)
        throws InvalidKeyException
    {
        md5Digest.reset();
        rsaCipher.engineInit(2, publickey, rand);
    }

    protected void engineSetParameter(String s, Object obj)
        throws InvalidParameterException
    {
        throw new InvalidParameterException("The parameter " + s + " is invalid for this algorithm.");
    }

    protected byte[] engineSign()
        throws SignatureException
    {
        byte abyte0[] = md5Digest.digest();
        byte abyte2[];
        byte abyte1[] = encodeDigest(abyte0);
        abyte2 = rsaCipher.engineDoFinal(abyte1, 0, abyte1.length);
        return abyte2;
        Exception exception;
        exception;
        throw new SignatureException(exception.getMessage());
    }

    protected void engineUpdate(byte byte0)
        throws SignatureException
    {
        md5Digest.update(byte0);
    }

    protected void engineUpdate(byte abyte0[], int i, int j)
        throws SignatureException
    {
        md5Digest.update(abyte0, i, j);
    }

    protected boolean engineVerify(byte abyte0[])
        throws SignatureException
    {
        byte abyte1[] = md5Digest.digest();
        byte abyte2[];
        byte abyte3[];
        abyte2 = rsaCipher.engineDoFinal(abyte0, 0, abyte0.length);
        abyte3 = encodeDigest(abyte1);
        if(abyte2.length != abyte3.length)
            return false;
        int i = 0;
_L1:
        if(i >= abyte2.length)
            break MISSING_BLOCK_LABEL_67;
        if(abyte2[i] != abyte3[i])
            return false;
        i++;
          goto _L1
        return true;
        Exception exception;
        exception;
        throw new SignatureException(exception.getMessage());
    }

}
