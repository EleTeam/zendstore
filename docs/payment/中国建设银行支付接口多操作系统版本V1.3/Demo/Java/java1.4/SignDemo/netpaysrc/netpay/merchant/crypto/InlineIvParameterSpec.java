// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   InlineIvParameterSpec.java

package netpay.merchant.crypto;

import java.security.spec.AlgorithmParameterSpec;

public class InlineIvParameterSpec
    implements AlgorithmParameterSpec
{

    public static final String ident = "$Id: InlineIvParameterSpec.java,v 1.5 1998/10/28 23:20:47 leachbj Exp $";
    private boolean encrypted;

    public InlineIvParameterSpec()
    {
        encrypted = false;
    }

    public InlineIvParameterSpec(boolean flag)
    {
        encrypted = flag;
    }

    public boolean isEncryptedIv()
    {
        return encrypted;
    }
}
