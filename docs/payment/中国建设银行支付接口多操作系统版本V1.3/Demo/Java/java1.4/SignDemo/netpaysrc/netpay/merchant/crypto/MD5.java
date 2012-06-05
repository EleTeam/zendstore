// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   MD5.java

package netpay.merchant.crypto;

import java.security.MessageDigest;

public class MD5 extends MessageDigest
{

    public static final String ident = "$Id: MD5.java,v 1.5 1998/10/05 05:46:52 dgh Exp $";
    int H1;
    int H2;
    int H3;
    int H4;
    int count;
    int X[];
    private byte buffer[];
    private static final int MAGIC1 = 0x67452301;
    private static final int MAGIC2 = 0xefcdab89;
    private static final int MAGIC3 = 0x98badcfe;
    private static final int MAGIC4 = 0x10325476;
    private static final int S11 = 7;
    private static final int S12 = 12;
    private static final int S13 = 17;
    private static final int S14 = 22;
    private static final int S21 = 5;
    private static final int S22 = 9;
    private static final int S23 = 14;
    private static final int S24 = 20;
    private static final int S31 = 4;
    private static final int S32 = 11;
    private static final int S33 = 16;
    private static final int S34 = 23;
    private static final int S41 = 6;
    private static final int S42 = 10;
    private static final int S43 = 15;
    private static final int S44 = 21;

    public MD5()
    {
        super("MD5");
        buffer = new byte[64];
        engineReset();
        X = new int[16];
    }

    private final int F(int i, int j, int k)
    {
        return i & j | ~i & k;
    }

    private final int FF(int i, int j, int k, int l, int i1, int j1, int k1)
    {
        i += F(j, k, l) + i1 + k1;
        i = rotateLeft(i, j1);
        return i + j;
    }

    private final int G(int i, int j, int k)
    {
        return i & k | j & ~k;
    }

    private final int GG(int i, int j, int k, int l, int i1, int j1, int k1)
    {
        i += G(j, k, l) + i1 + k1;
        i = rotateLeft(i, j1);
        return i + j;
    }

    private final int H(int i, int j, int k)
    {
        return i ^ j ^ k;
    }

    private final int HH(int i, int j, int k, int l, int i1, int j1, int k1)
    {
        i += H(j, k, l) + i1 + k1;
        i = rotateLeft(i, j1);
        return i + j;
    }

    private final int K(int i, int j, int k)
    {
        return j ^ (i | ~k);
    }

    private final int KK(int i, int j, int k, int l, int i1, int j1, int k1)
    {
        i += K(j, k, l) + i1 + k1;
        i = rotateLeft(i, j1);
        return i + j;
    }

    private final int bytesToInt(byte abyte0[], int i)
    {
        return abyte0[i] & 0xff | abyte0[i + 1] << 8 & 0xff00 | abyte0[i + 2] << 16 & 0xff0000 | abyte0[i + 3] << 24 & 0xff000000;
    }

    protected synchronized byte[] engineDigest()
    {
        long l = count << 3;
        engineUpdate((byte)-128);
        while((count & 0x3f) != 56) 
            engineUpdate((byte)0);
        for(int i = 0; i < 14; i++)
            X[i] = bytesToInt(buffer, i * 4);

        X[14] = (int)(l & -1L);
        X[15] = (int)(l >>> 32 & -1L);
        processBlock();
        byte abyte0[] = new byte[16];
        intToBytes(abyte0, 0, H1);
        intToBytes(abyte0, 4, H2);
        intToBytes(abyte0, 8, H3);
        intToBytes(abyte0, 12, H4);
        engineReset();
        return abyte0;
    }

    protected void engineReset()
    {
        H1 = 0x67452301;
        H2 = 0xefcdab89;
        H3 = 0x98badcfe;
        H4 = 0x10325476;
        count = 0;
    }

    protected synchronized void engineUpdate(byte byte0)
    {
        buffer[count & 0x3f] = byte0;
        if((count & 0x3f) == 63)
        {
            for(int i = 0; i < 16; i++)
                X[i] = bytesToInt(buffer, i * 4);

            processBlock();
        }
        count++;
    }

    protected synchronized void engineUpdate(byte abyte0[], int i, int j)
    {
        int k = i;
        for(; (count & 0x3f) != 63 && j > 0; j--)
            engineUpdate(abyte0[k++]);

        if(j == 0)
            return;
        engineUpdate(abyte0[k++]);
        for(j--; j > 64;)
        {
            for(int l = 0; l < 16; l++)
            {
                X[l] = bytesToInt(abyte0, k);
                k += 4;
            }

            count += 64;
            j -= 64;
            processBlock();
        }

        for(int i1 = 0; i1 != j; i1++)
            engineUpdate(abyte0[i1 + k]);

    }

    private final void intToBytes(byte abyte0[], int i, int j)
    {
        abyte0[i] = (byte)(j & 0xff);
        abyte0[i + 1] = (byte)(j >>> 8 & 0xff);
        abyte0[i + 2] = (byte)(j >>> 16 & 0xff);
        abyte0[i + 3] = (byte)(j >>> 24 & 0xff);
    }

    private final synchronized void processBlock()
    {
        int i = H1;
        int j = H2;
        int k = H3;
        int l = H4;
        i = FF(i, j, k, l, X[0], 7, 0xd76aa478);
        l = FF(l, i, j, k, X[1], 12, 0xe8c7b756);
        k = FF(k, l, i, j, X[2], 17, 0x242070db);
        j = FF(j, k, l, i, X[3], 22, 0xc1bdceee);
        i = FF(i, j, k, l, X[4], 7, 0xf57c0faf);
        l = FF(l, i, j, k, X[5], 12, 0x4787c62a);
        k = FF(k, l, i, j, X[6], 17, 0xa8304613);
        j = FF(j, k, l, i, X[7], 22, 0xfd469501);
        i = FF(i, j, k, l, X[8], 7, 0x698098d8);
        l = FF(l, i, j, k, X[9], 12, 0x8b44f7af);
        k = FF(k, l, i, j, X[10], 17, -42063);
        j = FF(j, k, l, i, X[11], 22, 0x895cd7be);
        i = FF(i, j, k, l, X[12], 7, 0x6b901122);
        l = FF(l, i, j, k, X[13], 12, 0xfd987193);
        k = FF(k, l, i, j, X[14], 17, 0xa679438e);
        j = FF(j, k, l, i, X[15], 22, 0x49b40821);
        i = GG(i, j, k, l, X[1], 5, 0xf61e2562);
        l = GG(l, i, j, k, X[6], 9, 0xc040b340);
        k = GG(k, l, i, j, X[11], 14, 0x265e5a51);
        j = GG(j, k, l, i, X[0], 20, 0xe9b6c7aa);
        i = GG(i, j, k, l, X[5], 5, 0xd62f105d);
        l = GG(l, i, j, k, X[10], 9, 0x2441453);
        k = GG(k, l, i, j, X[15], 14, 0xd8a1e681);
        j = GG(j, k, l, i, X[4], 20, 0xe7d3fbc8);
        i = GG(i, j, k, l, X[9], 5, 0x21e1cde6);
        l = GG(l, i, j, k, X[14], 9, 0xc33707d6);
        k = GG(k, l, i, j, X[3], 14, 0xf4d50d87);
        j = GG(j, k, l, i, X[8], 20, 0x455a14ed);
        i = GG(i, j, k, l, X[13], 5, 0xa9e3e905);
        l = GG(l, i, j, k, X[2], 9, 0xfcefa3f8);
        k = GG(k, l, i, j, X[7], 14, 0x676f02d9);
        j = GG(j, k, l, i, X[12], 20, 0x8d2a4c8a);
        i = HH(i, j, k, l, X[5], 4, 0xfffa3942);
        l = HH(l, i, j, k, X[8], 11, 0x8771f681);
        k = HH(k, l, i, j, X[11], 16, 0x6d9d6122);
        j = HH(j, k, l, i, X[14], 23, 0xfde5380c);
        i = HH(i, j, k, l, X[1], 4, 0xa4beea44);
        l = HH(l, i, j, k, X[4], 11, 0x4bdecfa9);
        k = HH(k, l, i, j, X[7], 16, 0xf6bb4b60);
        j = HH(j, k, l, i, X[10], 23, 0xbebfbc70);
        i = HH(i, j, k, l, X[13], 4, 0x289b7ec6);
        l = HH(l, i, j, k, X[0], 11, 0xeaa127fa);
        k = HH(k, l, i, j, X[3], 16, 0xd4ef3085);
        j = HH(j, k, l, i, X[6], 23, 0x4881d05);
        i = HH(i, j, k, l, X[9], 4, 0xd9d4d039);
        l = HH(l, i, j, k, X[12], 11, 0xe6db99e5);
        k = HH(k, l, i, j, X[15], 16, 0x1fa27cf8);
        j = HH(j, k, l, i, X[2], 23, 0xc4ac5665);
        i = KK(i, j, k, l, X[0], 6, 0xf4292244);
        l = KK(l, i, j, k, X[7], 10, 0x432aff97);
        k = KK(k, l, i, j, X[14], 15, 0xab9423a7);
        j = KK(j, k, l, i, X[5], 21, 0xfc93a039);
        i = KK(i, j, k, l, X[12], 6, 0x655b59c3);
        l = KK(l, i, j, k, X[3], 10, 0x8f0ccc92);
        k = KK(k, l, i, j, X[10], 15, 0xffeff47d);
        j = KK(j, k, l, i, X[1], 21, 0x85845dd1);
        i = KK(i, j, k, l, X[8], 6, 0x6fa87e4f);
        l = KK(l, i, j, k, X[15], 10, 0xfe2ce6e0);
        k = KK(k, l, i, j, X[6], 15, 0xa3014314);
        j = KK(j, k, l, i, X[13], 21, 0x4e0811a1);
        i = KK(i, j, k, l, X[4], 6, 0xf7537e82);
        l = KK(l, i, j, k, X[11], 10, 0xbd3af235);
        k = KK(k, l, i, j, X[2], 15, 0x2ad7d2bb);
        j = KK(j, k, l, i, X[9], 21, 0xeb86d391);
        H1 += i;
        H2 += j;
        H3 += k;
        H4 += l;
        for(int i1 = 0; i1 < X.length; i1++)
            X[i1] = 0;

    }

    private final int rotateLeft(int i, int j)
    {
        return i << j | i >>> 32 - j;
    }
}
