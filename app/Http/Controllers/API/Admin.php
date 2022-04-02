<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\Category;
use App\Models\MenuPosition;
use App\Models\Role;
use App\Models\RoleMenu;
use App\Models\Supply;
use App\Models\ProductPrice;
use App\Models\Investment;
use App\Models\Expense;
use App\Models\Lend;
use App\Models\Treasury;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Showroom;
use Carbon\Carbon;

class Admin extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Dashboard
	|--------------------------------------------------------------------------
	|Total Credit, Total Expense, Total Lend, Total Product, Total Categories, 
	|Number of Sold Product etc.
	|
	*/

	public function dashboard(){
		$treasury = Treasury::where('id',1)->first();
		$products = Product::where('status',1)->get();
		$sale = Sale::get();
		$category = Category::where('status',1)->get();

		$data['total_investment'] = $treasury->total_credit;
		$data['total_expense'] = $treasury->total_spent;
		$data['total_lend'] = $treasury->total_lend;
		$data['total_sell'] = $treasury->sell;
		$data['total_refund'] = $treasury->refund;
		$data['on_hand'] = $treasury->on_hand;
		$data['number_of_product'] = count(array($products));
		$data['number_of_sold_product'] = $sale->sum('quantity');
		$data['number_of_category'] = count(array($category));

		return response()->json($data,200);
	}


	/*
	|--------------------------------------------------------------------------
	| Admin Menu CRUD
	|--------------------------------------------------------------------------
	| Admin will be able to get menu list, create, update and delete menu here.
	|
	*/

    public function menuView(){
		$data['parent_menu'] = Menu::with('childMenu')->where('status',1)->paginate(10);
    	return json_encode($data);
    }

	public function addMenuView(){
        $data['menu_position'] = MenuPosition::where('status',1)->get();
        return response()->json($data,200);
    }

    public function addMenu(Request $request){
        if($request->menu_type == 1){
			$create_menu_item = Menu::create($request->all());
		}else{
            $create_menu_item = ChildMenu::create($request->all());
		}
    
    	if($create_menu_item){
           echo $message = "Menu Created Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	
    public function updateMenuView(Request $request, $id){
        $data['menu_position'] = MenuPosition::where('status',1)->get();
        $data['menu'] = Menu::where('status',1)->where('id',$id)->first();
        return response()->json($data,200);
    }

    public function updateMenu(Request $request, $id){
        if($request->menu_type == 1){
			$update_menu_item = Menu::where('id',$id)->update($rquest->all());
		}else{
			$update_menu_item = ChildMenu::where('id',$id)->update($rquest->all());
		}
    	
    	if($update_menu_item){
           echo $message = "Menu Updated Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteMenu(Request $request, $id){
		if($request->menu_type == 1){
			$delete_menu = Menu::destroy(array('id',$id));
		}else{
			$delete_menu = ChildMenu::destroy(array('id',$id));
		}

    	if($delete_menu){
           echo $message = "Menu Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    /*
	|--------------------------------------------------------------------------
	| Role Management
	|--------------------------------------------------------------------------
	| Admin will be able to get role list, create, update and delete role here.
	| Admin will also be able to regulate menu accessibility to roles(users).
	|
	*/

	public function userRole(){
    	$data['role'] = Role::where('status',1)->paginate(10);
    	return json_encode($data);
    }

    public function addRole(Request $request){

    	$create_menu_item = Role::create($request->all());

    	if($create_menu_item){
           $message = "Role Created Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	public function updateRoleView(Request $request, $id){
        $data['role'] = Role::where('status',1)->where('id',$id)->first();
        return response()->json($data,200);
    }

    public function updateUserRole(Request $request, $id){

    	$update_menu_item = Role::where('id',$id)->update($request->all());

    	if($update_menu_item){
           $message = "Role Updated Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteRole(Request $request, $id){

    	$delete_menu = Role::destroy(array('id',$id));

    	if($delete_menu){
           $message = "Role Deleted Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	public function roleView(Request $request){	

        $role_list = Role::with('roleMenu')->where('status',1)->get();
    	return json_encode($role_list);
    }

	
	public function updateRoleMenuView(Request $request, $id){
        $data['role_menu'] = RoleMenu::where('status',1)->where('id',$id)->first();
        return response()->json($data,200);
    }

    public function updateRole(Request $request, $id){
		
		$role_updated = RoleMenu::where('role_id','=',$id)->update($request->all());

    	if($role_updated){
           $message = "Role Updated Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }


	/*
	|--------------------------------------------------------------------------
	| Product Category
	|--------------------------------------------------------------------------
	|
	*/

	public function categoryView(Request $request){
		$cat_name = $request->category_name;
		if($cat_name){
            $data['category_list'] = Category::where('status',1)->where('category_name',$cat_name)->paginate(10);
		}else{
			$data['category_list'] = Category::where('status',1)->paginate(10);
		}
    	return json_encode($data);
    }

    public function addCategory(Request $request){

    	$create_category_item = Category::create($request->all());

    	if($create_category_item){
           echo $message = "Category Created Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	public function updateCategoryView(Request $request, $id){
        $data['category'] = Category::where('status',1)->where('id',$id)->first();
        return response()->json($data,200);
    }

    public function updateCategory(Request $request, $id){

    	$update_category_item = Category::where('id',$id)->update($request->all());

    	if($update_category_item){
           echo $message = "Category Updated Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteCategory(Request $request, $id){

    	$delete_category = Category::destroy(array('id',$id));

    	if($delete_category){
           echo $message = "Category Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	/*
	|--------------------------------------------------------------------------
	| Product Supply Management
	|--------------------------------------------------------------------------
	|
	*/

	public function supplyList(Request $request){
		$supplier_id = $request->supplier_id;
		$from_date = $request->from_date;
		$to_date = $request->to_date;
		if($supplier_id && $from_date && $to_date){
            $data['supplies'] = Supply::with('suppliers')
			                    ->where('status',1)
								->where('supplier_id',$supplier_id)
								->whereBetween('created_at', array($request->from_date, $request->to_date))
								->paginate(10);
		}else{
			$data['supplies'] = Supply::with('suppliers')->where('status',1)->paginate(10);
		}	
        
		return response()->json($data,200);
    }

	public function addSupplyView(){
        $data['vendor'] = User::where('status',1)->where('id',3)->get();
        $data['product'] = Product::with('product_variant')->where('status',1)->get();
        $data['warehouse'] = Warehouse::where('status',1)->get();
        return response()->json($data,200);
    }

	public function addSupply(Request $request){
		$current_expense = Treasury::first();
        \DB::transaction(function() use($request){
            $add_supply = Supply::create([
				'supplier_id' => $request->supplier_id,
				'product_id' => $request->product_id,
				'warehouse_id' => $request->warehouse_id,
				'quantity' => $request->quantity,
				'rate' => $request->rate,
				'status' => $request->status
			]);

			foreach ($request->product_id as $key => $value) {
    		
    			$input['warehouse_id'] = $request->warehouse_id[$key];
    			$input['supply_id'] = $request->supply_id[$key];
    			$input['product_id'] = $request->product_id[$key];
    			$input['quantity'] = $request->quantity[$key];
    			$input['purchase_price'] = $request->purchase_price[$key];

    			$supply_to_warehouse = WarehouseProduct::updateOrCreate(['product_id'=>$request->product_id[$key]], $input);
    		
    	    }

			foreach($request->product_id as $variable => $index){
				$update_stock = Product::where('id','=',$request->product_id)->update([
					'stock' => $request->quantity[$variable],
				]);
			}

			foreach($request->product_id as $variable => $index){
				$add_price = ProductPrice::create([
					'product_varient_id' => $request->product_varient_id[$variable],
				]);
			}

			$expense = Expense::create([
				'expense_token' => 's'.$id,
				'spent_on' => 'supply',
				'spent_by' => $request->spent_by,
				'spent_money' => $request->spent_money,
				'status' => $request->status
			]);

			$update_treasury = Treasury::where('id',1)->update([
				'spent_money' => $expense->sum('spent_money'),
				'on_hand' => $current_expense->total_spent - $expense->sum('spent_money'),
			]);
		});	
    	
    	if($add_supply){
           $message = "Supply Added Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

	public function updateSupplyView(Request $request, $id){
		$data['vendor'] = User::where('status',1)->where('id',3)->get();
        $data['product'] = Product::with('product_variant')->where('status',1)->get();
        $data['warehouse'] = Warehouse::where('status',1)->get();
        $data['supply'] = Supply::where('id',$id)->first();
        return response()->json($data,200);
    }

	public function updateSupply(Request $request, $id){
		$current_expense = Treasury::first();
        \DB::transaction(function() use($request){
            $update_supply = Supply::where('id',$id)->update([
				'supplier_id' => $request->supplier_id,
				'product_id' => $request->product_id,
				'warehouse_id' => $request->warehouse_id,
				'quantity' => $request->quantity,
				'rate' => $request->rate,
				'status' => $request->status
			]);

			foreach($request->product_id as $variable => $index){
				$update_prdct_wrhs = WarehouseProduct::where('supply_id',$id)->update([
					'warehouse_id' => $request->warehouse_id[$variable],
					'product_id' => $request->product_id[$variable],
					'supply_id' => $request->supply_id,
					'quantity' => $request->quantity[$variable],
					'purchase_price' => $request->rate[$variable]
				]);
			}

			$expense = Expense::where('expense_token','s'.$id)->update([
				'spent_on' => 'supply',
				'spent_by' => $request->spent_by,
				'spent_money' => $request->spent_money,
				'status' => $request->status
			]);

			$update_treasury = Treasury::where('id',1)->update([
				'spent_money' => $expense->sum('spent_money'),
				'on_hand' => $current_expense->total_spent - $expense->sum('spent_money'),
			]);
		});	
    	
    	if($update_supply){
           $message = "Supply Updated Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

	public function deleteSupply(Request $request, $id){
		$current_credit = Treasury::first();
		\DB::transaction(function() use($request){
            $delete_supply = Supply::destroy(array('id',$id));
			$delete_expense = Expense::destroy(array('expense_token','s'.$id));
			$delete_supply_from_warehouse = WarehouseProduct::destroy(array('supply_id',$supply_id));

			$update_treasury = Treasury::where('id',1)->update([
				'total_spent' => $delete_expense->sum('amount'),
				'on_hand' => $delete_expense->sum('amount') - $current_credit->total_spent,
			]);
		});	

    	if($delete_supply){
           echo $message = "Deposit Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	/*
	|--------------------------------------------------------------------------
	| Transfer Product from warehouse to Showroom
	|--------------------------------------------------------------------------
	|
	*/

	public function transferList(Request $request){	
        $data['transfer'] = Transfer::with('storages_from','storages_to','products')->where('status',1)->paginate(10);
		return response()->json($data,200);
    }

	public function addTransferView(){
        $data['vendor'] = User::where('status',1)->where('id',3)->get();
        $data['product'] = Product::where('status',1)->get();
        $data['warehouse'] = Warehouse::where('status',1)->get();
        $data['showroom'] = Showroom::where('status',1)->get();
        return response()->json($data,200);
    }

	public function addTransfer(Request $request){
		$current_expense = Treasury::first();
        \DB::transaction(function() use($request){
            $add_transfer = ShowroomProduct::create([
				'showroom_id' => $request->showroom_id,
				'product_id' => $request->product_id,
				'warehouse_id' => $request->warehouse_id,
				'quantity' => $request->quantity,
				'selling_price' => $request->selling_price
			]);

			foreach($request->supply_id as $variable => $index){
				$add_prdct_wrhs = WarehouseProduct::create([
					'warehouse_id' => $request->warehouse_id[$variable],
					'supply_id' => $request->supply_id[$variable],
					'quantity' => $request->quantity[$variable],
					'purchase_price' => $request->rate[$variable]
				]);
			}

			$expense = Expense::create([
				'expense_token' => 's'.$id,
				'spent_on' => 'supply',
				'spent_by' => $request->spent_by,
				'spent_money' => $request->spent_money,
				'status' => $request->status
			]);

			$update_treasury = Treasury::where('id',1)->update([
				'spent_money' => $expense->sum('spent_money'),
				'on_hand' => $current_expense->total_spent - $expense->sum('spent_money'),
			]);
		});	
    	
    	if($add_supply){
           $message = "Supply Added Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

	/*
	|--------------------------------------------------------------------------
	| Deposit
	|--------------------------------------------------------------------------
	|
	*/

	public function investment(Request $request){	
		$from_date = $request->from_date;
		$to_date = $request->to_date;
		if($from_date && $to_date){
			$data['deposit_list'] = investment::whereBetween('created_at', array($request->from_date, $request->to_date))
			                        ->paginate(10);
		}else{
			$data['deposit_list'] = investment::get();
		}	
        $data['total_credit'] = Treasury::first();
		return response()->json($data,200);
    }

	public function deposit(Request $request){	
		$current_credit = Treasury::first(); 

        \DB::transaction(function() use($request){
            $add_deposit = Investment::create($request->all());

			$update_treasury = Treasury::where('id',1)->update([
				'total_credit' => $add_deposit->sum('amount'),
				'on_hand' => $add_deposit->sum('amount') - $current_credit->total_spent,
			]);
		});	
    	
    	if($add_deposit){
           $message = "Deposit Added Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

	public function updateDepositView(Request $request, $id){
        $data['deposit'] = Investment::where('id',$id)->first();
        return response()->json($data,200);
    }

	public function updateDeposit(Request $request, $id){
		$current_credit = Treasury::first();
		\DB::transaction(function() use($request){
            $update_deposit = Investment::where('id',$id)->update($request->all());

			$update_treasury = Treasury::where('id',1)->update([
				'total_credit' => $update_deposit->sum('amount'),
				'on_hand' => $add_deposit->sum('amount') - $current_credit->total_spent,
			]);
		});	

    	if($update_deposit){
           echo $message = "Deposit Updated Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteDeposit(Request $request, $id){
		$current_credit = Treasury::first();
		\DB::transaction(function() use($request){
            $delete_deposit = Investment::destroy(array('id',$id));

			$update_treasury = Treasury::where('id',1)->update([
				'total_credit' => $delete_deposit->sum('amount'),
				'on_hand' => $add_deposit->sum('amount') - $current_credit->total_spent,
			]);
		});	

    	if($delete_deposit){
           echo $message = "Deposit Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	/*
	|--------------------------------------------------------------------------
	| Expenses
	|--------------------------------------------------------------------------
	|
	*/

	public function expense(Request $request){	
		$spent_on = $request->spent_on;
		$from_date = $request->from_date;
		$to_date = $request->to_date;
		if($spent_on && $from_date && $to_date){
			$data['expense_list'] = Expense::whereBetween('created_at', array($request->from_date, $request->to_date))
			                        ->where('spent_on','LIKE','%'.$spent_on.'%')
			                        ->paginate(10);
		}else{
			$data['expense_list'] = Expense::get();
		}	
        $data['total_expense'] = Treasury::first();
		
		return response()->json($data,200);
    }

	public function newExpense(Request $request){	
		$current_expense = Treasury::first();

        \DB::transaction(function() use($request){
            $add_expense = Expense::create($request->all());

			$update_treasury = Treasury::where('id',1)->update([
				'spent_money' => $add_expense->sum('spent_money'),
				'on_hand' => $current_expense->total_spent - $add_expense->sum('spent_money'),
			]);
		});	
    	
    	if($add_expense){
           $message = "Expense Added Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

	public function updateExpenseView(Request $request, $id){
        $data['expense'] = Expense::where('id',$id)->first();
        return response()->json($data,200);
    }

	public function updateExpense(Request $request, $id){
        $current_expense = Treasury::first();
		\DB::transaction(function() use($request){
            $update_expense = Expense::where('id',$id)->update($request->all());

			$update_treasury = Treasury::where('id',1)->update([
				'spent_money' => $update_expense->sum('spent_money'),
				'on_hand' => $current_expense->total_spent - $update_expense->sum('spent_money'),
			]);
		});	

    	if($update_expense){
           echo $message = "Expense Updated Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteExpense(Request $request, $id){
        $current_expense = Treasury::first();
		\DB::transaction(function() use($request){
            $delete_expense = Expense::destroy(array('id',$id));

			$update_treasury = Treasury::where('id',1)->update([
				'spent_money' => $delete_expense->sum('spent_money'),
				'on_hand' => $current_expense->total_spent - $delete_expense->sum('spent_money'),
			]);
		});	

    	if($delete_expense){
           echo $message = "Expense Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

	/*
	|--------------------------------------------------------------------------
	| Lends
	|--------------------------------------------------------------------------
	|
	*/

	public function lend(Request $request){	
		$nid = $request->nid;
		$phone = $request->phone;
		$borrower_name = $request->borrower_name;
		$from_date = $request->from_date;
		$to_date = $request->to_date;
		if($nid && $phone && $borrower_name && $from_date && $to_date){
			$data['lend_list'] = Lend::whereBetween('created_at', array($request->from_date, $request->to_date))
			                        ->where('nid',$nid)
			                        ->where('phone',$phone)
			                        ->where('borrower_name','LIKE','%'.$borrower_name.'%')
			                        ->paginate(10);
		}else{
			$data['lend_list'] = Lend::paginate(10);
		}	
        $data['total_lend'] = Treasury::first();
		
		return response()->json($data,200);
    }

	public function newLend(Request $request){	
		$current_lend = Treasury::first();

        \DB::transaction(function() use($request){
            $add_lend = Lend::create($request->all());

			$update_treasury = Treasury::where('id',1)->update([
				'total_lend' => $add_lend->sum('lend_amount'),
				'on_hand' => $current_lend->total_lend - $add_lend->sum('lend_amount'),
			]);
		});	
    	
    	if($add_lend){
           $message = "Lend Added Successfully"; 
    	}else{
           $message = "Something Went Wrong !"; 
    	}
    	return response()->json($message);
    }

	public function updateLendView(Request $request, $id){
        $data['lend'] = Lend::where('id',$id)->first();
        return response()->json($data,200);
    }

	public function updateLend(Request $request, $id){
		$current_lend = Treasury::first();
		\DB::transaction(function() use($request){
            $update_lend = Lend::where('id',$id)->update($request->all());

			$update_treasury = Treasury::where('id',1)->update([
				'total_lend' => $update_lend->sum('lend_amount'),
				'on_hand' => $current_lend->total_lend - $update_lend->sum('lend_amount'),
			]);
		});	

    	if($update_lend){
           echo $message = "Lend Updated Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

    public function deleteLend(Request $request, $id){
		$current_lend = Treasury::first();
		\DB::transaction(function() use($request){
            $delete_lend = Lend::destroy(array('id',$id));

			$update_treasury = Treasury::where('id',1)->update([
				'total_lend' => $delete_lend->sum('lend_amount'),
				'on_hand' => $current_lend->total_lend - $delete_lend->sum('lend_amount'),
			]);
		});	

    	if($delete_lend){
           echo $message = "Expense Deleted Successfully"; 
    	}else{
           echo $message = "Something Went Wrong !"; 
    	}
    	return json_encode($message);
    }

}
