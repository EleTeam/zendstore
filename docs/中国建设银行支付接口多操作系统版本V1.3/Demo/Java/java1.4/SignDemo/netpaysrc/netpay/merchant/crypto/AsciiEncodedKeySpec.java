// Decompiled by Jad v1.5.7g. Copyright 2000 Pavel Kouznetsov.
// Jad home page: http://www.geocities.com/SiliconValley/Bridge/8617/jad.html
// Decompiler options: packimports(3) fieldsfirst ansi 
// Source File Name:   AsciiEncodedKeySpec.java

package netpay.merchant.crypto;

import java.security.spec.EncodedKeySpec;

public class AsciiEncodedKeySpec extends EncodedKeySpec
{

    public static final String ident = "$Id: AsciiEncodedKeySpec.java,v 1.4 1998/10/26 01:46:47 leachbj Exp $";

    public AsciiEncodedKeySpec(String s)
    {
        super(s.getBytes());
    }

    public String getFormat()
    {
        return "ASCII";
    }
}
