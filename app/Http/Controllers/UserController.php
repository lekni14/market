<?php

namespace App\Http\Controllers;

use App\Model\User;
use Validator;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
	public function signup(Request $request)
	{
		// try{
			$validator = Validator::make($request->all(), [
				'firstname' => 'required',
				'lastname' => 'required',
				'brithdate' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required'
				]);

			if (!$validator->fails()) {
				$expireddate = null;
				if($request->input('is_vendor')){
					$expireddate = date('Y-m-d H:i:s', strtotime('+30 days'));	
				}				
				$user = new User([
					'firstname' => $request->input('firstname'),
					'lastname' => $request->input('lastname'),
					'brithdate' => $request->input('brithdate'),
					'email' => $request->input('email'),
					'is_vendor' => $request->input('is_vendor'),
					'password' => bcrypt($request->input('password')),
					'expireddate' => $expireddate
				]);
				$user->save();
				return response()->json([
					'message' => 'Successfully created user!'
				],201);
			}else{
				return response()->json([
					'error' => $validator->errors()
				],400);
			}	
		// }
		// catch(\Exception $e){		 
		//     return response()->json([
		// 		'errors' => $e->getMessage();
		// 	],401);
		// }			
			
	}
	public function signin(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required|email',
			'password' => 'required'
		]);
		if (!$validator->fails()) {
			$credientals = $request->only('email','password');
			try{
				if(!$token = JWTAuth::attempt($credientals)){					
					return response()->json([
						'error' => 'Invalid Credientals!'
					],401);
				}
			}catch(JWTException $e){
				return response()->json([
						'error' => 'Cloud not crate token!'
				],500);
			}
			return response()->json([
				'token' => $token
			],200);
		}else{
			$message = $validator->errors();
			return response()->json([
				'token' => $message
			],400);
		}
	}
}