/*
 * Project:		HTTP Test
 * Purpose:		HTTP Test
 * Author:		Ho-Jung Kim (godmode2k@hotmail.com)
 * Date:		Since Oct 24, 2015
 * Filename:	HttpTestActivity.java
 * 
 * Last modified:	Oct 24, 2015
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
import android.text.TextWatcher;
import android.text.format.DateFormat;

import java.util.Arrays;



public class HttpTestActivity extends Activity {
	final static String TAG = "HttpTestActivity";


	// Action
	private static final int __ACTION_LOGIN__ = 0;
	private static final int __ACTION_LOGOUT__ = 1;

	
	// session id
	private String m_cookie = null;
	
	
	// ipaddr:port, Login
	private String m_ipaddr = null;
	private String m_port = null;
	private String m_userid = null;
	private String m_passwd = null;
	
	
	
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
    		
    		if ( btn_login != null ) {
    			btn_login.setOnClickListener( new OnClickListener() {
    				final EditText m_et_ipaddr = (EditText)findViewById( R.id.EditText_ipaddr );
    				final EditText m_et_port = (EditText)findViewById( R.id.EditText_port );
    				final EditText m_et_userid = (EditText)findViewById( R.id.EditText_userid );
    				final EditText m_et_passwd = (EditText)findViewById( R.id.EditText_passwd );
    				
					@Override
					public void onClick(View v) {
						// TODO Auto-generated method stub
						
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
					}
				});
    		}
    		
    		{
    			EditText et_ipaddr = (EditText)findViewById( R.id.EditText_ipaddr );
    			EditText et_port = (EditText)findViewById( R.id.EditText_port );
				EditText et_userid = (EditText)findViewById( R.id.EditText_userid );
				EditText et_passwd = (EditText)findViewById( R.id.EditText_passwd );
				
				if ( et_ipaddr != null )
					et_ipaddr.setText( "" );	// ipaddr: xxx.xxx.xxx.xxx
				
				if ( et_port != null )
					et_port.setText( "8080" );	// port: xxxx
				
				if ( et_userid != null )
					et_userid.setText( "test1" );
				
				if ( et_passwd != null )
					et_passwd.setText( "12345678" );
    		}
    	}
    	
    	
    	
    	return true;
    }
    
    private void release() {
    	__DEBUG__( "release()" );
    }
    
    
    // ------------------------------------------------------------------------
    
    
    public class HttpMethodTestTask extends AsyncTask<Object, Object, Object> {
    	String m_response = null;
    	
		@Override
		protected Object doInBackground(Object... arg0) {
			// TODO Auto-generated method stub
			//return null;

			__DEBUG__( "HttpMethodTestTask::doInBackground()" );

			boolean ret = false;

			final int action = (Integer)arg0[0];
			final String ipaddr_port = (String)arg0[1];
			final String userid = (String)arg0[2];
			final String passwd = (String)arg0[3];

			
			switch ( action ) {
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
			conn.setInstanceFollowRedirects( false);	// POST: false
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
					
					JSONObject json_obj = new JSONObject( response );
					if ( json_obj != null ) {
						String result = json_obj.getString( "result" );
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
