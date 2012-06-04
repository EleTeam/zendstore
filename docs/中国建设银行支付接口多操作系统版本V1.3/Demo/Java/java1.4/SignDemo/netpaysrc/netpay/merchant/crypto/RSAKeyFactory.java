// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   RSAKeyFactory.java

package netpay.merchant.crypto;

import java.math.BigInteger;
import java.security.*;
import java.security.interfaces.*;
import java.security.spec.*;
import java.util.StringTokenizer;

// Referenced classes of package netpay.merchant.crypto:
//            AsciiEncodedKeySpec, RSAPrivKeyCrt, RSAPrivKey, RSAPubKey

public class RSAKeyFactory extends KeyFactorySpi
{

    public static final String ident = "$Id: RSAKeyFactory.java,v 1.13 1999/02/17 01:40:52 leachbj Exp $";
    static Class class$java$security$spec$X509EncodedKeySpec;
    static Class class$java$security$spec$RSAPublicKeySpec;
    static Class class$java$security$spec$PKCS8EncodedKeySpec;
    static Class class$java$security$spec$RSAPrivateCrtKeySpec;
    static Class class$java$security$spec$RSAPrivateKeySpec;

    public RSAKeyFactory()
    {
    }

    static Class getClass(String s)
    {
        return Class.forName(s);
        ClassNotFoundException classnotfoundexception;
        classnotfoundexception;
        throw new NoClassDefFoundError(classnotfoundexception.getMessage());
    }

    protected PrivateKey engineGeneratePrivate(KeySpec keyspec)
        throws InvalidKeySpecException
    {
        if(keyspec instanceof AsciiEncodedKeySpec)
        {
            BigInteger abiginteger[] = parseKey(((AsciiEncodedKeySpec)keyspec).getEncoded());
            if(abiginteger.length == 8)
                return new RSAPrivKeyCrt(abiginteger[0], abiginteger[1], abiginteger[2], abiginteger[3], abiginteger[4], abiginteger[5], abiginteger[6], abiginteger[7]);
            else
                return new RSAPrivKey(abiginteger[0], abiginteger[1]);
        }
        if(keyspec instanceof PKCS8EncodedKeySpec)
            return new RSAPrivKeyCrt(((PKCS8EncodedKeySpec)keyspec).getEncoded());
        if(keyspec instanceof RSAPrivateCrtKeySpec)
        {
            RSAPrivateCrtKeySpec rsaprivatecrtkeyspec = (RSAPrivateCrtKeySpec)keyspec;
            return new RSAPrivKeyCrt(rsaprivatecrtkeyspec.getModulus(), rsaprivatecrtkeyspec.getPublicExponent(), rsaprivatecrtkeyspec.getPrivateExponent(), rsaprivatecrtkeyspec.getPrimeP(), rsaprivatecrtkeyspec.getPrimeQ(), rsaprivatecrtkeyspec.getPrimeExponentP(), rsaprivatecrtkeyspec.getPrimeExponentQ(), rsaprivatecrtkeyspec.getCrtCoefficient());
        }
        if(keyspec instanceof RSAPrivateKeySpec)
        {
            RSAPrivateKeySpec rsaprivatekeyspec = (RSAPrivateKeySpec)keyspec;
            return new RSAPrivKey(rsaprivatekeyspec.getModulus(), rsaprivatekeyspec.getPrivateExponent());
        } else
        {
            throw new InvalidKeySpecException("Unknown KeySpec type.");
        }
    }

    protected PublicKey engineGeneratePublic(KeySpec keyspec)
        throws InvalidKeySpecException
    {
        if(keyspec instanceof AsciiEncodedKeySpec)
        {
            BigInteger abiginteger[] = parseKey(((AsciiEncodedKeySpec)keyspec).getEncoded());
            if(abiginteger.length >= 2)
                return new RSAPubKey(abiginteger[0], abiginteger[1]);
            else
                throw new InvalidKeySpecException("Incomplete EncodedKeySpec.");
        }
        if(keyspec instanceof X509EncodedKeySpec)
            return new RSAPubKey(((X509EncodedKeySpec)keyspec).getEncoded());
        if(keyspec instanceof RSAPublicKeySpec)
        {
            RSAPublicKeySpec rsapublickeyspec = (RSAPublicKeySpec)keyspec;
            return new RSAPubKey(rsapublickeyspec.getModulus(), rsapublickeyspec.getPublicExponent());
        } else
        {
            throw new InvalidKeySpecException("Unknown KeySpec type.");
        }
    }

    protected KeySpec engineGetKeySpec(Key key, Class class1)
        throws InvalidKeySpecException
    {
        if(key instanceof RSAPublicKey)
        {
            if((class$java$security$spec$X509EncodedKeySpec != null ? class$java$security$spec$X509EncodedKeySpec : (class$java$security$spec$X509EncodedKeySpec = getClass("java.security.spec.X509EncodedKeySpec"))).isAssignableFrom(class1))
                return new X509EncodedKeySpec(((X509EncodedKeySpec)key).getEncoded());
            if((class$java$security$spec$RSAPublicKeySpec != null ? class$java$security$spec$RSAPublicKeySpec : (class$java$security$spec$RSAPublicKeySpec = getClass("java.security.spec.RSAPublicKeySpec"))).isAssignableFrom(class1))
            {
                RSAPublicKey rsapublickey = (RSAPublicKey)key;
                return new RSAPublicKeySpec(rsapublickey.getModulus(), rsapublickey.getPublicExponent());
            }
        } else
        if(key instanceof RSAPrivateKey)
        {
            if((class$java$security$spec$PKCS8EncodedKeySpec != null ? class$java$security$spec$PKCS8EncodedKeySpec : (class$java$security$spec$PKCS8EncodedKeySpec = getClass("java.security.spec.PKCS8EncodedKeySpec"))).isAssignableFrom(class1))
                return new PKCS8EncodedKeySpec(((PKCS8EncodedKeySpec)key).getEncoded());
            if((class$java$security$spec$RSAPrivateCrtKeySpec != null ? class$java$security$spec$RSAPrivateCrtKeySpec : (class$java$security$spec$RSAPrivateCrtKeySpec = getClass("java.security.spec.RSAPrivateCrtKeySpec"))).isAssignableFrom(class1))
            {
                RSAPrivKeyCrt rsaprivkeycrt = (RSAPrivKeyCrt)key;
                return new RSAPrivateCrtKeySpec(rsaprivkeycrt.getModulus(), rsaprivkeycrt.getPublicExponent(), rsaprivkeycrt.getPrivateExponent(), rsaprivkeycrt.getPrimeP(), rsaprivkeycrt.getPrimeQ(), rsaprivkeycrt.getPrimeExponentP(), rsaprivkeycrt.getPrimeExponentQ(), rsaprivkeycrt.getCrtCoefficient());
            }
            if((class$java$security$spec$RSAPrivateKeySpec != null ? class$java$security$spec$RSAPrivateKeySpec : (class$java$security$spec$RSAPrivateKeySpec = getClass("java.security.spec.RSAPrivateKeySpec"))).isAssignableFrom(class1))
            {
                RSAPrivateKey rsaprivatekey = (RSAPrivateKey)key;
                return new RSAPrivateKeySpec(rsaprivatekey.getModulus(), rsaprivatekey.getPrivateExponent());
            }
        }
        throw new InvalidKeySpecException("Invalid KeySpec.");
    }

    protected Key engineTranslateKey(Key key)
        throws InvalidKeyException
    {
        if(key instanceof RSAPrivateCrtKey)
            if(key instanceof RSAPrivKeyCrt)
            {
                return key;
            } else
            {
                RSAPrivateCrtKey rsaprivatecrtkey = (RSAPrivateCrtKey)key;
                return new RSAPrivKeyCrt(rsaprivatecrtkey.getModulus(), rsaprivatecrtkey.getPublicExponent(), rsaprivatecrtkey.getPrivateExponent(), rsaprivatecrtkey.getPrimeP(), rsaprivatecrtkey.getPrimeQ(), rsaprivatecrtkey.getPrimeExponentP(), rsaprivatecrtkey.getPrimeExponentQ(), rsaprivatecrtkey.getCrtCoefficient());
            }
        if(key instanceof RSAPrivateKey)
            if(key instanceof RSAPrivateKey)
            {
                return key;
            } else
            {
                RSAPrivateKey rsaprivatekey = (RSAPrivateKey)key;
                return new RSAPrivKey(rsaprivatekey.getModulus(), rsaprivatekey.getPrivateExponent());
            }
        if(key instanceof RSAPublicKey)
        {
            if(key instanceof RSAPublicKey)
            {
                return key;
            } else
            {
                RSAPublicKey rsapublickey = (RSAPublicKey)key;
                return new RSAPubKey(rsapublickey.getModulus(), rsapublickey.getPublicExponent());
            }
        } else
        {
            throw new InvalidKeyException("Unsupported key type.");
        }
    }

    protected static BigInteger[] parseKey(byte abyte0[])
    {
        String s = new String(abyte0);
        StringTokenizer stringtokenizer = new StringTokenizer(s, ".");
        int i = stringtokenizer.countTokens();
        BigInteger abiginteger[];
        if(i > 2)
            abiginteger = new BigInteger[8];
        else
            abiginteger = new BigInteger[2];
        for(int j = 0; j != i; j++)
            abiginteger[j] = new BigInteger(stringtokenizer.nextToken(), 16);

        if(i > 2)
        {
            BigInteger biginteger = abiginteger[2];
            BigInteger biginteger1 = abiginteger[3];
            BigInteger biginteger2 = abiginteger[4];
            if(biginteger1.compareTo(biginteger2) < 0)
            {
                BigInteger biginteger5 = biginteger1;
                abiginteger[3] = biginteger1 = biginteger2;
                abiginteger[4] = biginteger2 = biginteger5;
            }
            BigInteger biginteger3 = biginteger1.subtract(BigInteger.valueOf(1L));
            BigInteger biginteger4 = biginteger2.subtract(BigInteger.valueOf(1L));
            abiginteger[5] = biginteger.remainder(biginteger3);
            abiginteger[6] = biginteger.remainder(biginteger4);
            abiginteger[7] = biginteger2.modInverse(biginteger1);
        }
        return abiginteger;
    }
}
