// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   ABAProvider.java

package netpay.merchant.crypto;

import java.security.Provider;

public final class ABAProvider extends Provider
{

    public static final String ident = "$Id: ABAProvider.java,v 1.25 1999/02/11 04:32:50 leachbj Exp $";
    private static String info = "ABA Security Provider v1.1, SHA, MD5 message Digests, and Crypto algorithms.";

    public ABAProvider()
    {
        super("ABA", 1.1000000000000001D, info);
        put("MessageDigest.MD5", "netpay.merchant.crypto.MD5");
        put("MessageDigest.SHA-1", "netpay.merchant.crypto.SHA1");
        put("Alg.Alias.MessageDigest.SHA1", "SHA-1");
        put("Alg.Alias.MessageDigest.SHA", "SHA-1");
        put("MessageDigest.SHA-0", "netpay.merchant.crypto.SHA0");
        put("MessageDigest.CRC16", "netpay.merchant.crypto.CRC16");
        put("Cipher.RSA", "netpay.merchant.crypto.RSA");
        put("Alg.Alias.Cipher.OID.1.2.840.113549.1.1.1", "RSA");
        put("Cipher.RC4", "netpay.merchant.crypto.RC4");
        put("Cipher.DES", "netpay.merchant.crypto.DES");
        put("Cipher.DESede", "netpay.merchant.crypto.DESede");
        put("Cipher.IDEA", "netpay.merchant.crypto.IDEA");
        put("Cipher.Blowfish", "netpay.merchant.crypto.Blowfish");
        put("Cipher.Twofish", "netpay.merchant.crypto.Twofish");
        put("Cipher.PBEWithMD5AndDES", "netpay.merchant.crypto.PBEWithMD5AndDES");
        put("Cipher.PBEWithSHA1And128BitRC4", "netpay.merchant.crypto.PBEWithSHA1And128BitRC4");
        put("Mac.DESMac", "netpay.merchant.crypto.DESMac");
        put("Alg.Alias.Mac.DES-MAC", "DESMac");
        put("KeyPairGenerator.RSA", "netpay.merchant.crypto.RSAKeyPairGenerator");
        put("Alg.Alias.KeyPairGenerator.OID.1.2.840.113549.1.1.1", "RSA");
        put("Alg.Alias.KeyPairGenerator.1.2.840.113549.1.1.1", "RSA");
        put("KeyGenerator.RC4", "netpay.merchant.crypto.RC4KeyGenerator");
        put("KeyGenerator.DES", "netpay.merchant.crypto.DESKeyGenerator");
        put("KeyGenerator.DESede", "netpay.merchant.crypto.DESedeKeyGenerator");
        put("KeyGenerator.IDEA", "netpay.merchant.crypto.IDEAKeyGenerator");
        put("KeyGenerator.Blowfish", "netpay.merchant.crypto.BlowfishKeyGenerator");
        put("KeyGenerator.Twofish", "netpay.merchant.crypto.TwofishKeyGenerator");
        put("KeyFactory.RSA", "netpay.merchant.crypto.RSAKeyFactory");
        put("Alg.Alias.KeyFactory.1.2.840.113549.1.1.1", "RSA");
        put("SecretKeyFactory.DES", "netpay.merchant.crypto.DESKeyFactory");
        put("SecretKeyFactory.DESede", "netpay.merchant.crypto.DESedeKeyFactory");
        put("SecretKeyFactory.RC4", "netpay.merchant.crypto.RC4KeyFactory");
        put("SecretKeyFactory.IDEA", "netpay.merchant.crypto.IDEAKeyFactory");
        put("SecretKeyFactory.Blowfish", "netpay.merchant.crypto.BlowfishKeyFactory");
        put("SecretKeyFactory.Twofish", "netpay.merchant.crypto.TwofishKeyFactory");
        put("SecretKeyFactory.PBEWithMD5AndDES", "netpay.merchant.crypto.PBEKeyFactory");
        put("SecretKeyFactory.PBEWithSHA1And128BitRC4", "netpay.merchant.crypto.PBEKeyFactory");
        put("KeyStore.ABA", "netpay.merchant.crypto.KeyStore");
        put("Signature.MD5withRSA", "netpay.merchant.crypto.MD5withRSA");
        put("Alg.Alias.Signature.MD5/RSA", "MD5withRSA");
        put("Alg.Alias.Signature.OID.1.2.840.113549.1.1.4", "MD5withRSA");
        put("Alg.Alias.Signature.1.2.840.113549.1.1.4", "MD5withRSA");
        put("Alg.Alias.Signature.1.3.14.3.2.25", "MD5withRSA");
        put("CertificateFactory.X509", "au.net.aba.cert.ABAX509CertFactory");
        put("Alg.Alias.CertificateFactory.X.509", "X509");
    }

}
