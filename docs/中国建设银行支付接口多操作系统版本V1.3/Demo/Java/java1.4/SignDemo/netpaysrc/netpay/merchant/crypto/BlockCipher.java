// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   BlockCipher.java

package netpay.merchant.crypto;

import java.security.*;
import java.security.spec.AlgorithmParameterSpec;
import javax.crypto.*;
import javax.crypto.spec.IvParameterSpec;

// Referenced classes of package netpay.merchant.crypto:
//            InlineIvParameterSpec

public abstract class BlockCipher extends CipherSpi
{

    public static final String ident = "$Id: BlockCipher.java,v 1.25 1999/02/11 04:28:32 leachbj Exp $";
    protected static final int BLOCK_SIZE = 8;
    protected static final int ECB = 0;
    protected static final int CBC = 1;
    protected byte buffer[];
    protected int bufferPos;
    protected int mode;
    protected boolean paddedStream;
    protected int streamMode;
    protected byte ivec[];
    protected byte cbcV[];
    protected boolean ivInline;
    protected boolean ivEncrypted;
    protected boolean firstBlock;
    protected Key key;
    protected SecureRandom random;
    static Class class$javax$crypto$spec$IvParameterSpec;
    static Class class$au$net$aba$crypto$spec$InlineIvParameterSpec;

    public BlockCipher()
    {
        paddedStream = false;
        streamMode = 0;
    }

    static Class getClass(String s)
    {
        return Class.forName(s);
        ClassNotFoundException classnotfoundexception;
        classnotfoundexception;
        throw new NoClassDefFoundError(classnotfoundexception.getMessage());
    }

    protected abstract int decryptBlock(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws BadPaddingException;

    protected abstract int encryptBlock(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws IllegalBlockSizeException;

    protected byte[] engineDoFinal(byte abyte0[], int i, int j)
        throws IllegalBlockSizeException, BadPaddingException
    {
        byte abyte1[] = new byte[engineGetOutputSize(j)];
        try
        {
            int k = engineDoFinal(abyte0, i, j, abyte1, 0);
            if(k != abyte1.length)
            {
                byte abyte2[] = new byte[k];
                System.arraycopy(abyte1, 0, abyte2, 0, k);
                abyte1 = abyte2;
            }
        }
        catch(ShortBufferException shortbufferexception)
        {
            throw new BadPaddingException("ShortBufferException: " + shortbufferexception.getMessage());
        }
        return abyte1;
    }

    protected int engineDoFinal(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws ShortBufferException, IllegalBlockSizeException, BadPaddingException
    {
        int l = engineGetBlockSize();
        int i1 = processAllBlocks(abyte0, i, j, abyte1, k);
        k += i1;
        if(mode == 1)
        {
            if(bufferPos == l)
            {
                int j1 = processBlock(buffer, 0, l, abyte1, k);
                k += j1;
                i1 += j1;
                bufferPos = 0;
            }
            if(paddedStream)
            {
                int k1 = l - bufferPos;
                for(; bufferPos < l; bufferPos++)
                    buffer[bufferPos] = (byte)k1;

            }
            if(bufferPos > 0)
            {
                i1 += processBlock(buffer, 0, bufferPos, abyte1, k);
                bufferPos = 0;
            }
        } else
        if(mode == 2)
        {
            if(bufferPos > 0)
                if(bufferPos == l)
                {
                    i1 += processBlock(buffer, 0, l, abyte1, k);
                    bufferPos = 0;
                } else
                {
                    throw new IllegalBlockSizeException("input truncated.");
                }
            if(paddedStream)
            {
                int l1 = abyte1[(k + l) - 1] & 0xff;
                i1 -= l1;
            }
        }
        reset();
        return i1;
    }

    protected int engineGetBlockSize()
    {
        return 8;
    }

    protected byte[] engineGetIV()
    {
        if(ivec != null)
        {
            int i = engineGetBlockSize();
            byte abyte0[] = new byte[i];
            System.arraycopy(ivec, 0, abyte0, 0, i);
            return abyte0;
        } else
        {
            return null;
        }
    }

    protected int engineGetOutputSize(int i)
    {
        int j = engineGetBlockSize();
        if(firstBlock && ivInline)
            if(mode == 1)
                i += j;
            else
            if(mode == 2)
                i -= j;
        i += bufferPos;
        if(paddedStream)
        {
            if(i % j == 0)
                i += j;
            return (((i + j) - 1) / j) * j;
        } else
        {
            return (i / j) * j;
        }
    }

    protected AlgorithmParameters engineGetParameters()
    {
        return null;
    }

    protected void engineInit(int i, Key key1, AlgorithmParameters algorithmparameters, SecureRandom securerandom)
        throws InvalidKeyException, InvalidAlgorithmParameterException
    {
        AlgorithmParameterSpec algorithmparameterspec = null;
        if(algorithmparameters != null)
            try
            {
                algorithmparameterspec = algorithmparameters.getParameterSpec(class$javax$crypto$spec$IvParameterSpec != null ? class$javax$crypto$spec$IvParameterSpec : (class$javax$crypto$spec$IvParameterSpec = getClass("javax.crypto.spec.IvParameterSpec")));
            }
            catch(Exception _ex)
            {
                try
                {
                    algorithmparameterspec = algorithmparameters.getParameterSpec(class$au$net$aba$crypto$spec$InlineIvParameterSpec != null ? class$au$net$aba$crypto$spec$InlineIvParameterSpec : (class$au$net$aba$crypto$spec$InlineIvParameterSpec = getClass("netpay.merchant.crypto.InlineIvParameterSpec")));
                }
                catch(Exception exception)
                {
                    throw new InvalidAlgorithmParameterException("Processing error: " + exception);
                }
            }
        engineInit(i, key1, algorithmparameterspec, securerandom);
    }

    protected void engineInit(int i, Key key1, SecureRandom securerandom)
        throws InvalidKeyException
    {
        try
        {
            engineInit(i, key1, (AlgorithmParameterSpec)null, securerandom);
        }
        catch(InvalidAlgorithmParameterException invalidalgorithmparameterexception)
        {
            throw new InvalidKeyException("InvalidAlgorithmParameterException: " + invalidalgorithmparameterexception.getMessage());
        }
    }

    protected void engineInit(int i, Key key1, AlgorithmParameterSpec algorithmparameterspec, SecureRandom securerandom)
        throws InvalidKeyException, InvalidAlgorithmParameterException
    {
        reset();
        mode = i;
        random = securerandom;
        key = key1;
        if(streamMode == 1)
        {
            int j = engineGetBlockSize();
            ivec = new byte[j];
            cbcV = new byte[j];
            if(algorithmparameterspec instanceof IvParameterSpec)
            {
                System.arraycopy(((IvParameterSpec)algorithmparameterspec).getIV(), 0, ivec, 0, j);
            } else
            {
                if(algorithmparameterspec instanceof InlineIvParameterSpec)
                {
                    ivInline = true;
                    firstBlock = true;
                    ivEncrypted = ((InlineIvParameterSpec)algorithmparameterspec).isEncryptedIv();
                }
                securerandom.nextBytes(ivec);
            }
            System.arraycopy(ivec, 0, cbcV, 0, j);
        }
        setKey(key1);
    }

    protected void engineSetMode(String s)
        throws NoSuchAlgorithmException
    {
        if(s.equals("ECB"))
            streamMode = 0;
        else
        if(s.equals("CBC"))
            streamMode = 1;
        else
            throw new NoSuchAlgorithmException("Mode " + s + " not supported.");
    }

    protected void engineSetPadding(String s)
        throws NoSuchPaddingException
    {
        if(s.equals("PKCS5Padding"))
            paddedStream = true;
        else
        if(s.equals("NoPadding"))
            paddedStream = false;
        else
            throw new NoSuchPaddingException("Unsupported padding " + s);
    }

    protected byte[] engineUpdate(byte abyte0[], int i, int j)
    {
        byte abyte1[] = null;
        int k = engineGetOutputSize(j);
        if(k != 0)
            abyte1 = new byte[k];
        try
        {
            k = engineUpdate(abyte0, i, j, abyte1, 0);
        }
        catch(ShortBufferException shortbufferexception)
        {
            shortbufferexception.printStackTrace();
            throw new RuntimeException("ShortBufferException: " + shortbufferexception.getMessage());
        }
        if(abyte1 != null && k != abyte1.length)
        {
            byte abyte2[] = new byte[k];
            System.arraycopy(abyte1, 0, abyte2, 0, k);
            abyte1 = abyte2;
        }
        return abyte1;
    }

    protected int engineUpdate(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws ShortBufferException
    {
        return processAllBlocks(abyte0, i, j, abyte1, k);
        BadPaddingException badpaddingexception;
        badpaddingexception;
        badpaddingexception.printStackTrace();
        break MISSING_BLOCK_LABEL_29;
        IllegalBlockSizeException illegalblocksizeexception;
        illegalblocksizeexception;
        illegalblocksizeexception.printStackTrace();
        throw new ShortBufferException("Internal error, see stacktrace on console.");
    }

    private int processAllBlocks(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws BadPaddingException, IllegalBlockSizeException
    {
        int l = engineGetBlockSize();
        int i1 = 0;
        if(j < l - bufferPos)
        {
            if(j > 0)
            {
                System.arraycopy(abyte0, i, buffer, bufferPos, j);
                bufferPos += j;
            }
            return 0;
        }
        if(j == l - bufferPos)
        {
            if(j > 0)
                System.arraycopy(abyte0, i, buffer, bufferPos, j);
            if(paddedStream)
            {
                bufferPos += j;
                return 0;
            } else
            {
                i1 = processBlock(buffer, 0, l, abyte1, k);
                bufferPos = 0;
                return i1;
            }
        }
        int j1 = l - bufferPos;
        System.arraycopy(abyte0, i, buffer, bufferPos, j1);
        i1 = processBlock(buffer, 0, l, abyte1, k);
        j -= j1;
        i += j1;
        k += i1;
        bufferPos = 0;
        j1 = ((j + l) - 1) / l;
        int k1 = j % l;
        for(int l1 = 0; l1 < j1 - 1; l1++)
        {
            int i2 = processBlock(abyte0, i, l, abyte1, k);
            i += l;
            k += i2;
            i1 += i2;
        }

        if(k1 == 0)
        {
            if(paddedStream)
            {
                System.arraycopy(abyte0, i, buffer, 0, l);
                bufferPos = l;
            } else
            {
                int j2 = processBlock(abyte0, i, l, abyte1, k);
                k += j2;
                i1 += j2;
                bufferPos = 0;
            }
        } else
        {
            System.arraycopy(abyte0, i, buffer, 0, k1);
            bufferPos = k1;
        }
        return i1;
    }

    private int processBlock(byte abyte0[], int i, int j, byte abyte1[], int k)
        throws BadPaddingException, IllegalBlockSizeException
    {
        int l = engineGetBlockSize();
        int i1 = 0;
        if(firstBlock && ivInline)
        {
            firstBlock = false;
            if(mode == 1)
            {
                int j1;
                if(ivEncrypted)
                {
                    j1 = encryptBlock(ivec, 0, l, abyte1, k);
                } else
                {
                    System.arraycopy(ivec, 0, abyte1, k, l);
                    j1 = l;
                }
                k += j1;
                i1 += j1;
            } else
            {
                if(ivEncrypted)
                    decryptBlock(abyte0, i, j, ivec, 0);
                else
                    System.arraycopy(abyte0, i, ivec, 0, l);
                System.arraycopy(ivec, 0, cbcV, 0, l);
                return 0;
            }
        }
        if(mode == 1)
        {
            if(streamMode == 1)
            {
                for(int k1 = 0; k1 < l; k1++)
                    cbcV[k1] ^= abyte0[i + k1];

                abyte0 = cbcV;
                i = 0;
            }
            i1 += encryptBlock(abyte0, i, j, abyte1, k);
            if(streamMode == 1)
                System.arraycopy(abyte1, k, cbcV, 0, l);
        } else
        {
            i1 += decryptBlock(abyte0, i, j, abyte1, k);
            if(streamMode == 1)
            {
                for(int l1 = 0; l1 < l; l1++)
                    abyte1[k + l1] ^= cbcV[l1];

                System.arraycopy(abyte0, i, cbcV, 0, l);
            }
        }
        return i1;
    }

    protected void reset()
    {
        if(buffer != null)
        {
            for(int i = 0; i < buffer.length; i++)
                buffer[0] = 0;

            buffer = null;
        }
        if(ivec != null)
            System.arraycopy(ivec, 0, cbcV, 0, engineGetBlockSize());
        if(key != null)
            try
            {
                setKey(key);
            }
            catch(InvalidKeyException _ex) { }
        buffer = new byte[engineGetBlockSize()];
        bufferPos = 0;
        firstBlock = ivInline;
    }

    protected abstract void setKey(Key key1)
        throws InvalidKeyException;
}
