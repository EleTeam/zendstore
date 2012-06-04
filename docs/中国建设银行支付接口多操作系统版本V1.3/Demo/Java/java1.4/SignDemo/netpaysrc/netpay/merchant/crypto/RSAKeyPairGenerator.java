// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   RSAKeyPairGenerator.java

package netpay.merchant.crypto;

import java.math.BigInteger;
import java.security.*;

// Referenced classes of package netpay.merchant.crypto:
//            RSAPubKey, RSAPrivKeyCrt

public class RSAKeyPairGenerator extends KeyPairGenerator
{

    public static final String ident = "$Id: RSAKeyPairGenerator.java,v 1.9 1998/10/30 04:20:14 leachbj Exp $";
    private static BigInteger one = BigInteger.valueOf(1L);
    private static BigInteger two = BigInteger.valueOf(2L);
    int strength;
    SecureRandom random;
    int certainty;

    public RSAKeyPairGenerator()
    {
        super("RSA");
        certainty = 20;
    }

    public KeyPair generateKeyPair()
    {
        int i = (strength + 1) / 2;
        BigInteger biginteger = new BigInteger(i, certainty, random);
        BigInteger biginteger1;
        do
            biginteger1 = new BigInteger(i, certainty, random);
        while(biginteger.equals(biginteger1));
        if(biginteger.compareTo(biginteger1) < 0)
        {
            BigInteger biginteger8 = biginteger;
            biginteger = biginteger1;
            biginteger1 = biginteger8;
        }
        BigInteger biginteger2 = biginteger.multiply(biginteger1);
        BigInteger biginteger5 = biginteger.subtract(one);
        BigInteger biginteger6 = biginteger1.subtract(one);
        BigInteger biginteger7 = biginteger5.multiply(biginteger6);
        BigInteger biginteger4;
        for(biginteger4 = BigInteger.valueOf(17L); !biginteger4.gcd(biginteger7).equals(one); biginteger4 = biginteger4.add(two));
        BigInteger biginteger3 = biginteger4.modInverse(biginteger7);
        BigInteger biginteger9 = biginteger3.remainder(biginteger5);
        BigInteger biginteger10 = biginteger3.remainder(biginteger6);
        BigInteger biginteger11 = biginteger1.modInverse(biginteger);
        RSAPubKey rsapubkey = new RSAPubKey(biginteger2, biginteger4);
        RSAPrivKeyCrt rsaprivkeycrt = new RSAPrivKeyCrt(biginteger2, biginteger4, biginteger3, biginteger, biginteger1, biginteger9, biginteger10, biginteger11);
        return new KeyPair(rsapubkey, rsaprivkeycrt);
    }

    public void initialize(int i, SecureRandom securerandom)
    {
        strength = i;
        random = securerandom;
    }

}
