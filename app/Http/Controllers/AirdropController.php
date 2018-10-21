<?php

namespace App\Http\Controllers;

use App\Models\AirdropModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\Mail;

class AirdropController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('airdrop.airdrop');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function registerAir(Request $request)
    {
        $telegram_user  = $request['telegram'];

        $eth_address    = $request['eth_address'];

        $email_id       = $request['email'];

        if($request['twitter'] != ''){
            $twitter = $request['twitter'];
        }
        else{
           $twitter = 0; 
        }

        $check_email    = AirdropModel::where('email_address', '=', $email_id)->select('id')->first();

        $check_tel      = AirdropModel::where('tel_user_name', '=', $telegram_user)->select('id')->first();
        if($check_email === null){

            if($check_tel === null){
                $create = AirdropModel::create([
                    'tel_user_name' => $telegram_user,
                    'email_address' => $email_id,
                    'twitter_user'  => $twitter,
                    'eth_address'   => $eth_address,
                    'verify_telegram'=> 0,
                    'verify_twitter' => 0,
                    'created_at'    => date('Y-m-d H:i:s')
                ]);
                
                $telegram_username = $request['telegram'];
                $email = $request['email'];

                $maildata = [
                    'tel_user_name' => $telegram_username,
                    'email_address' => $email
                ];

                Mail::send(['html' => 'mail.register'], $maildata, function ($message) use ($email, $telegram_username) {
                $message->to($email, $telegram_username)
                    ->subject('Lala World : Airdrop Registration');
                $message->from('hello@lalaworld.io', 'Lala World');
                });

                die(json_encode(['status'=>'succ','msg'=>'User registered successfully']));

            }else{

                die(json_encode(['status'=>'err','msg'=>'Telegram Username already exist']));
            }
        }
        else{

            die(json_encode(['status'=>'err','msg'=>'Email Id already exist']));
        }    
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AirdropModel  $airdropModel
     * @return \Illuminate\Http\Response
     */
    public function show(AirdropModel $airdropModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AirdropModel  $airdropModel
     * @return \Illuminate\Http\Response
     */
    public function edit(AirdropModel $airdropModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AirdropModel  $airdropModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AirdropModel $airdropModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AirdropModel  $airdropModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(AirdropModel $airdropModel)
    {
        //
    }

    public function telegramUsers(Request $request){
        $columns = array( 
                            0 =>'id',
                            1 =>'tel_user_name',
                            2 =>'twitter_user',
                            3=> 'email_address',
                            4=> 'eth_address',
                            5=> 'verify_telegram',
                            6=> 'verify_twitter'
                        );
  
        $totalData = AirdropModel::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = AirdropModel::offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            $posts =  AirdropModel::where('id','LIKE',"%{$search}%")
                            ->orWhere('tel_user_name', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = AirdropModel::where('id','LIKE',"%{$search}%")
                             ->orWhere('tel_user_name', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data = array();

        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $nestedData['id'] = $post->id;
                $nestedData['tel_user_name'] = $post->tel_user_name;
                $nestedData['twitter_user'] = $post->twitter_user;
                $nestedData['email_address'] = $post->email_address;
                $nestedData['eth_address'] = $post->eth_address;
                $nestedData['verify_telegram'] = $post->verify_telegram;
                $nestedData['verify_twitter'] = $post->verify_twitter;

                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }

    public function verifyTelegram(Request $request){
        $tel_user = $request['user'];
        $check = AirdropModel::where('tel_user_name', $tel_user)->select('verify_telegram')->first();
        if ($check->verify_telegram == 1) {
            $data = [
            'verify_telegram' => 0
        ];
        }elseif ($check->verify_telegram == 0) {
            $data = [
            'verify_telegram' => 1
        ];
        }
        $result = AirdropModel::where('tel_user_name', $tel_user)
                                ->update($data);
        if($result){

                $response = ['status' =>'SUCC','msg'=>'Request Success'];
            return  json_encode($response);
        }else{
             $response = ['status' =>'ERR','msg'=>'Request Failes'];
            return  json_encode($response);
        }
    }

    public function verifyTwitter(Request $request){
        $tweet_user = $request['user'];
        $check = AirdropModel::where('twitter_user', $tweet_user)->select('verify_twitter')->first();
        if ($check->verify_twitter == 1) {
            $data = [
            'verify_twitter' => 0
        ];
        }elseif ($check->verify_twitter == 0) {
            $data = [
            'verify_twitter' => 1
        ];
        }
        $result = AirdropModel::where('twitter_user', $tweet_user)
                                ->update($data);
        if($result){

                $response = ['status' =>'SUCC','msg'=>'Request Success'];
            return  json_encode($response);
        }else{
             $response = ['status' =>'ERR','msg'=>'Request Failes'];
            return  json_encode($response);
        }
    }
        
}
