<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;
use App\DxaRequest;
use App\MibRequest;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;

class TaskController extends Controller
{
	public function __construct(){
        $this->middleware('auth');
    }
    
	// DXA requests list
    public function list(){
        $page = (int)Input::get('page');
		$requests = DxaRequest::select('dxa_requests.*')->orderBy('recieved_at', 'DESC')->paginate(10);
     	return view('task.list', compact('requests', 'page'));
    }

    public function viewTask($id){
    	$request = DxaRequest::where('id', '=', $id)->first();
        if(!empty($request)){
            if($request->status == 0){
                $request->status = 1;
                $request->seen_at = date('Y-m-d H:i');
                $request->save();
            }

            $req=$request;

            $response = json_decode($req->response);

            $types = tbl_vehicle_types::select('id', 'vehicle_type as name')->get();
            $brands = tbl_vehicle_brands::select('id', 'vehicle_brand as name', 'vehicle_id as type_id')->get();

            return view('task.view', compact('req', 'brands', 'types', 'response'));
        }else{
            return 'not-found';
        }
    }

    public function saveTask(Request $request){
    	$req = DxaRequest::where('id', '=', $request->id)->first();
    	if(!empty($req)){
    		$req->response=$request->json;
    		$s = $req->save();
    		return response()->json([
    			'status'=>'success',
    			'message'=>$s,
    			'json'=>$request->json
    		]);
    	}else{
    		return response()->json([
    			'status'=>'error',
    			'message'=>'request was not found for given id'
    		]);
    	}
    }

    public function responseSent($id){
    	$request = DxaRequest::select('dxa_requests.*')
            ->where('id', '=', $id)
            ->where('status', 1)->first();

    	if(!empty($request)){

            // ********** SENDING REQUEST TO DXM ********** // 
            // DXM ADDRESS:                         10.190.2.65:8088/liquidation/agrotech/get_info
            // AGROINSPEKSIYA ADDRESS               10.190.4.250/api/get_info

            $client = new \GuzzleHttp\Client();

            $url = 'http://10.190.2.65:8088/liquidation/agrotech/get_info';
            //$url = 'http://iut-attendance.herokuapp.com/api/teacher/login';
            //$url  = 'http://10.190.4.250/api/get_info';

            $body = json_decode($request->response);

            //$body = json_decode('{"application_id":"00003","name":"Phoenix Systems","inn":"123456790","address":"","objects":[{"number":"01 AB 345 Q","model":"Arion-630c","p_series":"UZ-AB000001","p_given_date":"03.02.2010","p_given_by":"Inspeksiyaning Toshkent shahar bo\'limi","produced_year":"1894","type":"Arion-630c","chassis_no":"12324tdfva3fsd6","engine_no":"123k6","note":"test","prohibition":{"pr_status":"taqiqqa olingan","pr_date":"11.07.2019","pr_by":"sud"}},{"number":"01 AB 456 R","model":"SR-26T","p_series":"UZ-AB000002","p_given_date":"16.05.2013","p_given_by":"Inspeksiyaning Toshkent shahar bo\'limi","produced_year":"2015","type":"SR-26T","chassis_no":"asd78sdfdgd8as9","engine_no":"23b423v2","note":"something","prohibition":{"pr_status":"taqiqqa olinmagan","pr_date":"","pr_by":""}}]}');

            try {
                $response = $client->request('POST', $url, [
                    'json' => $body,
                    'connect_timeout' => 3
                ]);
            } catch (RequestException $e) {
                // return Psr7\str($e->getRequest());
                // if ($e->hasResponse()) {
                //     return Psr7\str($e->getResponse());
                // }

                return response()->json([
                    'url' => $url,
                    'status' => 'error',
                    'message' => 'connection timeout',
                    'request' => Psr7\str($e->getRequest()),
                    'response' => ($e->hasResponse() ? Psr7\str($e->getResponse()) : ''),
                    'body' => $body
                ]);
            }
            

            $responseDetails = [
                'url' => $url,
                'code' => $response->getStatusCode(),
                'reason' => $response->getReasonPhrase(),
                'body' => json_decode((string) $response->getBody())
            ];

            // *******  REQUEST SENT ********** //

            if($responseDetails['code'] == '200'){
                $request->status = 2;
                $request->sent_at = date('Y-m-d H:i');
                $s = $request->save();
                if($s){
                    return response()->json([
                        'status'=>'success',
                        'message'=>'request has been updated',
                        'dxmRequest' => $request,
                        'body' => $body,
                        'dxmResponse'=>$responseDetails
                    ]);
                }else{
                    return response()->json([
                        'status'=>'error',
                        'message'=>'error while updating the Request'
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>'error',
                    'message'=> 'DXM did not respond',
                    'dxmResponse' => $responseDetails
                ]);
            }
    	}else{
    		return response()->json([
    			'status'=>'error',
    			'message'=>'invalid request id'
    		]);
    	}
    }

    // MIB requests list
    public function mibRequests(){
        $method = (int)Input::get('method');
        $page = (int)Input::get('page');
        $s = Input::get("search");
        $status = Input::get("status");

        $requests = MibRequest::select('mib_requests.*');

        // filter by method
        if($method){
            $requests = $requests->where('method', '=', $method);
        }

        // filter by status
        if($status != ""){
            $requests = $requests->where('status', '=', $status);
        }

        // search engine
		if($s){
			$requests = $requests->where(function($query) use($s){
				$columnsForSearch = [
					'mib_requests.response',
                    'mib_requests.pinfl_debtor',
                    'mib_requests.fio_debtor',
                    'mib_requests.inn_debtor',
                    'mib_requests.property_number',
                    'mib_requests.doc_number',
                    'mib_requests.branch_name',
                    'mib_requests.inspector_fio',
                    DB::raw("CONCAT(UPPER(mib_requests.passport_sn), UPPER(mib_requests.passport_num))"),
                    DB::raw("CONCAT(UPPER(mib_requests.property_pass_info), UPPER(mib_requests.property_pass_num))"),
					'mib_requests.ban_id'
				];
				foreach($columnsForSearch as $col){
					$query = $query->orWhere($col, 'like', '%'.$s.'%');
				}
			});
        }
        
        $search = $s;
        
        $requests = $requests->orderBy('created_at', 'DESC')->paginate(2);
        $requests = $requests->appends(Input::except('page'));
        
     	return view('task.mib.list', compact('requests', 'method', 'page', 'search', 'status'));
    }
}