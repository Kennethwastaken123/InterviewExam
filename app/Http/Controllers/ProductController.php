<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductController extends Controller
{
    public function order(Request $request){
        
        $token = request()->bearerToken();
        $Data = $request->input();
        $uservalidation = DB::table('users')->where('remember_token',$token)->first();
        if($uservalidation){
            $productData = DB::table('product')->where('id',$Data['product_id'])->first();
            $newqty = 0;
            if($productData){
                $newqty = $productData->qty - $Data['qty'];
                if($newqty < 0){
                    return response()->json(['message' =>'Failed to order this product due to unavailability of the stock']);
                }else{
                    $query = ['qty' => $newqty];
                    DB::table('product')
                    ->where('id', $Data['product_id'])
                    ->update($query);
                    return response()->json(['message' =>'You have successfully ordered this product']);
                }
            }else{
                return response()->json(['message' =>'Invalid Product Id']);
            }
        }else{
            return response()->json(['message' =>'Invalid credentials']);
        }
       
       
    }
}
