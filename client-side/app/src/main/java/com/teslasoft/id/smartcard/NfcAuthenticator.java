package com.teslasoft.id.smartcard;

import android.annotation.SuppressLint;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.PendingIntent;
import android.content.ComponentName;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.pm.PackageManager;
import android.content.pm.Signature;
import android.net.Uri;
import android.nfc.NdefMessage;
import android.nfc.NfcAdapter;
import android.nfc.Tag;
import android.os.Bundle;
import android.os.Handler;
import android.os.Parcelable;
import android.provider.Settings;
import android.util.Log;
import android.view.View;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.google.gson.Gson;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashMap;
import java.util.List;
import java.util.Map;
import java.util.Objects;

public class NfcAuthenticator extends Activity {
	public TextView nfc_message;
	public NfcAdapter nfcAdapter;
	public PendingIntent pendingIntent;
	public IntentFilter[] writeTagFilters;
    boolean writeMode;
	public Tag myTag;
	public Context context;
	public String url;
	public LinearLayout loadbar;
	public LinearLayout actions;
	private String signatureHash;
	public Signature sig;
	public int versionCode = BuildConfig.VERSION_CODE;
	public String versionName = BuildConfig.VERSION_NAME;
	public PackageManager packageManager;

	/***********************************************************
	 * Unimplemented:
	 * public int RESPONSE_CODE;
	 * private int SELF_SIGNATURE = 0;
	 * private int SELF_DEBUG_SIGNATURE = 0;
	 * private int DEFAULT_SIGNATURE = -672009692;
	 * private int GOOGLE_APPS_SIGNATURE = -473270056;
	 * private int ANDROID_SIGNATURE = -810989147;
	 * private String appSignature;
	 * private String isNotification;
	 **********************************************************/

	public String const_CONT;

	@SuppressLint("PackageManagerGetSignatures")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		overridePendingTransition(R.anim.fade_in, R.anim.fade_out);
		setContentView(R.layout.nfc_read);
		nfc_message = findViewById(R.id.nfc_message);
		loadbar = findViewById(R.id.loadbar);
		actions = findViewById(R.id.actions);
		context = this;
		packageManager = context.getPackageManager();

		if (isPackageInstalled("com.teslasoft.libraries.support", packageManager)) {
			if (this.checkSelfPermission("com.teslasoft.core.permission.ACCESS_SMARTCARD_FRAMEWORK") == PackageManager.PERMISSION_GRANTED) {

			} else {
				requestPermissions(new String[]{"com.teslasoft.core.permission.ACCESS_SMARTCARD_FRAMEWORK"}, 22);
			}
		} else {
			new AlertDialog.Builder(this)
					.setTitle("ERROR")
					.setMessage("This app requires one or more features of Teslasoft Core (com.teslasoft.core.permission.ACCESS_SMARTCARD_FRAMEWORK, com.teslasoft.jarvis.core.SmartCardService, com.teslasoft.jarvis.licence.PiracyCheck) that is not installed. Would you like to open Google Play and install it?")
					.setCancelable(false)
					.setNegativeButton(android.R.string.cancel, (dialog, which) -> finishAndRemoveTask())
					.setPositiveButton(android.R.string.ok, (dialog, which) -> openPlay(this))
					.show();
		}

		try {
			sig = this.getPackageManager().getPackageInfo(this.getPackageName(), PackageManager.GET_SIGNATURES).signatures[0];
			signatureHash = Integer.toString(sig.hashCode());
			toast("Debug: " + signatureHash, this);
		} catch(Exception e) {
			new AlertDialog.Builder(this)
				.setTitle("ERROR")
				.setMessage("We can not check license because we can not check application signature. [ERR_APP_INVALID_SIGNATURE_HASH]: -2")
				.setCancelable(false)
				.setPositiveButton(android.R.string.ok, (dialog, which) -> finishAndRemoveTask())
				.show();
		}

		try {
			Intent intent = new Intent(Intent.ACTION_MAIN);
			intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
			intent.setComponent(new ComponentName("com.teslasoft.libraries.support", "com.teslasoft.jarvis.core.SmartCardLoader"));
			intent.addCategory(Intent.CATEGORY_LAUNCHER);
			startActivity(intent);
		}

		catch(Exception ignored) {}

		@SuppressLint("HardwareIds") String android_id = android.provider.Settings.Secure.getString(getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);
		if (!verifyInstallerId(this)) {
			// DEBUG: toast(android_id, this);
			if (android_id.equals("d15c94372be47f06")) {
				// toast("WARNING! A test device detected. License check skipped. Current signature hash: " + signatureHash + ", device ID: " + android_id,this);
			} else {
				new AlertDialog.Builder(this)
					.setTitle("ERROR")
					.setMessage("We can not check license because this app installed from third-party source. Try to install it from Google Play. We perform this check to prevent tampering with API and security attacks. [ERR_PREFERAL_INSTALLED_BY_PACKAGE_INSTALLER]: -1")
					.setCancelable(false)
					.setPositiveButton(android.R.string.ok, (dialog, which) -> finishAndRemoveTask())
					.show();
			}
		}

		nfcAdapter = NfcAdapter.getDefaultAdapter(this);
		if(nfcAdapter == null) {
			new AlertDialog.Builder(this)
					.setTitle("ERROR")
					.setMessage("This application requires NFC that is not supported or disabled on your devices. [ERR_NFC_ADAPTER_FAILURE]: 4")
					.setCancelable(false)
					.setPositiveButton(android.R.string.ok, (dialog, which) -> finishAndRemoveTask())
					.show();
		}

		try {
			Intent intent = getIntent();
			const_CONT = intent.getStringExtra("cont");
			// toast("DEBUG: " + const_CONT, this);
			// toast("DEBUG: " + cont, this);
			if (const_CONT.toString().equals("null")) {
				// toast("ERROR: No intent data found! API authentication has skipped.", this);
				const_CONT = "https://id.teslasoft.org/account/main";
				readFromIntent(getIntent());
				pendingIntent = PendingIntent.getActivity(this, 0, new Intent(this, getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), 0);
				IntentFilter tagDetected = new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
				tagDetected.addCategory(Intent.CATEGORY_DEFAULT);
				writeTagFilters = new IntentFilter[] { tagDetected };
			} else {
				readFromIntent(getIntent());

				pendingIntent = PendingIntent.getActivity(this, 0, new Intent(this, getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), 0);
				IntentFilter tagDetected = new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
				tagDetected.addCategory(Intent.CATEGORY_DEFAULT);
				writeTagFilters = new IntentFilter[] { tagDetected };
			}
		} catch (Exception __e) {
			// toast("ERROR: No intent data found! API authentication has skipped.", this);
			const_CONT = "https://id.teslasoft.org/account/main";
			readFromIntent(getIntent());
			pendingIntent = PendingIntent.getActivity(this, 0, new Intent(this, getClass()).addFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP), 0);
			IntentFilter tagDetected = new IntentFilter(NfcAdapter.ACTION_TAG_DISCOVERED);
			tagDetected.addCategory(Intent.CATEGORY_DEFAULT);
			writeTagFilters = new IntentFilter[] { tagDetected };
		}
	}

	public void openPlay(Context context) {
		Intent browserIntent = new Intent(Intent.ACTION_VIEW, Uri.parse("https://play.google.com/store/apps/details?id=com.teslasoft.libraries.support"));
		startActivity(browserIntent);
		finishAndRemoveTask();
	}

	private boolean isPackageInstalled(String packageName, PackageManager packageManager) {
		try {
			packageManager.getPackageInfo(packageName, 0);
			return true;
		} catch (PackageManager.NameNotFoundException e) {
			return false;
		}
	}



	public void openPermissions(Context context) {
		Intent intent = new Intent(Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
		Uri uri = Uri.fromParts("package", getPackageName(), null);
		intent.setData(uri);
		startActivity(intent);
		finishAndRemoveTask();
	}

	@Override
	public void onRequestPermissionsResult(int requestCode, String[] permissions, int[] grantResults) {
		super.onRequestPermissionsResult(requestCode, permissions, grantResults);
		switch (requestCode) {
			case 23:
				break;
			default:
				new AlertDialog.Builder(this)
						.setTitle("ERROR")
						.setMessage("This app is not authorized to use Teslasoft SmartCard API. If you have already provided permission and still see this error, please restart this app. Would you like to open app settings now?")
						.setCancelable(false)
						.setNegativeButton(android.R.string.cancel, (dialog, which) -> finishAndRemoveTask())
						.setPositiveButton(android.R.string.ok, (dialog, which) -> openPermissions(this))
						.show();
		}
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
	
	private void readFromIntent(Intent intent) {
        String action=intent.getAction();
        if (NfcAdapter.ACTION_TAG_DISCOVERED.equals(action) || NfcAdapter.ACTION_TECH_DISCOVERED.equals(action) || NfcAdapter.ACTION_NDEF_DISCOVERED.equals(action)) {
            Parcelable[] rawMsgs = intent.getParcelableArrayExtra(NfcAdapter.EXTRA_NDEF_MESSAGES);
			byte[] tagId = intent.getByteArrayExtra(NfcAdapter.EXTRA_ID);
			StringBuilder hexdump = new StringBuilder();
			for (byte b : tagId) {
				String x = Integer.toHexString(((int) b & 0xff));
				if (x.length() == 1) {
					x = '0' + x;
				}
				hexdump.append(x);
			}

            NdefMessage[] msgs = null;
            if (rawMsgs != null) {
                msgs = new NdefMessage[rawMsgs.length];
                for(int i = 0; i < rawMsgs.length; i++) msgs[i] = (NdefMessage) rawMsgs[i];
            }
            buildTagViews(msgs, hexdump.toString());
        }
	}

	private void buildTagViews(NdefMessage[] msgs, String tagId) {
        if (msgs == null || msgs.length == 0) return;
        String text = "";
		byte[] payload = msgs[0].getRecords()[0].getPayload();
        String textEncoding = ((payload[0] & 128) == 0) ? "UTF-8" : "UTF-16";
        int languageCodeLength = payload[0] & 51;
        try {
        	text = new String(payload, languageCodeLength+1, payload.length - languageCodeLength - 1, textEncoding);
        } catch(Exception e) {
        	Log.e("UnsupportedEncoding", e.toString());
        }

		Authenticate(text, tagId);
    }

	@Override
    protected void onNewIntent(Intent intent) {
        setIntent(intent);
        readFromIntent(getIntent());
        if(NfcAdapter.ACTION_TAG_DISCOVERED.equals(intent.getAction())) {
            myTag = intent.getParcelableExtra(NfcAdapter.EXTRA_TAG);
        }
   	}

	@Override
    public void onPause() {
        super.onPause();
        writeMode = false;
        nfcAdapter.disableForegroundDispatch(this);
    }

    @Override
    public void onResume() {
        super.onResume();
        writeMode = true;
        nfcAdapter.enableForegroundDispatch(this, pendingIntent, writeTagFilters, null);
    }

	public void Authenticate(String token, String serial) {
		// toast("DEBUG: " + const_CONT, this);
		try {
			Gson gson = new Gson();
			Map <String,Object> map = new HashMap<>();
			map = (Map<String,Object>) gson.fromJson(token,map.getClass());
			String user_fwid = Objects.requireNonNull(map.get("fwid")).toString();
			String user_id = Objects.requireNonNull(map.get("uid")).toString();
			String pincode_encrypted = Objects.requireNonNull(map.get("pin")).toString();
			token = user_fwid.trim();
			token = token.toUpperCase();
			nfc_message.setText("SmartCard Info\n\nSerial Number: ".concat(serial.concat("\nSmartCard ID: ".concat(user_fwid.concat("\nUser ID: ".concat(user_id))))));
			url = "https://id.teslasoft.org/smartcard/auth?cbs=".concat(token).concat("&sid=").concat(serial).concat("&pwtoken=").concat(pincode_encrypted).concat("&uid=").concat(user_id).concat("&ver=").concat(Integer.valueOf(versionCode).toString()).concat("&vn=").concat(versionName).concat("&continue=").concat(const_CONT).concat("&signature=").concat(signatureHash);
			loadbar.setVisibility(View.GONE);
			actions.setVisibility(View.VISIBLE);
		} catch(Exception e) {
			new AlertDialog.Builder(this)
				.setTitle("Error")
				.setMessage("An error occurred while reading data from the SmartCard. Please make sure that you used valid SmartCard.")
				.setCancelable(false)
				.setPositiveButton(android.R.string.ok, (dialog, which) -> finishAndRemoveTask())
				.show();
		}
	}

	public void Auth(View v) {
		openUrl(url);
	}

	public void Close(View v) {
		finishAndRemoveTask();
	}

	public void openUrl(String url) {
		final String urls=url;
		final Handler handler = new Handler();
		handler.postDelayed(() -> {
			overridePendingTransition(R.anim.fade_in, R.anim.fade_out);
			Intent browserIntent = new Intent(Intent.ACTION_VIEW, Uri.parse(urls));
			startActivity(browserIntent);
			final Handler handler1 = new Handler();
			handler1.postDelayed(() -> {
				overridePendingTransition(R.anim.fade_in, R.anim.fade_out);
				finishAndRemoveTask();
			}, 10);
		}, 1000);
	}
	
	public Handler mHandler = new Handler();
	public void toast(final CharSequence text, final Context context) {
        mHandler.post(() -> {
			try {
				Toast.makeText(context,text,Toast.LENGTH_SHORT).show();
			}
			catch(Exception ignored) {

			}
		});
    }
}
