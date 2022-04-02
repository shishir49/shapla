<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Treasury;
use App\Models\Refund;
use App\Models\User;

class Sales extends Controller
{

    /*
	|--------------------------------------------------------------------------
	| Sales
	|--------------------------------------------------------------------------
	|
	*/

    public function sell(Request $request){	
        $from_date = $request->from_date;
		$to_date = $request->to_date;
		if($from_date && $to_date){
			$data['sell_list'] = Sale::whereBetween('created_at', array($request->from_date, $request->to_date))
                                 ->paginate(10);
		}else{
			$data['sell_list'] = Sale::paginate(10);
		}	
        $data['total_sell'] = Treasury::first();
        
		return response()->json($data,200);
    }

    public function newSellView(){
        $data['products'] = Product::where('status',1)->get();
        $data['users'] = User::where('status',1)->get();
        return response()->json($data,200);
    }

	public function newSell(Request $request){
        $product = Product::where('id', $request->product_id)->first();
        $stock = $product->stock;
        \DB::transaction(function() use($request){
            $add_sell = Sale::create($request->all());
            $update_stock = Product::where('id', $request->product_id)->update([
                'stock' => $stock - $request->stock
            ]);
			$update_treasury = Treasury::where('id',1)->update([
				'sell' => $add_sell->sum('gross_price')
			]);
		});	
    	
    	if($add_sell){
           $message = "Sell Added Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

    public function updateSellView(Request $request, $id){
        $data['products'] = Product::where('status',1)->get();
        $data['users'] = User::where('status',1)->get();
        $data['sell'] = Sale::where('status',1)->where('id',$id)->first();
        return response()->json($data,200);
    }

	public function updateSell(Request $request, $id){
        $product = Product::where('id', $request->product_id)->first();
        $stock = $product->stock;
		\DB::transaction(function() use($request){
            $update_sell = Sale::where('id',$id)->update($request->all());
            $update_stock = Product::where('id', $request->product_id)->update([
                'stock' => $stock - $request->stock
            ]);
			$update_treasury = Treasury::where('id',1)->update([
				'sell' => $update_sell->sum('gross_price')
			]);
		});	

    	if($update_sell){
           echo $message = "Sell Updated Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteSell(Request $request, $id){
        $sale = Sale::where('id', $id)->first();
        $stock = $sale->quantity;
		\DB::transaction(function() use($request){
            $delete_sell = Sale::destroy(array('id',$id));
            $update_stock = Product::where('id', $request->product_id)->update([
                'stock' => $stock + $request->stock
            ]);
			$update_treasury = Treasury::where('id',1)->update([
				'sell' => $delete_sell->sum('gross_price')
			]);
		});	

    	if($delete_sell){
           echo $message = "Expense Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    /*
	|--------------------------------------------------------------------------
	| Refunds
	|--------------------------------------------------------------------------
	|
	*/

    public function refund(Request $request){	
        $from_date = $request->from_date;
		$to_date = $request->to_date;
		if($from_date && $to_date){
			$data['refund_list'] = Refund::whereBetween('created_at', array($request->from_date, $request->to_date))
                                   ->paginate(10);
		}else{
			$data['refund_list'] = Refund::paginate(10);
		}	
        $data['total_refund'] = Treasury::first();
        
		return response()->json($data,200);
    }

    public function newRefundView(Request $request){
        $data['sales'] = Sale::where('status',1)->get();
        $data['users'] = User::where('status',1)->get();
        return response()->json($data,200);
    }

	public function newRefund(Request $request){
        $product = Product::where('id', $request->product_id)->first();
        $sale = Sale::where('id', $request->sale_id)->first();
        $stock = $product->stock;
        \DB::transaction(function() use($request){
            $add_refund = Refund::create($request->all());
            $update_sale = Sale::where('id', $request->sale_id)->update($request->all());
            $update_stock = Product::where('id', $request->product_id)->update([
                'stock' => $stock + $request->quantity
            ]);
			$update_treasury = Treasury::where('id',1)->update([
				'refund' => $add_refund->sum('refund_amount')
			]);
		});	
    	
    	if($add_refund){
           $message = "Refund Added Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

    public function updateRefundView(Request $request, $id){
        $data['products'] = Product::where('status',1)->get();
        $data['users'] = User::where('status',1)->get();
        $data['refund'] = Refund::where('status',1)->where('id',$id)->first();
        return response()->json($data,200);
    }

	public function updateRefund(Request $request, $id){
        $product = Product::where('id', $request->product_id)->first();
        $sale = Sale::where('id', $request->sale_id)->first();
        $stock = $product->stock;
		\DB::transaction(function() use($request){
            $update_refund = Refund::where('id',$id)->update($request->all());
            $update_sale = Sale::where('id', $request->sale_id)->update($request->all());
            $update_stock = Product::where('id', $request->product_id)->update([
                'stock' => $stock + $request->quantity
            ]);
			$update_treasury = Treasury::where('id',1)->update([
				'refund' => $add_refund->sum('refund_amount')
			]);
		});	

    	if($update_refund){
           echo $message = "Refund Updated Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteRefund(Request $request, $id){
        $product = Product::where('id', $request->product_id)->first();
        $refund = Refund::where('id', $id)->first();
        $stock = $product->quantity;
		\DB::transaction(function() use($request){
            $delete_sell = Refund::destroy(array('id',$id));
            $update_stock = Product::where('id', $request->product_id)->update([
                'stock' => $stock - $delete_sell->quantity
            ]);
			$update_treasury = Treasury::where('id',1)->update([
				'refund' => $delete_sell->sum('refund_amount')
			]);
		});	

    	if($delete_sell){
           echo $message = "Refund Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }


}
