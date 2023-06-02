<?php

namespace App\Http\Controllers;

use App\customer;
use App\hr_employment;
use App\coa_accounts_control;
use App\guest_type;
use App\fnb_user_shifts;
use App\fnb_pos_location;
use App\fnb_ent_detail;
use App\accounts;
use App\kotrec;
use App\User;
use App\fnb_table_reservation;
use App\fnb_table_reservation_subs;
use Carbon\Carbon;
use App\fnb_sale;
use App\fnb_shifts;
use App\mem_family;
use App\finance_cash_receipt;
use App\transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use DataTables;
use App\membership;
use App\fnb_item_definition;
use App\fnb_restaurant_location;
use App\fnb_currency;
use App\fnb_item_sub_category;
use App\fnb_item_category;
use App\fnb_item_manufacturer;
use App\fnb_measurement_unit;
use App\fnb_product_classification;
use App\fnb_waitor_definition;
use App\fnb_table_definition;
use App\fnb_predefined_value;
use App\mem_status;
use App\finance_account_head;
use App\finance_account_type;
use App\finance_payment_methods;
use App\fnb_sales_subs;
use App\admin_company_profile;
use App\fnb_cancelled_item_remark;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use App\trans_relations;
use App\trans_type;
use App\fnb_sales_recipe_subs;
use App\store_transactions;
use App\coa_account;
use App\corporateMembership;
use App\TempAppliedMemberName;
use Illuminate\Support\Facades\Log;

/*ssh martin@192.168.1.9*/

class FnbSaleController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index_list_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/food-and-beverage/sales/sales-list-vue');
	}


	public function index_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/food-and-beverage/sales/sales-vue');
	}


	public function sales_init_vue(Request $request)
	{

		$search = '';


		if ($request->get('start_date')) {
			$search .= ' and fnb_sales.date >="' . $request->get('start_date') . '"';
		}
		if ($request->get('end_date')) {
			$search .= ' and fnb_sales.date <="' . $request->get('end_date') . '"';
		}
		if ($request->get('invoiceno')) {
			$search .= ' and fnb_sales.invoice_no = "' . $request->get('invoiceno') . '"';
		}
		if ($request->get('mocid')) {
			$search .= ' and  fnb_sales.customer_id ="' . $request->get('mocid') . '"';
		}
		if ($request->get('mog') == 1) {
			$search .= ' and  fnb_sales.type =1';
		}
		if ($request->get('mog') == 0) {
			$search .= ' and  fnb_sales.type =0';
		}
		if ($request->get('mog') == 3) {
			$search .= ' and  fnb_sales.type =3';
		}
		if ($request->get('mog') == 6) {
			$search .= ' and  fnb_sales.type =6';
		}
		if ($request->specific == 1) {
			$search .= ' and fnb_sales.discount >0 ';
		}
		if ($request->specific == 2) {
			$search .= ' and fnb_sales.tax >0 ';
		}


		if ($request->ent == 'Include') {
			$search .= ' and fnb_sales.ent is not null ';
		}
		if ($request->ent == 'Exclude') {
			$search .= ' and fnb_sales.ent not in (1,2) ';
		}
		if ($request->ent == 'Only ENT') {
			$search .= ' and fnb_sales.ent =1 ';
		}
		if ($request->ent == 'Only CTS') {
			$search .= ' and fnb_sales.ent =2 ';
		}

		if ($request->entdetail) {
			$search .= ' and fnb_sales.ent_detail in (' . $request->entdetail . ') ';
		}
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->rcashier) {
			$search .= ' and  transactions.created_by in (' . $request->rcashier . ') ';
		}
		if ($request->get('acftype')) {
			$search .= ' and trans_types.name ="' . $request->get('acftype') . '"';
		}


		$start_date = settings('fnb_due');
		if ($request->kk) {


			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_sales.*, fnb_restaurant_locations.desc as restaurant, fnb_table_definitions.desc as tabledef, memberships.mem_no as mem_no,
      st.desc as activity,
      customer_name as customer,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,

     corporate_memberships.title as ctname,
  corporate_memberships.applicant_name as clname,
  corporate_memberships.first_name as cfname,
  corporate_memberships.middle_name as cmname,


    customers.guest_type                                  as cgt,
     guest_types.desc as guesttype,
  users.name as cashiername
,
 ruser.name as rcashiername,
 transactions.created_by as ruserid,
  group_concat(distinct fnb_sales_subs.kot_no)               as kotnos,

trans_types.name as payment_method,

  memberships.mem_no as mem_no,sum(distinct transactions.trans_amount ) as paid_amount , GROUP_CONCAT(distinct transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,
if(fnb_sales.customer_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC,

CONCAT_WS(" ",corporate_memberships.title,corporate_memberships.first_name,corporate_memberships.middle_name,corporate_memberships.applicant_name) as  nameMOCC,
 corporate_memberships.mem_no as co_mem_no,
stt.desc as coactivity


from fnb_sales
left outer join transactions as t1 on t1.trans_type=5 and t1.trans_type_id=fnb_sales.id and t1.debit_or_credit=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=5 and transactions.trans_type_id=fnb_sales.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join trans_types on trans_types.id = transactions.payment_method
left outer join users on users.id =fnb_sales.created_by  
left outer join users ruser on ruser.id =transactions.created_by  
left outer join hr_employments on hr_employments.id=fnb_sales.customer_id
left outer join fnb_restaurant_locations on fnb_restaurant_locations.id=fnb_sales.restaurant_location
left outer join fnb_sales_subs on fnb_sales_subs.sales_id=fnb_sales.id
left outer join fnb_table_definitions on fnb_table_definitions.id=fnb_sales.table_definition
left outer join memberships on memberships.id = fnb_sales.customer_id and memberships.deleted_at is null
left outer join corporate_memberships on corporate_memberships.id = fnb_sales.customer_id and corporate_memberships.deleted_at is null and fnb_sales.type=6

left outer join mem_statuses st on st.id=memberships.active and st.status=1
left outer join mem_statuses stt on stt.id=corporate_memberships.active and stt.status=1

left outer join customers on customers.id =fnb_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type and guest_types.deleted_at is null

where fnb_sales.completed!=0 and fnb_sales.`date`>="' . $start_date . '"  and fnb_sales.deleted_at is null ' . $search . ' group by fnb_sales.id order by fnb_sales.id desc'
			);
		} else {
			$data['sales'] = [];
		}

		$data['accTypes'] =   trans_type::where('cash_or_payment', 2)->where('type', 7)->get();
		$data['accpermit'] = Auth::user()->getAllPermissions()->where('category', 23)->pluck('name');
		$data['gts'] = guest_type::where('status', 1)->get();
		$data['ent_details'] = fnb_ent_detail::where('status', 1)->get();
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['users'] = User::where('status', 1)->get();
		if (Auth::user()->can('Export Sales')) {
			$data['exported'] = 1;
		}

		return $data;
	}


	// RUNNING SALES LIST
	public function index_running_list_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/food-and-beverage/sales/running-sales-list-vue');
	}

	public function running_sales_init_vue(Request $request)
	{
		$start_date = settings('fnb_due');
		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			'select fnb_sales.*, fnb_restaurant_locations.desc as restaurant, fnb_table_definitions.desc as tabledef, memberships.mem_no as mem_no,
      st.desc as activity,
      customer_name as customer,
       customers.guest_type                                  as cgt,
       guest_types.desc as guesttype,
      hr_employments.name as employee,
       memberships.title as tname,
  memberships.applicant_name as lname,
  memberships.first_name as fname,
  memberships.middle_name as mname,


     corporate_memberships.title as ctname,
  corporate_memberships.applicant_name as clname,
  corporate_memberships.first_name as cfname,
  corporate_memberships.middle_name as cmname,

  users.name as cashiername,

  group_concat(distinct fnb_sales_subs.kot_no)               as kotnos,


  memberships.mem_no as mem_no,sum(distinct transactions.trans_amount ) as paid_amount , GROUP_CONCAT(distinct transactions.receipt_id) as reciept_id,(t1.is_active) as is_active,
if(fnb_sales.customer_id is null,customers.customer_name,CONCAT_WS(" ",memberships.title,memberships.first_name,memberships.middle_name,memberships.applicant_name)) as  nameMOC,

CONCAT_WS(" ",corporate_memberships.title,corporate_memberships.first_name,corporate_memberships.middle_name,corporate_memberships.applicant_name) as  nameMOCC,
 corporate_memberships.mem_no as co_mem_no,
stt.desc as coactivity

from fnb_sales
left outer join transactions as t1 on t1.trans_type=5 and t1.trans_type_id=fnb_sales.id and t1.debit_or_credit=1 and t1.deleted_at is null
left outer join transactions on transactions.trans_type=5 and transactions.trans_type_id=fnb_sales.id and transactions.debit_or_credit=0 and transactions.deleted_at is null
left outer join hr_employments on hr_employments.id=fnb_sales.customer_id
left outer join fnb_restaurant_locations on fnb_restaurant_locations.id=fnb_sales.restaurant_location
left outer join fnb_sales_subs on fnb_sales_subs.sales_id=fnb_sales.id
left outer join users on users.id =fnb_sales.created_by
left outer join fnb_table_definitions on fnb_table_definitions.id=fnb_sales.table_definition
left outer join memberships on memberships.id = fnb_sales.customer_id and memberships.deleted_at is null
left outer join corporate_memberships on corporate_memberships.id = fnb_sales.customer_id and corporate_memberships.deleted_at is null and fnb_sales.type=6


left outer join mem_statuses st on st.id=memberships.active and st.status=1
left outer join mem_statuses stt on stt.id=corporate_memberships.active and stt.status=1

left outer join customers on customers.id =fnb_sales.customer_id and customers.deleted_at is null
left outer join guest_types on guest_types.id =customers.guest_type and guest_types.deleted_at is null

where fnb_sales.completed=0 and fnb_sales.`date`>="' . $start_date . '" and fnb_sales.deleted_at is null group by fnb_sales.id order by fnb_sales.id desc'
		);

		$data['gts'] = guest_type::where('status', 1)->get();
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['users'] = User::where('status', 1)->get();

		if (Auth::user()->can('Export Running Sales')) {
			$data['exported'] = 1;
		}

		return $data;
	}
	// RUNNING SALES LIST

	public function index_deleted(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/food-and-beverage/sales/sales-deleted');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function indexdt_deleted(Request $request, fnb_sale $fnb_sale)
	{

		$table = fnb_sale::onlyTrashed()->get();
		return DataTables::of($table)

			->addColumn('restorebutton', function ($table) {
				return '<button class="buttoncolor" title="Restore"><a style="color:#000000;" href="' . url('food-and-beverage/sales/restore/') . '/' . $table->id . '"><i class="fas fa-trash-restore"></i></a></button>';
			})

			->addColumn('date', function ($table) {
				return formatDateToShow($table->date);
			})


			->addColumn('deleted_at', function ($table) {
				return formatDateToShow($table->deleted_at);
			})


			->addColumn('type', function ($table) {
				if ($table->type == 0) {
					return "Member";
				} else if ($table->type == 6) {
					return "Corporate Member";
				} else if ($table->type == 1) {
					return "Guest";
				} else if ($table->type == 3) {
					return "Employee";
				}
			})

			->addColumn('waiter_definition', function ($table) {
				return saleswaitername($table->waiter_definition);
			})

			->addColumn('table_definition', function ($table) {
				return salestablename($table->table_definition);
			})


			->addColumn('restaurant_location', function ($table) {
				return salesrestaurantname($table->restaurant_location);
			})


			->addColumn('customer_id', function ($table) {
				//                    dd($room_bookings->member);

				if ($table->type == 0) {
					return  $table->member ? $table->member->mem_no : '';
				} else if ($table->type == 6) {
					return  $table->corporateMember ? $table->corporateMember->mem_no : '';
				} else if ($table->type == 1) {
					return $table->customer ? $table->customer->customer_no : '';
				} else if ($table->type == 3) {
					return $table->employees ? $table->employees->id : '';
				} else {
					return  $table->customer_id;
				}
			})


			->rawColumns(['restorebutton', 'type', 'waiter_definition', 'table_definition', 'restaurant_location', 'date'])
			->addIndexColumn()
			->make(true);
	}

	public function sales()
	{
		return view('backend/food-and-beverage.sales.sales-aeu');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function sales_init(Request $request)
	{
		$kot = getLastKot();
		if ($request->get('r')) {
			$lastval = fnb_sale::find($request->get('r'));
			$num = 0;
			if ($lastval) {
				$num = $lastval->id;
				$lastval['increment_number'] = $num;
			} else {
				$num = 0;
				$lastval['increment_number'] = $num;
			}
			$comi = fnb_sale::where('id', $request->get('r'))->get()->pluck('completed');

			if (transactions::where('trans_type', 5)->where('trans_type_id', $request->get('r'))->where('type', 2)->where('debit_or_credit', 0)->exists()) {
				$therecid = transactions::where('trans_type', 5)->where('trans_type_id', $request->get('r'))->where('type', 2)->where('debit_or_credit', 0)->get()->pluck('receipt_id');
				if ($therecid[0]) {
					$lastval['lediscount'] = finance_cash_receipt::where('id', $therecid[0])->get()->pluck('discount');
					$lastval['advance'] = finance_cash_receipt::where('id', $therecid[0])->get()->pluck('advance');
				}
			}

			if (Auth::user()->can('Cancel Sales')) {
				$lastval['cancel_permit'] = Permission::where('name', 'Cancel Sales')->get();
			}

			if (Auth::user()->can('Edit Sales')) {
				$lastval['editsalepermit'] = Permission::where('name', 'Edit Sales')->get();
			}

			$lastval['catspermit'] = Auth::user()->getAllPermissions()->where('category', 18)->pluck('name');

			$lastval['selected_items'] = fnb_sales_subs::selectRaw('fnb_sales_subs.*,0 as product, 0 as varDisc,0 as totalamt')->where('sales_id', $num)->get();
			$lastval['completedstatus'] = fnb_sale::where('id', $num)->pluck('completed');
			$lastval['tempvar'] = fnb_sale::where('id', $num)->get()->pluck('grand_total');
			$lastval['tempgrandtotal'] = $lastval['tempvar'][0];

			$lastval['booked_tables'] = fnb_sale::where('completed', 0)->pluck('table_definition');

			if ($lastval->type == 0) {
				$familyid = $lastval->customer_id;
				$lastval['families'] = mem_family::where('member_id', $familyid)->with('relationship_name')->get();
			}


			$xp = fnb_predefined_value::get()->first()->pluck('xp_printer');
			$lastval['xpprinter'] = $xp[0];


			$xptwo = fnb_predefined_value::get()->first()->pluck('xp_printer_two');
			$lastval['xpprintertwo'] = $xptwo[0];


			$lastval['printed_tables'] = fnb_sale::where('completed', 1)->pluck('table_definition');
			$lastval['accounts'] = coa_accounts_control::whereIn('cost_center', ['1', '2'])->get();

			$pos = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
			if ($pos && $pos->in_out == 0) {
				$lastval['cur_pos'] = $pos->pos_location;
			} else {
				$lastval['cur_pos'] = '';
			}
			$lastval['poss'] = trans_type::where('type', 6)->get();
			/*  $lastval['poss']=fnb_pos_location::where('status',1)->get();*/

			$lastval['companies'] = coa_account::wherenotnull('desc')->get();
			$lastval['pms'] = finance_payment_methods::where('status', 1)->get();
			$lastval['taxandservice'] = fnb_predefined_value::get()->first();
			$lastval['gts'] = guest_type::where('status', 1)->get();
			$lastval['ent_details'] = fnb_ent_detail::where('status', 1)->get();
			$lastval['mains'] = fnb_item_category::where('status', 1)->orderBy('desc')->get();
			// $lastval['subcats'] = fnb_item_sub_category::where('status', 1)->get();
			// $lastval['itemdefs'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();
		 // $lastval['waiters'] = fnb_waitor_definition::where('status', 1)->get();
			// $lastval['tables'] = fnb_table_definition::where('status', 1)->orderBy('desc')->get();
			$lastval['restaurants'] = fnb_restaurant_location::where('status', 1)->where('restaurant', 1)->get();
			$lastval['cancelled_remarks'] = fnb_cancelled_item_remark::where('status', 1)->get();
			$lastval['currencies'] = fnb_currency::where('status', 1)->get();
			// $lastval['discountables'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get()->first();
			$lastval['accheads'] = finance_account_head::where('status', 1)->get();
			$lastval['acctypes'] = trans_type::where('cash_or_payment', 2)->where('type', 7)->get();
			/* $lastval['acctypes']=finance_account_type::where('status',1)->get();*/
			$lastval['accpermit'] = Auth::user()->getAllPermissions()->where('category', 23)->pluck('name');
			if (fnb_shifts::get()->count() != 0) {
				$lastval['shift'] = fnb_shifts::get()->first()->pluck('date');
			} else {
				$lastval['shift'] = [];
			}
			if(TempAppliedMemberName::where('sale_id', $request->get('r'))->exists()){
				$person = TempAppliedMemberName::where('sale_id', $request->get('r'))->pluck('person_name');
				$lastval['person_name'] = $person[0];
			}else{
				$lastval['person_name'] = "";
			}

			$lastval['kot'] = $kot;

			return $lastval;
		} else {

			//Get the last record id and pass to the view
			$lastval = fnb_sale::withTrashed()->latest('id')->first();
			$num = 0;
			if ($lastval) {
				$num = $lastval->id + 1;
				$data['increment_number'] = $num;
			} else {
				$num = 1;
				$data['increment_number'] = $num;
			}


			$reserve = fnb_table_reservation::withTrashed()->latest('id')->first();
			$rn = 0;
			if ($reserve) {
				$rn = $reserve->id + 1;
				$data['reservation_number'] = $rn;
			} else {
				$rn = 1;
				$data['reservation_number'] = $rn;
			}



			if (Auth::user()->can('Cancel Sales')) {
				$data['cancel_permit'] = Permission::where('name', 'Cancel Sales')->get();
			}

			if (Auth::user()->can('Edit Sales')) {
				$data['editsalepermit'] = Permission::where('name', 'Edit Sales')->get();
			}
			// dd();
			$data['pms'] = finance_payment_methods::where('status', 1)->get();
			$data['catspermit'] = Auth::user()->getAllPermissions()->where('category', 18)->pluck('name');
			$data['accounts'] = coa_accounts_control::whereIn('cost_center', ['1', '2'])->get();
			$data['booked_tables'] = fnb_sale::where('completed', 0)->pluck('table_definition');
			$data['printed_tables'] = fnb_sale::where('completed', 1)->pluck('table_definition');

			$data['taxandservice'] = fnb_predefined_value::first();

			$xp = fnb_predefined_value::get()->first()->pluck('xp_printer');
			$data['xpprinter'] = $xp[0];


			$xptwo = fnb_predefined_value::get()->first()->pluck('xp_printer_two');
			$data['xpprintertwo'] = $xptwo[0];


			$pos = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
			if ($pos && $pos->in_out == 0) {
				$data['cur_pos'] = $pos->pos_location;
			} else {
				$data['cur_pos'] = '';
			}

			$data['poss'] = trans_type::where('type', 6)->get();

			/*  $data['poss']=fnb_pos_location::where('status',1)->get();*/
			$data['companies'] = coa_account::wherenotnull('desc')->get();
			$data['gts'] = guest_type::where('status', 1)->get();
			$data['mains'] = fnb_item_category::where('status', 1)->orderBy('desc')->get();
			// $data['subcats']=fnb_item_sub_category::where('status',1)->get();
			// $data['itemdefs']=fnb_item_definition::where('status',1)->where('salable',1)->get();
		 //$data['waiters']=fnb_waitor_definition::where('status',1)->get();
			// $data['tables']=fnb_table_definition::where('status',1)->orderBy('id')->get();
			$data['restaurants'] = fnb_restaurant_location::where('status', 1)->where('restaurant', 1)->get();
			$data['currencies'] = fnb_currency::where('status', 1)->get();
			// $data['discountables']=fnb_item_definition::where('status',1)->where('salable',1)->get()->first();

			$data['accheads'] = finance_account_head::where('status', 1)->get();
			/* $data['acctypes']=finance_account_type::where('status',1)->get();*/
			$data['acctypes'] = trans_type::where('cash_or_payment', 2)->where('type', 7)->get();
			$data['accpermit'] = Auth::user()->getAllPermissions()->where('category', 23)->pluck('name');

			if (fnb_shifts::get()->count() != 0) {
				$data['shift'] = fnb_shifts::get()->first()->pluck('date');
			} else {
				$data['shift'] = [];
			}

			//$membership = membership::get();
			//$active=mem_status::where('id',$membership->active)->get();
			//$data['memstatus']= $active[0]['desc'];
			$data['kot'] = $kot;
			return $data;
		}
	}

	public function save(Request $request)
	{
		$mega = 0;
		// $magi = fnb_predefined_value::first()->pluck('cost_center');
		/* if($magi[0]){
		$ccc=$magi[0];
    		}
		else{
      		$ccc='001-001';
    		}*/
		$ccc = $request->get('company');
		$typo = null;

		/*  if($request->get('type')=='01' || $request->get('type')=='1'){
      		$typo=1;
   	 	}
		else if($request->get('type')=='02' || $request->get('type')=='2'){
      		$typo=1;
		}*/
		if ($request->get('type') > 10) {
			$typo = 1;
		} else if ($request->get('type') == 1) {
			$typo = 1;
		} else if ($request->get('type') == 8) {
			$typo = 0;
		} else if ($request->get('type') == 6) {
			$typo = 6;
		} else if ($request->get('type') == 3) {
			$typo = 3;
		}

		if ($request->get('selected_items') == []) {
			abort(500);
		} else {
			$rest_loc = fnb_table_definition::where('id', $request->get('sTable'))->pluck('restaurant_location');
			if(!empty($rest_loc)){
				$restaurant_loc = $rest_loc[0];
			}else{
				$restaurant_loc = '';
			}

			$pos = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
			$pos_loc = $pos->pos_location;

			$d = [];
			$dd = '';
			$cati = '';

			if ($typo == 0) {
				$dd = $request->get('customer_id');

				if (membership::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = membership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//    $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;

						$cati = memcategoryname($dd);
					}
				}
			} else if ($typo == 6) {
				$dd = $request->get('customer_id');

				if (corporateMembership::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = corporateMembership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//    $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;

						$cati = comemcategoryname($dd);
					}
				}
			} else if ($typo == 1) {
				$dd = $request->get('customer_id');

				if (customer::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = customer::where('id', $request->get('customer_id'))->get()->pluck('account');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//  $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;
						$cati =  null;
					}
				}
			} else if ($typo == 3) {

				$dd = $request->get('customer_id');


				if (hr_employment::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = hr_employment::where('id', $request->get('customer_id'))->get()->pluck('account');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//  $dd=$d['coa_code'];

						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;
						$cati =  null;
					}
				}
			}

			DB::beginTransaction();
			try {
				$lastval = fnb_sale::withTrashed()->latest('id')->first();
				$num = 0;
				if ($lastval) {
					$num = $lastval->id + 1;
					$data['increment_number'] = $num;
				} else {
					$num = 1;
					$data['increment_number'] = $num;
				}

				if (fnb_sale::where('id', $data['increment_number'])->count() == 0) {
					$d['invoice_no'] = $data['increment_number'];
					$d['date'] = $request->get('date');
					$d['time'] = $request->get('time');
					$d['unit'] = $ccc;
					$d['table_definition'] = $request->get('sTable');
					$d['restaurant_location'] = $restaurant_loc;
					$d['waiter_definition'] = $request->get('sWaiter');
					$d['order_type'] = $request->get('sType');
					$d['type'] = $typo;
					$d['name'] = $request->get('customer');
					$d['customer_id'] = $request->get('customer_id');
					if ($typo == 0 || $typo == 6) {
						$d['family'] = $request->get('family');
					}
					$d['ledger_amount'] = $request->get('ledger_amount');
					$d['covers'] = $request->get('covers');
					$d['discount_card_no'] = $request->get('discountcard');
					$d['disc'] = $request->get('disc');
					$d['disc_pc'] = $request->get('disc_pc');
					$d['category'] = $request->get('sCategory');
					$d['sub_category'] = $request->get('sSubCat');
					$d['gross'] = $request->get('gross');
					$d['discount'] = $request->get('discount');
					$d['sub_total'] = $request->get('subtotal');
					$d['tax'] = $request->get('tax');
					$d['service_charges'] = $request->get('service');
					$d['service_charges_pct'] = $request->get('service_pct');
					$d['grand_total'] = $request->get('grandtotal');
					$d['completed'] = 0;
					$d['confirmed'] = 0;
					$d['pos_location'] = $pos_loc;

					$id =  fnb_sale::create($d);
					//auto correct inovice number & id order
					if($id->id !== $data['increment_number']){
						$fnb_data = fnb_sale::where('invoice_no', $data['increment_number'])->first();
						if(!empty($fnb_data)){
							fnb_sale::where('invoice_no', $data['increment_number'])->update([
								'invoice_no' => $id->id
							]);
						}
					}
					$tempData['sale_id'] = $id->id;
					if(!empty($request->get('temp_person_name'))){
						$tempData['person_name'] = $request->get('temp_person_name');
						TempAppliedMemberName::create($tempData);
					}

					foreach ($request->get('selected_items') as $inv) {
						$mega = $mega + $inv['product'];
						if (fnb_sales_subs::where('kot_no', $inv['kot'])->where('created_by', Auth::id())->where('sales_id', '!=', $id->id)->exists()) {
							$rekot = $inv['kot'] + 1;
						} else {
							$rekot = $inv['kot'];
						}
						$m =  fnb_sales_subs::create([
							'sales_id' => $id->id,
							'item_code' => $inv['item_code'],
							'item_details' => $inv['item_details'],
							'sale_price' => $inv['sale_price'],
							'sub_total_price' => $inv['product'],
							'instruction' => $inv['instruction'],
							'remark' => $inv['remark'],
							'aftercancel' => $inv['aftercancel'],
							'status' => $inv['status'],
							'kot_no' => $rekot,
							'total' => $inv['totalamt'],
							'qty' => $inv['qty'],
							'item_discount' => $inv['item_discount'],
							'subcategory' => $inv['subcategory'],
							'date' => $request->get('date'),
							'saved' => 1,
	
						]);
	
						$itsme = fnb_item_definition::where('item_code', $inv['item_code'])->first();
						if ($itsme) {
							$recipes = fnb_sales_recipe_subs::where('item_id', $itsme->id)->get();
							if ($recipes) {
								foreach ($recipes as $reci) {
									$stt =  store_transactions::create([
										'type_id' => $id->id,
										'sub_id' => $m->id,
										'date' => $request->get('date'),
										'in_or_out' => 0,
										'item_code' => $reci['item_code'],
										'issue_price' => $reci['sub_total_price'],
										'store_location' => itemcategoryname($inv['item_code']),
										'unit' => $ccc,
										'qty' => $inv['qty'] * $reci['qty'],
										'type' => 4,
										'is_active' => 1,
										'item_coa_code' => ItemCoaCode($reci['item_code']), //for FNB sales
									]);
								}
							}
						}
					}

					//sending into transactions table
					if (transactions::where('type', 1)->where('debit_or_credit', 1)->where('trans_type', 5)->where('trans_type_id', $id->id)->where('trans_amount', $request->get('grandtotal'))->count() == 0) {
						$t = [];
						$t['type'] = 1;
						$t['debit_or_credit'] = 1;
						$t['trans_type'] = 5;
						$t['trans_type_id'] = $id->id;
						$t['trans_amount'] = $request->get('grandtotal');
						$t['trans_moc'] = $dd;
						$t['trans_moc_category'] = $cati;
						$t['trans_moc_type'] = $typo;
						$t['is_active'] = 1;
						$t['date'] = $request->get('date');
						$t['pos_location'] = $pos_loc;
						$t['account'] = transTypesCoa($pos_loc);
						$t['trans_coa'] = $d['coa_code'];
						$t['unit'] = $ccc;
						$tid =  transactions::create($t);
					}
					//sending into transactions table


				}

				DB::commit();
				return response()->json(['status' => 'success', 'message' => 'succes', 'id' => $id->id]);
				// all good
			} catch (\Exception $e) {
				DB::rollback();	
				return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
				// something went wrong
			}

			
		}
	}


	public function reserve(Request $request)
	{
		//        dd($request->all());

		$typo = null;

		/* if($request->get('type')=='01' || $request->get('type')=='1'){
		$typo=1;
		}
		else if($request->get('type')=='02' || $request->get('type')=='2'){
		$typo=1;
		}*/
		if ($request->get('type') > 10) {
			$typo = 1;
		} else if ($request->get('type') == 1) {
			$typo = 1;
		} else if ($request->get('type') == 8) {
			$typo = 0;
		} else if ($request->get('type') == 6) {
			$typo = 6;
		} else if ($request->get('type') == 3) {
			$typo = 3;
		}
		$lastval = fnb_sale::withTrashed()->latest('id')->first();
		$num = 0;
		if ($lastval) {
			$num = $lastval->id + 1;
			$data['increment_number'] = $num;
		} else {
			$num = 1;
			$data['increment_number'] = $num;
		}



		$reserveone = fnb_table_reservation::withTrashed()->latest('id')->first();
		$rn = 0;
		if ($reserveone) {
			$rn = $reserveone->id + 1;
			$data['reservation_number'] = $rn;
		} else {
			$rn = 1;
			$data['reservation_number'] = $rn;
		}




		if ($request->get('selected_items') == []) {
			abort(500);
		} else {
			$rest_loc = fnb_table_definition::where('id', $request->get('sTable'))->get()->pluck('restaurant_location');
			$restaurant_loc = $rest_loc[0];
			if (fnb_sale::where('invoice_no', $data['increment_number'])->count() == 0 && fnb_table_reservation::where('reservation_no', $data['reservation_number'])->count() == 0) {


				$d = [];

				$d['invoice_no'] = $data['increment_number'];
				$d['date'] = $request->get('date');
				$d['time'] = $request->get('time');

				$d['unit'] = $request->get('company');
				$d['table_definition'] = $request->get('sTable');
				$d['restaurant_location'] = $restaurant_loc;
				$d['waiter_definition'] = $request->get('sWaiter');
				$d['order_type'] = $request->get('sType');

				$d['type'] = $typo;
				$d['name'] = $request->get('customer');
				$d['customer_id'] = $request->get('customer_id');

				if ($typo == 0 || $typo == 6) {
					$d['family'] = $request->get('family');
				}
				//   $d['ledger_amount']=$request->get('ledger_amount');

				$d['covers'] = $request->get('covers');

				$d['discount_card_no'] = $request->get('discountcard');
				$d['disc'] = $request->get('disc');
				$d['disc_pc'] = $request->get('disc_pc');

				//   $d['category']=$request->get('sCategory');
				//   $d['sub_category']=$request->get('sSubCat');

				$d['gross'] = $request->get('gross');
				$d['discount'] = $request->get('discount');
				$d['sub_total'] = $request->get('subtotal');
				$d['tax'] = $request->get('tax');
				$d['service_charges'] = $request->get('service');
				$d['service_charges_pct'] = $request->get('service_pct');
				$d['grand_total'] = $request->get('grandtotal');
				//  $d['completed']=0;
				//  $d['confirmed']=0;


				$d['reservation_no'] = $data['reservation_number'];
				$d['reservation_date'] = formatDate($request->get('reservation_date'));
				$d['nature_of_function'] = $request->get('nature_of_function');
				$d['from_time'] = $request->get('from_time');
				$d['to_time'] = $request->get('to_time');
				$d['theme'] = $request->get('theme');
				$d['arrangement_details'] = $request->get('arrangement_details');

				$id =  fnb_table_reservation::create($d);
			}



			foreach ($request->get('selected_items') as $inv) {
				//       var_dump($inv);

				if (fnb_table_reservation_subs::where('kot_no', $inv['kot'])->where('created_by', Auth::id())->where('sales_id', '!=', $id->id)->exists()) {
					$rekot = $inv['kot'] + 1;
				} else {
					$rekot = $inv['kot'];
				}
				$m =  fnb_table_reservation_subs::create([
					'sales_id' => $id->id,
					'item_code' => $inv['item_code'],
					'item_details' => $inv['item_details'],
					'sale_price' => $inv['sale_price'],
					'sub_total_price' => $inv['product'],
					'instruction' => $inv['instruction'],
					'remark' => $inv['remark'],
					'aftercancel' => $inv['aftercancel'],
					'kot_no' => $rekot,
					'total' => $inv['totalamt'],
					'qty' => $inv['qty'],
					'item_discount' => $inv['item_discount'],
					'status' => $inv['status'],
					'subcategory' => $inv['subcategory'],
					'date' => $request->get('date'),
					'saved' => 1,

				]);
			}

			return $id->id;
		}
	}

	public function updated(Request $request)
	{
		try {
			$typo = null;

			/*  if($request->get('type')=='01' || $request->get('type')=='1'){
				$typo=1;
			}
			else if($request->get('type')=='02' || $request->get('type')=='2'){
				$typo=1;
			}*/
			if ($request->get('type') > 10) {
				$typo = 1;
			} else if ($request->get('type') == 1) {
				$typo = 1;
			} else if ($request->get('type') == 8) {
				$typo = 0;
			} else if ($request->get('type') == 6) {
				$typo = 6;
			} else if ($request->get('type') == 3) {
				$typo = 3;
			}

			// $magi = fnb_predefined_value::first()->pluck('cost_center');
			/* if($magi[0]){
				$ccc=$magi[0];
			}
			else{
				$ccc='001-001';
			}*/
			$ccc = $request->get('company');

			$lastval = fnb_sale::withTrashed()->latest('id')->first();
			$num = 0;
			if ($lastval) {
				$num = $lastval->id + 1;
				$data['increment_number'] = $num;
			} else {
				$num = 1;
				$data['increment_number'] = $num;
			}


			$rest_loc = fnb_table_definition::where('id', $request->get('sTable'))->get()->pluck('restaurant_location');
			$restaurant_loc = $rest_loc[0];

			$d = [];
			$dd = '';
			$cati = '';

			if ($typo == 0) {
				$dd = $request->get('customer_id');

				if (membership::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = membership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//    $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;

						$cati = memcategoryname($dd);
					}
				}
			} else if ($typo == 6) {
				$dd = $request->get('customer_id');

				if (corporateMembership::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = corporateMembership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//    $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;

						$cati = comemcategoryname($dd);
					}
				}
			} else if ($typo == 1) {
				$dd = $request->get('customer_id');

				if (customer::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = customer::where('id', $request->get('customer_id'))->get()->pluck('account');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//  $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;
						$cati =  null;
					}
				}
			} else if ($typo == 3) {
				$dd = $request->get('customer_id');
				if (hr_employment::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = hr_employment::where('id', $request->get('customer_id'))->get()->pluck('account');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//  $dd=$d['coa_code'];

						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;
						$cati =  null;
					}
				}
			}
			DB::beginTransaction();

			// $d['invoice_no']= $data['increment_number'];
			$d['date'] = $request->get('date');
			$d['time'] = $request->get('time');
			$d['unit'] = $ccc;
			$d['table_definition'] = $request->get('sTable');
			$d['restaurant_location'] = $restaurant_loc;

			$d['waiter_definition'] = $request->get('sWaiter');
			$d['order_type'] = $request->get('sType');

			$d['type'] = $typo;
			$d['name'] = $request->get('customer');
			$d['customer_id'] = $request->get('customer_id');

			if ($typo == 0 || $typo == 6) {
				$d['family'] = $request->get('family');
			}
			$d['ledger_amount'] = $request->get('ledger_amount');

			$d['covers'] = $request->get('covers');

			$d['discount_card_no'] = $request->get('discountcard');
			$d['disc'] = $request->get('disc');
			$d['disc_pc'] = $request->get('disc_pc');

			$d['category'] = $request->get('sCategory');
			$d['sub_category'] = $request->get('sSubCat');

			$d['gross'] = $request->get('gross');
			$d['discount'] = $request->get('discount');
			$d['sub_total'] = $request->get('subtotal');
			$d['tax'] = $request->get('tax');
			$d['service_charges'] = $request->get('service');
			$d['service_charges_pct'] = $request->get('service_pct');
			$d['grand_total'] = $request->get('grandtotal');


			$id =  fnb_sale::where('id', $request->get('id'))->updateWithUserstamps($d);
			if(!empty($request->get('temp_person_name'))){
				$tempData['person_name'] = $request->get('temp_person_name');
				if(TempAppliedMemberName::where('sale_id',$request->get('id'))->exists()){
					TempAppliedMemberName::where('sale_id',$request->get('id'))->updateWithUserstamps($tempData);	
				}else{
					$tempData['sale_id'] = $request->get('id');
					$tempData['person_name'] = $request->get('temp_person_name');
					TempAppliedMemberName::create($tempData);
				}

			}
			//sending into transactions table

			$pos = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
			$pos_loc = $pos->pos_location;

			$t = [];


			$t['type'] = 1;
			$t['debit_or_credit'] = 1;
			$t['trans_type'] = 5;
			$t['trans_type_id'] = $request->get('id');
			$t['trans_amount'] = $request->get('grandtotal');
			$t['trans_moc'] = $dd;
			$t['trans_moc_category'] = $cati;

			$t['trans_moc_type'] = $typo;
			$t['is_active'] = 1;
			$t['date'] = $request->get('date');
			$t['account'] = transTypesCoa($pos_loc);
			$t['trans_coa'] = $d['coa_code'];
			$t['unit'] = $ccc;


			$tid = transactions::where('type', 1)->where('debit_or_credit', 1)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->updateWithUserstamps($t);
			//sending into transactions table


			//Re-Calculation
			$re_sub_total = 0;
			$re_item_discount = 0;
			$re_total = 0;
			$re_tax = $request->get('tax');
			$re_service_charges = $request->get('service');

			foreach ($request->get('selected_items') as $inv) {
				$re_sub_total += ($inv['sale_price'] * $inv['qty']);
				$re_total += (($inv['sale_price'] * $inv['qty']) - $inv['item_discount']);
				$re_item_discount += $inv['item_discount'];

				if (!isset($inv['kot_no']) || $inv['kot_no'] == null) {

					$m = fnb_sales_subs::create([
						'sales_id' => $request->get('id'),
						'item_code' => $inv['item_code'],
						'item_details' => $inv['item_details'],
						'sale_price' => $inv['sale_price'],
						'sub_total_price' => $inv['product'],
						'instruction' => $inv['instruction'],
						'remark' => $inv['remark'],
						'aftercancel' => $inv['aftercancel'],
						'kot_no' => $inv['kot'],
						'total' => $inv['totalamt'],
						'qty' => $inv['qty'],
						'item_discount' => $inv['item_discount'],
						'status' => $inv['status'],
						'subcategory' => $inv['subcategory'],
						'date' => $request->get('date'),
						'saved' => 1,

					]);

					$itsme = fnb_item_definition::where('item_code', $inv['item_code'])->first();
					if ($itsme) {
						$recipes = fnb_sales_recipe_subs::where('item_id', $itsme->id)->get();
						if ($recipes) {

							foreach ($recipes as $reci) {
								$stt =  store_transactions::create([
									'type_id' => $request->get('id'),
									'sub_id' => $m->id,
									'date' => $request->get('date'),
									'in_or_out' => 0,
									'item_code' => $reci['item_code'],
									'issue_price' => $reci['sub_total_price'],
									'store_location' => itemcategoryname($inv['item_code']),
									'unit' => $ccc,
									'qty' => $inv['qty'] * $reci['qty'],
									'type' => 4,
									'is_active' => 1,
									'item_coa_code' => ItemCoaCode($reci['item_code']), //for FNB sales
								]);
							}
						}
					}
				} else {

					if (fnb_sales_subs::where('kot_no', $inv['kot'])->where('created_by', Auth::id())->where('sales_id', '!=', $request->get('id'))->exists()) {
						$rekot = $inv['kot'] + 1;
					} else {
						$rekot = $inv['kot'];
					}

					$m = fnb_sales_subs::where('id', $inv['id'])->updateWithUserstamps([
						'sales_id' => $request->get('id'),
						'item_code' => $inv['item_code'],
						'item_details' => $inv['item_details'],
						'sale_price' => $inv['sale_price'],
						'sub_total_price' => $inv['product'],
						'instruction' => $inv['instruction'],
						'remark' => $inv['remark'],
						'aftercancel' => $inv['aftercancel'],
						'kot_no' => $rekot,
						'total' => $inv['totalamt'],
						'qty' => $inv['qty'],
						'item_discount' => $inv['item_discount'],
						'status' => $inv['status'],
						'subcategory' => $inv['subcategory'],
						'date' => $request->get('date'),
						'saved' => 1,
					]);

					$itsme = fnb_item_definition::where('item_code', $inv['item_code'])->first();
					if ($itsme) {
						$recipes = fnb_sales_recipe_subs::where('item_id', $itsme->id)->get();
						if ($recipes) {

							foreach ($recipes as $reci) {
								$stt = store_transactions::where('type', 4)->where('in_or_out', 0)->where('type_id', $request->get('id'))->where('sub_id', $m->id)->updateWithUserstamps([
									'type_id' => $request->get('id'),
									'sub_id' => $m->id,
									'date' => $request->get('date'),
									'in_or_out' => 0,
									'item_code' => $reci['item_code'],
									'issue_price' => $reci['sub_total_price'],
									'store_location' => itemcategoryname($inv['item_code']),
									'unit' => $ccc,
									'qty' => $inv['qty'] * $reci['qty'],
									'type' => 4,
									'is_active' => 1,
									'item_coa_code' => ItemCoaCode($reci['item_code']), //for FNB sales
								]);
							}
						}
					}
				}
			}

			if($request->get('gross') !== (int) $re_sub_total ){
				$message = 'Calculation Error in Invoice : '.$request->get('id'). ' and bill amount is '.$request->get('gross'). ' And sub-total is '.($re_sub_total - $re_item_discount). ' and discount is '.$re_item_discount. ' and Grand Total is '.(($re_sub_total - $re_item_discount) + $re_tax + $re_service_charges);
				Log::warning($message);

				$up['gross'] = $re_sub_total;
				$up['discount'] = $re_item_discount;
				$up['sub_total'] = ($re_sub_total - $re_item_discount);
				$up['grand_total'] = ($re_sub_total - $re_item_discount) + $re_tax + $re_service_charges;
				fnb_sale::where('id', $request->get('id'))->updateWithUserstamps($d);
			}
			// dd('total:'.$re_grand_total, 'gross:'. $re_sub_total, 'discount:'. $re_item_discount, 'Vue-Gross:'.$request->get('gross'), 'Vue-Discount: '.$request->get('discount'), 'Total: '.$request->get('subtotal'), 'Grand_total:'.$request->get('grandtotal'));

			DB::commit();
			return response()->json(['status' => 'success', 'message' => 'succes']);
		} catch (\Throwable $e) {
			DB::rollback();
			return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
		}
		
	}



	public function confirmorder(Request $request, $id)
	{

		$d = [];

		$d['confirmed'] = 1;

		$id =  fnb_sale::where('id', $id)->updateWithUserstamps($d);
		//      dd();

		return redirect('food-and-beverage/running-kitchen-order');
	}

	public function moved(Request $request)
	{

		$d = [];
		$rest_loc = fnb_table_definition::where('id', $request->get('sTable'))->get()->pluck('restaurant_location');
		$restaurant_loc = $rest_loc[0];

		$d['table_definition'] = $request->get('sTable');
		$d['restaurant_location'] = $restaurant_loc;

		$id =  fnb_sale::where('id', $request->get('id'))->updateWithUserstamps($d);
		//      dd();

	}


	public function generate_invoice(Request $request)
	{
		$mega = 0;
		if (fnb_shifts::get()->count() != 0) {
			$mydate = fnb_shifts::get()->first()->pluck('date');
			$activeshift = $mydate[0];
		} else {
			$activeshift = '';
		}

		$mytime = Carbon::now();

		$disc = fnb_sale::where('id', $request->get('id'))->get()->pluck('discount');
		$diss = $disc[0];

		$tax = fnb_sale::where('id', $request->get('id'))->get()->pluck('tax');
		$taxx = $tax[0];

		if ($diss) { } else {
			$diss = 0;
		}

		if ($taxx) { } else {
			$taxx = 0;
		}

		$loops = fnb_sales_subs::where('sales_id', $request->get('id'))->get();
		foreach ($loops as $lop) {
			$mega = $mega + ($lop['sale_price'] * $lop['qty']);
		}



		$d = [];
		$d['completed'] = 1;

		$d['date'] = formatDate($activeshift);
		$d['generated_at'] = formatTimestamp($mytime);
		$d['gross'] = $mega;
		$d['sub_total'] = $mega - $diss;
		$d['grand_total'] = $d['sub_total'] + $taxx;

		$d['created_by'] = Auth::id();
		$d['created_by'] = Auth::id();

		$id =  fnb_sale::where('id', $request->get('id'))->updateWithUserstamps($d);


		$m = fnb_sales_subs::where('sales_id', $request->get('id'))->updateWithUserstamps([
			'date' => formatDate($activeshift),
		]);


		if ($id && $m) {
			return 2;
		}
	}


	public function start_shift(Request $request)
	{

		$d = [];
		$d['date'] = formatDate($request->get('date'));
		if (fnb_shifts::get()->count() != 0) {
			$id = fnb_shifts::where('id', '!=', '')->updateWithUserstamps($d);
		} else {
			$id =  fnb_shifts::create($d);
		}
	}

	public function end_shift(Request $request)
	{

		$d = [];
		$d['date'] = null;

		$id = fnb_shifts::where('id', '!=', '')->updateWithUserstamps($d);
	}


	public function unpaid(Request $request)
	{
		//
		$lastval = fnb_sale::withTrashed()->latest('id')->first();
		$num = 0;
		if ($lastval) {
			$num = $lastval->id + 1;
			$data['increment_number'] = $num;
		} else {
			$num = 1;
			$data['increment_number'] = $num;
		}

		$d = [];

		$d['remarks'] = $request->get('remarks');
		$d['completed'] = 3;

		$id =  fnb_sale::where('id', $request->get('id'))->updateWithUserstamps($d);
		//      dd();



	}


	public function received(Request $request)
	{
		$var_type = null;
		$var_trans_type = null;
		$var_account = null;
		$var_ent = null;
		$typo = null;

		/*if($request->get('type')=='01' || $request->get('type')=='1'){
		$typo=1;
		}
		else if($request->get('type')=='02' || $request->get('type')=='2'){
		$typo=1;
		}*/
		try {
			if ($request->get('type') > 10) {
				$typo = 1;
			} else if ($request->get('type') == 1) {
				$typo = 1;
			} else if ($request->get('type') == 8) {
				$typo = 0;
			} else if ($request->get('type') == 6) {
				$typo = 6;
			} else if ($request->get('type') == 3) {
				$typo = 3;
			}

			// $magi = fnb_predefined_value::first()->pluck('cost_center');
			/* if($magi[0]){
				$ccc=$magi[0];
				}
			else{
				$ccc='001-001';
			}*/
			DB::beginTransaction();
				
			$ccc = $request->get('company');

			$lastval = fnb_sale::withTrashed()->latest('id')->first();
			$num = 0;
			if ($lastval) {
				$num = $lastval->id + 1;
				$data['increment_number'] = $num;
			} else {
				$num = 1;
				$data['increment_number'] = $num;
			}

			$d = [];

			$d['account_head'] = $request->get('sAccHead');
			$d['account_type'] = $request->get('sAccType');
			$d['coa_trans_type'] = $request->get('account');
			$d['remarks'] = $request->get('remarks');
			$d['completed'] = 2;
			$d['amount_received'] = $request->get('amount_received');
			$d['ent'] = $request->get('ent');
			$d['ent_detail'] = $request->get('ent_detail');


			$id =  fnb_sale::where('id', $request->get('id'))->updateWithUserstamps($d);
			//      dd();


			$omega = fnb_sale::where('id', $request->get('id'))->get()->pluck('grand_total');

			$lastcashreceipt = finance_cash_receipt::withTrashed()->latest('id')->first();
			$numtwo = 0;
			if ($lastcashreceipt) {
				$numtwo = $lastcashreceipt->id + 1;
				$cashrec['increment_number'] = $numtwo;
			} else {
				$numtwo = 1;
				$cashrec['increment_number'] = $numtwo;
			}

			$d = [];
			$dd = '';
			$cati = '';

			if ($typo == 0) {
				$dd = $request->get('customer_id');

				if (membership::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = membership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//    $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;

						$cati = memcategoryname($dd);
					}
				}
			} else if ($typo == 6) {
				$dd = $request->get('customer_id');

				if (corporateMembership::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = corporateMembership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//    $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;

						$cati = comemcategoryname($dd);
					}
				}
			} else if ($typo == 1) {
				$dd = $request->get('customer_id');

				if (customer::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = customer::where('id', $request->get('customer_id'))->get()->pluck('account');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//  $dd=$d['coa_code'];
						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;
						$cati =  null;
					}
				}
			} else if ($typo == 3) {

				$dd = $request->get('customer_id');


				if (hr_employment::where('id', $request->get('customer_id'))->exists()) {
					$arr_coa = hr_employment::where('id', $request->get('customer_id'))->get()->pluck('account');
					if ($arr_coa[0]) {
						$coa = $arr_coa[0];
						$d['coa_code'] = $coa;
						//  $dd=$d['coa_code'];

						$cati =  coaparent($coa);
					} else {
						$d['coa_code'] = null;
						$cati =  null;
					}
				}
			}

			$r = [];

			if ($request->get('advance') == 1) {
				$r['advance'] = $request->get('advance');
				$request->sAccType = 20;
				$var_type = 7;
				$var_trans_type = 26;
				$var_account = transTypesCoa(26);
				$var_ent = 5;
			} else if ($request->get('lediscount') == 1) {
				$r['discount'] = $request->get('lediscount');
				$request->sAccType = 20;
				$var_type = 7;
				$var_trans_type = 28;
				$var_account = transTypesCoa(28);
				$var_ent = 3;
			} else {
				$var_type = 3;
				$var_trans_type = 5;
				$var_account = $request->get('account');
				$var_ent = $request->get('ent');
			}



			if (transactions::where('type', '2')->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->where('trans_amount', $request->get('amount_received') + $request->get('return_value'))->count() == 0) {
					//   sending into cash receipts table
					//     || $request->get('ent')==1 || $request->get('ent')==2

					//$request->get('ent')!=2
					//&& ($request->get('ent')!=2 )
					if ($request->get('amount_received') > 0) {



						if ($typo == 0) {
							$r['mem_number'] = $dd;
						} else if ($typo == 6) {
							$r['corporate_id'] = $dd;
						} else if ($typo == 1) {
							$r['customer_id'] = $dd;
						} else if ($typo == 3) {
							$r['employee_id'] = $dd;
						}

						$r['coa_code'] = $d['coa_code'];
						$r['invoice_no'] = $cashrec['increment_number'];
						$r['invoice_date'] = $request->get('date');
						$r['receipt_type'] = $typo;
						$r['family'] = $request->get('family');
						$r['total_amount'] = $request->get('cash_receipt_amt');
						$r['total'] = $request->get('cash_receipt_amt');
						$r['account'] = $request->get('sAccType');
						$r['remarks'] = $request->get('remarks');
						$r['amount_in_words'] = $request->get('amount_in_words');


						$rid =  finance_cash_receipt::create($r);
					}
					//sending into cash receipts table
					if ($request->get('ent') == 1) {
						$d = transactions::where('type', '1')->where('debit_or_credit', '1')->where('trans_type_id', $request->get('id'))->where('trans_type', 5)->first();
						if ($d) {
							$d->ent = 1;

							$d->save();
						}
					} else if ($request->get('ent') == 2) {
						$d = transactions::where('type', '1')->where('debit_or_credit', '1')->where('trans_type_id', $request->get('id'))->where('trans_type', 5)->first();
						if ($d) {
							$d->ent = 2;

							$d->save();
						}
					} else {
						$d = transactions::where('type', '1')->where('debit_or_credit', '1')->where('trans_type_id', $request->get('id'))->where('trans_type', 5)->first();
						if ($d) {
							$d->ent = 0;

							$d->save();
						}
					}


					$pos = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
					$pos_loc = $pos->pos_location;

					//sending into transactions table
					//&& $request->get('ent')!=2

					//(int)($request->get('amount_received'))>0 && 
					//($request->get('ent')!=2 )
					if ((int) ($request->get('amount_received')) > 0 && ($request->get('ent') != 1)) {
						$t = [];
						$t['type'] = 2;
						$t['debit_or_credit'] = 0;
						$t['trans_type'] = 5;
						$t['trans_type_id'] = $request->get('id');
						$t['trans_amount'] = $request->get('cash_receipt_amt');
						$t['trans_moc'] = $dd;
						$t['trans_moc_category'] = $cati;
						// $t['trans_moc_category']=memcategoryname($request->get('customer_id'));
						$t['trans_moc_type'] = $typo;
						$t['is_active'] = 1;
						$t['receipt_id'] = $rid->id;
						$t['date'] = $request->get('date');
						$t['ent'] = $var_ent;
						$t['pos_location'] = $pos_loc;
						$t['payment_method'] = $request->get('sAccType');
						$t['unit'] =  $ccc;
						$t['account'] = transTypesCoa($pos_loc);
						$t['trans_coa'] = $d['coa_code'];



						$acc =  transactions::create([
							'type' => $var_type,
							'debit_or_credit' => 1,
							'trans_type' => $var_trans_type,
							'trans_type_id' => $request->get('id'),
							'trans_amount' => $request->get('cash_receipt_amt'),
							'trans_moc' => $dd,
							'trans_moc_category' => $cati,

							'trans_moc_type' => $typo,
							'receipt_id' => $rid->id,
							'date' => $request->get('date'),
							'ent' => $var_ent,
							'pos_location' => $pos_loc,
							'payment_method' => $request->get('sAccType'),
							'unit' => $ccc,
							'is_active' => 1,
							'account' => $var_account,
							'trans_coa' => $d['coa_code'],


						]);


						$tid =  transactions::create($t);
					}

					//|| $request->get('ent')==2
					else if ((int) ($request->get('amount_received')) > 0 && $request->get('ent') == 1) {

						$t = [];
						$t['type'] = 2;
						$t['debit_or_credit'] = 0;
						$t['trans_type'] = 5;
						$t['trans_type_id'] = $request->get('id');
						$t['trans_amount'] = round($omega[0]);
						$t['trans_moc'] = $dd;
						$t['trans_moc_category'] = $cati;
						// $t['trans_moc_category']=memcategoryname($request->get('customer_id'));
						$t['trans_moc_type'] = $typo;
						$t['is_active'] = 1;
						$t['receipt_id'] = $rid->id;
						$t['date'] = $request->get('date');
						$t['ent'] = $var_ent;
						$t['pos_location'] = $pos_loc;
						$t['payment_method'] = $request->get('sAccType');
						$t['unit'] =  $ccc;
						$t['account'] = transTypesCoa($pos_loc);
						$t['trans_coa'] = $d['coa_code'];


						$acc =  transactions::create([
							'type' => $var_type,
							'debit_or_credit' => 1,
							'trans_type' => $var_trans_type,
							'trans_type_id' => $request->get('id'),
							'trans_amount' => round($omega[0]),
							'trans_moc' => $dd,
							'trans_moc_category' => $cati,

							'trans_moc_type' => $typo,
							'receipt_id' => $rid->id,
							'date' => $request->get('date'),
							'ent' => $var_ent,
							'pos_location' => $pos_loc,
							'payment_method' => $request->get('sAccType'),
							'unit' => $ccc,
							'is_active' => 1,
							'account' => $var_account,
							'trans_coa' => $d['coa_code'],


						]);


						$tid =  transactions::create($t);
					} else if ((int) ($request->get('amount_received')) <= 0 && $request->get('ent') == 1) {

						$t = [];
						$t['type'] = 2;
						$t['debit_or_credit'] = 0;
						$t['trans_type'] = 5;
						$t['trans_type_id'] = $request->get('id');
						$t['trans_amount'] = 0;
						$t['trans_moc'] = $dd;
						$t['trans_moc_category'] = $cati;
						// $t['trans_moc_category']=memcategoryname($request->get('customer_id'));
						$t['trans_moc_type'] = $typo;
						$t['is_active'] = 1;
						// $t['receipt_id']=$rid->id;
						$t['date'] = $request->get('date');
						$t['ent'] = $var_ent;
						$t['pos_location'] = $pos_loc;
						$t['payment_method'] = $request->get('sAccType');
						$t['unit'] =  $ccc;
						$t['account'] = transTypesCoa($pos_loc);
						$t['trans_coa'] = $d['coa_code'];


						$acc =  transactions::create([
							'type' => $var_type,
							'debit_or_credit' => 1,
							'trans_type' => $var_trans_type,
							'trans_type_id' => $request->get('id'),
							'trans_amount' => 0,
							'trans_moc' => $dd,
							'trans_moc_category' => $cati,

							'trans_moc_type' => $typo,
							//    'receipt_id'=>$rid->id,
							'date' => $request->get('date'),
							'ent' => $var_ent,
							'pos_location' => $pos_loc,
							'payment_method' => $request->get('sAccType'),
							'unit' => $ccc,
							'is_active' => 1,
							'account' => $var_account,
							'trans_coa' => $d['coa_code'],


						]);


						$tid =  transactions::create($t);
					}

					//sending into transactions table


					//sending into trans relations

					//  && $request->get('ent')!=2
					if ((int) ($request->get('amount_received')) > 0) {

						$inv = transactions::where('type', 1)->where('debit_or_credit', 1)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->get()->pluck('id');
						if ($inv) {
							if ((int) ($request->get('amount_received')) > 0) {

								trans_relations::create([
									'receipt' => $tid->id,
									'invoice' => $inv[0],
									'account' =>  $acc->id
								]);
							}
						}
						/* else{
				if($request->get('amount_received')>0){
						trans_relations::create([
							'receipt'=>$tid->id,
							'invoice'=> 0,
						]);
					}
				}*/
				}
				//sending into trans relations
			}
			DB::commit();
			return response()->json(['status' => 'success', 'message' => 'succes']);
		} catch (\Throwable $e) {
			DB::rollback();
			return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
		}
	}

	public function updateandreceive(Request $request)
	{

		$var_type = null;
		$var_trans_type = null;
		$var_account = null;
		$var_ent = null;
		$typo = null;

		/* if($request->get('type')=='01' || $request->get('type')=='1'){
      $typo=1;
    }
    else if($request->get('type')=='02' || $request->get('type')=='2'){
      $typo=1;
    }*/
		if ($request->get('type') > 10) {
			$typo = 1;
		} else if ($request->get('type') == 1) {
			$typo = 1;
		} else if ($request->get('type') == 8) {
			$typo = 0;
		} else if ($request->get('type') == 6) {
			$typo = 6;
		} else if ($request->get('type') == 3) {
			$typo = 3;
		}
		$magi = fnb_predefined_value::first()->pluck('cost_center');
		/*if($magi[0]){
      $ccc=$magi[0];
    }
   else{
      $ccc='001-001';
    }*/
		$ccc = $request->get('company');

		$lastval = fnb_sale::withTrashed()->latest('id')->first();
		$num = 0;
		if ($lastval) {
			$num = $lastval->id + 1;
			$data['increment_number'] = $num;
		} else {
			$num = 1;
			$data['increment_number'] = $num;
		}

		$rest_loc = fnb_table_definition::where('id', $request->get('sTable'))->get()->pluck('restaurant_location');
		$restaurant_loc = $rest_loc[0];


		$d = [];



		$d = [];
		$dd = '';
		$cati = '';

		if ($typo == 0) {
			$dd = $request->get('customer_id');

			if (membership::where('id', $request->get('customer_id'))->exists()) {
				$arr_coa = membership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
				if ($arr_coa[0]) {
					$coa = $arr_coa[0];
					$d['coa_code'] = $coa;
					//    $dd=$d['coa_code'];
					$cati =  coaparent($coa);
				} else {
					$d['coa_code'] = null;

					$cati = memcategoryname($dd);
				}
			}
		} else if ($typo == 6) {
			$dd = $request->get('customer_id');

			if (corporateMembership::where('id', $request->get('customer_id'))->exists()) {
				$arr_coa = corporateMembership::where('id', $request->get('customer_id'))->get()->pluck('mem_unique_code');
				if ($arr_coa[0]) {
					$coa = $arr_coa[0];
					$d['coa_code'] = $coa;
					//    $dd=$d['coa_code'];
					$cati =  coaparent($coa);
				} else {
					$d['coa_code'] = null;

					$cati = comemcategoryname($dd);
				}
			}
		} else if ($typo == 1) {
			$dd = $request->get('customer_id');

			if (customer::where('id', $request->get('customer_id'))->exists()) {
				$arr_coa = customer::where('id', $request->get('customer_id'))->get()->pluck('account');
				if ($arr_coa[0]) {
					$coa = $arr_coa[0];
					$d['coa_code'] = $coa;
					//  $dd=$d['coa_code'];
					$cati =  coaparent($coa);
				} else {
					$d['coa_code'] = null;
					$cati =  null;
				}
			}
		} else if ($typo == 3) {

			$dd = $request->get('customer_id');


			if (hr_employment::where('id', $request->get('customer_id'))->exists()) {
				$arr_coa = hr_employment::where('id', $request->get('customer_id'))->get()->pluck('account');
				if ($arr_coa[0]) {
					$coa = $arr_coa[0];
					$d['coa_code'] = $coa;
					//  $dd=$d['coa_code'];

					$cati =  coaparent($coa);
				} else {
					$d['coa_code'] = null;
					$cati =  null;
				}
			}
		}


		// $d['invoice_no']= $data['increment_number'];



		//  $d['date']=$request->get('date');
		$d['time'] = $request->get('time');
		$d['unit'] = $ccc;
		$d['table_definition'] = $request->get('sTable');
		$d['restaurant_location'] = $restaurant_loc;
		$d['waiter_definition'] = $request->get('sWaiter');
		$d['order_type'] = $request->get('sType');

		$d['type'] = $typo;
		$d['name'] = $request->get('customer');
		$d['customer_id'] = $request->get('customer_id');

		if ($typo == 0 || $typo == 6) {
			$d['family'] = $request->get('family');
		}

		$d['ledger_amount'] = $request->get('ledger_amount');

		$d['covers'] = $request->get('covers');

		$d['discount_card_no'] = $request->get('discountcard');
		$d['disc'] = $request->get('disc');
		$d['disc_pc'] = $request->get('disc_pc');

		$d['category'] = $request->get('sCategory');
		$d['sub_category'] = $request->get('sSubCat');

		$d['gross'] = $request->get('gross');
		$d['discount'] = $request->get('discount');
		$d['sub_total'] = $request->get('subtotal');
		$d['tax'] = $request->get('tax');
		$d['service_charges'] = $request->get('service');
		$d['service_charges_pct'] = $request->get('service_pct');
		$d['grand_total'] = $request->get('grandtotal');

		$d['coa_trans_type'] = $request->get('account');
		$d['account_head'] = $request->get('sAccHead');
		$d['account_type'] = $request->get('sAccType');
		$d['remarks'] = $request->get('remarks');
		$d['completed'] = 2;
		$d['amount_received'] = $request->get('amount_received');
		$d['ent'] = $request->get('ent');
		$d['ent_detail'] = $request->get('ent_detail');

		$id =  fnb_sale::where('id', $request->get('id'))->updateWithUserstamps($d);
		//      dd();

		$omega = fnb_sale::where('id', $request->get('id'))->get()->pluck('grand_total');

		if ($request->get('ent') == 1) {
			$d = transactions::where('type', '1')->where('debit_or_credit', '1')->where('trans_type_id', $request->get('id'))->where('trans_type', 5)->first();
			if ($d) {
				$d->ent = 1;

				$d->save();
			}
		} else if ($request->get('ent') == 2) {
			$d = transactions::where('type', '1')->where('debit_or_credit', '1')->where('trans_type_id', $request->get('id'))->where('trans_type', 5)->first();
			if ($d) {
				$d->ent = 2;

				$d->save();
			}
		} else {
			$d = transactions::where('type', '1')->where('debit_or_credit', '1')->where('trans_type_id', $request->get('id'))->where('trans_type', 5)->first();
			if ($d) {
				$d->ent = 0;

				$d->save();
			}
		}

		$pos = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
		if ($pos) {
			$pos_loc = $pos->pos_location;
		} else {
			$pos_loc = null;
		}

		//sending into transactions table

		$t = [];



		$t['type'] = 1;
		$t['debit_or_credit'] = 1;
		$t['trans_type'] = 5;
		$t['trans_type_id'] = $request->get('id');
		$t['trans_amount'] = $request->get('grandtotal');
		$t['trans_moc'] = $dd;
		$t['trans_moc_category'] = $cati;
		// $t['trans_moc_category']=memcategoryname($request->get('customer_id'));
		$t['trans_moc_type'] = $typo;
		$t['is_active'] = 1;

		$t['date'] = $request->get('date');

		$t['unit'] = $ccc;
		$t['account'] = transTypesCoa($pos_loc);
		$t['trans_coa'] = $d['coa_code'];





		if (transactions::where('type', 1)->where('debit_or_credit', 1)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->exists()) {
			$tid = transactions::where('type', 1)->where('debit_or_credit', 1)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->updateWithUserstamps($t);
		} else {
			$tid =  transactions::create([
				'type' => 1,
				'debit_or_credit' => 1,
				'trans_type' => 5,
				'trans_type_id' => $request->get('id'),
				'trans_amount' => $request->get('grandtotal'),
				'trans_moc' => $dd,
				'trans_moc_type' => $typo,
				'trans_moc_category' => $cati,
				'is_active' => 1,
				'date' => $request->get('date'),
				'pos_location' => $pos_loc,
				'unit' => $ccc,
				'trans_coa' => $d['coa_code'],
				'account' => transTypesCoa($pos_loc),



			]);
		}

		//sending into transactions table


		foreach ($request->get('selected_items') as $inv) {
			//            dd($inv);
			if (!isset($inv['kot_no']) || $inv['kot_no'] == null) {

				$m =  fnb_sales_subs::create([
					'sales_id' => $request->get('id'),

					'item_code' => $inv['item_code'],
					'item_details' => $inv['item_details'],
					'sale_price' => $inv['sale_price'],
					'sub_total_price' => $inv['product'],
					'instruction' => $inv['instruction'],
					'remark' => $inv['remark'],
					'aftercancel' => $inv['aftercancel'],
					'kot_no' => $inv['kot'],
					'total' => $inv['totalamt'],
					'qty' => $inv['qty'],
					'item_discount' => $inv['item_discount'],
					'status' => $inv['status'],
					'subcategory' => $inv['subcategory'],
					//          'date'=>$request->get('date'),
					'saved' => 1,

				]);
			} else {
				$m = fnb_sales_subs::where('id', $inv['id'])->updateWithUserstamps([
					'sales_id' => $request->get('id'),
					'item_code' => $inv['item_code'],
					'item_details' => $inv['item_details'],
					'sale_price' => $inv['sale_price'],
					'sub_total_price' => $inv['product'],
					'instruction' => $inv['instruction'],
					'remark' => $inv['remark'],
					'aftercancel' => $inv['aftercancel'],
					'kot_no' => $inv['kot'],
					'total' => $inv['totalamt'],
					'qty' => $inv['qty'],
					'item_discount' => $inv['item_discount'],
					'status' => $inv['status'],
					'subcategory' => $inv['subcategory'],
					//       'date'=>$request->get('date'),
					'saved' => 1,
				]);
			}
		}

		/*$lastcashreceipt=finance_cash_receipt::withTrashed()->latest('id')->first();
      $numtwo=0;
      if($lastcashreceipt){
        $numtwo=$lastcashreceipt->id+1;
        $cashrec['increment_number']=$numtwo;

      }else{
        $numtwo=1;
        $cashrec['increment_number']=$numtwo;
      }*/


		//->whereNotIn('ent',[1,2])
		//->where('ent','!=',2)



		$r = [];

		if ($request->get('advance') == 1) {
			$r['advance'] = $request->get('advance');
			$request->sAccType = 20;
			$var_type = 7;
			$var_trans_type = 26;
			$var_account = transTypesCoa(26);
			$var_ent = 5;
		} else if ($request->get('lediscount') == 1) {
			$r['discount'] = $request->get('lediscount');
			$request->sAccType = 20;
			$var_type = 7;
			$var_trans_type = 28;
			$var_account = transTypesCoa(28);
			$var_ent = 3;
		} else {
			$var_type = 3;
			$var_trans_type = 5;
			$var_account = $request->get('account');
			$var_ent = $request->get('ent');
		}



		if (transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->exists()) {
			$pegi = transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->get()->pluck('receipt_id');
		} else {
			$pegi = null;
		}

		//&& $request->get('ent')!=2
		if ($pegi) {
			$thepreviousrec = $pegi[0];


			//   $r=[];

			if ($typo == 0) {
				$r['mem_number'] = $dd;
			} else if ($typo == 1) {
				$r['customer_id'] = $dd;
			} else if ($typo == 6) {
				$r['corporate_id'] = $dd;
			} else if ($typo == 3) {
				$r['employee_id'] = $dd;
			}

			$r['coa_code'] = $d['coa_code'];
			$r['invoice_no'] = $thepreviousrec;
			$r['invoice_date'] = $request->get('date');
			$r['receipt_type'] = $typo;
			$r['family'] = $request->get('family');
			$r['total_amount'] = $request->get('cash_receipt_amt');
			$r['total'] = $request->get('cash_receipt_amt');
			$r['account'] = $request->get('sAccType');
			$r['remarks'] = $request->get('remarks');
			$r['amount_in_words'] = $request->get('amount_in_words');


			$rid =  finance_cash_receipt::where('id', $thepreviousrec)->updateWithUserstamps($r);
		}
		// && $request->get('ent')!=2
		else {



			$cashi = finance_cash_receipt::withTrashed()->latest('id')->first();

			$cn     = 0;

			if ($cashi) {
				$cn                      = $cashi->id + 1;
				$thepreviousrec = $cn;
			} else {
				$cn                      = 1;
				$thepreviousrec = $cn;
			}

			// $r=[];

			$moc = 0;
			if ($typo == 0) {
				$moc = 0;
			} else if ($typo == 6) {
				$moc = 6;
			} else if ($typo == 1) {
				$moc = 1;
			} else if ($typo == 3) {
				$moc = 3;
			}



			if ($typo == 0) {
				$r['mem_number'] = $dd;
			} else if ($typo == 1) {
				$r['customer_id'] = $dd;
			} else if ($typo == 6) {
				$r['corporate_id'] = $dd;
			} else if ($typo == 3) {
				$r['employee_id'] = $dd;
			}

			$r['coa_code'] = $d['coa_code'];
			$r['invoice_no'] = $thepreviousrec;
			$r['invoice_date'] = $request->get('date');
			$r['receipt_type'] = $moc;
			$r['family'] = $request->get('family');
			$r['total_amount'] = $request->get('cash_receipt_amt');
			$r['total'] = $request->get('cash_receipt_amt');
			$r['account'] = $request->get('sAccType');
			$r['remarks'] = $request->get('remarks');
			$r['amount_in_words'] = $request->get('amount_in_words');

			if(finance_cash_receipt::where('id', $thepreviousrec)->exists()){
				$rid = finance_cash_receipt::where('id', $thepreviousrec)->updateWithUserstamps($r);	
			}else{
				$rid = finance_cash_receipt::create($r);
			}
		}
		/*if(transactions::where('debit_or_credit',0)->where('trans_type',5)->where('trans_type_id',$request->get('id'))->where('trans_amount',$request->get('amount_received')+$request->get('return_value'))->count() == 0)
 {*/
		//sending into cash receipts table
		/* if($request->get('amount_received')>0){*/

		/* }*/

		//sending into cash receipts table


		//sending into transactions table
		/* if($request->get('amount_received')>0){*/


		//&& $request->get('ent')!=2
		if (transactions::where('type', $var_type)->where('debit_or_credit', 1)->where('trans_type', $var_trans_type)->where('trans_type_id', $request->get('id'))->exists() && $request->get('ent') != 1) {
			$acc =  transactions::where('type', $var_type)->where('debit_or_credit', 1)->where('trans_type', $var_trans_type)->where('trans_type_id', $request->get('id'))->updateWithUserstamps([
				'type' => $var_type,
				'debit_or_credit' => 1,
				'trans_type' => $var_trans_type,
				'trans_type_id' => $request->get('id'),
				'trans_amount' => $request->get('cash_receipt_amt'),
				'trans_moc' => $request->get('customer_id'),
				'trans_moc_category' => $cati,
				'trans_moc_type' => $typo,
				'receipt_id' => $thepreviousrec,
				'date' => $request->get('date'),
				'ent' => $var_ent,
				'is_active' => 1,
				'payment_method' => $request->get('sAccType'),
				'unit' => $ccc,

				'account' => $var_account,
				'trans_coa' => $r['coa_code'],

			]);
		} else if (!transactions::where('type', $var_type)->where('debit_or_credit', 1)->where('trans_type', $var_trans_type)->where('trans_type_id', $request->get('id'))->exists() && $request->get('ent') != 1) {

			$acc =  transactions::create([
				'type' => $var_type,
				'debit_or_credit' => 1,
				'trans_type' => $var_trans_type,
				'trans_type_id' => $request->get('id'),
				'trans_amount' => $request->get('cash_receipt_amt'),
				'trans_moc' => $request->get('customer_id'),
				'trans_moc_category' => $cati,
				'trans_moc_type' => $typo,
				'receipt_id' => $thepreviousrec,
				'date' => $request->get('date'),
				'ent' => $var_ent,
				'is_active' => 1,
				'payment_method' => $request->get('sAccType'),
				'unit' => $ccc,

				'account' => $var_account,
				'trans_coa' => $r['coa_code'],
				'pos_location' => $pos_loc,

			]);
		}




		//&& $request->get('ent')!=2
		else if (transactions::where('type', $var_type)->where('debit_or_credit', 1)->where('trans_type', $var_trans_type)->where('trans_type_id', $request->get('id'))->exists() && $request->get('ent') == 1) {

			$acc =  transactions::where('type', $var_type)->where('debit_or_credit', 1)->where('trans_type', $var_trans_type)->where('trans_type_id', $request->get('id'))->updateWithUserstamps([
				'type' => $var_type,
				'debit_or_credit' => 1,
				'trans_type' => $var_trans_type,
				'trans_type_id' => $request->get('id'),
				'trans_amount' => round($omega[0]),
				'trans_moc' => $request->get('customer_id'),
				'trans_moc_category' => $cati,
				'trans_moc_type' => $typo,
				'receipt_id' => $thepreviousrec,
				'date' => $request->get('date'),
				'ent' => $var_ent,
				'is_active' => 1,
				'payment_method' => $request->get('sAccType'),
				'unit' => $ccc,

				'account' => $var_account,
				'trans_coa' => $r['coa_code'],

			]);
		} else if (!transactions::where('type', $var_type)->where('debit_or_credit', 1)->where('trans_type', $var_trans_type)->where('trans_type_id', $request->get('id'))->exists() && $request->get('ent') == 1) {

			$acc =  transactions::create([
				'type' => $var_type,
				'debit_or_credit' => 1,
				'trans_type' => $var_trans_type,
				'trans_type_id' => $request->get('id'),
				'trans_amount' => round($omega[0]),
				'trans_moc' => $request->get('customer_id'),
				'trans_moc_category' => $cati,
				'trans_moc_type' => $typo,
				'receipt_id' => $thepreviousrec,
				'date' => $request->get('date'),
				'ent' => $var_ent,
				'is_active' => 1,
				'payment_method' => $request->get('sAccType'),
				'unit' => $ccc,

				'account' => $var_account,
				'trans_coa' => $r['coa_code'],
				'pos_location' => $pos_loc,

			]);
		}






		//&& $request->get('ent')!=2
		if (transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->exists() && ($request->get('ent') != 1)) {

			$tt = [];

			$tt['type'] = 2;
			$tt['debit_or_credit'] = 0;
			$tt['trans_type'] = 5;
			$tt['trans_type_id'] = $request->get('id');
			$tt['trans_amount'] = $request->get('cash_receipt_amt');
			$tt['trans_moc'] = $request->get('customer_id');
			$tt['trans_moc_category'] = $cati;
			//    $tt['trans_moc_category']=memcategoryname($request->get('customer_id'));
			$tt['trans_moc_type'] = $typo;
			$tt['is_active'] = 1;
			$tt['receipt_id'] = $thepreviousrec;
			$tt['date'] = $request->get('date');
			$tt['ent'] = $var_ent;
			$tt['payment_method'] = $request->get('sAccType');
			$tt['unit'] = $ccc;
			//$tt['account']= transTypesCoa($pos_loc);
			$tt['trans_coa'] = $r['coa_code'];

			$tidd = transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->updateWithUserstamps($tt);
			//&& $request->get('ent')!=2
		} else if (!transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->exists() && ($request->get('ent') != 1)) {

			$tidd =  transactions::create([
				'type' => 2,
				'debit_or_credit' => 0,
				'trans_type' => 5,
				'trans_type_id' => $request->get('id'),
				'trans_amount' => $request->get('cash_receipt_amt'),
				'trans_moc' => $request->get('customer_id'),
				'trans_moc_category' => $cati,
				'trans_moc_type' => $typo,
				'receipt_id' => $thepreviousrec,
				'date' => $request->get('date'),
				'ent' => $var_ent,
				'payment_method' => $request->get('sAccType'),
				'unit' => $ccc,
				'is_active' => 1,
				'account' =>  transTypesCoa($pos_loc),
				'trans_coa' => $r['coa_code'],
				'pos_location' => $pos_loc,
			]);
		} else if (transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->exists() && ($request->get('ent') == 1)) {

			$tt = [];

			$tt['type'] = 2;
			$tt['debit_or_credit'] = 0;
			$tt['trans_type'] = 5;
			$tt['trans_type_id'] = $request->get('id');
			$tt['trans_amount'] = round($omega[0]);
			$tt['trans_moc'] = $request->get('customer_id');
			$tt['trans_moc_category'] = $cati;
			//    $tt['trans_moc_category']=memcategoryname($request->get('customer_id'));
			$tt['trans_moc_type'] = $typo;
			$tt['is_active'] = 1;
			$tt['receipt_id'] = $thepreviousrec;
			$tt['date'] = $request->get('date');
			$tt['ent'] = $var_ent;
			$tt['payment_method'] = $request->get('sAccType');
			$tt['unit'] = $ccc;
			//$tt['account']= transTypesCoa($pos_loc);
			$tt['trans_coa'] = $r['coa_code'];

			$tidd = transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->updateWithUserstamps($tt);
			//&& $request->get('ent')!=2
		} else if (!transactions::where('type', 2)->where('debit_or_credit', 0)->where('trans_type', 5)->where('trans_type_id', $request->get('id'))->exists() && ($request->get('ent') == 1)) {

			$tidd =  transactions::create([
				'type' => 2,
				'debit_or_credit' => 0,
				'trans_type' => 5,
				'trans_type_id' => $request->get('id'),
				'trans_amount' => round($omega[0]),
				'trans_moc' => $request->get('customer_id'),
				'trans_moc_category' => $cati,
				'trans_moc_type' => $typo,
				'receipt_id' => $thepreviousrec,
				'date' => $request->get('date'),
				'ent' => $var_ent,
				'payment_method' => $request->get('sAccType'),
				'unit' => $ccc,
				'is_active' => 1,
				'account' =>  transTypesCoa($pos_loc),
				'trans_coa' => $r['coa_code'],
				'pos_location' => $pos_loc,
			]);
		}


		/*  }*/

		//sending into transactions table

		//sending into trans relations

		/*   if($request->get('amount_received')>0){*/
		/* if(transactions::where('type',2)->where('debit_or_credit',0)->where('trans_type',5)->where('trans_type_id',$request->get('id'))->exists()){
$rec=transactions::where('type',2)->where('debit_or_credit',0)->where('trans_type',5)->where('trans_type_id',$request->get('id'))->get()->pluck('id');
    }
    else{
      $rec=[];
    }


    if(transactions::where('type',1)->where('debit_or_credit',1)->where('trans_type',5)->where('trans_type_id',$request->get('id'))->exists()){
      $inv=transactions::where('type',1)->where('debit_or_credit',1)->where('trans_type',5)->where('trans_type_id',$request->get('id'))->get()->pluck('id');
    }else{
      $inv= [];
    }

    if(transactions::where('type',3)->where('debit_or_credit',1)->where('trans_type',5)->where('trans_type_id',$request->get('sAccType'))->exists()){
      $accid=transactions::where('type',3)->where('debit_or_credit',1)->where('trans_type',5)->where('trans_type_id',$request->get('sAccType'))->where('receipt_id',$thepreviousrec)->get()->pluck('id');
    }
     else{
      $accid=[];
     }
*/

		/*    if($inv && $rec && $accid && trans_relations::where('receipt',$rec[0])->where('invoice',$inv[0])->where('account',$accid[0])->exists()){

if($inv && $rec &&  $accid){
      trans_relations::where('receipt',$rec[0])->where('invoice',$inv[0])->updateWithUserstamps([
                'receipt'=>$rec[0],
                'invoice'=> $inv[0],
                'account' =>  $accid[0]
            ]);
}
}
else{

if($inv && $rec &&  $accid){
     trans_relations::create([
               'receipt'=>$rec[0],
                'invoice'=> $inv[0],
                'account' =>  $accid[0]
        ]);
   }
}*/


		/* }*/
		//sending into trans relations


		/*}*/
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\fnb_sale  $fnb_sale
	 * @return \Illuminate\Http\Response
	 */
	public function show(fnb_sale $fnb_sale)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\fnb_sale  $fnb_sale
	 * @return \Illuminate\Http\Response
	 */

	public function booked(fnb_sale $fnb_sale, $id)
	{
		$data = fnb_sale::where('table_definition', $id)->where('completed', 0)->pluck('id');

		return $data;
	}

	public function printed(fnb_sale $fnb_sale, $id)
	{
		$data = fnb_sale::where('table_definition', $id)->where('completed', 1)->pluck('id');

		return $data;
	}

	public function edit(fnb_sale $fnb_sale, $id)
	{
		$data['id'] = $id;
		$data['datatableid'] = $id;
		$data['init'] = 0;
		return view('backend/food-and-beverage.sales.sales-aeu', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\fnb_sale  $fnb_sale
	 * @return \Illuminate\Http\Response
	 */

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\fnb_sale  $fnb_sale
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, fnb_sale $fnb_sale, $id)
	{
		$update = fnb_sale::where('id', $id)->updateWithUserstamps([
			'delete_comments' => $request->remarks,
		]);

		$delete = $fnb_sale::where('id', $id)->deleteWithUserstamps();
		$transaction = transactions::where('debit_or_credit', 1)->where('trans_type', 5)->where('trans_type_id', $id)->deleteWithUserstamps();
	}
	/* public function destroy(fnb_sale $fnb_sale,$id)
    {
        $destroy=$fnb_sale::where('id', $id)->deleteWithUserstamps();
        $transaction = transactions::where('debit_or_credit',1)->where('trans_type', 5)->where('trans_type_id', $id)->deleteWithUserstamps();

        if($destroy){
            Session::flash('message', 'Data deleted Successfully !');
            Session::flash('alert-class', 'alert-success');
         }

         else{

            Session::flash('message', 'Data Not Deleted !');
            Session::flash('alert-class', 'alert-danger');

         }


        return redirect('food-and-beverage/sales-vue');
    }*/

	public function restore(fnb_sale $fnb_sale, $id)
	{
		$restore = fnb_sale::onlyTrashed()->find($id)->restore();
		$transaction = transactions::onlyTrashed()->where('trans_type_id', $id)->where('trans_type', 5)->where('debit_or_credit', 1)->restore();

		if ($restore) {
			Session::flash('message', 'Data restored Successfully !');
			Session::flash('alert-class', 'alert-success');
		} else {

			Session::flash('message', 'Failed to restore data !');
			Session::flash('alert-class', 'alert-danger');
		}
		return redirect('food-and-beverage/sales/deleted');
	}

	public function invoice(fnb_sale $fnb_sale, $id)
	{
		$data['saledata'] = fnb_sale::where('id', $id)->first();
		
		// $data['taxandservice'] = fnb_predefined_value::get()->first();
		// $data['mains'] = fnb_item_category::where('status', 1)->get();
		// $data['subcats'] = fnb_item_sub_category::where('status', 1)->get();
		// $data['itemdefs'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();
		// $data['waiters'] = fnb_waitor_definition::where('status', 1)->get();
		// $data['tables'] = fnb_table_definition::where('status', 1)->get();
		// $data['restaurants'] = fnb_restaurant_location::where('status', 1)->get();
		$data['currencies'] = fnb_predefined_value::first();
		// $data['discountables'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get()->first();
		// $data['accheads'] = finance_account_head::where('status', 1)->get();
		// /*$data['acctypes']=finance_account_type::where('status',1)->get();*/
		// $data['acctypes'] = trans_type::where('cash_or_payment', 2)->where('type', 7)->get();

		$data['salesub'] = fnb_sale::with(['salesubs' => function ($query) {
			$query->selectRaw('sales_id,sum(qty) as qty,sum(sub_total_price) as sub_total_price,sale_price,item_details')->where('status', NULL)->groupBy('item_code');
		}])->where('id', $id)->get();
		// dd($data['salesub'][0]->toArray());
		$data['salesubdata'] = $data['salesub'][0]['salesubs'];
		$data['defaultprinter'] = fnb_predefined_value::get()->pluck('printer');
		$data['defaultprintqty'] = fnb_predefined_value::get()->pluck('print_limit');

		$data['profiledata'] = admin_company_profile::where('cost_center', $data['saledata']->unit)->first();
		
		if(TempAppliedMemberName::where('sale_id', $id)->exists()){
			$data['temp_name'] = TempAppliedMemberName::where('sale_id', $id)->pluck('person_name');
		}else{
			$data['temp_name'] = [];
		}
		$data['kots'] = fnb_sales_subs::where('sales_id', $id)->groupBy('kot_no')->get()->pluck('kot_no');

		return view('backend/food-and-beverage.sales.sales-invoice', $data);
	}


	public function invoicep(fnb_sale $fnb_sale, $id, Request $request)
	{
		/*   auth()->loginUsingId('2');*/
		if ($request->get('ttoken')) {
			auth()->loginUsingId($request->get('ttoken'));
		}
		$data['saledata'] = fnb_sale::where('id', $id)->first();

		// $data['taxandservice'] = fnb_predefined_value::get()->first();
		// $data['mains'] = fnb_item_category::where('status', 1)->get();
		// $data['subcats'] = fnb_item_sub_category::where('status', 1)->get();
		// $data['itemdefs'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();
		// $data['waiters'] = fnb_waitor_definition::where('status', 1)->get();
		// $data['tables'] = fnb_table_definition::where('status', 1)->get();
		// $data['restaurants'] = fnb_restaurant_location::where('status', 1)->get();
		$data['currencies'] = fnb_predefined_value::first();
		// $data['discountables'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get()->first();
		// $data['accheads'] = finance_account_head::where('status', 1)->get();
		/*        $data['acctypes']=finance_account_type::where('status',1)->get();*/
		// $data['acctypes'] = trans_type::where('cash_or_payment', 2)->where('type', 7)->get();

		$data['salesub'] = fnb_sale::with(['salesubs' => function ($query) {
			$query->selectRaw('sales_id,sum(qty) as qty,sum(sub_total_price) as sub_total_price,sale_price,item_details')->where('status', NULL)->groupBy('item_code');
		}])->where('id', $id)->get();
		// dd($data['salesub'][0]->toArray());
		if (isset($data['salesub'][0])) {

			$data['salesubdata'] = $data['salesub'][0]['salesubs'];
		} else {

			$data['salesubdata'] = [];
		}

		$data['defaultprinter'] = fnb_predefined_value::get()->first()->pluck('printer');
		$data['defaultprintqty'] = fnb_predefined_value::get()->first()->pluck('print_limit');

		$data['profiledata'] = admin_company_profile::get()->first();
		if(TempAppliedMemberName::where('sale_id', $id)->exists()){
			$data['temp_name'] = TempAppliedMemberName::where('sale_id', $id)->pluck('person_name');
		}else{
			$data['temp_name'] = [];
		}
		$data['kots'] = fnb_sales_subs::where('sales_id', $id)->groupBy('kot_no')->get()->pluck('kot_no');

		return view('backend/food-and-beverage.sales.sales-invoice', $data);
	}


	public function openkots(fnb_sale $fnb_sale, $id)
	{

		$data['running'] = 1;
		$data['kots'] = fnb_sales_subs::where('sales_id', $id)->groupBy('kot_no')->get();
		//->pluck('kot_no')
		$data['invoice'] = $id;

		return view('backend/food-and-beverage.sales.kots', $data);
	}


	public function runningopenkots(fnb_sale $fnb_sale, $id)
	{

		$data['running'] = 0;
		$data['kots'] = fnb_sales_subs::where('sales_id', $id)->groupBy('kot_no')->get();
		//->pluck('kot_no')
		$data['invoice'] = $id;

		return view('backend/food-and-beverage.sales.kots', $data);
	}


	public function kot(fnb_sale $fnb_sale, $id)
	{
		$data['saledata'] = fnb_sale::where('id', $id)->first();

		$lastval['itemdefs'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();
		$lastval['waiters'] = fnb_waitor_definition::where('status', 1)->get();
		$lastval['tables'] = fnb_table_definition::where('status', 1)->get();
		$lastval['restaurants'] = fnb_restaurant_location::where('status', 1)->get();
		$lastval['discountables'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get()->first();

		$data['salesub'] = fnb_sale::with('salesubs')->where('id', $id)->get();
		$data['salesubdata'] = $data['salesub'][0]['salesubs'];
		$data['running'] = 0;
		$data['duplicate'] = 0;

		return view('backend/food-and-beverage.sales.sales-kot', $data);
	}

	public function kotp(fnb_sale $fnb_sale, $invoiceno, $id, $cat, Request $request)
	{
		file_put_contents(base_path() . '/public/kot.log', $request->fullUrl() . '\n', FILE_APPEND | LOCK_EX);

		auth()->loginUsingId('2');
		

 		// $data['saledata'] = fnb_sale::where('id', $invoiceno)->first();

		 //This code is to Keep same the id and Invoice_no.
		$saledata  = fnb_sale::where('id', $invoiceno)->first();
		if(empty($saledata)){
			$fnb_data = fnb_sale::where('invoice_no', $invoiceno)->first();
			if(!empty($fnb_data)){
				fnb_sale::where('invoice_no', $invoiceno)->update([
					'invoice_no' => $fnb_data->id
				]);
				$saledata = fnb_sale::where('id', $fnb_data->id)->first();
				$invoiceno = $saledata->id;
			}
		}
		$data['saledata'] = $saledata;
		$data['cat'] = $cat;
		$data['itemCat'] = fnb_item_definition::where('category', $cat)->where('status', 1)->where('salable', 1)->get()->pluck('item_code')->toArray();
		//  dd($data);
		//        $data['saledata']=fnb_sale::where('id',$id)->first();

		$data['salesub'] = fnb_sales_subs::where('kot_no', $id)->where('sales_id', $invoiceno)->get();

		// dd($data['saledata']->toArray());
		$data['salesubdata'] = $data['salesub'];
		$data['running'] = 0;
		$data['duplicate'] = 0;


		if (!$data['salesub'] || $data['salesub'] == null || $data['saledata'] == null || empty($data['salesub']->toArray())) {
			return abort(404);
		}
		if (!fnb_sales_subs::where('kot_no', $id)->exists()) {
			return abort(404);
		}
		kotrec::create(['order' => $invoiceno, 'category' => $cat, 'kot_id' => $id, 'user' => $data['saledata']->created_by]);
		return view('backend/food-and-beverage.sales.sales-kot', $data);
	}

	public function edittedsaleskot(fnb_sale $fnb_sale, $invoiceno, $id, $cat, Request $request)
	{

		file_put_contents(base_path() . '/public/kot.log', $request->fullUrl() . '\n', FILE_APPEND | LOCK_EX);

		auth()->loginUsingId('2');
		$data['cat'] = $cat;
		$data['itemCat'] = fnb_item_definition::where('category', $cat)->where('status', 1)->where('salable', 1)->get()->pluck('item_code')->toArray();
		//  dd($data);
		//        $data['saledata']=fnb_sale::where('id',$id)->first();
		$data['salesub'] = fnb_sales_subs::where('kot_no', $id)->where('sales_id', $invoiceno)->get();

		$data['saledata'] = fnb_sale::where('id', $invoiceno)->first();
		// dd($data['saledata']->toArray());
		$data['salesubdata'] = $data['salesub'];
		$data['running'] = 1;
		$data['duplicate'] = 0;

		kotrec::create(['order' => $invoiceno, 'category' => $cat, 'kot_id' => $id, 'user' => $data['saledata']->created_by]);
		return view('backend/food-and-beverage.sales.sales-kot', $data);
	}


	public function xpedittedsaleskot(fnb_sale $fnb_sale, $invoiceno, $id, $cat, Request $request)
	{

		file_put_contents(base_path() . '/public/kot.log', $request->fullUrl() . '\n', FILE_APPEND | LOCK_EX);

		auth()->loginUsingId('2');
		$data['cat'] = $cat;
		$data['itemCat'] = fnb_item_definition::where('category', $cat)->where('status', 1)->where('salable', 1)->get()->pluck('item_code')->toArray();
		//  dd($data);
		//        $data['saledata']=fnb_sale::where('id',$id)->first();
		$data['salesub'] = fnb_sales_subs::where('kot_no', $id)->where('sales_id', $invoiceno)->get();

		$data['saledata'] = fnb_sale::where('id', $invoiceno)->first();
		// dd($data['saledata']->toArray());
		$data['salesubdata'] = $data['salesub'];
		$data['running'] = 1;
		$data['duplicate'] = 0;

		kotrec::create(['order' => $invoiceno, 'category' => $cat, 'kot_id' => $id, 'user' => $data['saledata']->created_by, 'xprider' => 1]);
		return view('backend/food-and-beverage.sales.sales-kot', $data);
	}


	public function duplicatesaleskot(fnb_sale $fnb_sale, $invoiceno, $kot)
	{

		$data['salesub'] = fnb_sales_subs::where('kot_no', $kot)->where('sales_id', $invoiceno)->get();

		$data['saledata'] = fnb_sale::where('id', $invoiceno)->first();
		// dd($data['saledata']->toArray());
		$data['salesubdata'] = $data['salesub'];
		$data['running'] = 1;
		$data['duplicate'] = 1;

		return view('backend/food-and-beverage.sales.sales-duplicate-kot', $data);
	}


	public function xpduplicatesaleskot(fnb_sale $fnb_sale, $invoiceno)
	{

		auth()->loginUsingId('2');


		//This code is to Keep same the id and Invoice_no.
		$saledata  = fnb_sale::where('id', $invoiceno)->first();
		if(empty($saledata)){
			$fnb_data = fnb_sale::where('invoice_no', $invoiceno)->first();
			if(!empty($fnb_data)){
				fnb_sale::where('invoice_no', $invoiceno)->update([
					'invoice_no' => $fnb_data->id
				]);
				$saledata = fnb_sale::where('id', $fnb_data->id)->first();
				$invoiceno = $saledata->id;
			}
		}
		$data['saledata'] = $saledata;
		$data['salesub'] = fnb_sales_subs::where('sales_id', $invoiceno)->get();

		// dd($data['saledata']->toArray());
		$data['salesubdata'] = $data['salesub'];
		$data['running'] = 0;
		$data['duplicate'] = 1;
		kotrec::create(['order' => $invoiceno, 'category' => 0, 'kot_id' => $data['salesubdata'][0]->kot_no, 'user' => $data['saledata']->created_by, 'xprider' => 1]);
		return view('backend/food-and-beverage.sales.sales-duplicate-kot', $data);
	}


	function tables($id)
	{
		if ($id != 0) {
			$tables = fnb_table_definition::where('restaurant_location', $id)->orderBy('id')->get();
		} else {
			$tables = fnb_table_definition::orderBy('id')->get();
		}
		return $tables;
	}


	function waiters($id)
	{
		if ($id != 0) {
			/*  $waiters=fnb_waitor_definition::where('restaurant_location',$id)->orWhere('second_restaurant_location',$id)->orWhere('third_restaurant_location',$id)->orderBy('id')->get();*/

			$waiters = fnb_waitor_definition::where('status', 1)->where(function ($query) use ($id) {
				$query->orWhere('restaurant_location', $id)->orWhere('second_restaurant_location', $id)->orWhere('third_restaurant_location', $id);
			})->orderBy('id')->get();
		} else {
			$waiters = fnb_waitor_definition::where('status', 1)->orderBy('id')->get();
		}
		return $waiters;
	}


	function subcategory($id)
	{
		if ($id != 0) {
			$subcategory = fnb_item_sub_category::where('item_category', $id)->orderBy('desc')->where('status', 1)->get();
		} else {
			$subcategory = fnb_item_sub_category::orderBy('desc')->where('status', 1)->get();
		}
		return $subcategory;
	}

	function itemselect($id)
	{
		if ($id != 0) {
			$item = fnb_item_definition::where('sub_category', $id)->orderBy('item_details')->get();
		} else {
			$item = fnb_item_definition::orderBy('item_details')->get();
		}
		return $item;
	}

	function restaurants($id)
	{
		if ($id != 0) {
			$restaurant = fnb_table_definition::where('id', $id)->pluck('restaurant_location');
			return $restaurant;
		} else {
			return 0;
		}
	}

	function accounttypes($id)
	{
		if ($id != 0) {
			$acc_type = finance_account_type::where('desc', $id)->get();
		} else {
			$acc_type = finance_account_type::get();
		}
		return $acc_type;
	}

	function items($id)
	{
		$items = fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('sub_category', $id)->where('status', 1)->where('salable', 1)->orderBy('item_details')->get();
		return $items;
	}


	function gettheitems($id)
	{
		$items = fnb_item_definition::where('item_code', $id)->where('status', 1)->where('salable', 1)->select('discountable', 'discount_amount', 'discount_percentage')->get();
		return $items;
	}


	function searcheditems()
	{
		$items = fnb_item_definition::selectRaw('*,1 as qty,null as status,null as instruction,null as remark,null as aftercancel,null as kot, 0 as item_discount, 0 as totalamt')->where('status', 1)->where('salable', 1)->get();
		return $items;
	}

	// REPORTS

	public function closingsales_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/closing-sales-report/closing-sales-report-vue');
	}

	public function closingsales_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {

			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->order_type) {
			$search .= " and fnb_sales.order_type in ('" . str_replace(",", "','", $request->order_type) . "') ";
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales.discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				' select group_concat(s.bbbb), sum(s.grosssale) as grosssale,
       sum(s.diss) as diss,
       sum(s.netsale) as  netsale,
       sum(s.taxx) as  taxx,
       sum(s.netcovers) as netcovers,
       sum(s.grandd) as  grandd,
       sum(if(s.account_type = 22,s.grandd,0)) as cashgross,
       sum(if(s.account_type = 24,s.grandd,0)) as creditgross,
       sum(if(s.account_type not in (22,24),s.grandd,0)) as othergross,

  
    sum(if(s.ent=1 and s.ent_detail=1,s.grandd,0)) as grandentone,
     sum(if(s.ent=1 and s.ent_detail=2,s.grandd,0)) as grandenttwo,
 sum(if(s.ent=1 and s.ent_detail=3,s.grandd,0)) as grandentthree,
  sum(if(s.ent=1 and s.ent_detail=4,s.grandd,0)) as grandentfour,
  sum(if(s.ent=1 and s.ent_detail=5,s.grandd,0)) as grandentfive,

       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as cat,
       fnb_table_definitions.desc    as tables,
       fnb_waitor_definitions.name    as waitor,

       sum(s.paid_amount ) as paid_amount

       from (select
        group_concat(fnb_sales.id) as bbbb,
       ((fnb_sales.gross))                     as grosssale,
       ((fnb_sales.discount))                as diss,
       ((fnb_sales.sub_total))               as netsale,
       ((fnb_sales.tax))                  as taxx,
       ((fnb_sales.covers))                 as netcovers,
       ((fnb_sales.grand_total))                 as grandd,
        fnb_sales.account_type,
         fnb_sales.ent,
          fnb_sales.ent_detail,
                    fnb_sales.restaurant_location as rl,
                    fnb_sales.table_definition as td,
                    fnb_sales.waiter_definition as wd,
                    transactions.trans_amount as paid_amount




from fnb_sales





         left outer join transactions on transactions.trans_type=5
    and transactions.trans_type_id=fnb_sales.id and
                              transactions.debit_or_credit=0 and transactions.deleted_at is null
where  fnb_sales.id is not null and fnb_sales.completed!=0 and  fnb_sales.deleted_at is null ' . $search . '  and
                                           DATE(fnb_sales.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales.date) >= "' . $start_date . '" ' . $search3 . '

group by fnb_sales.id
) as s
                left outer join fnb_restaurant_locations on fnb_restaurant_locations.id=s.rl
                left outer join fnb_ent_details on fnb_ent_details.id=s.ent_detail and s.ent_detail is not null and s.ent_detail!=0
                left outer join fnb_table_definitions on fnb_table_definitions.id = s.td and
                                                         fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
                left outer join fnb_waitor_definitions on s.wd = fnb_waitor_definitions.id
where 1=1

group by s.rl order by cat

'
			);



			/* $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_sales.id,

       (sum(fnb_sales.gross))                     as grosssale,
       (sum(fnb_sales.discount))                as diss,
         (sum(fnb_sales.sub_total))               as netsale,
         (sum(fnb_sales.tax))                  as taxx,
          (sum(fnb_sales.covers))                 as netcovers,
          (sum(fnb_sales.grand_total))                 as grandd,
     sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
     sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,
      sum(if(fnb_sales.account_type not in (22,24),fnb_sales.grand_total,0)) as othergross,
     group_concat(DISTINCT fnb_restaurant_locations.`desc`) as cat,
      fnb_table_definitions.desc    as tables,
      fnb_waitor_definitions.name    as waitor

from fnb_sales

         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id=fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_sales.id is not null and fnb_sales.completed!=0 and  fnb_sales.deleted_at is null  '.$search.'  and
                                           DATE(fnb_sales.date) <= "'.$end_date.'" and
                                           DATE(fnb_sales.date) >= "'.$start_date.'" '.$search3.'
                                           group by fnb_restaurant_locations.id,fnb_sales.created_by
                                           order by cat asc
');*/
		}


		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['ent_details'] = fnb_ent_detail::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		return $data;
	}



	public function cashiersales_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/daily-cashier-sales-list/daily-cashier-sales-list-vue');
	}


	public function cashiersales_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->order_type) {
			$search .= " and fnb_sales.order_type in ('" . str_replace(",", "','", $request->order_type) . "') ";
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales.discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'





                                           select group_concat(s.bbbb), sum(s.grosssale) as grosssale,
       sum(s.diss) as diss,
       sum(s.netsale) as  netsale,
       sum(s.taxx) as  taxx,
       sum(s.netcovers) as netcovers,
       sum(s.grandd) as  grandd,
       sum(if(s.account_type = 22,s.grandd,0)) as cashgross,
       sum(if(s.account_type = 24,s.grandd,0)) as creditgross,
       sum(if(s.account_type not in (22,24),s.grandd,0)) as othergross,

        users.name as name,
       sum(s.paid_amount ) as paid_amount

       from (select
        group_concat(fnb_sales.id) as bbbb,
       ((fnb_sales.gross))                     as grosssale,
       ((fnb_sales.discount))                as diss,
       ((fnb_sales.sub_total))               as netsale,
       ((fnb_sales.tax))                  as taxx,
       ((fnb_sales.covers))                 as netcovers,
       ((fnb_sales.grand_total))                 as grandd,
        fnb_sales.account_type,
                    fnb_sales.created_by as rl,
                    fnb_sales.table_definition as td,
                    fnb_sales.waiter_definition as wd,
                    transactions.trans_amount as paid_amount





from fnb_sales





         left outer join transactions on transactions.trans_type=5
    and transactions.trans_type_id=fnb_sales.id and
                              transactions.debit_or_credit=0 and transactions.deleted_at is null
where  fnb_sales.id is not null and fnb_sales.completed!=0 and  fnb_sales.deleted_at is null ' . $search . '  and
                                           DATE(fnb_sales.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales.date) >= "' . $start_date . '" ' . $search3 . '

group by fnb_sales.id
) as s
                left outer join users on users.id=s.rl

where 1=1

group by s.rl order by users.id

'
			);



			/* $data['sales'] =\Illuminate\Support\Facades\DB::select(
                'select fnb_sales.id,

                 (sum(fnb_sales.gross))                     as grosssale,
                 (sum(fnb_sales.discount))                as diss,
                   (sum(fnb_sales.sub_total))               as netsale,
                   (sum(fnb_sales.tax))                  as taxx,
                    (sum(fnb_sales.covers))                 as netcovers,
                    (sum(fnb_sales.grand_total))                 as grandd,
               sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
               sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,
                sum(if(fnb_sales.account_type not in (22,24),fnb_sales.grand_total,0)) as othergross,
               group_concat(DISTINCT fnb_restaurant_locations.`desc`) as cat,
                fnb_table_definitions.desc    as tables,
                fnb_waitor_definitions.name    as waitor

          from fnb_sales

                   left outer join fnb_restaurant_locations on fnb_restaurant_locations.id=fnb_sales.restaurant_location
                   left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                            fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
                   left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
          where fnb_sales.id is not null and fnb_sales.completed!=0 and  fnb_sales.deleted_at is null  '.$search.'  and
                                                     DATE(fnb_sales.date) <= "'.$end_date.'" and
                                                     DATE(fnb_sales.date) >= "'.$start_date.'" '.$search3.'
                                                     group by fnb_restaurant_locations.id,fnb_sales.created_by
                                                     order by cat asc
          ');*/
		}


		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();
		if (Auth::user()->can('Export Daily Cashier Sales List')) {
			$data['exported'] = 1;
		}

		return $data;
	}





	public function dailyrestsales_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/daily-restaurant-sales-summary/daily-restaurant-sales-summary-vue');
	}

	public function dailyrestsales_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->order_type) {
			$search .= " and fnb_sales.order_type in ('" . str_replace(",", "','", $request->order_type) . "') ";
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales.discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_sales.id,

       (sum(fnb_sales.gross))                     as grosssale,
       (sum(fnb_sales.discount))                as diss,
         (sum(fnb_sales.tax))                  as taxx,
          (sum(fnb_sales.grand_total))                 as grandd,
     group_concat(DISTINCT fnb_restaurant_locations.`desc`) as cat,
      fnb_table_definitions.desc    as tables,
      fnb_waitor_definitions.name    as waitor,
        sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
     sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,

  sum(transactions.trans_amount ) as paid_amount


from fnb_sales

left outer join transactions on transactions.trans_type=5 and transactions.trans_type_id=fnb_sales.id and transactions.debit_or_credit=0 and transactions.deleted_at is null



         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id=fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_sales.id is not null and fnb_sales.completed!=0 and  fnb_sales.deleted_at is null and fnb_sales.completed>0 ' . $search . '  and
                                           DATE(fnb_sales.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales.date) >= "' . $start_date . '" ' . $search3 . '
                                           group by fnb_restaurant_locations.id
                                           order by cat asc
'
			);
		}

		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		return $data;
	}





	public function itemsummary_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/items-sales-summary/items-sales-summary-vue');
	}

	public function itemsummary_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->inv) {
			$search2 .= ' and fnb_sales.id in (' . $request->inv . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2 && $request->mog != null) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_item_definitions.sale_price,

      concat("Invoice#: ",group_concat(DISTINCT fnb_sales.invoice_no))       as cat,

      fnb_sales.type as type,
      hr_employments.name as employee,
      customers.customer_name as guest,
      concat(coalesce(memberships.first_name, ""), " ", coalesce(memberships.middle_name, ""), " ",
                 coalesce(memberships.applicant_name, "")) as member,

       group_concat(DISTINCT fnb_sales.id)                    as sale_id,
       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as resturants,
       group_concat(DISTINCT fnb_table_definitions.`desc`)    as tables,
       group_concat(DISTINCT fnb_waitor_definitions.name)     as waitor,
       group_concat(DISTINCT fnb_sales.covers)     as covers,
       group_concat(DISTINCT fnb_sales.tax)     as tax,
       group_concat(DISTINCT fnb_sales_subs.kot_no)     as kot,
       group_concat(DISTINCT fnb_sales_subs.status)     as status,
      (sum( fnb_sales_subs.total ))     as sale_price3,
      (fnb_sales.grand_total)     as gtotal,
        (sum( fnb_sales_subs.sub_total_price ))     as sale_price2,
       group_concat(DISTINCT fnb_sales_subs.`created_at`)     as wtime,
       (sum(fnb_sales_subs.qty))                          as sales,
       sum( fnb_sales_subs.item_discount)              as discount,
       group_concat(DISTINCT fnb_sales.date)                  as dda,
       group_concat(DISTINCT fnb_sales.order_type)                  as ordertype


from fnb_item_definitions
 left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where   deleted_at is null ' . $search . ' ) and
                                           DATE(fnb_sales_subs.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales_subs.date) >= "' . $start_date . '" ' . $search3 . '
                                            and fnb_sales_subs.status is null
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id

        left outer join memberships on memberships.id = fnb_sales.customer_id
        left outer join customers on customers.id = fnb_sales.customer_id
        left outer join hr_employments on hr_employments.id=fnb_sales.customer_id

          where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0 ' . $search2 . '
group by fnb_item_definitions.id, fnb_sales.id
order by fnb_sales.invoice_no,fnb_item_definitions.item_details asc'
			);
		}

		/*  if(group_concat(DISTINCT fnb_sales.type) = 0,
          concat(coalesce(memberships.first_name, ""), " ", coalesce(memberships.middle_name, ""), " ",
                 coalesce(memberships.applicant_name, "")), customers.customer_name) as sub,*/

		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		if (Auth::user()->can('Export Sales Summary With Items')) {
			$data['exported'] = 1;
		}

		return $data;
	}







	public function saleserrors_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/sales-errors/sales-errors-vue');
	}

	public function saleserrors_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->inv) {
			$search2 .= ' and fnb_sales.id in (' . $request->inv . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2 && $request->mog != null) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_item_definitions.sale_price,

      concat("Invoice#: ",group_concat(DISTINCT fnb_sales.invoice_no))                as cat,

      fnb_sales.type as type,
      hr_employments.name as employee,
      customers.customer_name as guest,
      concat(coalesce(memberships.first_name, ""), " ", coalesce(memberships.middle_name, ""), " ",
                 coalesce(memberships.applicant_name, "")) as member,

       group_concat(DISTINCT fnb_sales.id)                    as sale_id,
       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as resturants,
       group_concat(DISTINCT fnb_table_definitions.`desc`)    as tables,
       group_concat(DISTINCT fnb_waitor_definitions.name)     as waitor,
       group_concat(DISTINCT fnb_sales.covers)     as covers,
       group_concat(DISTINCT fnb_sales.tax)     as tax,
       group_concat(DISTINCT fnb_sales_subs.kot_no)     as kot,
       group_concat(DISTINCT fnb_sales_subs.status)     as status,
      (sum( fnb_sales_subs.total ))     as sale_price3,
      (fnb_sales.grand_total)     as gtotal,
        (sum( fnb_sales_subs.sub_total_price ))     as sale_price2,
       group_concat(DISTINCT fnb_sales.`time`)     as wtime,
       (sum(fnb_sales_subs.qty))                          as sales,
       sum( fnb_sales_subs.item_discount)              as discount,
       group_concat(DISTINCT fnb_sales.date)                  as dda,
       group_concat(DISTINCT fnb_sales.order_type)                  as ordertype


from fnb_item_definitions
 left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where   deleted_at is null ' . $search . ' ) and
                                           DATE(fnb_sales_subs.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales_subs.date) >= "' . $start_date . '" ' . $search3 . '
                                            and fnb_sales_subs.status is null
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id

        left outer join memberships on memberships.id = fnb_sales.customer_id
        left outer join customers on customers.id = fnb_sales.customer_id
        left outer join hr_employments on hr_employments.id=fnb_sales.customer_id

          where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0 ' . $search2 . '
group by fnb_item_definitions.id, fnb_sales.id
order by cat,fnb_item_definitions.item_details asc'
			);
		}
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		if (Auth::user()->can('Export Sales Errors')) {
			$data['exported'] = 1;
		}

		return $data;
	}





	public function closingsalesreport(Request $request, fnb_sale $fnb_sale)
	{
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();

		if ($request->get('restsearch')) {
			$data['chosenrest'] = $request->get('restsearch');
		} else {
			$data['chosenrest'] = [];
		}

		if ($request->get('ordersearch')) {
			$data['chosenorder'] = $request->get('ordersearch');
		} else {
			$data['chosenorder'] = [];
		}
		$r = fnb_sale::withoutTrashed();
		if ($request->get('start_date')) {
			$start_date = $request->get('start_date');
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
			$r->where('date', '>=', formatDate($start_date));
		}
		if ($request->get('end_date')) {
			$r->where('date', '<=', formatDate($request->get('end_date')));
		}
		if ($request->get('restsearch')) {
			$r->whereIn('restaurant_location', $request->get('restsearch'));
		}

		if ($request->get('ordersearch')) {
			$r->whereIn('order_type', $request->get('ordersearch'));
		}

		if (!($request->get('start_date') != '' ||
			$request->get('end_date') != '')) {

			$r->where('date', '=', '00/00/0000');
		}
		$data['start_date'] = $request->get('start_date');
		$data['end_date'] = $request->get('end_date');

		$data['sales'] = $r->get();

		$data['Cashid'] = finance_account_head::where('status', 1)->where('desc', 'Cash')->pluck('id');
		/*dd($data['Cashid'][0]);*/
		$data['Creditid'] = finance_account_head::where('status', 1)->where('desc', 'Credit')->pluck('id');

		if ($request->get('restsearch')) {
			$data['restaurants'] = fnb_restaurant_location::where('status', 1)->whereIn('id', $request->get('restsearch'))->get();
		} else {
			$data['restaurants'] = fnb_restaurant_location::where('status', 1)->get();
		}

		$Cash = finance_account_head::where('id', 1)->get()->pluck('id');
		$data['acccash'] = finance_account_type::where('desc', $Cash)->get()->pluck('id')->toArray();
		//dd($data['acccash']);

		$Credit = finance_account_head::where('id', 2)->get()->pluck('id');
		$data['acccredit']  = finance_account_type::where('desc', $Credit)->get()->pluck('id')->toArray();

		//dd($data['restaurants'][0]);
		if (Auth::user()->can('Export Closing Sales Report')) {
			$data['exported'] = 1;
		}

		return view('backend/finance-and-management/closing-sales-report/closing-sales-report', $data);
	}

	public function dishbreakdownsummary(Request $request, fnb_sale $fnb_sale)
	{

		$data['start_date'] = $request->get('start_date');
		$data['end_date'] = $request->get('end_date');
		$data['categorysearch'] = fnb_item_category::where('status', 1)->get();
		$data['subcatsearch'] = fnb_item_sub_category::where('status', 1)->get();
		$data['itemssearch'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();

		if ($request->get('catsearch')) {
			$data['chosencat'] = $request->get('catsearch');
		} else {
			$data['chosencat'] = [];
		}
		if ($request->get('subsearch')) {
			$data['chosensubcat'] = $request->get('subsearch');
		} else {
			$data['chosensubcat'] = [];
		}
		if ($request->get('itemsearch')) {
			$data['chosenitem'] = $request->get('itemsearch');
		} else {
			$data['chosenitem'] = [];
		}


		if ($request->get('catsearch')) {
			$data['categories'] = fnb_item_category::where('status', 1)->whereIn('id', $request->get('catsearch'))->get();
		} else {
			$data['categories'] = fnb_item_category::where('status', 1)->get();
		}

		if ($request->get('subsearch')) {
			$data['subcategories'] = fnb_item_sub_category::where('status', 1)->whereIn('id', $request->get('subsearch'))->get();
		} else {
			$data['subcategories'] = fnb_item_sub_category::where('status', 1)->get();
		}

		if ($request->get('itemsearch')) {
			$data['itemdefinitions'] = fnb_item_definition::where('status', 1)->where('salable', 1)->whereIn('id', $request->get('itemsearch'))->get();
		} else {
			$data['itemdefinitions'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();
		}

		$data['salessubs'] = fnb_sales_subs::with('saleid')->where('status', NULL)->get();
		//dd($data['salessubs']);

		return view('backend/finance-and-management/dish-breakdown-summary/dish-breakdown-summary', $data);
	}

	public function dishbreakdownsummary_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/dish-breakdown-summary/dish-breakdown-summary-vue');
	}

	public function dishbreakdownsummary_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_sales_subs.sale_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       group_concat(DISTINCT fnb_sales.id)                    as sale_id,
       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as resturants,
       group_concat(DISTINCT fnb_table_definitions.`desc`)    as tables,
       group_concat(DISTINCT fnb_waitor_definitions.name)     as waitor,
       (sum(fnb_sales_subs.qty))                          as sales,
       sum( fnb_sales_subs.item_discount)              as discount,
       group_concat(DISTINCT fnb_sales.date)                  as dda,
        (sum( fnb_sales_subs.total ))     as sale_price3,
        (sum( fnb_sales_subs.sub_total_price ))     as sale_price2


from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category 
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null ' . $search . ' ) and
                                           DATE(fnb_sales_subs.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales_subs.date) >= "' . $start_date . '" ' . $search3 . ' and fnb_sales_subs.status is null
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0 ' . $search2 . '
group by fnb_item_definitions.id,fnb_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc'
			);

			// and fnb_item_categories.status=1 and fnb_item_sub_categories.status=1

		}
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		if (Auth::user()->can('Export Dish Breakdown Summary')) {
			$data['exported'] = 1;
		}

		return $data;
	}



	public function revenuesummary_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/revenue-summary/revenue-summary-vue');
	}

	public function revenuesummary_init_vue(Request $request)
	{
		$q = '';
		$q2 = '';
		if ($request->get('start_date')) {
			$q .= ' and transactions.date>="' . $request->get('start_date') . '" ';
			$q2 .= ' and Date(fnb_sales.date)>="' . $request->get('start_date') . '" ';
		}
		if ($request->get('end_date')) {
			$q .= ' and transactions.date<="' . $request->get('end_date') . '" ';
			$q2 .= ' and Date(fnb_sales.date)<="' . $request->get('end_date') . '" ';
		}


		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			"(select t.desc as cat ,sum(t.discount) as discount ,sum(t.cashgross) as cashgross,sum(t.creditgross) as creditgross,sum(t.entgross) as  entgross from(
          select fic.desc,
           ( fss.item_discount)              as discount,
                 (if(fnb_sales.account_type = 22 or fnb_sales.account_type is null, fnb_sales.grand_total, 0))             as cashgross,
                 (if(fnb_sales.account_type in (23,24,25), fnb_sales.grand_total, 0))             as creditgross,
                 (if(fnb_sales.ent = 1 or fnb_sales.type = 3, fnb_sales.grand_total, 0)) as entgross,
                 fnb_sales.id
          from fnb_sales
                  left outer join fnb_sales_subs fss on fnb_sales.id = fss.sales_id
                   left outer join fnb_item_definitions fid on fss.item_code = fid.item_code
                   left outer join fnb_item_categories fic on fid.category = fic.id
          where
          fnb_sales.completed > 0
            and fnb_sales.deleted_at is null

           $q2
          group by fnb_sales.id
      ) as t group by t.desc)

union all
(select 'Room Booking' as cat  ,COALESCE(sum(room_bookings.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0) as cashgross,
        COALESCE(sum(if(fcr.account=24,transactions.trans_amount,0)),0) as creditgross,0  from room_bookings
    inner join transactions on transactions.trans_type_id=room_bookings.id and transactions.trans_type=1 and transactions.debit_or_credit=0
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id where 1=1 $q
    )
union all
(select 'Membership Fee',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
     left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where transactions.debit_or_credit=0 and transactions.trans_type =3 $q
    )
union all
(select 'Maintenance Fee',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where transactions.debit_or_credit=0 and transactions.trans_type =4
     $q

    )
union all
(select 'Sport Subscription',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where transactions.debit_or_credit=0 and transactions.trans_type in(select id from trans_types where type=3) $q
    )union all
(select 'Supplementary Card',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where transactions.debit_or_credit=0 and transactions.trans_type =10 $q
    )"
		);



		return $data;
	}



	public function memrevenue_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/revenue-summary/member-revenue-summary-vue');
	}

	public function memrevenue_init_vue(Request $request)
	{
		$q = '';
		$q2 = '';
		if ($request->get('start_date')) {
			$q .= ' and transactions.date>="' . $request->get('start_date') . '" ';
			$q2 .= ' and Date(fnb_sales.date)>="' . $request->get('start_date') . '" ';
		}
		if ($request->get('end_date')) {
			$q .= ' and transactions.date<="' . $request->get('end_date') . '" ';
			$q2 .= ' and Date(fnb_sales.date)<="' . $request->get('end_date') . '" ';
		}


		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			"select mem_categories.unique_code as sub,
       (select t.desc as cat ,sum(t.discount) as discount ,sum(t.cashgross) as cashgross,sum(t.creditgross) as creditgross,sum(t.entgross) as  entgross from(
          select fic.desc,
           ( fss.item_discount)              as discount,
                 (if(fnb_sales.account_type = 22 or fnb_sales.account_type is null, fnb_sales.grand_total, 0))             as cashgross,
                 (if(fnb_sales.account_type in (23,24,25), fnb_sales.grand_total, 0))             as creditgross,
                 (if(fnb_sales.ent = 1 or fnb_sales.type = 3, fnb_sales.grand_total, 0)) as entgross,
                 fnb_sales.id
          from fnb_sales
                  left outer join fnb_sales_subs fss on fnb_sales.id = fss.sales_id
                   left outer join fnb_item_definitions fid on fss.item_code = fid.item_code
                   left outer join fnb_item_categories fic on fid.category = fic.id
          where
          fnb_sales.completed > 0 and fnb_sales.type=0
            and fnb_sales.deleted_at is null

           $q2
          group by fnb_sales.id
      ) as t group by t.desc)

union all
(select 'Room Booking' as cat  ,COALESCE(sum(room_bookings.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0) as cashgross,
        COALESCE(sum(if(fcr.account=24,transactions.trans_amount,0)),0) as creditgross,0  from room_bookings
    inner join transactions on transactions.trans_type_id=room_bookings.id and transactions.trans_type=1 and transactions.debit_or_credit=0
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id where 1=1 and room_bookings.booking_type=0 $q
    )
union all
(select 'Membership Fee',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
     left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where fi.invoice_type=0 and transactions.debit_or_credit=0 and transactions.trans_type =3 $q
    )
union all
(select 'Maintenance Fee',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where fi.invoice_type=0 and transactions.debit_or_credit=0 and transactions.trans_type =4
     $q

    )
union all
(select 'Sport Subscription',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where fi.invoice_type=0 and transactions.debit_or_credit=0 and transactions.trans_type in(select id from trans_types where type=3) $q
    )union all
(select 'Supplementary Card',COALESCE(sum(fi.discount_amount),0),COALESCE(sum(if(fcr.account=22,transactions.trans_amount,0)),0), COALESCE(sum(if(fcr.account in(23,24,25),transactions.trans_amount,0)),0),0 from transactions
    left outer join finance_cash_receipts fcr on transactions.receipt_id = fcr.id
left outer join finance_invoices fi on transactions.trans_type_id=fi.id
    where fi.invoice_type=0 and transactions.debit_or_credit=0 and transactions.trans_type =10 $q )


from mem_categories
         left outer join memberships on memberships.mem_category_id = mem_categories.id

where mem_categories.deleted_at is null and mem_categories.id is not null 
group by mem_categories.id
order by sub,mem_categories.desc asc"



		);



		return $data;
	}


	public function book_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/transaction-book/transaction-book-vue');
	}

	public function book_init_vue(Request $request)
	{
		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			'select
       fnb_item_categories.desc                               as cat,
       sum( fnb_sales_subs.item_discount)              as discount,

    sum(if(fnb_sales.account_type = 22,fnb_sales.grand_total,0)) as cashgross,
     sum(if(fnb_sales.account_type = 24,fnb_sales.grand_total,0)) as creditgross,
     sum(if(fnb_sales.ent = 1 or fnb_sales.type=3,fnb_sales.grand_total,0)) as entgross

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null) and fnb_sales_subs.status is null
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id

where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0
group by cat
order by cat'
		);

		return $data;
	}


















	// SALES KOT REPORT
	public function saleskot_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/sales-kot-report/sales-kot-report-vue');
	}

	public function saleskot_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		$c = kotrec::query();
		if ($request->start_date) {

			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
			$c->where('created_at', '>=', $start_date);
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
			$c->where('created_at', '<=', $end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->cashier) {
			$c->whereIn('user', $request->cashier);
			//            $search.=' and fnb_sales.created_by in ('.$request->cashier.') ';
		}
		if ($request->cashier) {
			$c->whereIn('user', $request->cashier);
			//            $search.=' and fnb_sales.created_by in ('.$request->cashier.') ';
		}
		if ($request->category) {
			$c->whereIn('category', $request->category);

			//        $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
		}
		if ($request->category) {
			$c->whereIn('category', $request->category);

			//        $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
		}
		if ($request->error) {
			//  dd(DB::connection('sqlite')->select('select max(kot_id) - min(kot_id) + 1 - count(*) as num_missings from kotrec;'));


			//    $c->whereIn('kot_id',array_column($missing,'kot_id'));
			//        $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
		}

		if ($request->r) {
			$data['sales'] = $c->get();
			if ($request->start_date) {
				$start_date = formatDate($request->start_date);
				if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
					$start_date = settings('fnb_due');
				}
				//   $c->where('created_at','>',$start_date);

			}
			if ($request->end_date) {
				$end_date = formatDate($request->end_date);
				// $c->where('created_at','<',$end_date);


			}
			$data['missing'] = fnb_sales_subs::whereIn('kot_no', array_column(kotrec::selectRaw(' j1.kot_id + 1 as kot_id
from kotrec j1
left join kotrec j2 on j2.kot_id = j1.kot_id + 1
where j2.kot_id is null
    and j1.kot_id <> (select max(kot_id) from kotrec) group by j1.kot_id
order by j1.kot_id;')->get()->toArray(), 'kot_id'))->where('created_at', '>=', $start_date)->where('created_at', '<=', $end_date)->with('item')->get();
		}

		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();
		if (Auth::user()->can('Export Sales KOT Report')) {
			$data['exported'] = 1;
		}
		return $data;
	}

	// SALES KOT REPORT




	public function salesdashboard_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/sales-dashboard/sales-dashboard-vue');
	}

	public function salesdashboard_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select

sum(if(fnb_sales.order_type = "Dine-In" and fnb_sales.completed!=0,fnb_sales.grand_total,0)) as processed_dine_sales,
sum(if(fnb_sales.order_type = "Dine-In" and fnb_sales.completed!=0,fnb_sales.covers,0)) as processed_dine_covers,
sum(if(fnb_sales.order_type = "Dine-In" and fnb_sales.completed!=0,1,0)) as processed_dine_count,

sum(if(fnb_sales.order_type = "Take Away" and fnb_sales.completed!=0,fnb_sales.grand_total,0)) as processed_take_sales,
sum(if(fnb_sales.order_type = "Take Away" and fnb_sales.completed!=0,fnb_sales.covers,0)) as processed_take_covers,
sum(if(fnb_sales.order_type = "Take Away" and fnb_sales.completed!=0,1,0)) as processed_take_count,

sum(if(fnb_sales.order_type = "Home Delivery" and fnb_sales.completed!=0,fnb_sales.grand_total,0)) as processed_home_sales,
sum(if(fnb_sales.order_type = "Home Delivery" and fnb_sales.completed!=0,fnb_sales.covers,0)) as processed_home_covers,
sum(if(fnb_sales.order_type = "Home Delivery" and fnb_sales.completed!=0,1,0)) as processed_home_count,



sum(if(fnb_sales.order_type = "Dine-In" and fnb_sales.completed=0,fnb_sales.grand_total,0)) as inprocess_dine_sales,
sum(if(fnb_sales.order_type = "Dine-In" and fnb_sales.completed=0,fnb_sales.covers,0)) as inprocess_dine_covers,
sum(if(fnb_sales.order_type = "Dine-In" and fnb_sales.completed=0,1,0)) as inprocess_dine_count,

sum(if(fnb_sales.order_type = "Take Away" and fnb_sales.completed=0,fnb_sales.grand_total,0)) as inprocess_take_sales,
sum(if(fnb_sales.order_type = "Take Away" and fnb_sales.completed=0,fnb_sales.covers,0)) as inprocess_take_covers,
sum(if(fnb_sales.order_type = "Take Away" and fnb_sales.completed=0,1,0)) as inprocess_take_count,

sum(if(fnb_sales.order_type = "Home Delivery" and fnb_sales.completed=0,fnb_sales.grand_total,0)) as inprocess_home_sales,
sum(if(fnb_sales.order_type = "Home Delivery" and fnb_sales.completed=0,fnb_sales.covers,0)) as inprocess_home_covers,
sum(if(fnb_sales.order_type = "Home Delivery" and fnb_sales.completed=0,1,0)) as inprocess_home_count



from fnb_sales

        
where fnb_sales.id is not null and fnb_sales.deleted_at is null ' . $search . '  and
                                           DATE(fnb_sales.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales.date) >= "' . $start_date . '" ' . $search3 . '

'
			);
		}
		/*
 $data['processed']= fnb_sale::where('completed','!=',0)->get();
  $data['inprocess']= fnb_sale::where('completed',0)->get();*/

		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		/* $data['table_defs']= fnb_table_definition::where('status',1)->orderBy('id')->get();
  $data['waiter_defs']= fnb_waitor_definition::where('status',1)->get();
  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
    $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();*/

		return $data;
	}




	public function hourlysales_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/hourly-sales/hourly-sales-vue');
	}
	public function hourlysales_init_vue(Request $request)
	{
		$data = [];
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_definitions.category in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_definitions.sub_category in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search .= ' and fnb_sales.tax >0 ';
		}


		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			' select  concat(DATE_FORMAT(STR_TO_DATE(fs.time, "%h:%i:%s %p"), "%h %p"), " ",
              DATE_FORMAT(DATE_ADD(STR_TO_DATE(fs.time, "%h:%i:%s %p"), INTERVAL 1 HOUR), "%h %p")) as t,
       sum(fs.grand_total)                                                                          as grand,
      sum(fs.d)                                                                     as c,
      count(i) as i,group_concat(b)

from (select  sum(fnb_sales_subs.total) as grand_total, sum(fnb_sales_subs.qty) as d,fnb_sales.time,fnb_sales.id as i ,group_concat(fnb_sales.id) as b from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs

group by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p"))
order by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p")) asc'
		);


		$s = \Illuminate\Support\Facades\DB::select(
			'

 select   UNIX_TIMESTAMP(STR_TO_DATE(concat( fs.time),  "%h:%i:%s %p") ) * 1000 as t,
       sum(fs.grand_total)                                                                          as c

      from (select sum(fnb_sales_subs.total) as grand_total, fnb_sales.time,fnb_sales.date from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs

group by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p"))
order by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p")) asc



'
		);



		foreach ($s as $c) {

			$c = (array) $c;
			$data['salesChart'][] = [$c['t'], (int) $c['c']];
		}
		ksort($data['salesChart']);
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		return $data;
	}






	// WEEKDAYS GRAPHICAL SALES REPORT
	public function weekdayssales_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/weekly-graphical-sales/weekly-graphical-sales-vue');
	}
	public function weekdayssales_init_vue(Request $request)
	{
		$data = [];
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		$search4 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_definitions.category in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_definitions.sub_category in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search .= ' and fnb_sales.tax >0 ';
		}
		if ($request->day != -1) {
			$dvv = $request->day;
			if ($dvv == 0) {
				$dvv = 7;
			}
			$dvv = $dvv - 1;
			$search4 .= '  and WEEKDAY(STR_TO_DATE(fs.date, "%Y-%m-%d"))= ' . $dvv;
		}


		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			' select fs.date as t,
       sum(fs.grand_total)                                                                          as grand,
      sum(fs.d)                                                                     as c,
      count(i) as i,group_concat(b)

from (select  sum(fnb_sales_subs.total) as grand_total, sum(fnb_sales_subs.qty) as d,fnb_sales.date,fnb_sales.id as i ,group_concat(fnb_sales.id) as b from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs
where 1=1 ' . $search4 . '
group by fs.date
order by fs.date asc'
		);

		$s = \Illuminate\Support\Facades\DB::select(
			'
 select   UNIX_TIMESTAMP(fs.date ) * 1000 as t,
       sum(fs.grand_total)                                                                          as c

      from (select sum(fnb_sales_subs.total) as grand_total, fnb_sales.time,fnb_sales.date from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0 and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs
where 1=1 ' . $search4 . '
group by fs.date
order by fs.date asc



'
		);
		foreach ($s as $c) {

			$c = (array) $c;
			$data['salesChart'][] = [$c['t'], (int) $c['c']];
		}
		ksort($data['salesChart']);
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		return $data;
	}
	// WEEKDAYS GRAPHICAL SALES REPORT






	// RESTAURANT GRAPHICAL SALES REPORT
	public function restaurantsales_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/restaurant-graphical-sales/restaurant-graphical-sales-vue');
	}
	public function restaurantsales_init_vue(Request $request)
	{
		$data = [];
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_definitions.category in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_definitions.sub_category in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search .= ' and fnb_sales.tax >0 ';
		}


		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			' select  concat(DATE_FORMAT(STR_TO_DATE(fs.time, "%h:%i:%s %p"), "%h %p"), " ",
              DATE_FORMAT(DATE_ADD(STR_TO_DATE(fs.time, "%h:%i:%s %p"), INTERVAL 1 HOUR), "%h %p")) as t,
       sum(fs.grand_total)                                                                          as grand,
      sum(fs.d)                                                                     as c,
      count(i) as i,group_concat(b)

from (select  sum(fnb_sales_subs.total) as grand_total, sum(fnb_sales_subs.qty) as d,fnb_sales.time,fnb_sales.id as i ,group_concat(fnb_sales.id) as b from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs

group by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p"))
order by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p")) asc'
		);

		$s = \Illuminate\Support\Facades\DB::select(
			'
 select   UNIX_TIMESTAMP(STR_TO_DATE(concat( fs.time),  "%h:%i:%s %p") ) * 1000 as t,
       sum(fs.grand_total)                                                                          as c

      from (select sum(fnb_sales_subs.total) as grand_total, fnb_sales.time,fnb_sales.date from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs

group by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p"))
order by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p")) asc



'
		);
		foreach ($s as $c) {

			$c = (array) $c;
			$data['salesChart'][] = [$c['t'], (int) $c['c']];
		}
		ksort($data['salesChart']);
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		return $data;
	}
	// RESTAURANT GRAPHICAL SALES REPORT





	// SUBCATEGORY GRAPHICAL SALES REPORT
	public function subcategorysales_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/subcategory-graphical-sales/subcategory-graphical-sales-vue');
	}
	public function subcategorysales_init_vue(Request $request)
	{
		$data = [];
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_definitions.category in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_definitions.sub_category in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search .= ' and fnb_sales.tax >0 ';
		}


		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			' select  concat(DATE_FORMAT(STR_TO_DATE(fs.time, "%h:%i:%s %p"), "%h %p"), " ",
              DATE_FORMAT(DATE_ADD(STR_TO_DATE(fs.time, "%h:%i:%s %p"), INTERVAL 1 HOUR), "%h %p")) as t,
       sum(fs.grand_total)                                                                          as grand,
      sum(fs.d)                                                                     as c,
      count(i) as i,group_concat(b)

from (select  sum(fnb_sales_subs.total) as grand_total, sum(fnb_sales_subs.qty) as d,fnb_sales.time,fnb_sales.id as i ,group_concat(fnb_sales.id) as b from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs

group by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p"))
order by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p")) asc'
		);

		$s = \Illuminate\Support\Facades\DB::select(
			'
 select   UNIX_TIMESTAMP(STR_TO_DATE(concat( fs.time),  "%h:%i:%s %p") ) * 1000 as t,
       sum(fs.grand_total)                                                                          as c

      from (select sum(fnb_sales_subs.total) as grand_total, fnb_sales.time,fnb_sales.date from  fnb_sales
         inner join fnb_sales_subs on fnb_sales_subs.sales_id = fnb_sales.id ' . $search3 . ' and fnb_sales_subs.status is null
         inner join fnb_item_definitions on fnb_item_definitions.item_code = fnb_sales_subs.item_code ' . $search2 . '
    where fnb_sales.id is not null and fnb_sales.completed>0
  and DATE(fnb_sales.date) <= "' . $end_date . '"
  and DATE(fnb_sales.date) >= "' . $start_date . '"  ' . $search . '
  group by fnb_sales.id
    ) as fs

group by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p"))
order by Hour(STR_TO_DATE(fs.time, "%h:%i:%s %p")) asc



'
		);
		foreach ($s as $c) {

			$c = (array) $c;
			$data['salesChart'][] = [$c['t'], (int) $c['c']];
		}
		ksort($data['salesChart']);
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		return $data;
	}
	// SUBCATEGORY GRAPHICAL SALES REPORT






	/*   public function oldhourlysales_init_vue(Request $request)
    {
        $data=[];
$start_date=date('Y-m-d');
$search =" ";
        if($request->start_date){
            $start_date=formatDate($request->start_date);

 if($request->resturants){
            $search="and `restaurant_location` in ($request->resturants)";
        }



  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      "select concat(DATE_FORMAT(STR_TO_DATE(`time`, '%h:%i:%s %p'),'%h %p'),' ',DATE_FORMAT(DATE_ADD(STR_TO_DATE(`time`, '%h:%i:%s %p'),INTERVAL 1 HOUR),'%h %p')) as t,sum(grand_total) as grand,count(id) as c from fnb_sales where `date`='$start_date' $search group by Hour(STR_TO_DATE(`time`, '%h:%i:%s %p')) order by Hour(STR_TO_DATE(`time`, '%h:%i:%s %p')) asc
");


      $s=\Illuminate\Support\Facades\DB::select(
      "select UNIX_TIMESTAMP(STR_TO_DATE(concat(`date`,' ',`time`), '%Y-%m-%d %h:%i:%s %p') ) * 1000 as t,sum(grand_total) as c from fnb_sales where `date`='$start_date' $search group by Hour(STR_TO_DATE(`time`, '%h:%i:%s %p')) order by Hour(STR_TO_DATE(`time`, '%h:%i:%s %p')) asc
");

        }

        foreach($s as $c){

            $c=(array) $c;
            $data['salesChart'][]=[$c['t'],(int) $c['c']];
        }
  $data['restaurant_locations']= fnb_restaurant_location::where('status',1)->get();

     return $data;
}

*/


	public function resdishbreakdownsummary_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/dish-breakdown-summary/restaurant-dish-breakdown-summary-vue');
	}

	public function resdishbreakdownsummary_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_sales_subs.sale_price,
       fnb_item_categories.desc                               as sub,
       fnb_item_sub_categories.`desc`                         as subssss,
       group_concat(DISTINCT fnb_sales.id)                    as sale_id,
       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as cat,
       group_concat(DISTINCT fnb_table_definitions.`desc`)    as tables,
       group_concat(DISTINCT fnb_waitor_definitions.name)     as waitor,
       (sum(fnb_sales_subs.qty))                          as sales,
       sum( fnb_sales_subs.item_discount)              as discount,
       group_concat(DISTINCT fnb_sales.date)                  as dda,
        (sum( fnb_sales_subs.total ))     as sale_price3,
        (sum( fnb_sales_subs.sub_total_price ))     as sale_price2


from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null ' . $search . ' ) and
                                           DATE(fnb_sales_subs.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales_subs.date) >= "' . $start_date . '" ' . $search3 . '
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0 ' . $search2 . '
group by fnb_restaurant_locations.id,fnb_item_sub_categories.id,fnb_item_definitions.id,fnb_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc'
			);
		}
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();
		if (Auth::user()->can('Export Dish Breakdown Summary Restaurant-wise')) {
			$data['exported'] = 1;
		}

		return $data;
	}



	public function datedishbreakdownsummary_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/dish-breakdown-summary/date-dish-breakdown-summary-vue');
	}

	public function datedishbreakdownsummary_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_sales_subs.sale_price,
       fnb_item_categories.desc                               as sub,
       fnb_item_sub_categories.`desc`                         as subssss,
       group_concat(DISTINCT fnb_sales.id)                    as sale_id,
       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as cat,
       group_concat(DISTINCT fnb_table_definitions.`desc`)    as tables,
       group_concat(DISTINCT fnb_waitor_definitions.name)     as waitor,
       (sum(fnb_sales_subs.qty))                          as sales,
       sum( fnb_sales_subs.item_discount)              as discount,
       group_concat(DISTINCT fnb_sales.date)                  as dda,
        (sum( fnb_sales_subs.total ))     as sale_price3,
        (sum( fnb_sales_subs.sub_total_price ))     as sale_price2


from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null ' . $search . ' ) and
                                           DATE(fnb_sales_subs.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales_subs.date) >= "' . $start_date . '" ' . $search3 . '
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0 ' . $search2 . '
group by fnb_restaurant_locations.id,fnb_item_sub_categories.id,fnb_item_definitions.id,fnb_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc'
			);
		}
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();
		if (Auth::user()->can('Export Dish Breakdown Summary Date-wise')) {
			$data['exported'] = 1;
		}
		return $data;
	}





	public function yearlydishbreakdownsummary_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/dish-breakdown-summary/yearly-dish-breakdown-summary-vue');
	}

	public function yearlydishbreakdownsummary_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				"select fnb_item_definitions.item_details,
       fnb_sales_subs.sale_price,
       fnb_sales_subs.item_code,

       date_format(fnb_sales_subs.date,'%b-%y')                           as cat,
       fnb_item_categories.desc                               as sub,
       fnb_item_sub_categories.`desc`                         as subssss,

       (sum(fnb_sales_subs.qty))                          as sales,
       (sum(fnb_sales_subs.qty))                          as total1,
       (sum( fnb_sales_subs.total ))     as sale_price3,
       (sum( fnb_sales_subs.total ))     as total2,
       (sum( fnb_sales_subs.sub_total_price ))     as sale_price2


from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null ) and
                                           DATE(fnb_sales_subs.date) <= '2021-01-01' and
                                           DATE(fnb_sales_subs.date) >= '2020-01-01'
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
   where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0
group by fnb_item_sub_categories.id,fnb_item_definitions.id,fnb_sales_subs.item_code, MONTH(fnb_sales_subs.date)
order by sub,subssss,fnb_item_definitions.item_details ,MONTH(fnb_sales_subs.date) asc"
			);
		}
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		if (Auth::user()->can('Export Yearly Dish Breakdown Summary')) {
			$data['exported'] = 1;
		}

		return $data;
	}




	public function kotget()
	{
		// $kot = (fnb_sales_subs::where('created_by', Auth::id())->max('kot_no'));
		$kot = getLastKot();

		return $kot;
	}

	public function soldquantity_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/sold-quantity-report/sold-quantity-report-vue');
	}

	public function soldquantity_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_sales_subs.sale_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       group_concat(DISTINCT fnb_sales.id)                    as sale_id,
       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as resturants,
       group_concat(DISTINCT fnb_table_definitions.`desc`)    as tables,
       group_concat(DISTINCT fnb_waitor_definitions.name)     as waitor,
       (sum(fnb_sales_subs.qty))                          as sales,
       sum( fnb_sales_subs.item_discount)              as discount,
       group_concat(DISTINCT fnb_sales.date)                  as dda


from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null ' . $search . ' ) and
                                           DATE(fnb_sales_subs.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales_subs.date) >= "' . $start_date . '" ' . $search3 . ' and fnb_sales_subs.status is null
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0 ' . $search2 . '
group by fnb_item_definitions.id,fnb_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc'
			);
		}
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();

		if (Auth::user()->can('Export Sold Quantity Report')) {
			$data['exported'] = 1;
		}
		return $data;
		/*        $start_date=date('Y-m-d');
        $end_date=date('Y-m-d');
        if($request->start_date){
            $start_date=formatDate($request->start_date);
        }
        if($request->end_date){
            $end_date=formatDate($request->end_date);

        }
        $search ='';
        $search2 ='';
        if($request->resturants){
            $search.=' and fnb_sales.restaurant_location in ('.$request->resturants.') ';
        }   if($request->waiter){
            $search.=' and fnb_sales.waiter_definition in ('.$request->waiter.') ';
        }if($request->tables){
            $search.=' and fnb_sales.table_definition in ('.$request->tables.') ';
        }if($request->cashier){
            $search.=' and fnb_sales.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->mem){
        $search.=' and fnb_sales.customer_id in ('.$request->mem.') and type='.$request->mog.' ';
        }
        if($request->r){



  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_item_definitions.sale_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       group_concat(DISTINCT fnb_sales.id)                    as sale_id,
       group_concat(DISTINCT fnb_restaurant_locations.`desc`) as resturants,
       group_concat(DISTINCT fnb_table_definitions.`desc`)    as tables,
       group_concat(DISTINCT fnb_waitor_definitions.name)     as waitor,
        (sum(fnb_sales_subs.qty))                          as sales,
       sum( fnb_sales_subs.item_discount)              as discount,
       group_concat(DISTINCT fnb_sales.date)                  as dda

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where completed!=0 and deleted_at is null '.$search.' and
                                           DATE(fnb_sales.date) <= "'.$end_date.'" and
                                           DATE(fnb_sales.date) >= "'.$start_date.'")
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null '.$search2.'
group by fnb_item_definitions.id,fnb_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc');
        }

          (count(fnb_sales_subs.id)*fnb_sales_subs.qty)                          as sales,

  $data['restaurant_locations']= fnb_restaurant_location::where('status',1)->get();
  $data['table_defs']= fnb_table_definition::where('status',1)->orderBy('id')->get();
  $data['waiter_defs']= fnb_waitor_definition::where('status',1)->get();
  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
      $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

     return $data;*/
	}


	public function dumpitems_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/finance-and-management/daily-dump-items/daily-dump-items-vue');
	}

	public function dumpitems_init_vue(Request $request)
	{
		$start_date = date('Y-m-d');
		$end_date = date('Y-m-d');
		if ($request->start_date) {
			$start_date = formatDate($request->start_date);
			if (strtotime($start_date) < strtotime(settings('fnb_due'))) {
				$start_date = settings('fnb_due');
			}
		}
		if ($request->end_date) {
			$end_date = formatDate($request->end_date);
		}
		$search = '';
		$search2 = '';
		$search3 = '';
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}
		if ($request->waiter) {
			$search .= ' and fnb_sales.waiter_definition in (' . $request->waiter . ') ';
		}
		if ($request->tables) {
			$search .= ' and fnb_sales.table_definition in (' . $request->tables . ') ';
		}
		if ($request->cashier) {
			$search .= ' and fnb_sales.created_by in (' . $request->cashier . ') ';
		}
		if ($request->category) {
			$search2 .= ' and fnb_item_categories.id in (' . $request->category . ') ';
		}
		if ($request->sub_category) {
			$search2 .= ' and fnb_item_sub_categories.id in (' . $request->sub_category . ') ';
		}
		if ($request->item) {
			$search2 .= ' and fnb_item_definitions.id in (' . $request->item . ') ';
		}
		if ($request->item_code) {
			$search2 .= ' and fnb_item_definitions.item_code in (' . $request->item_code . ') ';
		}
		if ($request->mem) {
			$search .= ' and fnb_sales.customer_id in (' . $request->mem . ') ';
		}
		if ($request->mog != 2) {
			$search .= ' and fnb_sales.type=' . $request->mog . ' ';
		}
		if ($request->discounted == 1) {
			$search3 .= ' and fnb_sales_subs.item_discount >0 ';
		}
		if ($request->cancelledby) {
			$search3 .= ' and fnb_sales_subs.updated_by in (' . $request->cancelledby . ') ';
		}
		if ($request->discounted == 2) {
			$search3 .= ' and fnb_sales.tax >0 ';
		}
		if ($request->r) {

			$data['sales'] = \Illuminate\Support\Facades\DB::select(
				'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
         fnb_item_definitions.id,
       fnb_item_definitions.sale_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       fnb_sales.id                   as sale_id,
       fnb_restaurant_locations.desc as resturants,
      fnb_table_definitions.desc    as tables,
       fnb_waitor_definitions.name   as waitor,
       fnb_sales_subs.qty                         as sales,
       fnb_sales_subs.status                         as status,
       fnb_sales_subs.instruction                    as instruction,
       fnb_sales_subs.remark                         as remark,
       fnb_sales_subs.aftercancel                    as aftercancel,
        fnb_sales_subs.kot_no                    as kot_no,
       sum( fnb_sales_subs.item_discount)              as discount,
       fnb_sales.date                 as dda,
      fnb_sales.invoice_no                  as invoice_no,
       users.name                  as cancelledby

from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id in (select id from fnb_sales where  deleted_at is null ' . $search . ' ) and
                                           DATE(fnb_sales_subs.date) <= "' . $end_date . '" and
                                           DATE(fnb_sales_subs.date) >= "' . $start_date . '" ' . $search3 . '
                                          and fnb_sales_subs.status="Cancelled"
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
          left outer join users on users.id =fnb_sales_subs.updated_by and users.status=1
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales.completed>0 ' . $search2 . '
group by fnb_item_definitions.id,fnb_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc'
			);
		}
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		$data['table_defs'] = fnb_table_definition::where('status', 1)->orderBy('id')->get();
		$data['waiter_defs'] = fnb_waitor_definition::where('status', 1)->get();
		$data['category'] = fnb_item_category::where('status', 1)->get();
		$data['sub_category'] = fnb_item_sub_category::where('status', 1)->get();
		$data['items'] = fnb_item_definition::where('status', 1)->get();
		$data['created_by'] = User::where('status', 1)->get();
		if (Auth::user()->can('Export Daily Dump Items List')) {
			$data['exported'] = 1;
		}

		return $data;
		/* $start_date=date('Y-m-d');
        $end_date=date('Y-m-d');
        if($request->start_date){
            $start_date=formatDate($request->start_date);
        }
        if($request->end_date){
            $end_date=formatDate($request->end_date);

        }
        $search ='';
        $search2 ='';
        if($request->resturants){
            $search.=' and fnb_sales.restaurant_location in ('.$request->resturants.') ';
        }   if($request->waiter){
            $search.=' and fnb_sales.waiter_definition in ('.$request->waiter.') ';
        }if($request->tables){
            $search.=' and fnb_sales.table_definition in ('.$request->tables.') ';
        }if($request->cashier){
            $search.=' and fnb_sales.created_by in ('.$request->cashier.') ';
        }if($request->category){
            $search2.=' and fnb_item_categories.id in ('.$request->category.') ';
        }if($request->sub_category){
            $search2.=' and fnb_item_sub_categories.id in ('.$request->sub_category.') ';
        }
        if($request->item_code){
            $search2.=' and fnb_item_definitions.item_code in ('.$request->item_code.') ';
        }
         if($request->item){
            $search2.=' and fnb_item_definitions.id in ('.$request->item.') ';
        }
        if($request->mem){
        $search.=' and fnb_sales.customer_id in ('.$request->mem.') and type='.$request->mog.' ';
        }
        if($request->r){


  $data['sales'] =\Illuminate\Support\Facades\DB::select(
      'select fnb_item_definitions.item_details,
       fnb_item_definitions.item_code,
       fnb_item_definitions.id,
       fnb_item_definitions.sale_price,
       fnb_item_categories.desc                               as cat,
       fnb_item_sub_categories.`desc`                         as sub,
       fnb_sales.id                   as sale_id,
       fnb_restaurant_locations.desc as resturants,
      fnb_table_definitions.desc    as tables,
       fnb_waitor_definitions.name   as waitor,
       fnb_sales_subs.qty                         as sales,
       fnb_sales_subs.status                         as status,
       fnb_sales_subs.instruction                    as instruction,
       fnb_sales_subs.remark                         as remark,
       fnb_sales_subs.aftercancel                    as aftercancel,
        fnb_sales_subs.kot_no                    as kot_no,
       sum( fnb_sales_subs.item_discount)              as discount,
       fnb_sales.date                 as dda,
      fnb_sales.invoice_no                  as invoice_no


from fnb_item_definitions
         left outer join fnb_item_categories on fnb_item_categories.id = fnb_item_definitions.category
         left outer join fnb_item_sub_categories on fnb_item_sub_categories.id = fnb_item_definitions.sub_category
         left outer join fnb_sales_subs on fnb_sales_subs.item_code = fnb_item_definitions.item_code  and fnb_sales_subs.sales_id  in (select id from fnb_sales where completed!=0 and deleted_at is null '.$search.' and
                                           DATE(fnb_sales.date) <= "'.$end_date.'" and
                                           DATE(fnb_sales.date) >= "'.$start_date.'")
         left outer join fnb_sales on fnb_sales.id = fnb_sales_subs.sales_id
         left outer join fnb_restaurant_locations on fnb_restaurant_locations.id = fnb_sales.restaurant_location
         left outer join fnb_table_definitions on fnb_table_definitions.id = fnb_sales.table_definition and
                                                  fnb_table_definitions.restaurant_location = fnb_restaurant_locations.id
         left outer join fnb_waitor_definitions on fnb_sales.waiter_definition = fnb_waitor_definitions.id
where fnb_item_definitions.deleted_at is null and fnb_sales.id is not null and fnb_sales_subs.status="Cancelled"'.$search2.'
group by fnb_item_definitions.id,fnb_sales_subs.item_code
order by cat,sub,fnb_item_definitions.item_details asc');
        }

  $data['restaurant_locations']= fnb_restaurant_location::where('status',1)->get();
  $data['table_defs']= fnb_table_definition::where('status',1)->orderBy('id')->get();
  $data['waiter_defs']= fnb_waitor_definition::where('status',1)->get();
  $data['category']= fnb_item_category::where('status',1)->get();
  $data['sub_category']= fnb_item_sub_category::where('status',1)->get();
     $data['items']= fnb_item_definition::where('status',1)->get();
  $data['created_by']= User::where('status',1)->get();

     return $data;*/
	}




	public function soldquantityreport(Request $request, fnb_sale $fnb_sale)
	{

		$data['start_date'] = $request->get('start_date');

		$data['end_date'] = $request->get('end_date');
		$data['categorysearch'] = fnb_item_category::where('status', 1)->get();
		$data['itemssearch'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();

		if ($request->get('catsearch')) {
			$data['chosencat'] = $request->get('catsearch');
		} else {
			$data['chosencat'] = [];
		}

		if ($request->get('itemsearch')) {
			$data['chosenitem'] = $request->get('itemsearch');
		} else {
			$data['chosenitem'] = [];
		}


		if ($request->get('catsearch')) {
			$data['categories'] = fnb_item_category::where('status', 1)->whereIn('id', $request->get('catsearch'))->get();
		} else {
			$data['categories'] = fnb_item_category::where('status', 1)->get();
		}



		if ($request->get('itemsearch')) {
			$data['itemdefinitions'] = fnb_item_definition::where('status', 1)->where('salable', 1)->whereIn('id', $request->get('itemsearch'))->get();
		} else {
			$data['itemdefinitions'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();
		}

		$data['salessubs'] = fnb_sales_subs::with('saleid')->where('status', NULL)->get();
		//dd($data['salessubs']);

		return view('backend/finance-and-management/sold-quantity-report/sold-quantity-report', $data);
	}



	public function dailydumpitems(Request $request, fnb_sale $fnb_sale)
	{
		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();
		if ($request->get('restsearch')) {
			$data['chosenrest'] = $request->get('restsearch');
		} else {
			$data['chosenrest'] = [];
		}

		$data['start_date'] = $request->get('start_date');
		$data['end_date'] = $request->get('end_date');

		$data['salessubs'] = fnb_sales_subs::with('saleid')->where('status', 'Cancelled')->get();
		$data['itemdefinitions'] = fnb_item_definition::where('status', 1)->where('salable', 1)->get();

		if ($request->get('restsearch')) {
			$data['restaurants'] = fnb_restaurant_location::where('status', 1)->whereIn('id', $request->get('restsearch'))->get();
		} else {
			$data['restaurants'] = fnb_restaurant_location::where('status', 1)->get();
		}


		return view('backend/finance-and-management/daily-dump-items/daily-dump-items', $data);
	}


	public function runningkitchenorder(Request $request, fnb_sale $fnb_sale)
	{

		if (!$request->get('restaurant')) {
			$data['rest_search'] = 0;
		} else {
			$data['rest_search'] = $request->get('restaurant');
		}


		if (!$request->get('invdate')) {
			$data['sales'] = fnb_sale::where('completed', 0)->where('confirmed', 0)->get();

			$data['date_search'] = '';
		} else {
			$data['sales'] = fnb_sale::where('completed', 0)->where('confirmed', 0)->where('date', formatDate($request->get('invdate')))->get();

			$data['date_search'] = $request->get('invdate');
		}


		$data['salessubs'] = fnb_sales_subs::with(['saleid' => function ($query) {
			$query->where('completed', 0)->where('confirmed', 0);
		}])->orderBy('kot_no')->get();



		$data['restaurants'] = fnb_restaurant_location::where('status', 1)->get();

		return view('backend/food-and-beverage/running-kitchen-order/running-kitchen-order', $data);
	}


	public function running_vue(Request $request, fnb_sale $fnb_sale)
	{
		return view('backend/food-and-beverage/running-kitchen-order/running-kitchen-order-vue');
	}
	public function running_init_vue(Request $request)
	{

		$search = '';

		if ($request->get('start_date')) {
			$search .= ' and fnb_sales.date >="' . $request->get('start_date') . '"';
		}
		if ($request->get('end_date')) {
			$search .= ' and fnb_sales.date <="' . $request->get('end_date') . '"';
		}
		if ($request->resturants) {
			$search .= ' and fnb_sales.restaurant_location in (' . $request->resturants . ') ';
		}



		$data['sales'] = \Illuminate\Support\Facades\DB::select(
			'select fnb_sales.id,
       fnb_sales.invoice_no,
       fnb_sales.date,
       fnb_sales.time,
       fnb_sales.restaurant_location,
      fnb_table_definitions.desc as tabledef
      
 
from fnb_sales
 
left outer join fnb_table_definitions on fnb_table_definitions.id=fnb_sales.table_definition
 
where fnb_sales.completed=0 and fnb_sales.confirmed=0   and fnb_sales.deleted_at is null  ' . $search . '  group by fnb_sales.id order by fnb_sales.id asc'
		);

		$data['subs'] = \Illuminate\Support\Facades\DB::select(
			'select fnb_sales_subs.sales_id,
      fnb_sales_subs.kot_no,
      fnb_sales_subs.qty,
      fnb_sales_subs.item_code,
      fnb_sales_subs.item_details,
       fnb_sales.restaurant_location
 
from fnb_sales_subs
 
left outer join fnb_sales on fnb_sales.id=fnb_sales_subs.sales_id
 
where fnb_sales.completed=0 and fnb_sales.confirmed=0   and fnb_sales.deleted_at is null  ' . $search . '  group by fnb_sales_subs.id order by fnb_sales_subs.id,fnb_sales_subs.kot_no  asc'
		);


		$data['restaurant_locations'] = fnb_restaurant_location::where('status', 1)->get();

		return $data;
	}







	public function runningsalesorder(Request $request, fnb_sale $fnb_sale)
	{


		if (!$request->get('restaurant')) {
			$data['rest_search'] = 0;
		} else {
			$data['rest_search'] = $request->get('restaurant');
		}

		if (!$request->get('cashier')) {
			$data['cash_search'] = 0;
		} else {
			$data['cash_search'] = $request->get('cashier');
		}

		if (!$request->get('invdate')) {
			$data['sales'] = fnb_sale::with('member')->where('completed', 0)->get();

			$data['date_search'] = '';
		} else {
			$data['sales'] = fnb_sale::with('member')->where('completed', 0)->where('date', formatDate($request->get('invdate')))->get();

			$data['date_search'] = $request->get('invdate');
		}

		$data['restaurants'] = fnb_restaurant_location::where('status', 1)->get();
		$data['cashiers'] = User::where('status', 1)->get();

		return view('backend/food-and-beverage/running-sales-order/running-sales-order', $data);
	}

	// REPORTS

	public function shifts_vue()
	{
		return view('backend/food-and-beverage.shifts.shifts');
	}



	public function user_shifts_vue()
	{
		return view('backend/food-and-beverage.shifts.user-shifts');
	}

	public function user_shifts_init(Request $request)
	{
		if (fnb_user_shifts::where('user_id', Auth::id())->get()->count() != 0) {
			$data['shift'] = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
		} else {
			$data['shift'] = [];
		}
		$removal = array();


		$userids = User::get()->pluck('id');


		foreach ($userids as $d) {
			if ($d) {
				$redd = fnb_user_shifts::where('user_id', $d)->latest('id')->first();

				if ($redd && $redd->in_out == 0) {
					$removal[] = $redd->pos_location;
				}
			}
		}


        $data['alllocs'] = trans_type::where('type', 6)->get();

		return $data;
	}

	public function start_user_shift(Request $request)
	{

		$d = [];
		$d['user_id'] = Auth::id();
		$d['pos_location'] = $request->get('pos_location');
		$d['in_out'] = 0;

		$id =  fnb_user_shifts::create($d);
	}
	public function end_user_shift(Request $request)
	{

		$d = [];
		$d['user_id'] = Auth::id();
		$d['pos_location'] = $request->get('pos_location');
		$d['in_out'] = 1;

		$id =  fnb_user_shifts::create($d);
	}

	public function check_user_shift(Request $request)
	{

		$data['shifts'] = fnb_user_shifts::where('user_id', Auth::id())->latest('id')->first();
		if ($data['shifts'] && $data['shifts']->in_out == 0) {
			return 1;
		} else {
			return 0;
		}
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
}
