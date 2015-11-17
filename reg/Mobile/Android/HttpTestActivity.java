/*
 * Project:		HTTP Test
 * Purpose:		HTTP Test
 * Author:		Ho-Jung Kim (godmode2k@hotmail.com)
 * Date:		Since Oct 24, 2015
 * Filename:	HttpTestActivity.java
 * 
 * Last modified:	Nov 16, 2015
 * License:
 * 
 *
 * Copyright (C) 2014 Ho-Jung Kim (godmode2k@hotmail.com)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * 
 * Source:
 * Note: {
  }
 * -----------------------------------------------------------------
 * TODO:
 *
 * URGENT!!!
 * TODO:
 *
 */

package com.test.testNetSensorAll;

import android.app.Activity;

import android.app.Dialog;
import android.app.AlertDialog;
import android.app.AlertDialog.Builder;
import android.app.ProgressDialog;

import android.content.BroadcastReceiver;
import android.content.ContentResolver;
import android.content.ContentUris;
import android.content.ContentValues;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.res.AssetFileDescriptor;
import android.content.res.Configuration;
import android.database.Cursor;
import android.content.Context;

import java.io.BufferedWriter;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.BufferedReader;
import java.io.OutputStream;
import java.io.OutputStreamWriter;
import java.io.UnsupportedEncodingException;

import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLConnection;
import java.net.HttpURLConnection;
import java.net.URLEncoder;

import javax.net.ssl.HttpsURLConnection;

import org.json.JSONArray;
import org.json.JSONObject;

import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;
import java.util.List;
import java.util.Map;
import java.util.HashMap;
import java.util.ArrayList;
import java.util.Iterator;
import java.util.Random;
import java.util.Set;
import java.lang.Thread;

import android.media.AudioManager;
import android.net.Uri;
import android.net.wifi.ScanResult;
import android.net.wifi.WifiManager;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Color;
import android.graphics.Paint;
import android.graphics.RectF;
import android.graphics.Bitmap.Config;
import android.graphics.Typeface;
import android.os.AsyncTask;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.AttributeSet;
import android.util.Log;
import android.view.KeyEvent;
import android.view.MotionEvent;
import android.view.View;
import android.view.LayoutInflater;
import android.view.WindowManager;
import android.view.View.OnClickListener;

import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.SeekBar.OnSeekBarChangeListener;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.SeekBar;
import android.widget.TextView;
import android.widget.Toast;

import android.text.Editable;
import android.text.Html;
import android.text.TextWatcher;
import android.text.format.DateFormat;
import android.text.method.LinkMovementMethod;
import android.text.util.Linkify;

import java.util.Arrays;



public class HttpTestActivity extends Activity {
	final static String TAG = "HttpTestActivity";


	// Action
	private static final int __ACTION_UNKNOWN__ = -1;
	private static final int __ACTION_LOGIN__ = 0;
	private static final int __ACTION_LOGOUT__ = 1;
	private static final int __ACTION_SIGN_UP__ = 2;
	private static final int __ACTION_GET_ACCOUNT_INFO__ = 3;
	private static final int __ACTION_SET_ACCOUNT_INFO__ = 4;
	private static final int __ACTION_SET_ACCOUNT_INFO_REMOVE__ = 5;

	
	// session id
	private String m_cookie = null;
	
	
	// ipaddr:port, Login
	private String m_ipaddr = null;
	private String m_port = null;
	private String m_userid = null;
	private String m_passwd = null;
	
	// account info
	private String m_account_info_id = null;
	private String m_account_info_passwd_cur = null;
	private String m_account_info_passwd_new = null;
	private String m_account_info_name = null;
	private String m_account_info_email = null;
	private String m_account_info_email_confirm = null;
	private String m_account_info_phone = null;
	//
	private String m_account_info_confirm_url = null;
	
	
	
	// ----------------------------------------------------------
	
	
	
	/** Called when the activity is first created. */
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

        setContentView(R.layout.http_test_activity);
        
        // Prevent soft-keyboard slide-out
        getWindow().setSoftInputMode( WindowManager.LayoutParams.SOFT_INPUT_STATE_ALWAYS_HIDDEN );
        
        // Initialize
        init();
    }
    
    @Override
    protected void onDestroy() {
    	super.onDestroy();
    	
    	__DEBUG__( "onDestroy()" );
    	

    	// Release
    	release();
    	
    	System.gc();
    }
    
    @Override
    public void onConfigurationChanged(Configuration newConfig) {
        // TODO Auto-generated method stub
        super.onConfigurationChanged(newConfig);
        
        __DEBUG__( "onConfigurationChanged()" );
    }
    
    @Override
    public void onRestoreInstanceState(Bundle savedInstanceState) {
        super.onRestoreInstanceState(savedInstanceState);
        
        __DEBUG__( "onRestoreInstanceState()" );
    }
    
    @Override
    public void onRestart(){
        super.onRestart();

        __DEBUG__( "onRestart()" );
    }

    @Override
    public void onStart(){
        super.onStart();
        
        __DEBUG__( "onStart()" );
    }
   
    @Override
    public void onResume(){
        super.onResume();
        
        __DEBUG__( "onResume()" );
    }
    
    @Override
    public void onSaveInstanceState(Bundle savedInstanceState){
        super.onSaveInstanceState(savedInstanceState);
        
        __DEBUG__( "onSaveInstanceState()" );
    }
    
    @Override
    protected void onPause() {
    	// TODO Auto-generated method stub
    	super.onPause();
    	
    	__DEBUG__( "onPuase()" );
    }
    
    @Override
    public void onStop() {
        super.onStop();

        __DEBUG__( "onStop()" );
    }
    
    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {
    	if ( keyCode == KeyEvent.KEYCODE_BACK ) {
			//return true;
    		HttpTestActivity.this.finish();
    	}

    	return super.onKeyDown( keyCode, event );
    }
    
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
    	// TODO Auto-generated method stub
    	//super.onActivityResult(requestCode, resultCode, data);
    	
    	__DEBUG__( "onActivityResult()" );
    	
    	if ( resultCode == RESULT_OK ) {
    	}
    	else {
    		__DEBUG__( "onActivityResult(): Unknown resultCode = " + resultCode );
    	}
    	
    	super.onActivityResult(requestCode, resultCode, data);
    }
    
    // ------------------------------------------------------------------------
	
    public void __DEBUG__(String str) {
    	Log.d( TAG, str );
    }

    public void __DEBUG_ERROR__(String str, StackTraceElement[] val) {
		Log.d( TAG, "Exception: " + str );
    	if ( val != null ) {
	 		for ( int i = 0; i < val.length; i++ ) {
	 			Log.d( TAG, "Exception: [" + i + "] " + val[i] );
	 		}
 		}
    }
    
    // ------------------------------------------------------------------------
    
    private boolean init() {
    	__DEBUG__( "init()" );
    	
    	// HTTP method test
    	{
    		Button btn_login = (Button)findViewById( R.id.Button_login );
    		Button btn_logout = (Button)findViewById( R.id.Button_logout );
    		Button btn_sign_up = (Button)findViewById( R.id.Button_sign_up );
    		Button btn_account_info = (Button)findViewById( R.id.Button_account_info );
    		
    		if ( btn_login != null ) {
    			btn_login.setOnClickListener( new OnClickListener() {
    				/*
    				final EditText m_et_ipaddr = (EditText)findViewById( R.id.EditText_ipaddr );
    				final EditText m_et_port = (EditText)findViewById( R.id.EditText_port );
    				final EditText m_et_userid = (EditText)findViewById( R.id.EditText_userid );
    				final EditText m_et_passwd = (EditText)findViewById( R.id.EditText_passwd );
    				*/
    				
					@Override
					public void onClick(View v) {
						// TODO Auto-generated method stub
						
						/*
						if ( m_et_ipaddr != null ) {
							if ( m_et_ipaddr.getText() != null ) {
								m_ipaddr = m_et_ipaddr.getText().toString();
							}
						}
						
						if ( m_et_port != null ) {
							if ( m_et_port.getText() != null ) {
								m_port = m_et_port.getText().toString();
							}
						}
						
						if ( m_et_userid != null ) {
							if ( m_et_userid.getText() != null ) {
								m_userid = m_et_userid.getText().toString();
							}
						}
						
						if ( m_et_passwd != null ) {
							if ( m_et_passwd.getText() != null ) {
								m_passwd = m_et_passwd.getText().toString();
							}
						}
						*/
						
						set_ipaddr_idpasswd( true, true );
						
						
						if ( (m_ipaddr != null) && (m_userid != null) && (m_passwd != null) ) {
							http_method_test( __ACTION_LOGIN__, m_ipaddr, m_port, m_userid, m_passwd );
						}
					}
				});
    		}
    		
    		if ( btn_logout != null ) {
    			btn_logout.setOnClickListener( new OnClickListener() {
					@Override
					public void onClick(View v) {
						// TODO Auto-generated method stub
						
						http_method_test( __ACTION_LOGOUT__, m_ipaddr, m_port );
						
						clear_layout_all();
					}
				});
    		}
    		
    		if ( btn_sign_up != null ) {
    			btn_sign_up.setOnClickListener( new OnClickListener() {
					@Override
					public void onClick(View v) {
						// TODO Auto-generated method stub
						
						clear_layout_all();
						
						final LinearLayout sign_up = (LinearLayout)findViewById( R.id.LinearLayout_sign_up );
						if ( sign_up == null ) {
							Toast.makeText( HttpTestActivity.this, "sign-up layout == NULL", Toast.LENGTH_SHORT ).show();
							return;
						}
						sign_up.setVisibility( View.VISIBLE );
					}
				});
    		}
    		
    		if ( btn_account_info != null ) {
    			btn_account_info.setOnClickListener( new OnClickListener() {
					@Override
					public void onClick(View v) {
						// TODO Auto-generated method stub
						
						clear_layout_all();
						
						final LinearLayout account_info = (LinearLayout)findViewById( R.id.LinearLayout_account_info );
						if ( account_info == null ) {
							Toast.makeText( HttpTestActivity.this, "account layout == NULL", Toast.LENGTH_SHORT ).show();
							return;
						}
						account_info.setVisibility( View.VISIBLE );
						
						
						http_method_test( __ACTION_GET_ACCOUNT_INFO__, m_ipaddr, m_port, m_userid, m_passwd );
					}
				});
    		}
    		
    		
    		
    		{
    			/*
    			EditText et_ipaddr = (EditText)findViewById( R.id.EditText_ipaddr );
    			EditText et_port = (EditText)findViewById( R.id.EditText_port );
				EditText et_userid = (EditText)findViewById( R.id.EditText_userid );
				EditText et_passwd = (EditText)findViewById( R.id.EditText_passwd );
				
				if ( et_ipaddr != null )
					et_ipaddr.setText( "192.168." );
				
				if ( et_port != null )
					et_port.setText( "8080" );
				
				if ( et_userid != null )
					et_userid.setText( "test1" );
				
				if ( et_passwd != null )
					et_passwd.setText( "12345678" );
				*/
    			
    			final String ipaddr = "192.168.";
    			final String port = "8080";
    			final String id = "test1";
    			final String passwd = "12345678";
    			
    			set_ipaddr_idpasswd( ipaddr, port, id, passwd );
    		}
    		
    		
    		
    		// Sign-Up layout
    		{
    			final LinearLayout sign_up = (LinearLayout)findViewById( R.id.LinearLayout_sign_up );
    			if ( sign_up == null ) {
    				Log.d( TAG, "init(): sign-up layout == NULL" );
    				Toast.makeText( HttpTestActivity.this, "sign-up layout == NULL", Toast.LENGTH_SHORT ).show();
    				return false;
    			}
    			
    			final Button btn_sign_up_done = (Button)sign_up.findViewById( R.id.Button_sign_up_done );
    			
    			if ( btn_sign_up_done != null ) {
    				btn_sign_up_done.setOnClickListener( new OnClickListener() {
						@Override
						public void onClick(View v) {
							// TODO Auto-generated method stub
							
							
							final EditText et_sign_up_id = (EditText)sign_up.findViewById( R.id.EditText_sign_up_id );
							final EditText et_sign_up_passwd = (EditText)sign_up.findViewById( R.id.EditText_sign_up_passwd );
							final EditText et_sign_up_passwd_confirm = (EditText)sign_up.findViewById( R.id.EditText_sign_up_passwd_confirm );
							final EditText et_sign_up_name = (EditText)sign_up.findViewById( R.id.EditText_sign_up_name );
							final EditText et_sign_up_email = (EditText)sign_up.findViewById( R.id.EditText_sign_up_email );
							final EditText et_sign_up_email_confirm = (EditText)sign_up.findViewById( R.id.EditText_sign_up_email_confirm );
							final EditText et_sign_up_phone = (EditText)sign_up.findViewById( R.id.EditText_sign_up_phone );
							String sign_up_id = null;
							String sign_up_passwd = null;
							String sign_up_passwd_confirm = null;
							String sign_up_name = null;
							String sign_up_email = null;
							String sign_up_email_confirm = null;
							String sign_up_phone = null;
							
							if ( et_sign_up_id != null ) {
								if ( et_sign_up_id.getText() != null ) {
									sign_up_id = et_sign_up_id.getText().toString();
								}
							}
							
							if ( et_sign_up_passwd != null ) {
								if ( et_sign_up_passwd.getText() != null ) {
									sign_up_passwd = et_sign_up_passwd.getText().toString();
								}
							}
							
							if ( et_sign_up_passwd_confirm != null ) {
								if ( et_sign_up_passwd_confirm.getText() != null ) {
									sign_up_passwd_confirm = et_sign_up_passwd_confirm.getText().toString();
								}
							}
							
							if ( et_sign_up_name != null ) {
								if ( et_sign_up_name.getText() != null ) {
									sign_up_name = et_sign_up_name.getText().toString();
								}
							}
							
							if ( et_sign_up_email != null ) {
								if ( et_sign_up_email.getText() != null ) {
									sign_up_email = et_sign_up_email.getText().toString();
								}
							}
							
							if ( et_sign_up_email_confirm != null ) {
								if ( et_sign_up_email_confirm.getText() != null ) {
									sign_up_email_confirm = et_sign_up_email_confirm.getText().toString();
								}
							}
							
							if ( et_sign_up_phone != null ) {
								if ( et_sign_up_phone != null ) {
									sign_up_phone = et_sign_up_phone.getText().toString();
								}
							}
							
							
							if ( (sign_up_name == null) ||
									(sign_up_email == null) ||
									(sign_up_email_confirm == null) ||
									(sign_up_phone == null) ) {
								Log.d( TAG, "init(): sign-up info == NULL" );
								return;
							}
							if ( sign_up_name.isEmpty() || sign_up_phone.isEmpty() ) {
								Log.d( TAG, "init(): sign-up (name, phone) == empty" );
								Toast.makeText( HttpTestActivity.this, "fill out: name, phone ", Toast.LENGTH_SHORT ).show();
								return;
							}
							if ( sign_up_email.isEmpty() || sign_up_email_confirm.isEmpty() ) {
								if ( sign_up_email.isEmpty() ) {
									Log.d( TAG, "init(): sign-up (email) == empty" );
									Toast.makeText( HttpTestActivity.this, "fill out: email", Toast.LENGTH_SHORT ).show();
									return;
								}
								if ( sign_up_email_confirm.isEmpty() ) {
									Log.d( TAG, "init(): sign-up (confirm email) == empty" );
									Toast.makeText( HttpTestActivity.this, "fill out: confirm email", Toast.LENGTH_SHORT ).show();
									return;
								}
							}
							
							
							// Passwd
							/*
							if ( (sign_up_passwd_current != null) && (sign_up_passwd_new != null) ) {
								if ( !sign_up_passwd_current.equals(sign_up_passwd_new) ) {
									Log.d( TAG, "init(): passwd doesn't matched" );
									Toast.makeText( HttpTestActivity.this, "passwd doesn't matched", Toast.LENGTH_SHORT ).show();
									return;
								}
							}
							*/
							if ( (sign_up_passwd != null) && (sign_up_passwd_confirm != null) ) {
								if ( !sign_up_passwd.isEmpty() ||
										!sign_up_passwd_confirm.isEmpty() ) {
									if ( sign_up_passwd.isEmpty() ) {
										Log.d( TAG, "init(): sign-up (passwd) == empty" );
										Toast.makeText( HttpTestActivity.this, "fill out: passwd", Toast.LENGTH_SHORT ).show();
										return;
									}
									if ( sign_up_passwd_confirm.isEmpty() ) {
										Log.d( TAG, "init(): sign-up (confirm passwd) == empty" );
										Toast.makeText( HttpTestActivity.this, "fill out: confirm passwd", Toast.LENGTH_SHORT ).show();
										return;
									}
								
									// confirm password
									if ( !sign_up_passwd.equals(sign_up_passwd_confirm) ) {
										Log.d( TAG, "init(): passwd doesn't matched" );
										Toast.makeText( HttpTestActivity.this, "passwd doesn't matched", Toast.LENGTH_SHORT ).show();
										return;
									}
								}
							}
							
							// Email
							if ( (sign_up_email != null) && (sign_up_email_confirm != null) ) {
								if ( !sign_up_email.equals(sign_up_email_confirm) ) {
									Log.d( TAG, "init(): email doesn't matched" );
									Toast.makeText( HttpTestActivity.this, "email doesn't matched", Toast.LENGTH_SHORT ).show();
									return;
								}
							}
							
							// Phone
							if ( sign_up_phone != null ) {
								// check...
								// ...
							}
							
							
							set_ipaddr_idpasswd( true, false );
							
							
							http_method_test( __ACTION_SIGN_UP__, m_ipaddr, m_port );
						}
					});
    			}
    		} // Sign-Up layout
    		
    		
    		
    		// Account layout
    		{
    			final LinearLayout account_info = (LinearLayout)findViewById( R.id.LinearLayout_account_info );
    			if ( account_info == null ) {
    				Log.d( TAG, "init(): account layout == NULL" );
    				Toast.makeText( HttpTestActivity.this, "account layout == NULL", Toast.LENGTH_SHORT ).show();
    				return false;
    			}
    			
    			final Button btn_account_info_done = (Button)account_info.findViewById( R.id.Button_account_info_done );
    			final Button btn_account_info_remove = (Button)account_info.findViewById( R.id.Button_account_info_remove );
    			
    			
    			if ( btn_account_info_done != null ) {
    				btn_account_info_done.setOnClickListener( new OnClickListener() {
						@Override
						public void onClick(View v) {
							// TODO Auto-generated method stub
							
							//final TextView tv_account_info_id = (TextView)account_info.findViewById( R.id.TextView_account_info_id );
							final EditText et_account_info_passwd_current = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_current );
							final EditText et_account_info_passwd_new = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_new );
							final EditText et_account_info_passwd_new_confirm = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_new_confirm );
							final EditText et_account_info_name = (EditText)account_info.findViewById( R.id.EditText_account_info_name );
							final EditText et_account_info_email = (EditText)account_info.findViewById( R.id.EditText_account_info_email );
							final EditText et_account_info_email_confirm = (EditText)account_info.findViewById( R.id.EditText_account_info_email_confirm );
							final EditText et_account_info_phone = (EditText)account_info.findViewById( R.id.EditText_account_info_phone );
							//String account_info_id = null;
							String account_info_passwd_current = null;
							String account_info_passwd_new = null;
							String account_info_passwd_new_confirm = null;
							String account_info_name = null;
							String account_info_email = null;
							String account_info_email_confirm = null;
							String account_info_phone = null;
							
							//if ( tv_account_info_id != null ) {
							//	if ( tv_account_info_id.getText() != null ) {
							//		account_info_id = tv_account_info_id.getText().toString();
							//	}
							//}
							
							if ( et_account_info_passwd_current != null ) {
								if ( et_account_info_passwd_current.getText() != null ) {
									account_info_passwd_current = et_account_info_passwd_current.getText().toString();
								}
							}
							
							if ( et_account_info_passwd_new != null ) {
								if ( et_account_info_passwd_new.getText() != null ) {
									account_info_passwd_new = et_account_info_passwd_new.getText().toString();
								}
							}
							
							if ( et_account_info_passwd_new_confirm != null ) {
								if ( et_account_info_passwd_new_confirm.getText() != null ) {
									account_info_passwd_new_confirm = et_account_info_passwd_new_confirm.getText().toString();
								}
							}
							
							if ( et_account_info_name != null ) {
								if ( et_account_info_name.getText() != null ) {
									account_info_name = et_account_info_name.getText().toString();
								}
							}
							
							if ( et_account_info_email != null ) {
								if ( et_account_info_email.getText() != null ) {
									account_info_email = et_account_info_email.getText().toString();
								}
							}
							
							if ( et_account_info_email_confirm != null ) {
								if ( et_account_info_email_confirm.getText() != null ) {
									account_info_email_confirm = et_account_info_email_confirm.getText().toString();
								}
							}
							
							if ( et_account_info_phone != null ) {
								if ( et_account_info_phone != null ) {
									account_info_phone = et_account_info_phone.getText().toString();
								}
							}
							
							
							if ( (account_info_name == null) ||
									(account_info_email == null) ||
									(account_info_email_confirm == null) ||
									(account_info_phone == null) ) {
								Log.d( TAG, "init(): account info == NULL" );
								return;
							}
							if ( account_info_name.isEmpty() || account_info_phone.isEmpty() ) {
								Log.d( TAG, "init(): account info (name, phone) == empty" );
								Toast.makeText( HttpTestActivity.this, "fill out: name, phone ", Toast.LENGTH_SHORT ).show();
								return;
							}
							if ( account_info_email.isEmpty() || account_info_email_confirm.isEmpty() ) {
								if ( account_info_email.isEmpty() ) {
									Log.d( TAG, "init(): account info (email) == empty" );
									Toast.makeText( HttpTestActivity.this, "fill out: email", Toast.LENGTH_SHORT ).show();
									return;
								}
								if ( account_info_email_confirm.isEmpty() ) {
									if ( (m_account_info_email != null) && !m_account_info_email.equals(account_info_email) ) {
										Log.d( TAG, "init(): account info (confirm email) == empty" );
										Toast.makeText( HttpTestActivity.this, "fill out: confirm email", Toast.LENGTH_SHORT ).show();
										return;
									}
								}
							}
							
							
							// Passwd
							/*
							if ( (account_info_passwd_current != null) && (account_info_passwd_new != null) ) {
								if ( !account_info_passwd_current.equals(account_info_passwd_new) ) {
									Log.d( TAG, "init(): passwd doesn't matched" );
									Toast.makeText( HttpTestActivity.this, "passwd doesn't matched", Toast.LENGTH_SHORT ).show();
									return;
								}
							}
							*/
							if ( (account_info_passwd_current != null) &&
									(account_info_passwd_new != null) && (account_info_passwd_new_confirm != null) ) {
								if ( !account_info_passwd_current.isEmpty() ||
										!account_info_passwd_new.isEmpty() ||
										!account_info_passwd_new_confirm.isEmpty() ) {
									if ( account_info_passwd_current.isEmpty() ) {
										Log.d( TAG, "init(): account info (current passwd) == empty" );
										Toast.makeText( HttpTestActivity.this, "fill out: current passwd", Toast.LENGTH_SHORT ).show();
										return;
									}
									if ( account_info_passwd_new.isEmpty() ) {
										Log.d( TAG, "init(): account info (new passwd) == empty" );
										Toast.makeText( HttpTestActivity.this, "fill out: new passwd", Toast.LENGTH_SHORT ).show();
										return;
									}
									if ( account_info_passwd_new_confirm.isEmpty() ) {
										Log.d( TAG, "init(): account info (confirm new passwd) == empty" );
										Toast.makeText( HttpTestActivity.this, "fill out: confirm new passwd", Toast.LENGTH_SHORT ).show();
										return;
									}
								
									// confirm new password
									if ( !account_info_passwd_new.equals(account_info_passwd_new_confirm) ) {
										Log.d( TAG, "init(): new passwd doesn't matched" );
										Toast.makeText( HttpTestActivity.this, "new passwd doesn't matched", Toast.LENGTH_SHORT ).show();
										return;
									}
								}
							}
							
							// Email
							if ( (account_info_email != null) && (account_info_email_confirm != null) ) {
								if ( (m_account_info_email != null) && !m_account_info_email.equals(account_info_email) ) {
									if ( !account_info_email.equals(account_info_email_confirm) ) {
										Log.d( TAG, "init(): email doesn't matched" );
										Toast.makeText( HttpTestActivity.this, "email doesn't matched", Toast.LENGTH_SHORT ).show();
										return;
									}
								}
							}
							
							// Phone
							if ( account_info_phone != null ) {
								// check...
								// ...
							}
							
							
							http_method_test( __ACTION_SET_ACCOUNT_INFO__, m_ipaddr, m_port, m_userid, m_passwd );
						}
					});
    			}
    			
    			if ( btn_account_info_remove != null ) {
    				btn_account_info_remove.setOnClickListener( new OnClickListener() {
						@Override
						public void onClick(View v) {
							// TODO Auto-generated method stub
							
							final EditText et_account_info_passwd_current = (EditText)account_info.findViewById( R.id.EditText_account_info_remove_passwd_current );
							String account_info_remove_passwd_current = null;
							
							if ( et_account_info_passwd_current != null ) {
								if ( et_account_info_passwd_current.getText() != null ) {
									account_info_remove_passwd_current = et_account_info_passwd_current.getText().toString();
									
									if ( !account_info_remove_passwd_current.isEmpty() ) {
										// confirm new password
										if ( (m_passwd != null) && !m_passwd.equals(account_info_remove_passwd_current) ) {
											Log.d( TAG, "init(): passwd doesn't matched" );
											Toast.makeText( HttpTestActivity.this, "new passwd doesn't matched", Toast.LENGTH_SHORT ).show();
											return;
										}
										
										http_method_test( __ACTION_SET_ACCOUNT_INFO_REMOVE__, m_ipaddr, m_port, m_userid, m_passwd );
									}
								}
							}
						}
					});
    			}
    		} // account layout
    	}
    	
    	
    	
    	return true;
    }
    
    private void release() {
    	__DEBUG__( "release()" );
    }
    
    
    // ------------------------------------------------------------------------
    
    
    public void clear_layout_all() {
    	// Account info
		{
			final LinearLayout account_info = (LinearLayout)findViewById( R.id.LinearLayout_account_info );
			if ( account_info == null ) {
				__DEBUG__( "clear_layout_all(): account layout == NULL" );
				//Toast.makeText( HttpTestActivity.this, "account layout == NULL", Toast.LENGTH_SHORT ).show();
				return;
			}
			
			final TextView tv_account_info_id = (TextView)account_info.findViewById( R.id.TextView_account_info_id );
			final EditText et_account_info_passwd_current = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_current );
			final EditText et_account_info_passwd_new = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_new );
			final EditText et_account_info_passwd_new_confirm = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_new_confirm );
			final EditText et_account_info_name = (EditText)account_info.findViewById( R.id.EditText_account_info_name );
			final EditText et_account_info_email = (EditText)account_info.findViewById( R.id.EditText_account_info_email );
			final EditText et_account_info_email_confirm = (EditText)account_info.findViewById( R.id.EditText_account_info_email_confirm );
			final EditText et_account_info_phone = (EditText)account_info.findViewById( R.id.EditText_account_info_phone );
			
			if ( tv_account_info_id != null ) {
				tv_account_info_id.setText( "" );
			}
			
			if ( et_account_info_passwd_current != null ) {
				et_account_info_passwd_current.setText( "" );
			}
			if ( et_account_info_passwd_new != null ) {
				et_account_info_passwd_new.setText( "" );
			}
			if ( et_account_info_passwd_new_confirm != null ) {
				et_account_info_passwd_new_confirm.setText( "" );
			}
			
			if ( et_account_info_name != null ) {
				et_account_info_name.setText( "" );
			}
			
			if ( et_account_info_email != null ) {
				et_account_info_email.setText( "" );
			}
			if ( et_account_info_email_confirm != null ) {
				et_account_info_email_confirm.setText( "" );
			}
			
			if ( et_account_info_phone != null ) {
				et_account_info_phone.setText( "" );
			}
			
			account_info.setVisibility( View.GONE );
		}
		
    	// Sign-Up
		{
			final LinearLayout sign_up = (LinearLayout)findViewById( R.id.LinearLayout_sign_up );
			if ( sign_up == null ) {
				__DEBUG__( "clear_layout_all(): sign-up layout == NULL" );
				//Toast.makeText( HttpTestActivity.this, "sign-up layout == NULL", Toast.LENGTH_SHORT ).show();
				return;
			}
			
			final EditText et_sign_up_id = (EditText)sign_up.findViewById( R.id.EditText_sign_up_id );
			final EditText et_sign_up_passwd = (EditText)sign_up.findViewById( R.id.EditText_sign_up_passwd );
			final EditText et_sign_up_passwd_confirm = (EditText)sign_up.findViewById( R.id.EditText_sign_up_passwd_confirm );
			final EditText et_sign_up_name = (EditText)sign_up.findViewById( R.id.EditText_sign_up_name );
			final EditText et_sign_up_email = (EditText)sign_up.findViewById( R.id.EditText_sign_up_email );
			final EditText et_sign_up_email_confirm = (EditText)sign_up.findViewById( R.id.EditText_sign_up_email_confirm );
			final EditText et_sign_up_phone = (EditText)sign_up.findViewById( R.id.EditText_sign_up_phone );
			
			if ( et_sign_up_id != null ) {
				et_sign_up_id.setText( "" );
			}
			
			if ( et_sign_up_passwd != null ) {
				et_sign_up_passwd.setText( "" );
			}
			if ( et_sign_up_passwd_confirm != null ) {
				et_sign_up_passwd_confirm.setText( "" );
			}
			
			if ( et_sign_up_name != null ) {
				et_sign_up_name.setText( "" );
			}
			
			if ( et_sign_up_email != null ) {
				et_sign_up_email.setText( "" );
			}
			if ( et_sign_up_email_confirm != null ) {
				et_sign_up_email_confirm.setText( "" );
			}
			
			if ( et_sign_up_phone != null ) {
				et_sign_up_phone.setText( "" );
			}
			
			sign_up.setVisibility( View.GONE );
		}
    }
    
    public void clear_layout_confirm_url() {
    	// Confirm URL
    	{
			final LinearLayout sign_up_confirm_url_layout = (LinearLayout)findViewById( R.id.LinearLayout_sign_up_confirm_url );
			if ( sign_up_confirm_url_layout == null ) {
				__DEBUG__( "clear_layout_confirm_url(): sign-up confirm url layout == NULL" );
				//Toast.makeText( HttpTestActivity.this, "sign-up confirm url layout == NULL", Toast.LENGTH_SHORT ).show();
				return;
			}
			
			TextView tv_confirm_url = (TextView)findViewById( R.id.TextView_sign_up_confirm_url );
			
			if ( tv_confirm_url != null ) {
				tv_confirm_url.setText( "" );
			}
			
			sign_up_confirm_url_layout.setVisibility( View.GONE );
		}
    }
    
    public void set_ipaddr_idpasswd(boolean ipaddr, boolean idpasswd) {
		if ( ipaddr ) {
	    	final EditText et_ipaddr = (EditText)findViewById( R.id.EditText_ipaddr );
			final EditText et_port = (EditText)findViewById( R.id.EditText_port );
			
			m_ipaddr = "";
			m_port = "";
			
			if ( et_ipaddr != null ) {
				if ( et_ipaddr.getText() != null ) {
					m_ipaddr = et_ipaddr.getText().toString();
				}
			}
			
			if ( et_port != null ) {
				if ( et_port.getText() != null ) {
					m_port = et_port.getText().toString();
				}
			}
		}
		
		if ( idpasswd ) {
			final EditText et_userid = (EditText)findViewById( R.id.EditText_userid );
			final EditText et_passwd = (EditText)findViewById( R.id.EditText_passwd );
			
			m_userid = "";
			m_passwd = "";
			
			if ( et_userid != null ) {
				if ( et_userid.getText() != null ) {
					m_userid = et_userid.getText().toString();
				}
			}
			
			if ( et_passwd != null ) {
				if ( et_passwd.getText() != null ) {
					m_passwd = et_passwd.getText().toString();
				}
			}
		}
    }
    
    public void set_ipaddr_idpasswd(String ipaddr, String port, String id, String passwd) {
    	final EditText et_ipaddr = (EditText)findViewById( R.id.EditText_ipaddr );
		final EditText et_port = (EditText)findViewById( R.id.EditText_port );
		final EditText et_userid = (EditText)findViewById( R.id.EditText_userid );
		final EditText et_passwd = (EditText)findViewById( R.id.EditText_passwd );
		
		m_ipaddr = ipaddr;
		if ( et_ipaddr != null ) {
			et_ipaddr.setText( ipaddr );
		}
		
		m_port = port;
		if ( et_port != null ) {
			et_port.setText( port );
		}
		
		m_userid = id;
		if ( et_userid != null ) {
			et_userid.setText( id );
		}
		
		m_passwd = passwd;
		if ( et_passwd != null ) {
			et_passwd.setText( passwd );
		}
    }
    
    public void set_connection_info_init_all() {
    	set_connection_info_init( true, true );
    }
    
    public void set_connection_info_init(boolean host, boolean account) {
    	if ( host ) {
	    	// session id
	    	m_cookie = null;
	    	
	    	// ipaddr:port, Login
	    	m_ipaddr = null;
	    	m_port = null;
	    	m_userid = null;
	    	m_passwd = null;
    	}
    	
    	if ( account ) {
	    	// account info
	    	m_account_info_id = null;
	    	m_account_info_passwd_cur = null;
	    	m_account_info_passwd_new = null;
	    	m_account_info_name = null;
	    	m_account_info_email = null;
	    	m_account_info_email_confirm = null;
	    	m_account_info_phone = null;
	    	
	    	//m_account_info_confirm_url = null;
    	}
    }
    
    public String make_hyperlink(final String url) {
    	return make_hyperlink( url, null );
    }
    
    public String make_hyperlink(final String url, final String desc) {
    	if ( url == null )
    		return null;
    	
		String result = "<a href=\"" + url + "\">";
		
		if ( desc != null )
			result += desc + "</a>";
		else
			result += url + "</a>";
		
		return result;
    }
    
    
    // ------------------------------------------------------------------------
    
    
    public class HttpMethodTestTask extends AsyncTask<Object, Object, Object> {
    	private int m_action = __ACTION_UNKNOWN__;
    	private String m_response = null;
    	
		@Override
		protected Object doInBackground(Object... arg0) {
			// TODO Auto-generated method stub
			//return null;

			__DEBUG__( "HttpMethodTestTask::doInBackground()" );

			boolean ret = false;

			final String ipaddr_port = (String)arg0[1];
			final String userid = (String)arg0[2];
			final String passwd = (String)arg0[3];
			
			m_action = (Integer)arg0[0];

			
			switch ( m_action ) {
				case __ACTION_LOGIN__:
					{
						// POST: login
						m_response = http_method_post_login( ipaddr_port, userid, passwd );
					} break;
				case __ACTION_LOGOUT__:
					{
						// GET: logout
						m_response = http_method_post_logout( ipaddr_port );
					} break;
				case __ACTION_SIGN_UP__:
					{
						m_response = set_http_sign_up( ipaddr_port );
					} break;
				case __ACTION_GET_ACCOUNT_INFO__:
					{
						m_response = get_http_account_info( ipaddr_port, userid, passwd );
					} break;
				case __ACTION_SET_ACCOUNT_INFO__:
					{
						m_response = set_http_account_info( ipaddr_port, userid, passwd );
					} break;
				case __ACTION_SET_ACCOUNT_INFO_REMOVE__:
					{
						m_response = set_http_account_info_remove( ipaddr_port, userid, passwd );
					} break;
				default:
					break;
			}
			
			
			
	  		return ret;
		}
		
		@Override
		protected void onProgressUpdate(Object... values) {
			// TODO Auto-generated method stub
			//super.onProgressUpdate(values);
		}

		//public void updateMessage(String strMessage) {
		//	// Callback "protected void onProgressUpdate(Object... values)"
		//	publishProgress( strMessage );
		//}
		
		@Override
		protected void onPostExecute(Object result) {
			// TODO Auto-generated method stub
			//super.onPostExecute(result);
			
			__DEBUG__( "HttpMethodTestTask::onPostExecute()" );
			
			boolean ret = (Boolean)result;
			
			
			// Result
			if ( m_response != null ) {
				TextView tv_recv = (TextView)findViewById( R.id.TextView_recv );
				
				if ( tv_recv != null ) {
					tv_recv.setText( m_response );
				}
				
				
				switch ( m_action ) {
					case __ACTION_LOGIN__:
						{
						} break;
					case __ACTION_LOGOUT__:
						{
						} break;
					case __ACTION_SIGN_UP__:
						{
							clear_layout_all();
							
							{
								final LinearLayout sign_up_confirm_url_layout = (LinearLayout)findViewById( R.id.LinearLayout_sign_up_confirm_url );
								if ( sign_up_confirm_url_layout != null ) {
									TextView tv_confirm_url = (TextView)findViewById( R.id.TextView_sign_up_confirm_url );
									
									if ( (tv_confirm_url != null) && (m_account_info_confirm_url != null) ) {
										final String url = make_hyperlink( m_account_info_confirm_url );
									
										if ( url != null ) {
											tv_confirm_url.setText( Html.fromHtml(url) );
											tv_confirm_url.setMovementMethod( LinkMovementMethod.getInstance() );
											//tv_confirm_url.setAutoLinkMask( Linkify.WEB_URLS );
											//tv_confirm_url.setLinksClickable( true );
										}
										else {
											__DEBUG__( "HttpMethodTestTask::onPostExecute(): url (hyperlink) = NULL" );
										}
									}
									
									m_account_info_confirm_url = null;
									
									sign_up_confirm_url_layout.setVisibility( View.VISIBLE );
								}
							}
						} break;
					case __ACTION_GET_ACCOUNT_INFO__:
						{
							final TextView tv_account_info_id = (TextView)findViewById( R.id.TextView_account_info_id );
							final EditText et_account_info_name = (EditText)findViewById( R.id.EditText_account_info_name );
							final EditText et_account_info_email = (EditText)findViewById( R.id.EditText_account_info_email );
							final EditText et_account_info_phone = (EditText)findViewById( R.id.EditText_account_info_phone );
							
							if ( tv_account_info_id != null ) {
								tv_account_info_id.setText( m_account_info_id );
							}
							
							if ( et_account_info_name != null ) {
								et_account_info_name.setText( m_account_info_name );
							}
							
							if ( et_account_info_email != null ) {
								et_account_info_email.setText( m_account_info_email );
							}
							
							if ( et_account_info_phone != null ) {
								et_account_info_phone.setText( m_account_info_phone );
							}
						} break;
					case __ACTION_SET_ACCOUNT_INFO__:
						{
							final TextView tv_account_info_id = (TextView)findViewById( R.id.TextView_account_info_id );
							final EditText et_account_info_name = (EditText)findViewById( R.id.EditText_account_info_name );
							final EditText et_account_info_email = (EditText)findViewById( R.id.EditText_account_info_email );
							final EditText et_account_info_phone = (EditText)findViewById( R.id.EditText_account_info_phone );
							
							if ( tv_account_info_id != null ) {
								tv_account_info_id.setText( m_account_info_id );
							}
							
							if ( et_account_info_name != null ) {
								et_account_info_name.setText( m_account_info_name );
							}
							
							if ( et_account_info_email != null ) {
								et_account_info_email.setText( m_account_info_email );
							}
							
							if ( et_account_info_phone != null ) {
								et_account_info_phone.setText( m_account_info_phone );
							}
						} break;
					case __ACTION_SET_ACCOUNT_INFO_REMOVE__:
						{
							clear_layout_all();
						} break;
					default:
						break;
				}
			}
		}
    }
    
    
    // ------------------------------------------------------------------------
    
    
    // HTTP method test
    public void http_method_test(int action, String ipaddr, String port) {
    	final String userid = null;
    	final String passwd = null;
    	
    	http_method_test( action, ipaddr, port, userid, passwd );
    }
    
    public void http_method_test(int action, String ipaddr, String port, String userid, String passwd) {
    	HttpMethodTestTask task = new HttpMethodTestTask();
    	String ipaddr_port = ipaddr;
    	
    	clear_layout_confirm_url();
		
    	if ( task != null ) {
    		if ( (port != null) && !port.isEmpty() )
    			ipaddr_port += ":" + port;
    		
    		task.execute( action, ipaddr_port, userid, passwd );
    	}
    }
    
    public String http_method_post_login(String ipaddr_port, String userid, String passwd) {
    	//Log.d( TAG, "http_method_post_login()" );
    	
    	/*
    	URL url = null;
    	URLConnection connection = null;
    	InputStream is = null;
    	//String strURLtext = URLEncoder.encode( strData, "UTF-8" );
    	
    	String user_id = "hello1";
    	String user_passwd = "12345678";

    	try {
			url = new URL( "http://localhost:8080?"
							+ "reg_login_id=" + user_id
							+ "reg_login_passwd=" + user_passwd );

			connection = url.openConnection();
			//connection.setDoInput( true);		// Get Method
			//connection.setDoOutput( true );	// Post Method
			is = connection.getInputStream();
			
	    	// ... new InputStreamReader(is, "UTF-8")
	    	// ... new InputStreamReader(is, "MS949")
	    	BufferedReader bufferedReader = new BufferedReader( new InputStreamReader(is, "MS949") );
	    	StringBuilder stringBuilder = new StringBuilder();
    	}
    	catch ( Exception e ) {
    		//
    	}
    	*/
    	
    	if ( ipaddr_port == null ) {
    		Log.d( TAG, "http_method_post_login(): ipaddr:port == NULL" );
    		return null;
    	}
    	if ( userid == null ) {
    		Log.d( TAG, "http_method_post_login(): user id == NULL" );
    		return null;
    	}
    	if ( passwd == null ) {
    		Log.d( TAG, "http_method_post_login(): passwd == NULL" );
    		return null;
    	}
    	
    	URL url = null;
    	HttpURLConnection conn = null;
    	int response_code = 0;
    	String response = null;
    	//InputStream in_stream = null;
    	OutputStream out_stream = null;
    	BufferedReader breader = null;
    	BufferedWriter bwriter = null;
    	
    	
    	//String strURLtext = URLEncoder.encode( strData, "UTF-8" );
    	
    	//final String REQ_URL = "http://localhost:8080/reg/login_chk.php";	// session login
    	final String REQ_URL = "http://" + ipaddr_port + "/reg/login_chk.php";	// session login
    	final String POST_VAR_ID = "reg_login_id";
    	final String POST_VAR_PASSWD = "reg_login_passwd";
    	//final String user_id = "test1";
    	//final String user_passwd = "12345678";
    	final String user_id = userid;
    	final String user_passwd = passwd;

    	
    	Log.d( TAG, "http_method_post_login(): REQ_URL = " + REQ_URL );
    	
    	try {
			url = new URL( REQ_URL );
			if ( url == null ) {
				Log.d( TAG, "http_method_post_login(): URL == NULL" );
				return null;
			}
			
			conn = (HttpURLConnection)url.openConnection();
			if ( conn == null ) {
				Log.d( TAG, "http_method_post_login(): URLConnection == NULL" );
				return null;
			}
			
			conn.setRequestProperty( "User-Agent", "mobile_app" );
			//conn.setRequestProperty( "Content-Type", "application/x-www-form-urlencoded" );
			conn.setReadTimeout( 15000 );
			conn.setConnectTimeout( 15000 );
			conn.setRequestMethod( "POST" );
			conn.setDoInput( true);
			conn.setDoOutput( true );
			conn.setInstanceFollowRedirects( true );
			//! session id
			{
				if ( m_cookie != null ) {
					conn.setRequestProperty( "cookie", m_cookie );
				}
			}
			
			
			out_stream = conn.getOutputStream();
			if ( out_stream == null ) {
				Log.d( TAG, "http_method_post_login(): Output Stream == NULL" );
				return null;
			}
			
			bwriter = new BufferedWriter( new OutputStreamWriter(out_stream, "UTF-8") );
			if ( bwriter == null ) {
				Log.d( TAG, "http_method_post_login(): BufferedWriter == NULL" );
				return null;
			}
			
			StringBuilder data = new StringBuilder();
			if ( data == null ) {
				Log.d( TAG, "http_method_post_login(): StringBuilder == NULL" );
				return null;
			}
			{
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_id, "UTF-8") );
				data.append( "&" );
				data.append( URLEncoder.encode(POST_VAR_PASSWD, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_passwd, "UTF-8") );
			}
			
			bwriter.write( data.toString() );
			bwriter.flush();
			bwriter.close();
			
			if ( out_stream != null )
				out_stream.close();
			
			
			response_code = conn.getResponseCode();
			Log.d( TAG, "http_method_post_login(): response code = " + response_code );
			if ( response_code == HttpsURLConnection.HTTP_OK ) {
				Log.d( TAG, "http_method_post_login(): response code = HttpsURLConnection.HTTP_OK" ); 
				
				String line = null;
				
				breader = new BufferedReader( new InputStreamReader(conn.getInputStream()) );
				if ( breader == null ) {
					Log.d( TAG, "http_method_post_login(): BufferedReader == NULL" );
					return null;
				}
				
				response = "";
				while ( (line = breader.readLine()) != null ) {
					if ( line.contains( "<br>") ) {
						line = line.replace( "<br>", "\r\n" );
					}
					response += line;
				}

				//! session id
				// Save the session id
				{
					final String cookie = conn.getHeaderField( "Set-Cookie" );
					if ( cookie != null ) {
						// To preserve stored previous cookie
						m_cookie = cookie;
					}
					
					// Cookie = PHPSESSID=qqgkmjl5sade1rljfftupj9ei3; path=/
					Log.d( TAG, "http_method_post_login(): Cookie = " + m_cookie );
				}
				
				Log.d( TAG, "http_method_post_login(): response = " + response );
				
				
				///*
				//JSON Object
				response = response.replace( "\uFEFF", "" );	// remove UTF-8 BOM
				if ( (response != null) && !response.isEmpty() ) {
//					JSONArray json = new JSONArray( response );
//					if ( json != null ) {
//						int size = json.length();
//						
//						Log.d( TAG, "http_method_post_login(): JSON obj size = " + size );
//						
//						for ( int i = 0; i < size; i++ ) {
//							JSONObject obj = json.getJSONObject( i );
//							
//							if ( obj != null ) {
//								String result = obj.getString( "result" );
//							}
//						}
//					}

					String result = null;
					try {
						JSONObject json_obj = new JSONObject( response );
						if ( json_obj != null ) {
							result = json_obj.getString( "result" );
							
							String login = json_obj.getString( "login" );
							String login_already = json_obj.getString( "login_already" );
							String user_name = json_obj.getString( "user_name" );
							String user_email = json_obj.getString( "user_email" );
							String user_phone = json_obj.getString( "user_phone" );
							
							Log.d( TAG, "http_method_post_login(): JSON obj {" );
							Log.d( TAG, "http_method_post_login():   - result = " + result );
							Log.d( TAG, "http_method_post_login():   - login = " + login );
							Log.d( TAG, "http_method_post_login():   - login_already = " + login_already );
							Log.d( TAG, "http_method_post_login():   - user_name = " + user_name );
							Log.d( TAG, "http_method_post_login():   - user_email = " + user_email );
							Log.d( TAG, "http_method_post_login():   - user_phone = " + user_phone );
							Log.d( TAG, "http_method_post_login(): }" );
							
							
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "  - login = " + login + "\r\n";
							response += "  - login_already = " + login_already + "\r\n";
							response += "  - user_name = " + user_name + "\r\n";
							response += "  - user_email = " + user_email + "\r\n";
							response += "  - user_phone = " + user_phone + "\r\n";
							response += "}" + "\r\n";
						}
					}
					catch ( Exception e ) {
						if ( result != null ) {
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "}" + "\r\n";
						}
						
						set_connection_info_init( false, true );
					}
				}
				//*/
				
				
				return response;
			}
			else {
				response = null;
			}

    	}
    	catch ( Exception e ) {
    		e.printStackTrace();
    	}
    	
    	return null;
    }
    
    public String http_method_post_logout(String ipaddr_port) {
    	//Log.d( TAG, "http_method_post_logout()" );
    	
    	if ( ipaddr_port == null ) {
    		Log.d( TAG, "http_method_post_logout(): ipaddr:port == NULL" );
    		return null;
    	}
    	
    	URL url = null;
    	HttpURLConnection conn = null;
    	int response_code = 0;
    	String response = null;
    	//InputStream in_stream = null;
    	OutputStream out_stream = null;
    	BufferedReader breader = null;
    	BufferedWriter bwriter = null;
    	
    	
    	//String strURLtext = URLEncoder.encode( strData, "UTF-8" );
    	
    	//final String REQ_URL = "http://localhost:8080/reg/logout.php";	// session logout
    	final String REQ_URL = "http://" + ipaddr_port + "/reg/logout.php";	// session logout
    	//final String POST_VAR_ID = "reg_login_id";
    	//final String POST_VAR_PASSWD = "reg_login_passwd";
    	//final String user_id = "test1";
    	//final String user_passwd = "12345678";

    	
    	Log.d( TAG, "http_method_post_logout(): REQ_URL = " + REQ_URL );
    	
    	try {
			url = new URL( REQ_URL );
			if ( url == null ) {
				Log.d( TAG, "http_method_post_logout(): URL == NULL" );
				return null;
			}
			
			conn = (HttpURLConnection)url.openConnection();
			if ( conn == null ) {
				Log.d( TAG, "http_method_post_logout(): URLConnection == NULL" );
				return null;
			}
			
			conn.setRequestProperty( "User-Agent", "mobile_app" );
			//conn.setRequestProperty( "Content-Type", "application/x-www-form-urlencoded" );
			conn.setReadTimeout( 15000 );
			conn.setConnectTimeout( 15000 );
			conn.setRequestMethod( "GET" );
			conn.setDoInput( true);
			conn.setDoOutput( true );
			//! session id
			{
				if ( m_cookie != null ) {
					conn.setRequestProperty( "cookie", m_cookie );
				}
			}
			
			
			out_stream = conn.getOutputStream();
			if ( out_stream == null ) {
				Log.d( TAG, "http_method_post_logout(): Output Stream == NULL" );
				return null;
			}
			
			bwriter = new BufferedWriter( new OutputStreamWriter(out_stream, "UTF-8") );
			if ( bwriter == null ) {
				Log.d( TAG, "http_method_post_logout(): BufferedWriter == NULL" );
				return null;
			}
			
			StringBuilder data = new StringBuilder();
			if ( data == null ) {
				Log.d( TAG, "http_method_post_logout(): StringBuilder == NULL" );
				return null;
			}
			{
				/*
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_id, "UTF-8") );
				data.append( "&" );
				data.append( URLEncoder.encode(POST_VAR_PASSWD, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_passwd, "UTF-8") );
				*/
				data.append( "" );
			}
			
			bwriter.write( data.toString() );
			bwriter.flush();
			bwriter.close();
			
			if ( out_stream != null )
				out_stream.close();
			
			
			response_code = conn.getResponseCode();
			Log.d( TAG, "http_method_post_logout(): response code = " + response_code );
			if ( response_code == HttpsURLConnection.HTTP_OK ) {
				Log.d( TAG, "http_method_post_logout(): response code = HttpsURLConnection.HTTP_OK" ); 
				
				String line = null;
				
				breader = new BufferedReader( new InputStreamReader(conn.getInputStream()) );
				if ( breader == null ) {
					Log.d( TAG, "http_method_post_logout(): BufferedReader == NULL" );
					return null;
				}
				
				response = "";
				while ( (line = breader.readLine()) != null ) {
					if ( line.contains( "<br>") ) {
						line = line.replace( "<br>", "\r\n" );
					}
					response += line;
				}
				
				//! session id
				// Save the session id
				{
					m_cookie = null;
				}
				
				Log.d( TAG, "http_method_post_logout(): response = " + response );

				
				///*
				//JSON Object
				response = response.replace( "\uFEFF", "" );	// remove UTF-8 BOM
				if ( (response != null) && !response.isEmpty() ) {
//					JSONArray json = new JSONArray( response );
//					if ( json != null ) {
//						int size = json.length();
//						
//						Log.d( TAG, "http_method_post_logout(): JSON obj size = " + size );
//						
//						for ( int i = 0; i < size; i++ ) {
//							JSONObject obj = json.getJSONObject( i );
//							
//							if ( obj != null ) {
//								String result = obj.getString( "result" );
//								
//								Log.d( TAG, "http_method_post_logout(): JSON obj[" + i + "] {" );
//								Log.d( TAG, "http_method_post_logout():     result = " + result );
//								Log.d( TAG, "http_method_post_logout(): }" );
//							}
//						}
//					}
					
					JSONObject json_obj = new JSONObject( response );
					if ( json_obj != null ) {
						String result = json_obj.getString( "result" );
						
						Log.d( TAG, "http_method_post_logout(): JSON obj {" );
						Log.d( TAG, "http_method_post_logout():   - result = " + result );
						Log.d( TAG, "http_method_post_logout(): }" );
						
						
						response += "\r\n";
						response += "JSON obj {" + "\r\n";
						response += "  - result = " + result + "\r\n";
						response += "}" + "\r\n";
					}
				}
				//*/
				
				
				/*
				// account info
				m_account_info_id = null;
				m_account_info_passwd_cur = null;
				m_account_info_passwd_new = null;
				m_account_info_name = null;
				m_account_info_email = null;
				m_account_info_email_confirm = null;
				m_account_info_phone = null;
				
				m_ipaddr = null;
				m_port = null;
				m_userid = null;
				m_passwd = null;
				m_cookie = null;
				*/
				set_connection_info_init_all();
				
				
				return response;
			}
			else {
				response = null;
			}

    	}
    	catch ( Exception e ) {
    		e.printStackTrace();
    	}
    	
    	return null;
    }
    
    public String set_http_sign_up(String ipaddr_port/*, String userid, String passwd*/) {
    	//Log.d( TAG, "set_http_sign_up()" );
    	
    	if ( ipaddr_port == null ) {
    		Log.d( TAG, "set_http_sign_up(): ipaddr:port == NULL" );
    		return null;
    	}
    	/*
    	if ( userid == null ) {
    		Log.d( TAG, "set_http_sign_up(): user id == NULL" );
    		return null;
    	}
    	if ( passwd == null ) {
    		Log.d( TAG, "set_http_sign_up(): passwd == NULL" );
    		return null;
    	}
    	*/
    	
    	URL url = null;
    	HttpURLConnection conn = null;
    	int response_code = 0;
    	String response = null;
    	//InputStream in_stream = null;
    	OutputStream out_stream = null;
    	BufferedReader breader = null;
    	BufferedWriter bwriter = null;
    	
    	
    	//String strURLtext = URLEncoder.encode( strData, "UTF-8" );
    	
    	//final String REQ_URL = "http://localhost:8080/reg/account_commit.php";
    	final String REQ_URL = "http://" + ipaddr_port + "/reg/account_commit.php";
    	final String REQ_BASE_CONFIRM_URL = "http://" + ipaddr_port + "/reg/";
    	final String POST_VAR_ID = "reg_login_id";
    	final String POST_VAR_PASSWD = "reg_login_passwd";
    	//final String POST_VAR_PASSWD_CONFIRM = "reg_login_passwd_verify";
    	final String POST_VAR_NAME = "reg_login_name";
    	final String POST_VAR_EMAIL = "reg_login_email";
    	final String POST_VAR_PHONE = "reg_login_phone";
    	//final String user_id = "test1";
    	//final String user_passwd = "12345678";
    	//final String user_id = userid;
    	//final String user_passwd = passwd;

    	
    	Log.d( TAG, "set_http_sign_up(): REQ_URL = " + REQ_URL );
    	
    	try {
			url = new URL( REQ_URL );
			if ( url == null ) {
				Log.d( TAG, "set_http_sign_up(): URL == NULL" );
				return null;
			}
			
			conn = (HttpURLConnection)url.openConnection();
			if ( conn == null ) {
				Log.d( TAG, "set_http_sign_up(): URLConnection == NULL" );
				return null;
			}
			
			conn.setRequestProperty( "User-Agent", "mobile_app" );
			//conn.setRequestProperty( "Content-Type", "application/x-www-form-urlencoded" );
			conn.setReadTimeout( 15000 );
			conn.setConnectTimeout( 15000 );
			conn.setRequestMethod( "POST" );
			conn.setDoInput( true);
			conn.setDoOutput( true );
			conn.setInstanceFollowRedirects( true );
			//! session id
			{
				if ( m_cookie != null ) {
					conn.setRequestProperty( "cookie", m_cookie );
				}
			}
			
			
			out_stream = conn.getOutputStream();
			if ( out_stream == null ) {
				Log.d( TAG, "set_http_sign_up(): Output Stream == NULL" );
				return null;
			}
			
			bwriter = new BufferedWriter( new OutputStreamWriter(out_stream, "UTF-8") );
			if ( bwriter == null ) {
				Log.d( TAG, "set_http_sign_up(): BufferedWriter == NULL" );
				return null;
			}
			
			StringBuilder data = new StringBuilder();
			if ( data == null ) {
				Log.d( TAG, "set_http_sign_up(): StringBuilder == NULL" );
				return null;
			}
			{
				/*
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_id, "UTF-8") );
				data.append( "&" );
				data.append( URLEncoder.encode(POST_VAR_PASSWD, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_passwd, "UTF-8") );
				*/
				
				
				LinearLayout sign_up = (LinearLayout)findViewById( R.id.LinearLayout_sign_up );
				if ( sign_up == null ) {
					Log.d( TAG, "set_http_sign_up(): sign-up layout == NULL" );
					return null;
				}
				final EditText et_sign_up_id = (EditText)sign_up.findViewById( R.id.EditText_sign_up_id );
				final EditText et_sign_up_passwd = (EditText)sign_up.findViewById( R.id.EditText_sign_up_passwd );
				//final EditText et_sign_up_passwd_confirm = (EditText)sign_up.findViewById( R.id.EditText_sign_up_passwd_confirm );
				final EditText et_sign_up_name = (EditText)sign_up.findViewById( R.id.EditText_sign_up_name );
				final EditText et_sign_up_email = (EditText)sign_up.findViewById( R.id.EditText_sign_up_email );
				final EditText et_sign_up_phone = (EditText)sign_up.findViewById( R.id.EditText_sign_up_phone );
				String sign_up_id = null;
				String sign_up_passwd = null;
				//String sign_up_passwd_confirm = null;
				String sign_up_name = null;
				String sign_up_email = null;
				String sign_up_phone = null;
				
				if ( et_sign_up_id != null ) {
					if ( et_sign_up_id.getText() != null ) {
						sign_up_id = et_sign_up_id.getText().toString();
					}
				}
				
				if ( et_sign_up_passwd != null ) {
					if ( et_sign_up_passwd.getText() != null ) {
						sign_up_passwd = et_sign_up_passwd.getText().toString();
					}
				}
				
				//if ( et_sign_up_passwd_confirm != null ) {
				//	if ( et_sign_up_passwd_confirm.getText() != null ) {
				//		sign_up_passwd_confirm = et_sign_up_passwd_confirm.getText().toString();
				//	}
				//}
				
				if ( et_sign_up_name != null ) {
					if ( et_sign_up_name.getText() != null ) {
						sign_up_name = et_sign_up_name.getText().toString();
					}
				}
				
				if ( et_sign_up_email != null ) {
					if ( et_sign_up_email.getText() != null ) {
						sign_up_email = et_sign_up_email.getText().toString();
					}
				}
				
				if ( et_sign_up_phone != null ) {
					if ( et_sign_up_phone != null ) {
						sign_up_phone = et_sign_up_phone.getText().toString();
					}
				}
				
				if ( (sign_up_id == null) || (sign_up_name == null) ||
						(sign_up_passwd == null) || (sign_up_email == null) ||
						(sign_up_phone == null) ) {
					Log.d( TAG, "set_http_sign_up(): sign-up info == NULL" );
					return null;
				}
				
				
				// ID
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(sign_up_id, "UTF-8") );
				data.append( "&" );
				
				// Passwd
				if ( sign_up_passwd != null ) {
					data.append( URLEncoder.encode(POST_VAR_PASSWD, "UTF-8") );
					data.append( "=" );
					data.append( URLEncoder.encode(sign_up_passwd, "UTF-8") );
					data.append( "&" );
				}
				
				// Name
				data.append( URLEncoder.encode(POST_VAR_NAME, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(sign_up_name, "UTF-8") );
				data.append( "&" );
				
				// Email
				data.append( URLEncoder.encode(POST_VAR_EMAIL, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(sign_up_email, "UTF-8") );
				data.append( "&" );
				
				// Phone
				data.append( URLEncoder.encode(POST_VAR_PHONE, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(sign_up_phone, "UTF-8") );
			}
			
			bwriter.write( data.toString() );
			bwriter.flush();
			bwriter.close();
			
			if ( out_stream != null )
				out_stream.close();
			
			
			response_code = conn.getResponseCode();
			Log.d( TAG, "set_http_sign_up(): response code = " + response_code );
			if ( response_code == HttpsURLConnection.HTTP_OK ) {
				Log.d( TAG, "set_http_sign_up(): response code = HttpsURLConnection.HTTP_OK" ); 
				
				String line = null;
				
				breader = new BufferedReader( new InputStreamReader(conn.getInputStream()) );
				if ( breader == null ) {
					Log.d( TAG, "set_http_sign_up(): BufferedReader == NULL" );
					return null;
				}
				
				response = "";
				while ( (line = breader.readLine()) != null ) {
					if ( line.contains( "<br>") ) {
						line = line.replace( "<br>", "\r\n" );
					}
					response += line;
				}

				//! session id
				// Save the session id
				{
					final String cookie = conn.getHeaderField( "Set-Cookie" );
					if ( cookie != null ) {
						// To preserve stored previous cookie
						m_cookie = cookie;
					}
					
					// Cookie = PHPSESSID=qqgkmjl5sade1rljfftupj9ei3; path=/
					Log.d( TAG, "set_http_sign_up(): Cookie = " + m_cookie );
				}
				
				Log.d( TAG, "set_http_sign_up(): response = " + response );
				
				
				///*
				//JSON Object
				response = response.replace( "\uFEFF", "" );	// remove UTF-8 BOM
				if ( (response != null) && !response.isEmpty() ) {
//					JSONArray json = new JSONArray( response );
//					if ( json != null ) {
//						int size = json.length();
//						
//						Log.d( TAG, "set_http_sign_up(): JSON obj size = " + size );
//						
//						for ( int i = 0; i < size; i++ ) {
//							JSONObject obj = json.getJSONObject( i );
//							
//							if ( obj != null ) {
//								String result = obj.getString( "result" );
//							}
//						}
//					}
					
					String result = null;
					try {
						JSONObject json_obj = new JSONObject( response );
						if ( json_obj != null ) {
							result = json_obj.getString( "result" );
							
							String info_login_locked = json_obj.getString( "login_locked" );
							String info_confirm_url = json_obj.getString( "login_confirm_url" );
							
							Log.d( TAG, "set_http_sign_up(): JSON obj {" );
							Log.d( TAG, "set_http_sign_up():   - result = " + result );
							Log.d( TAG, "set_http_sign_up():   - login_locked = " + info_login_locked );
							Log.d( TAG, "set_http_sign_up():   - confirm_url = " + info_confirm_url );
							Log.d( TAG, "set_http_sign_up(): }" );
							
							
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "  - login_locked = " + info_login_locked + "\r\n";
							response += "  - confirm_url = " + REQ_BASE_CONFIRM_URL + info_confirm_url + "\r\n";
							response += "}" + "\r\n";
							
							m_account_info_confirm_url = REQ_BASE_CONFIRM_URL + info_confirm_url;
							Log.d( TAG, "set_http_sign_up(): confirm_url = " + m_account_info_confirm_url );
							
							
							/*
							// account info
							m_account_info_id = null;
							m_account_info_passwd_cur = null;
							m_account_info_passwd_new = null;
							m_account_info_name = null;
							m_account_info_email = null;
							m_account_info_email_confirm = null;
							m_account_info_phone = null;
							*/
							set_connection_info_init( false, true );
						}
					}
					catch ( Exception e ) {
						if ( result != null ) {
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "}" + "\r\n";
						}
						
						set_connection_info_init( false, true );
					}
				}
				//*/
				
				
				return response;
			}
			else {
				response = null;
			}

    	}
    	catch ( Exception e ) {
    		e.printStackTrace();
    	}
    	
    	return null;
    }
    
    public String get_http_account_info(String ipaddr_port, String userid, String passwd) {
    	//Log.d( TAG, "get_http_account_info()" );
    	
    	if ( ipaddr_port == null ) {
    		Log.d( TAG, "get_http_account_info(): ipaddr:port == NULL" );
    		return null;
    	}
    	if ( userid == null ) {
    		Log.d( TAG, "get_http_account_info(): user id == NULL" );
    		return null;
    	}
    	if ( passwd == null ) {
    		Log.d( TAG, "get_http_account_info(): passwd == NULL" );
    		return null;
    	}
    	
    	URL url = null;
    	HttpURLConnection conn = null;
    	int response_code = 0;
    	String response = null;
    	//InputStream in_stream = null;
    	OutputStream out_stream = null;
    	BufferedReader breader = null;
    	BufferedWriter bwriter = null;
    	
    	
    	//String strURLtext = URLEncoder.encode( strData, "UTF-8" );
    	
    	//final String REQ_URL = "http://localhost:8080/reg/account_info.php";
    	final String REQ_URL = "http://" + ipaddr_port + "/reg/account_info.php";
    	//final String POST_VAR_ID = "reg_login_id";
    	//final String POST_VAR_PASSWD = "reg_login_passwd";
    	//final String user_id = "test1";
    	//final String user_passwd = "12345678";
    	final String user_id = userid;
    	final String user_passwd = passwd;

    	
    	Log.d( TAG, "get_http_account_info(): REQ_URL = " + REQ_URL );
    	
    	try {
			url = new URL( REQ_URL );
			if ( url == null ) {
				Log.d( TAG, "get_http_account_info(): URL == NULL" );
				return null;
			}
			
			conn = (HttpURLConnection)url.openConnection();
			if ( conn == null ) {
				Log.d( TAG, "get_http_account_info(): URLConnection == NULL" );
				return null;
			}
			
			conn.setRequestProperty( "User-Agent", "mobile_app" );
			//conn.setRequestProperty( "Content-Type", "application/x-www-form-urlencoded" );
			conn.setReadTimeout( 15000 );
			conn.setConnectTimeout( 15000 );
			conn.setRequestMethod( "POST" );
			conn.setDoInput( true);
			conn.setDoOutput( true );
			conn.setInstanceFollowRedirects( false);	// POST: false
			//! session id
			{
				if ( m_cookie != null ) {
					conn.setRequestProperty( "cookie", m_cookie );
				}
			}
			
			
			out_stream = conn.getOutputStream();
			if ( out_stream == null ) {
				Log.d( TAG, "get_http_account_info(): Output Stream == NULL" );
				return null;
			}
			
			bwriter = new BufferedWriter( new OutputStreamWriter(out_stream, "UTF-8") );
			if ( bwriter == null ) {
				Log.d( TAG, "get_http_account_info(): BufferedWriter == NULL" );
				return null;
			}
			
			StringBuilder data = new StringBuilder();
			if ( data == null ) {
				Log.d( TAG, "get_http_account_info(): StringBuilder == NULL" );
				return null;
			}
			{
				/*
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_id, "UTF-8") );
				data.append( "&" );
				data.append( URLEncoder.encode(POST_VAR_PASSWD, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_passwd, "UTF-8") );
				*/
				data.append( "" );
			}
			
			bwriter.write( data.toString() );
			bwriter.flush();
			bwriter.close();
			
			if ( out_stream != null )
				out_stream.close();
			
			
			response_code = conn.getResponseCode();
			Log.d( TAG, "get_http_account_info(): response code = " + response_code );
			if ( response_code == HttpsURLConnection.HTTP_OK ) {
				Log.d( TAG, "get_http_account_info(): response code = HttpsURLConnection.HTTP_OK" ); 
				
				String line = null;
				
				breader = new BufferedReader( new InputStreamReader(conn.getInputStream()) );
				if ( breader == null ) {
					Log.d( TAG, "get_http_account_info(): BufferedReader == NULL" );
					return null;
				}
				
				response = "";
				while ( (line = breader.readLine()) != null ) {
					if ( line.contains( "<br>") ) {
						line = line.replace( "<br>", "\r\n" );
					}
					response += line;
				}

				//! session id
				// Save the session id
				{
					final String cookie = conn.getHeaderField( "Set-Cookie" );
					if ( cookie != null ) {
						// To preserve stored previous cookie
						m_cookie = cookie;
					}
					
					// Cookie = PHPSESSID=qqgkmjl5sade1rljfftupj9ei3; path=/
					Log.d( TAG, "get_http_account_info(): Cookie = " + m_cookie );
				}
				
				Log.d( TAG, "get_http_account_info(): response = " + response );
				
				
				///*
				//JSON Object
				response = response.replace( "\uFEFF", "" );	// remove UTF-8 BOM
				if ( (response != null) && !response.isEmpty() ) {
//					JSONArray json = new JSONArray( response );
//					if ( json != null ) {
//						int size = json.length();
//						
//						Log.d( TAG, "get_http_account_info(): JSON obj size = " + size );
//						
//						for ( int i = 0; i < size; i++ ) {
//							JSONObject obj = json.getJSONObject( i );
//							
//							if ( obj != null ) {
//								String result = obj.getString( "result" );
//							}
//						}
//					}
					
					String result = null;
					try {
						JSONObject json_obj = new JSONObject( response );
						if ( json_obj != null ) {
							result = json_obj.getString( "result" );
							
							String info_id = json_obj.getString( "account_info_id" );
							String info_name = json_obj.getString( "account_info_name" );
							String info_email = json_obj.getString( "account_info_email" );
							String info_phone = json_obj.getString( "account_info_phone" );
							
							Log.d( TAG, "get_http_account_info(): JSON obj {" );
							Log.d( TAG, "get_http_account_info():   - result = " + result );
							Log.d( TAG, "get_http_account_info():   - account_info_id = " + info_id );
							Log.d( TAG, "get_http_account_info():   - account_info_name = " + info_name );
							Log.d( TAG, "get_http_account_info():   - account_info_email = " + info_email );
							Log.d( TAG, "get_http_account_info():   - account_info_phone = " + info_phone );
							Log.d( TAG, "get_http_account_info(): }" );
							
							
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "  - account_info_id = " + info_id + "\r\n";
							response += "  - account_info_name = " + info_name + "\r\n";
							response += "  - account_info_email = " + info_email + "\r\n";
							response += "  - account_info_phone = " + info_phone + "\r\n";
							response += "}" + "\r\n";
							
							
							// account info
							m_account_info_id = info_id;
							m_account_info_passwd_cur = null;
							m_account_info_passwd_new = null;
							m_account_info_name = info_name;
							m_account_info_email = info_email;
							m_account_info_email_confirm = null;
							m_account_info_phone = info_phone;
						}
					}
					catch ( Exception e ) {
						if ( result != null ) {
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "}" + "\r\n";
						}
						
						set_connection_info_init( false, true );
					}
				}
				//*/
				
				
				return response;
			}
			else {
				response = null;
			}

    	}
    	catch ( Exception e ) {
    		e.printStackTrace();
    	}
    	
    	return null;
    }
    
    public String set_http_account_info(String ipaddr_port, String userid, String passwd) {
    	//Log.d( TAG, "set_http_account_info()" );
    	
    	if ( ipaddr_port == null ) {
    		Log.d( TAG, "set_http_account_info(): ipaddr:port == NULL" );
    		return null;
    	}
    	if ( userid == null ) {
    		Log.d( TAG, "set_http_account_info(): user id == NULL" );
    		return null;
    	}
    	if ( passwd == null ) {
    		Log.d( TAG, "set_http_account_info(): passwd == NULL" );
    		return null;
    	}
    	
    	URL url = null;
    	HttpURLConnection conn = null;
    	int response_code = 0;
    	String response = null;
    	//InputStream in_stream = null;
    	OutputStream out_stream = null;
    	BufferedReader breader = null;
    	BufferedWriter bwriter = null;
    	
    	
    	//String strURLtext = URLEncoder.encode( strData, "UTF-8" );
    	
    	//final String REQ_URL = "http://localhost:8080/reg/account_info_commit.php";
    	final String REQ_URL = "http://" + ipaddr_port + "/reg/account_info_commit.php";
    	final String POST_VAR_ID = "reg_login_id";
    	final String POST_VAR_PASSWD_CURRENT = "reg_login_passwd_old";
    	final String POST_VAR_PASSWD_NEW = "reg_login_passwd_new";
    	final String POST_VAR_NAME = "reg_login_name";
    	final String POST_VAR_EMAIL = "reg_login_email";
    	final String POST_VAR_PHONE = "reg_login_phone";
    	//final String user_id = "test1";
    	//final String user_passwd = "12345678";
    	final String user_id = userid;
    	final String user_passwd = passwd;

    	
    	Log.d( TAG, "set_http_account_info(): REQ_URL = " + REQ_URL );
    	
    	try {
			url = new URL( REQ_URL );
			if ( url == null ) {
				Log.d( TAG, "set_http_account_info(): URL == NULL" );
				return null;
			}
			
			conn = (HttpURLConnection)url.openConnection();
			if ( conn == null ) {
				Log.d( TAG, "set_http_account_info(): URLConnection == NULL" );
				return null;
			}
			
			conn.setRequestProperty( "User-Agent", "mobile_app" );
			//conn.setRequestProperty( "Content-Type", "application/x-www-form-urlencoded" );
			conn.setReadTimeout( 15000 );
			conn.setConnectTimeout( 15000 );
			conn.setRequestMethod( "POST" );
			conn.setDoInput( true);
			conn.setDoOutput( true );
			conn.setInstanceFollowRedirects( false);	// POST: false
			//! session id
			{
				if ( m_cookie != null ) {
					conn.setRequestProperty( "cookie", m_cookie );
				}
			}
			
			
			out_stream = conn.getOutputStream();
			if ( out_stream == null ) {
				Log.d( TAG, "set_http_account_info(): Output Stream == NULL" );
				return null;
			}
			
			bwriter = new BufferedWriter( new OutputStreamWriter(out_stream, "UTF-8") );
			if ( bwriter == null ) {
				Log.d( TAG, "set_http_account_info(): BufferedWriter == NULL" );
				return null;
			}
			
			StringBuilder data = new StringBuilder();
			if ( data == null ) {
				Log.d( TAG, "set_http_account_info(): StringBuilder == NULL" );
				return null;
			}
			{
				/*
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_id, "UTF-8") );
				data.append( "&" );
				data.append( URLEncoder.encode(POST_VAR_PASSWD, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_passwd, "UTF-8") );
				*/
				
				
				LinearLayout account_info = (LinearLayout)findViewById( R.id.LinearLayout_account_info );
				if ( account_info == null ) {
					Log.d( TAG, "set_http_account_info(): account layout == NULL" );
					return null;
				}
				final TextView tv_account_info_id = (TextView)account_info.findViewById( R.id.TextView_account_info_id );
				final EditText et_account_info_passwd_current = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_current );
				final EditText et_account_info_passwd_new = (EditText)account_info.findViewById( R.id.EditText_account_info_passwd_new );
				final EditText et_account_info_name = (EditText)account_info.findViewById( R.id.EditText_account_info_name );
				final EditText et_account_info_email = (EditText)account_info.findViewById( R.id.EditText_account_info_email );
				final EditText et_account_info_phone = (EditText)account_info.findViewById( R.id.EditText_account_info_phone );
				String account_info_id = null;
				String account_info_passwd_current = null;
				String account_info_passwd_new = null;
				String account_info_name = null;
				String account_info_email = null;
				String account_info_phone = null;
				
				if ( tv_account_info_id != null ) {
					if ( tv_account_info_id.getText() != null ) {
						account_info_id = tv_account_info_id.getText().toString();
					}
				}
				
				if ( et_account_info_passwd_current != null ) {
					if ( et_account_info_passwd_current.getText() != null ) {
						account_info_passwd_current = et_account_info_passwd_current.getText().toString();
					}
				}
				
				if ( et_account_info_passwd_new != null ) {
					if ( et_account_info_passwd_new.getText() != null ) {
						account_info_passwd_new = et_account_info_passwd_new.getText().toString();
					}
				}
				
				if ( et_account_info_name != null ) {
					if ( et_account_info_name.getText() != null ) {
						account_info_name = et_account_info_name.getText().toString();
					}
				}
				
				if ( et_account_info_email != null ) {
					if ( et_account_info_email.getText() != null ) {
						account_info_email = et_account_info_email.getText().toString();
					}
				}
				
				if ( et_account_info_phone != null ) {
					if ( et_account_info_phone != null ) {
						account_info_phone = et_account_info_phone.getText().toString();
					}
				}
				
				if ( (account_info_id == null) || (account_info_name == null) ||
						(account_info_email == null) || (account_info_phone == null) ) {
					Log.d( TAG, "set_http_account_info(): account info == NULL" );
					return null;
				}
				
				
				// ID
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_id, "UTF-8") );
				data.append( "&" );
				
				// Passwd
				if ( (account_info_passwd_current != null) && (account_info_passwd_new != null) ) {
					data.append( URLEncoder.encode(POST_VAR_PASSWD_CURRENT, "UTF-8") );
					data.append( "=" );
					data.append( URLEncoder.encode(account_info_passwd_current, "UTF-8") );
					data.append( "&" );
					data.append( URLEncoder.encode(POST_VAR_PASSWD_NEW, "UTF-8") );
					data.append( "=" );
					data.append( URLEncoder.encode(account_info_passwd_new, "UTF-8") );
					data.append( "&" );
				}
				
				// Name
				data.append( URLEncoder.encode(POST_VAR_NAME, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(account_info_name, "UTF-8") );
				data.append( "&" );
				
				// Email
				data.append( URLEncoder.encode(POST_VAR_EMAIL, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(account_info_email, "UTF-8") );
				data.append( "&" );
				
				// Phone
				data.append( URLEncoder.encode(POST_VAR_PHONE, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(account_info_phone, "UTF-8") );
			}
			
			bwriter.write( data.toString() );
			bwriter.flush();
			bwriter.close();
			
			if ( out_stream != null )
				out_stream.close();
			
			
			response_code = conn.getResponseCode();
			Log.d( TAG, "set_http_account_info(): response code = " + response_code );
			if ( response_code == HttpsURLConnection.HTTP_OK ) {
				Log.d( TAG, "set_http_account_info(): response code = HttpsURLConnection.HTTP_OK" ); 
				
				String line = null;
				
				breader = new BufferedReader( new InputStreamReader(conn.getInputStream()) );
				if ( breader == null ) {
					Log.d( TAG, "set_http_account_info(): BufferedReader == NULL" );
					return null;
				}
				
				response = "";
				while ( (line = breader.readLine()) != null ) {
					if ( line.contains( "<br>") ) {
						line = line.replace( "<br>", "\r\n" );
					}
					response += line;
				}

				//! session id
				// Save the session id
				{
					final String cookie = conn.getHeaderField( "Set-Cookie" );
					if ( cookie != null ) {
						// To preserve stored previous cookie
						m_cookie = cookie;
					}
					
					// Cookie = PHPSESSID=qqgkmjl5sade1rljfftupj9ei3; path=/
					Log.d( TAG, "set_http_account_info(): Cookie = " + m_cookie );
				}
				
				Log.d( TAG, "set_http_account_info(): response = " + response );
				
				
				///*
				//JSON Object
				response = response.replace( "\uFEFF", "" );	// remove UTF-8 BOM
				if ( (response != null) && !response.isEmpty() ) {
//					JSONArray json = new JSONArray( response );
//					if ( json != null ) {
//						int size = json.length();
//						
//						Log.d( TAG, "set_http_account_info(): JSON obj size = " + size );
//						
//						for ( int i = 0; i < size; i++ ) {
//							JSONObject obj = json.getJSONObject( i );
//							
//							if ( obj != null ) {
//								String result = obj.getString( "result" );
//							}
//						}
//					}
					
					String result = null;
					try {
						JSONObject json_obj = new JSONObject( response );
						if ( json_obj != null ) {
							result = json_obj.getString( "result" );
							
							String info_id = json_obj.getString( "account_info_id" );
							String info_name = json_obj.getString( "account_info_name" );
							String info_email = json_obj.getString( "account_info_email" );
							String info_phone = json_obj.getString( "account_info_phone" );
							
							Log.d( TAG, "set_http_account_info(): JSON obj {" );
							Log.d( TAG, "set_http_account_info():   - result = " + result );
							Log.d( TAG, "set_http_account_info():   - account_info_id = " + info_id );
							Log.d( TAG, "set_http_account_info():   - account_info_name = " + info_name );
							Log.d( TAG, "set_http_account_info():   - account_info_email = " + info_email );
							Log.d( TAG, "set_http_account_info():   - account_info_phone = " + info_phone );
							Log.d( TAG, "set_http_account_info(): }" );
							
							
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "  - account_info_id = " + info_id + "\r\n";
							response += "  - account_info_name = " + info_name + "\r\n";
							response += "  - account_info_email = " + info_email + "\r\n";
							response += "  - account_info_phone = " + info_phone + "\r\n";
							response += "}" + "\r\n";
							
							
							// account info
							m_account_info_id = info_id;
							m_account_info_passwd_cur = null;
							m_account_info_passwd_new = null;
							m_account_info_name = info_name;
							m_account_info_email = info_email;
							m_account_info_email_confirm = null;
							m_account_info_phone = info_phone;
						}
					}
					catch ( Exception e ) {
						if ( result != null ) {
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "}" + "\r\n";
						}
						
						set_connection_info_init( false, true );
					}
				}
				//*/
				
				
				return response;
			}
			else {
				response = null;
			}

    	}
    	catch ( Exception e ) {
    		e.printStackTrace();
    	}
    	
    	return null;
    }
    
    public String set_http_account_info_remove(String ipaddr_port, String userid, String passwd) {
    	//Log.d( TAG, "set_http_account_info_remove()" );
    	
    	if ( ipaddr_port == null ) {
    		Log.d( TAG, "set_http_account_info_remove(): ipaddr:port == NULL" );
    		return null;
    	}
    	if ( userid == null ) {
    		Log.d( TAG, "set_http_account_info_remove(): user id == NULL" );
    		return null;
    	}
    	if ( passwd == null ) {
    		Log.d( TAG, "set_http_account_info_remove(): passwd == NULL" );
    		return null;
    	}
    	
    	URL url = null;
    	HttpURLConnection conn = null;
    	int response_code = 0;
    	String response = null;
    	//InputStream in_stream = null;
    	OutputStream out_stream = null;
    	BufferedReader breader = null;
    	BufferedWriter bwriter = null;
    	
    	
    	//String strURLtext = URLEncoder.encode( strData, "UTF-8" );
    	
    	//final String REQ_URL = "http://localhost:8080/reg/account_remove_commit.php";
    	final String REQ_URL = "http://" + ipaddr_port + "/reg/account_remove_commit.php";
    	//final String POST_VAR_ID = "reg_login_id";
    	final String POST_VAR_PASSWD_REMOVE = "reg_login_passwd_remove";
    	//final String user_id = "test1";
    	//final String user_passwd = "12345678";
    	final String user_id = userid;
    	final String user_passwd = passwd;

    	
    	Log.d( TAG, "set_http_account_info_remove(): REQ_URL = " + REQ_URL );
    	
    	try {
			url = new URL( REQ_URL );
			if ( url == null ) {
				Log.d( TAG, "set_http_account_info_remove(): URL == NULL" );
				return null;
			}
			
			conn = (HttpURLConnection)url.openConnection();
			if ( conn == null ) {
				Log.d( TAG, "set_http_account_info_remove(): URLConnection == NULL" );
				return null;
			}
			
			conn.setRequestProperty( "User-Agent", "mobile_app" );
			//conn.setRequestProperty( "Content-Type", "application/x-www-form-urlencoded" );
			conn.setReadTimeout( 15000 );
			conn.setConnectTimeout( 15000 );
			conn.setRequestMethod( "POST" );
			conn.setDoInput( true);
			conn.setDoOutput( true );
			conn.setInstanceFollowRedirects( false);	// POST: false
			//! session id
			{
				if ( m_cookie != null ) {
					conn.setRequestProperty( "cookie", m_cookie );
				}
			}
			
			
			out_stream = conn.getOutputStream();
			if ( out_stream == null ) {
				Log.d( TAG, "set_http_account_info_remove(): Output Stream == NULL" );
				return null;
			}
			
			bwriter = new BufferedWriter( new OutputStreamWriter(out_stream, "UTF-8") );
			if ( bwriter == null ) {
				Log.d( TAG, "set_http_account_info_remove(): BufferedWriter == NULL" );
				return null;
			}
			
			StringBuilder data = new StringBuilder();
			if ( data == null ) {
				Log.d( TAG, "set_http_account_info_remove(): StringBuilder == NULL" );
				return null;
			}
			{
				/*
				data.append( URLEncoder.encode(POST_VAR_ID, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_id, "UTF-8") );
				data.append( "&" );
				data.append( URLEncoder.encode(POST_VAR_PASSWD, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(user_passwd, "UTF-8") );
				*/
				
				
				LinearLayout account_info = (LinearLayout)findViewById( R.id.LinearLayout_account_info );
				if ( account_info == null ) {
					Log.d( TAG, "set_http_account_info_remove(): account layout == NULL" );
					return null;
				}
				final EditText et_account_info_passwd_remove = (EditText)account_info.findViewById( R.id.EditText_account_info_remove_passwd_current );
				String account_info_passwd_current_remove = null;
				
				if ( et_account_info_passwd_remove != null ) {
					if ( et_account_info_passwd_remove.getText() != null ) {
						account_info_passwd_current_remove = et_account_info_passwd_remove.getText().toString();
						
						if ( account_info_passwd_current_remove != null ) {
							if ( account_info_passwd_current_remove.isEmpty() ) {
								account_info_passwd_current_remove = null;
							}
						}
					}
				}
				
				if ( account_info_passwd_current_remove == null ) {
					Log.d( TAG, "set_http_account_info_remove(): account info == NULL" );
					return null;
				}
				
				
				// Passwd
				data.append( URLEncoder.encode(POST_VAR_PASSWD_REMOVE, "UTF-8") );
				data.append( "=" );
				data.append( URLEncoder.encode(account_info_passwd_current_remove, "UTF-8") );
			}
			
			bwriter.write( data.toString() );
			bwriter.flush();
			bwriter.close();
			
			if ( out_stream != null )
				out_stream.close();
			
			
			response_code = conn.getResponseCode();
			Log.d( TAG, "set_http_account_info_remove(): response code = " + response_code );
			if ( response_code == HttpsURLConnection.HTTP_OK ) {
				Log.d( TAG, "set_http_account_info_remove(): response code = HttpsURLConnection.HTTP_OK" ); 
				
				String line = null;
				
				breader = new BufferedReader( new InputStreamReader(conn.getInputStream()) );
				if ( breader == null ) {
					Log.d( TAG, "set_http_account_info_remove(): BufferedReader == NULL" );
					return null;
				}
				
				response = "";
				while ( (line = breader.readLine()) != null ) {
					if ( line.contains( "<br>") ) {
						line = line.replace( "<br>", "\r\n" );
					}
					response += line;
				}

				//! session id
				// Save the session id
				{
					final String cookie = conn.getHeaderField( "Set-Cookie" );
					if ( cookie != null ) {
						// To preserve stored previous cookie
						m_cookie = cookie;
					}
					
					// Cookie = PHPSESSID=qqgkmjl5sade1rljfftupj9ei3; path=/
					Log.d( TAG, "set_http_account_info_remove(): Cookie = " + m_cookie );
				}
				
				Log.d( TAG, "set_http_account_info_remove(): response = " + response );
				
				
				///*
				//JSON Object
				response = response.replace( "\uFEFF", "" );	// remove UTF-8 BOM
				if ( (response != null) && !response.isEmpty() ) {
//					JSONArray json = new JSONArray( response );
//					if ( json != null ) {
//						int size = json.length();
//						
//						Log.d( TAG, "set_http_account_info_remove(): JSON obj size = " + size );
//						
//						for ( int i = 0; i < size; i++ ) {
//							JSONObject obj = json.getJSONObject( i );
//							
//							if ( obj != null ) {
//								String result = obj.getString( "result" );
//							}
//						}
//					}
					
					String result = null;
					try {
						JSONObject json_obj = new JSONObject( response );
						if ( json_obj != null ) {
							result = json_obj.getString( "result" );
							
							Log.d( TAG, "set_http_account_info_remove(): JSON obj {" );
							Log.d( TAG, "set_http_account_info_remove():   - result = " + result );
							Log.d( TAG, "set_http_account_info_remove(): }" );
							
							
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "}" + "\r\n";
						}
					}
					catch ( Exception e ) {
						if ( result != null ) {
							response += "\r\n";
							response += "JSON obj {" + "\r\n";
							response += "  - result = " + result + "\r\n";
							response += "}" + "\r\n";
						}
					}
				}
				//*/
				
				
				/*
				// account info
				m_account_info_id = null;
				m_account_info_passwd_cur = null;
				m_account_info_passwd_new = null;
				m_account_info_name = null;
				m_account_info_email = null;
				m_account_info_email_confirm = null;
				m_account_info_phone = null;
				
				m_ipaddr = null;
				m_port = null;
				m_userid = null;
				m_passwd = null;
				m_cookie = null;
				*/
				set_connection_info_init_all();
				
				
				return response;
			}
			else {
				response = null;
			}

    	}
    	catch ( Exception e ) {
    		e.printStackTrace();
    	}
    	
    	return null;
    }
    
    // ------------------------------------------------------------------------
}
