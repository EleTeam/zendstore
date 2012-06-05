// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   DER.java

package netpay.merchant.crypto;

import java.io.*;
import java.math.BigInteger;

class DER
{

    static int INTEGER = 2;
    static int BIT_STRING = 3;
    static int OCTET_STRING = 4;
    static int SEQUENCE = 16;
    static int CONSTRUCTED = 32;
    static byte version[] = {
        2, 1, 0
    };
    static byte rsaEncryptionAlgorithmIdentifier[] = {
        48, 13, 6, 9, 42, -122, 72, -122, -9, 13, 
        1, 1, 1, 5, 0
    };

    DER()
    {
    }

    static BigInteger readDERint(InputStream inputstream)
        throws IOException
    {
        DataInputStream datainputstream = new DataInputStream(inputstream);
        int i = readTag(datainputstream);
        int j = readLen(datainputstream);
        if(i != INTEGER)
            throw new RuntimeException("Expecting tag[0x02] got " + Integer.toHexString(i));
        if(j > 5096)
        {
            throw new RuntimeException("Length value seems a little big " + Integer.toHexString(j));
        } else
        {
            byte abyte0[] = new byte[j];
            datainputstream.readFully(abyte0);
            return new BigInteger(abyte0);
        }
    }

    static int readLen(InputStream inputstream)
        throws IOException
    {
        int i = inputstream.read();
        if(i > 127)
        {
            int j = 0;
            i ^= 0x80;
            for(int k = 0; k < i; k++)
                j = j * 256 + inputstream.read();

            i = j;
        }
        return i;
    }

    static int readTag(InputStream inputstream)
        throws IOException
    {
        return inputstream.read();
    }

    static int writeDERint(OutputStream outputstream, BigInteger biginteger)
        throws IOException
    {
        byte abyte0[] = biginteger.toByteArray();
        int i = abyte0.length + 1;
        outputstream.write(INTEGER);
        i += writeDERlen(outputstream, abyte0.length);
        outputstream.write(abyte0);
        return i;
    }

    static int writeDERlen(OutputStream outputstream, int i)
        throws IOException
    {
        if(i > 127)
        {
            byte byte0 = 1;
            if(i >= 256)
                byte0 = 2;
            else
            if(i >= 0x10000)
                byte0 = 3;
            else
            if(i >= 0x1000000)
                byte0 = 4;
            outputstream.write((byte)(byte0 | 0x80));
            for(int j = (byte0 - 1) * 8; j >= 0; j -= 8)
            {
                int k = i >> j;
                outputstream.write((byte)k);
            }

            return byte0;
        } else
        {
            outputstream.write((byte)i);
            return 1;
        }
    }

}
