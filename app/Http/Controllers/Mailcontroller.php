<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\tbl_mail_notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class Mailcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//mail form
	public function index()
	{
		$mailformat=DB::table('tbl_mail_notifications')->get()->toArray();
		return view('mail.mail',compact('mailformat')); 
		
	}
	
	//mail update
	public function emailupadte($id)
	{
		$emailformat = tbl_mail_notifications::find($id);
		
		$emailformat->subject = Input::get('subject');
		$emailformat->send_from = Input::get('send_from'); 
		$emailformat->notification_text = Input::get('notification_text');
		$emailformat->is_send = Input::get('is_send');
		$emailformat->save();
		
		return redirect('/mail/mail')->with('message','Successfully Updated');
	}
	
	//mail for user
    public function user()
	{	
		return view('mail.user'); 
	}
	
	//mail for sales
	public function sales()
	{	
		return view('mail.sales');
	}
	
	//mail for service
	public function services()
	{	
		return view('mail.service');
	}
	
	
}	
