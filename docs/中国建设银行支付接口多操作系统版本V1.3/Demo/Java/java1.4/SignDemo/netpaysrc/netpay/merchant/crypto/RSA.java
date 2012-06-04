// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   RSA.java

package netpay.merchant.crypto;

import java.math.BigInteger;
import java.security.*;
import java.security.interfaces.*;
import javax.crypto.*;

// Referenced classes of package netpay.merchant.crypto:
//            BlockCipher

public class RSA extends BlockCipher
{

    public static final String ident = "$Id: RSA.java,v 1.25 1999/01/22 06:28:03 leachbj Exp $";
    private static final int HEADER_SIZE = 11;
    private RSAPublicKey rsaPublicKey;
    private RSAPrivateKey rsaPrivateKey;
    private int significantBytes;
    private boolean padded;
    private static final int BITS_IN_BYTE = 8;

    public RSA()
    {
        significantBytes = 11;
        padded = true;
        paddedStream = false;
    }

    private BigInteger crtProcess(BigInteger biginteger)
    {
        RSAPrivateCrtKey rsaprivatecrtkey = (RSAPrivateCrtKey)rsaPrivateKey;
        BigInteger biginteger1 = rsaprivatecrtkey.getPrivateExponent();
        BigInteger biginteger2 = rsaprivatecrtkey.getPrimeP();
        BigInteger biginteger3 = rsaprivatecrtkey.getPrimeQ();
        BigInteger biginteger4 = rsaprivatecrtkey.getPrimeExponentP();
        BigInteger biginteger5 = rsaprivatecrtkey.getPrimeExponentQ();
        BigInteger biginteger6 = rsaprivatecrtkey.getCrtCoefficient();
        BigInteger biginteger7 = biginteger.remainder(biginteger2).modPow(biginteger4, biginteger2);
        BigInteger biginteger8 = biginteger.remainder(biginteger3).modPow(biginteger5, biginteger3);
        BigInteger biginteger9;
        if(biginteger7.compareTo(biginteger8) >= 0)
            biginteger9 = biginteger7.subtract(biginteger8);
        else
            biginteger9 = biginteger2.subtract(biginteger8.subtract(biginteger7));
        biginteger9 = biginteger9.multiply(biginteger6);
        biginteger9 = biginteger9.remainder(biginteger2);
        biginteger9 = biginteger9.multiply(biginteger3);
        biginteger9 = biginteger9.add(biginteger8);
        return biginteger9;
    }

    private BigInteger decrypt(BigInteger biginteger)
    {
        if(rsaPrivateKey instanceof RSAPrivateCrtKey)
            return crtProcess(biginteger);
        BigInteger biginteger1 = null;
        BigInteger biginteger2 = null;
        if(rsaPrivateKey != null)
        {
            biginteger1 = rsaPrivateKey.getPrivateExponent();
            biginteger2 = rsaPrivateKey.getModulus();
        } else
        {
            biginteger1 = rsaPublicKey.getPublicExponent();
            biginteger2 = rsaPublicKey.getModulus();
        }
        return biginteger.modPow(biginteger1, biginteger2);
    }

    private byte[] decrypt(byte abyte0[])
    {
        BigInteger biginteger = new BigInteger(1, abyte0);
        biginteger = decrypt(biginteger);
        return biginteger.toByteArray();
    }

    protected final int decryptBlock(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws BadPaddingException
    {
        byte abyte2[] = new byte[significantBytes];
        System.arraycopy(abyte0, i, abyte2, 0, abyte2.length);
        byte abyte3[] = decrypt(abyte2);
        int l = 0;
        if(padded)
        {
            if(abyte3[0] != 1 && abyte3[0] != 2)
                throw new BadPaddingException("Bad block type");
            for(l = 1; l != abyte3.length && abyte3[l] != 0; l++);
            l++;
        }
        int i1 = abyte3.length - l;
        if(i1 <= 0 || i1 > significantBytes - 11)
        {
            throw new BadPaddingException("Invalid PKCS1 block");
        } else
        {
            System.arraycopy(abyte3, l, abyte1, k, i1);
            return i1;
        }
    }

    protected BigInteger encrypt(BigInteger biginteger)
    {
        if(rsaPrivateKey instanceof RSAPrivateCrtKey)
            return crtProcess(biginteger);
        BigInteger biginteger1 = null;
        BigInteger biginteger2 = null;
        if(rsaPrivateKey != null)
        {
            biginteger1 = rsaPrivateKey.getPrivateExponent();
            biginteger2 = rsaPrivateKey.getModulus();
        } else
        {
            biginteger1 = rsaPublicKey.getPublicExponent();
            biginteger2 = rsaPublicKey.getModulus();
        }
        return biginteger.modPow(biginteger1, biginteger2);
    }

    private byte[] encrypt(byte abyte0[])
    {
        BigInteger biginteger = new BigInteger(1, abyte0);
        biginteger = encrypt(biginteger);
        return biginteger.toByteArray();
    }

    protected final int encryptBlock(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws IllegalBlockSizeException
    {
        if(j > significantBytes - 11)
            throw new IllegalBlockSizeException("Datasize greater than allowable payload size.");
        byte abyte2[] = new byte[significantBytes];
        if(padded)
        {
            if(rsaPrivateKey != null)
            {
                abyte2[0] = 0;
                abyte2[1] = 1;
                for(int l = 2; l != abyte2.length; l++)
                    abyte2[l] = -1;

            } else
            {
                random.nextBytes(abyte2);
                abyte2[0] = 0;
                abyte2[1] = 2;
                for(int i1 = 2; i1 != abyte2.length; i1++)
                    if(abyte2[i1] == 0)
                        abyte2[i1] = (byte)(0xff & ~i1);

            }
            abyte2[abyte2.length - j - 1] = 0;
        }
        System.arraycopy(abyte0, i, abyte2, abyte2.length - j, j);
        abyte2 = encrypt(abyte2);
        if(abyte2.length >= significantBytes)
        {
            System.arraycopy(abyte2, abyte2.length - significantBytes, abyte1, k, significantBytes);
        } else
        {
            int j1 = significantBytes - abyte2.length;
            for(int k1 = 0; k1 <= j1; k1++)
                abyte1[k + k1] = 0;

            System.arraycopy(abyte2, 0, abyte1, k + j1, abyte2.length);
        }
        return significantBytes;
    }

    protected int engineGetBlockSize()
    {
        if(mode == 2)
            return significantBytes;
        else
            return significantBytes - 11;
    }

    protected int engineGetOutputSize(int i)
    {
        int j = engineGetBlockSize();
        i += bufferPos;
        if(mode == 2)
            return (i / j) * (j - 11);
        else
            return (((i + j) - 1) / j) * significantBytes;
    }

    public void engineSetMode(String s)
        throws NoSuchAlgorithmException
    {
        if(!s.equals("ECB"))
            throw new NoSuchAlgorithmException("RSA only supports ECB.");
        else
            return;
    }

    public void engineSetPadding(String s)
        throws NoSuchPaddingException
    {
        if(s.equals("PKCS1Padding"))
            padded = true;
        else
        if(s.equals("NoPadding"))
            padded = false;
        else
            throw new NoSuchPaddingException("RSA only supports PKCS1.");
    }

    protected void setKey(Key key)
        throws InvalidKeyException
    {
        if(!(key instanceof RSAPrivateKey) && !(key instanceof RSAPublicKey))
            throw new InvalidKeyException("expecting RSAPrivateKey/RSAPrivateCrtKey/RSAPublicKey");
        int i = 0;
        if(key instanceof RSAPublicKey)
        {
            rsaPublicKey = (RSAPublicKey)key;
            rsaPrivateKey = null;
            i = rsaPublicKey.getModulus().bitLength();
        } else
        {
            rsaPrivateKey = (RSAPrivateKey)key;
            rsaPublicKey = null;
            i = rsaPrivateKey.getModulus().bitLength();
        }
        significantBytes = ((i + 8) - 1) / 8;
        buffer = new byte[engineGetBlockSize()];
    }
}
