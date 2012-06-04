package CCBSign;

import java.security.*;
import netpay.merchant.crypto.*;

public class RSASig{
	private String priKey;
	private String pubKey;
	
	public boolean generateKeys(){

		PublicKey		keyPub;
		PrivateKey		keyPri;
		SecureRandom		rand;

		Security.addProvider(new ABAProvider());

		rand = new SecureRandom();
		
		rand.setSeed(System.currentTimeMillis());

		try
		{
			KeyPairGenerator	fact;
			KeyPair			keyPair;

			fact = KeyPairGenerator.getInstance("RSA", "ABA");

			fact.initialize(1024, rand);

			keyPair = fact.generateKeyPair();

			keyPub = keyPair.getPublic();

			keyPri = keyPair.getPrivate();

			pubKey = bytesToHexStr(keyPub.getEncoded());

			priKey = bytesToHexStr(keyPri.getEncoded());
		}
		catch (Exception e)
		{
			return false;
		}
		return true;
	}

	
	public String getPublicKey(){
		return pubKey;
	}
	
	public String getPrivateKey(){
		return priKey;
	}
	
	public void setPublicKey(String pkey){
		pubKey = pkey;
	}
	
	public void setPrivateKey(String pkey){
		priKey = pkey;
	}
	
	public String generateSigature(String src){
		try{
		Security.addProvider(new ABAProvider());
		Signature sigEng = Signature.getInstance("MD5withRSA","ABA");

		byte[] pribyte = hexStrToBytes(priKey.trim());
		sigEng.initSign(new RSAPrivKeyCrt(pribyte));
		sigEng.update(src.getBytes());

		byte[] signature = sigEng.sign();
		return bytesToHexStr(signature);
		}catch(Exception e){
			return null;
		}
	}
		
	public boolean verifySigature(String sign,String src){
		try{
		Security.addProvider(new ABAProvider());
		Signature sigEng = Signature.getInstance("MD5withRSA","ABA");

		byte[] pubbyte = hexStrToBytes(pubKey.trim());
		sigEng.initVerify(new RSAPubKey(pubbyte));
		sigEng.update(src.getBytes());

		byte[] sign1 = hexStrToBytes(sign);
		if (sigEng.verify(sign1))
		{
			return true;
		}
		else
		{
			return false;
		}

		}catch(Exception e){
			return false;
		}
	}

	/**
	 * Transform the specified byte into a Hex String form.
	 */
	public static final String bytesToHexStr(
		byte[] bcd)
	{
		StringBuffer s = new StringBuffer(bcd.length * 2);

		for (int i = 0; i < bcd.length; i++)
		{
			s.append(bcdLookup[(bcd[i] >>> 4) & 0x0f]);
			s.append(bcdLookup[bcd[i] & 0x0f]);
		}

		return s.toString();
	}


	/**
	 * Transform the specified Hex String into a byte array.
	 */
	public static final byte[] hexStrToBytes(
		String	s)
	{
		byte[]	bytes;

		bytes = new byte[s.length() / 2];

		for (int i = 0; i < bytes.length; i++)
		{
			bytes[i] = (byte)Integer.parseInt(
					s.substring(2 * i, 2 * i + 2), 16);
		}

		return bytes;
	}

	private static final char[] bcdLookup =
	{
		'0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f'
	};
}