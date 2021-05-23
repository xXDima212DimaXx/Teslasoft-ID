package com.teslasoft.id.smartcard;

import android.os.Bundle;
import android.app.Activity;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.nfc.tech.Ndef;
import android.nfc.NdefMessage;
import android.nfc.NdefRecord;
import android.content.Intent;
import android.widget.Toast;
import android.os.Parcelable;
import android.widget.TextView;
import android.app.PendingIntent;
import java.nio.charset.Charset;
import java.util.Arrays;
import android.provider.Settings;
import android.util.Log;
import java.util.List;
import android.content.IntentFilter;
import android.content.Context;
import android.os.Handler;
import android.content.ComponentName;
import com.google.gson.Gson;
import java.util.Map;
import java.util.HashMap;
import android.net.Uri;
import android.view.View;
import android.widget.LinearLayout;
import java.util.List;
import java.util.ArrayList;
import java.util.Arrays;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Context;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.PackageManager.NameNotFoundException;
import android.content.pm.Signature;
import java.security.MessageDigest;

public class NfcAuthenticator extends Activity{
	public TextView nfc_message;
	public NfcAdapter nfcAdapter;
	public PendingIntent pendingIntent;
    IntentFilter writeTagFilters[];
    boolean writeMode;
    Tag myTag;
    Context context;
	String url;
	public LinearLayout loadbar;
	public LinearLayout actions;
	public int RESPONSE_CODE;
	private int SELF_SIGNATURE = 0;
	private int SELF_DEBUG_SIGNATURE = 0;
	private int DEFAULT_SIGNATURE = -672009692;
	private int GOOGLE_APPS_SIGNATURE = -473270056;
	private int ANDROID_SIGNATURE = -810989147;
	private String appSignature;
	private String signatureHash;
	private String isNotification;
	public Signature sig;
	
	@Override
	protected void onCreate(Bundle savedInstanceState){
		super.onCreate(savedInstanceState);
		overridePendingTransition(R.anim.fade_in,R.anim.fade_out);
		setContentView(R.layout.nfc_read);
		nfc_message=(TextView) findViewById(R.id.nfc_message);
		loadbar=(LinearLayout) findViewById(R.id.loadbar);
		actions=(LinearLayout) findViewById(R.id.actions);
		context=this;
		try{
		sig = this.getPackageManager().getPackageInfo(this.getPackageName(), PackageManager.GET_SIGNATURES).signatures[0];
		signatureHash = Integer.toString(sig.hashCode());
		//toast("Debug: " + signatureHash, this);
		}catch (Exception e) {
			new AlertDialog.Builder(this)
				.setTitle("Verification failed")
				.setMessage("We can not check licence because we can not check application signature. [ERR_APP_INVALID_SIGNATURE_HASH]: -2")
				.setCancelable(false)
				// Specifying a listener allows you to take an action before dismissing the dialog.
				// The dialog is automatically dismissed when a dialog button is clicked.
				.setPositiveButton(android.R.string.yes, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) { 
						finishAndRemoveTask();
					}
				})

				// A null listener allows the button to dismiss the dialog and take no further action.
				.show();
		}
		try{Intent intent = new Intent(Intent.ACTION_MAIN);
		intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
		intent.setComponent(new ComponentName("com.teslasoft.libraries.support","com.teslasoft.jarvis.core.SmartCardLoader"));
		intent.addCategory(Intent.CATEGORY_LAUNCHER);
		startActivity(intent);}
		catch(Exception eee){}
		String android_id = android.provider.Settings.Secure.getString(getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);
		if (verifyInstallerId(this) == false) {
		//toast(android_id, this);
			if (android_id.equals("608122f053f41340")) {
			toast("WARNING! A test device detected. Licence check skipped. Current signature hash: " + signatureHash + " ,device ID: " + android_id,this);
		} else {
		new AlertDialog.Builder(this)
			.setTitle("Verification failed")
			.setMessage("We can not check licence because this app installed from third-party source. Try to install it from Google Play. We perform this check to prevent tampering with API and security attacks. [ERR_PREFERAL_INSTALLED_BY_PACKAGE_INSTALLER]: -1")
			.setCancelable(false)
			// Specifying a listener allows you to take an action before dismissing the dialog.
			// The dialog is automatically dismissed when a dialog button is clicked.
			.setPositiveButton(android.R.string.yes, new DialogInterface.OnClickListener() {
				public void onClick(DialogInterface dialog, int which) { 
					finishAndRemoveTask();
				}
			})

			// A null listener allows the button to dismiss the dialog and take no further action.
			.show();
		}}
		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		if(nfcAdapter == null){
			toast("This device doesn't support NFC.",this);
			finishAndRemoveTask();
		}
			readFromIntent(getIntent());
			pendingIntent=PendingIntent.getActivity(this,0,new Intent(this,getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP),0);
			IntentFilter tagDetected=new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
			tagDetected.addCategory(Intent.CATEGORY_DEFAULT);
			writeTagFilters=new IntentFilter[]{tagDetected};
	}

	/* Piracy check starts */
	boolean verifyInstallerId(Context context) {
		// A list with valid installers package name
		List<String> validInstallers = new ArrayList<>(Arrays.asList("com.android.vending", "com.google.android.feedback"));

		// The package name of the app that has installed your app
		final String installer = context.getPackageManager().getInstallerPackageName(context.getPackageName());

		// true if your app has been downloaded from Play Store 
		return installer != null && validInstallers.contains(installer);
	}
	/* Piracy check ends */
	
	private void readFromIntent(Intent intent){
        String action=intent.getAction();
        if (NfcAdapter.ACTION_TAG_DISCOVERED.equals(action)
			|| NfcAdapter.ACTION_TECH_DISCOVERED.equals(action)
			|| NfcAdapter.ACTION_NDEF_DISCOVERED.equals(action)){
            Parcelable[] rawMsgs=intent.getParcelableArrayExtra(NfcAdapter.EXTRA_NDEF_MESSAGES);
			byte[] tagId=intent.getByteArrayExtra(NfcAdapter.EXTRA_ID);	
			String hexdump=new String();
			for(int i=0;i<tagId.length;i++){
				String x=Integer.toHexString(((int) tagId[i] & 0xff));
				if (x.length()==1){x='0'+x;}
				hexdump+=x;
			}
            NdefMessage[] msgs=null;
            if (rawMsgs!=null){
                msgs=new NdefMessage[rawMsgs.length];
                for(int i=0;i<rawMsgs.length;i++) msgs[i]=(NdefMessage) rawMsgs[i];
            }
            buildTagViews(msgs,hexdump);
        }
	}
	private void buildTagViews(NdefMessage[] msgs, String tagId) {
        if (msgs==null||msgs.length==0) return;
        String text="";
		byte[] payload=msgs[0].getRecords()[0].getPayload();
        String textEncoding=((payload[0]&128)==0) ? "UTF-8":"UTF-16";
        int languageCodeLength=payload[0]&0063;
        try{text=new String(payload,languageCodeLength+1,payload.length-languageCodeLength-1,textEncoding);
        }catch(Exception e){Log.e("UnsupportedEncoding",e.toString());}
		Authenticate(text,tagId);
    }
	@Override
    protected void onNewIntent(Intent intent){
        setIntent(intent);
        readFromIntent(intent);
        if(NfcAdapter.ACTION_TAG_DISCOVERED.equals(intent.getAction())){
            myTag=intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
        }
   	}
	@Override
    public void onPause(){
        super.onPause();
        writeMode=false;
        nfcAdapter.disableForegroundDispatch(this);
    }
    @Override
    public void onResume(){
        super.onResume();
        writeMode=true;
        nfcAdapter.enableForegroundDispatch(this,pendingIntent,writeTagFilters,null);
    }
	public void Authenticate(String token,String serial){
		try{
			Gson gson=new Gson();
			Map<String,Object> map=new HashMap<String,Object>();
			map=(Map<String,Object>) gson.fromJson(token,map.getClass());
			String user_fwid=map.get("fwid").toString();
			String user_id=map.get("uid").toString();
			String pincode_encrypted=map.get("pin").toString();
			token=user_fwid.trim();
			token=token.toUpperCase();
			nfc_message.setText("SmartCard Info\n\nSerial Number: ".concat(serial.concat("\nSmartCard ID: ".concat(user_fwid.concat("\nUser ID: ".concat(user_id))))));
			url="https://id.teslasoft.org/smartcard/auth?cbs=".concat(token).concat("&sid=").concat(serial).concat("&pwtoken=").concat(pincode_encrypted).concat("&uid=").concat(user_id);
			loadbar.setVisibility(View.GONE);
			actions.setVisibility(View.VISIBLE);
		}catch(Exception e){
			new AlertDialog.Builder(this)
				.setTitle("Error")
				.setMessage("An error occured while reading data from the SmartCard. Please make sure that you used valid SmartCard.")
				.setCancelable(false)
				// Specifying a listener allows you to take an action before dismissing the dialog.
				// The dialog is automatically dismissed when a dialog button is clicked.
				.setPositiveButton(android.R.string.yes, new DialogInterface.OnClickListener() {
					public void onClick(DialogInterface dialog, int which) { 
						finishAndRemoveTask();
					}
				})

				// A null listener allows the button to dismiss the dialog and take no further action.
				.show();
		}
	}
	public void Auth(View v){openUrl(url);}
	public void Close(View v){finishAndRemoveTask();}
	public void openUrl(String url){
		final String urls=url;
		final Handler handler=new Handler();
		handler.postDelayed(new Runnable(){
			@Override
			public void run(){
				overridePendingTransition(R.anim.fade_in,R.anim.fade_out);
				Intent browserIntent=new Intent(Intent.ACTION_VIEW,Uri.parse(urls));
				startActivity(browserIntent);
				final Handler handler=new Handler();
				handler.postDelayed(new Runnable(){
					@Override
					public void run(){
						overridePendingTransition(R.anim.fade_in,R.anim.fade_out);
						finishAndRemoveTask();
					}
				}, 10);
			}
		}, 1000);
	}
	
	public Handler mHandler = new Handler();
	public void toast(final CharSequence text,final Context context){
        mHandler.post(new Runnable(){
			@Override public void run(){
				try{Toast.makeText(context,text,Toast.LENGTH_SHORT).show();}
				catch(Exception e){}
			}
		});
    }
}
