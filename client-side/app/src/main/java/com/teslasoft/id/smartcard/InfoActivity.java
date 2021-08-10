package com.teslasoft.id.smartcard;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.content.ComponentName;
import android.content.Context;
import android.content.pm.PackageManager;
import android.content.pm.Signature;
import android.os.Bundle;
import android.app.Activity;
import android.os.Handler;
import android.view.View;
import android.content.Intent;
import android.net.Uri;
import android.widget.TextView;
import android.content.pm.PackageInfo;
import android.widget.Toast;

public class InfoActivity extends Activity
{
	public TextView app_ver;
	public TextView app_id;
	public TextView app_sg;
	public PackageInfo pInfo;
	private String signatureHash;
	public Signature sig;
	public int versionCode = BuildConfig.VERSION_CODE;
	public String versionName = BuildConfig.VERSION_NAME;
	public Context context;
	
	@SuppressLint({"SetTextI18n", "PackageManagerGetSignatures"})
	@Override
	protected void onCreate(Bundle savedInstanceState)
	{
		super.onCreate(savedInstanceState);
		setContentView(R.layout.info);
		
		try {
			pInfo = this.getPackageManager().getPackageInfo(this.getPackageName(), 0);
		} catch (Exception e) {
			e.printStackTrace();
		}
		
		String version = pInfo.versionName;
		/* int verCode = pInfo.versionCode; */
		
		app_ver = (TextView) findViewById(R.id.app_ver);
		app_id = (TextView) findViewById(R.id.app_id);
		app_sg = (TextView) findViewById(R.id.app_sg);
		
		@SuppressLint("HardwareIds") String android_id = android.provider.Settings.Secure.getString(getContentResolver(), android.provider.Settings.Secure.ANDROID_ID);
		
		app_id.setText(getString(R.string.inf_android_id) + " " + android_id);
		app_ver.setText(getString(R.string.info_app_ver) + " " + version);

		try {
			sig = this.getPackageManager().getPackageInfo(this.getPackageName(), PackageManager.GET_SIGNATURES).signatures[0];
			signatureHash = Integer.toString(sig.hashCode());
			app_sg.setText(getString(R.string.sg) + " " + signatureHash);
		} catch(Exception e) {
			app_sg.setText(getString(R.string.sg) + " Invalid certificate");
		}
	}
	
	public void Auth(View v) {
		Intent auth_intent = new Intent(this, com.teslasoft.id.smartcard.NfcAuthenticator.class);
		startActivity(auth_intent);
	}
	
	public void Settings(View v) {
		Intent intent = new Intent(android.provider.Settings.ACTION_APPLICATION_DETAILS_SETTINGS);
        intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
        intent.setData(Uri.parse("package:" + this.getPackageName()));
		startActivity(intent);
	}
	
	public void Privacy(View v) {
		Intent privacy_intent = new Intent(Intent.ACTION_VIEW);
		privacy_intent.setData(Uri.parse("https://teslasoft.org/privacy"));
		startActivity(privacy_intent);
	}
	
	public void Github(View v) {
		Intent github = new Intent(Intent.ACTION_VIEW);
		github.setData(Uri.parse("https://github.com/xXDima212DimaXx/Teslasoft-ID"));
		startActivity(github);
	}

	public void LisLauncher(View view) {
		new AlertDialog.Builder(this)
				.setTitle("Question")
				.setMessage("You can hide icon to reduce amount of icons on your desktop. This page will also be hidden. Would you like to hide launcher icon? You can recover it by reinstalling app. You can still use this app by opening supported links.")
				.setCancelable(false)
				.setNegativeButton(android.R.string.cancel, (dialog, which) -> doNothing())
				.setPositiveButton(android.R.string.ok, (dialog, which) -> hideIcon(this))
				.show();
	}

	public void hideIcon(Context context) {
		PackageManager pm = getPackageManager();
		pm.setComponentEnabledSetting(new ComponentName(this, com.teslasoft.id.smartcard.InfoActivity.class), PackageManager.COMPONENT_ENABLED_STATE_DISABLED, PackageManager.DONT_KILL_APP);
		toast("Launcher icon has been hidden successfully", this);
	}

	public void doNothing() {

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
