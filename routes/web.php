
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('getDatabases',function () {
    $databases = \DB::select('SHOW DATABASES');
    return response()->json(['status' => 'success', 'result' => $databases]);
});
Route::group(['middleware' => ['checkdatabase']], function () {
    Route::middleware('auth')->group(function () {
        Route::get('members-access/search-member-status', 'AccessSearchMembersController@searchstatus');

        Route::get('/', function () {
            return view('backend/home');
        });
        Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);


    // SEARCH MEMBER / GUEST 
    Route::post('search/corporatemem/data', 'SearchMemberGuestController@comemdata');
    Route::post('search/corporatemem/datalike', 'SearchMemberGuestController@comemdatalike');

    Route::post('search/customerdata', 'SearchMemberGuestController@customerdata');
    Route::post('search/salescustomerdata', 'SearchMemberGuestController@salescustomerdata');
    Route::post('search/customerdatalike', 'SearchMemberGuestController@customerdatalike');
    Route::post('search/itemsdata', 'SearchMemberGuestController@itemsdata');
    Route::post('search/itemsdataenter', 'SearchMemberGuestController@itemsdataenter');
    Route::post('search/itemsdatalike', 'SearchMemberGuestController@itemsdatalike');
    Route::post('search/discountdata', 'SearchMemberGuestController@discountdata');
    Route::post('search/discountdatalike', 'SearchMemberGuestController@discountdatalike');
    Route::post('search/employeedatalike', 'SearchMemberGuestController@employeedatalike');
    Route::post('search/itemsearchdata', 'SearchMemberGuestController@itemsearchdata');
    Route::post('search/itemsearchdatalike', 'SearchMemberGuestController@itemsearchdatalike');
    Route::post('search/designationdata', 'SearchMemberGuestController@designationdata');
    Route::post('search/designationdatalike', 'SearchMemberGuestController@designationdatalike');
    Route::post('search/empdata', 'SearchMemberGuestController@empdata');
    Route::post('search/empdatalike', 'SearchMemberGuestController@empdatalike');



    Route::post('search/purchasedata', 'SearchMemberGuestController@purchasedata');
    Route::post('search/purchasedatalike', 'SearchMemberGuestController@purchasedatalike');


    Route::post('search/coa/unitdata', 'SearchMemberGuestController@unitdata');
    Route::post('search/coa/unitsdatalike', 'SearchMemberGuestController@unitsdatalike');
    Route::post('search/coa/accountdata', 'SearchMemberGuestController@accountdata');
    Route::post('search/coa/accountdatalike', 'SearchMemberGuestController@accountdatalike');

    Route::post('search/coa/coaaccountdata', 'SearchMemberGuestController@coaaccountdata');
    Route::post('search/coa/coaaccountdatalike', 'SearchMemberGuestController@coaaccountdatalike');

    Route::post('search/coa/expaccountdata', 'SearchMemberGuestController@coaaccountdata');
    Route::post('search/coa/expaccountdatalike', 'SearchMemberGuestController@expaccountdatalike');
    Route::post('search/coa/cashbankdatalike', 'SearchMemberGuestController@cashbankdatalike');

    Route::post('search/coa/childdata', 'SearchMemberGuestController@childdata');
    Route::post('search/coa/childdatalike', 'SearchMemberGuestController@childdatalike');

    Route::post('search/coa/pmdata', 'SearchMemberGuestController@pmdata');
    Route::post('search/coa/pmdatalike', 'SearchMemberGuestController@pmdatalike');

    Route::post('search/storeitemsdata', 'SearchMemberGuestController@storeitemsdata');
    Route::post('search/storeitemsdataenter', 'SearchMemberGuestController@storeitemsdataenter');
    Route::post('search/storeitemsdatalike', 'SearchMemberGuestController@storeitemsdatalike');

    Route::post('search/storesalesitemsdata', 'SearchMemberGuestController@storesalesitemsdata');
    Route::post('search/storesalesitemsdataenter', 'SearchMemberGuestController@storesalesitemsdataenter');
    Route::post('search/storesalesitemsdatalike', 'SearchMemberGuestController@storesalesitemsdatalike');

    Route::post('search/storeissueitemsdata', 'SearchMemberGuestController@storeissueitemsdata');
    Route::post('search/storeissueitemsdatacs', 'SearchMemberGuestController@storeissueitemsdatacs');

    Route::post('search/storeissueitemsdataenter', 'SearchMemberGuestController@storeissueitemsdataenter');
    Route::post('search/storeissueitemsdatalike', 'SearchMemberGuestController@storeissueitemsdatalike');

    Route::post('search/famcustomerdata', 'SearchMemberGuestController@famcustomerdata');
    Route::post('search/famcustomerdatalike', 'SearchMemberGuestController@famcustomerdatalike');
    Route::post('create/guestid', 'SearchMemberGuestController@guestid');
    Route::post('search/cakebookingdatalike', 'SearchMemberGuestController@cakebookingdatalike');
    Route::post('search/cakebookingdata', 'SearchMemberGuestController@cakebookingdata');
    Route::post('search/reservationdatalike', 'SearchMemberGuestController@reservationdatalike');
    Route::post('search/reservationdata', 'SearchMemberGuestController@reservationdata');
    // SEARCH MEMBER / GUESTcakebookingdata




    Route::group(['middleware' => ['permission:View Revenue Dashboard']], function () {
        Route::get('dashboards/revenue-dashboard-vue', 'CrmLeadController@dash_vue');
        Route::get('dashboards/revenue-dashboard/dash_init_vue', 'CrmLeadController@dash_init_vue');
    });


    // MEMBERHSIP STATUS CONFIRMATION
    Route::group(['middleware' => ['permission:View Membership Status Confirmation']], function () {
    Route::get('members-access/confirm-membership-status', 'AccessSearchMembersController@searchstatus');
    });
    // MEMBERHSIP STATUS CONFIRMATION

        Route::group(['middleware' => ['permission:View Admin Settings']], function () {
            Route::get('admin-settings', function () {
                return view('backend/admin-settings/admin-settings');
            });
        });
        Route::group(['middleware' => ['permission:View Dashboards']], function () {
            Route::get('dashboards', function () {
                return view('backend/dashboards/dashboards');
            });
        });
        Route::group(['middleware' => ['permission:View General Sales']], function () {
            Route::get('sales', function () {
                return view('backend/finance-and-management/finance-invoices-sales');
            });
            Route::get('sales/definitions', function () {
                return view('backend/sales/sales-definitions');
            });
        });
        Route::group(['middleware' => ['permission:View User Rights']], function () {
            Route::get('user-rights', function () {
                return view('backend/admin-settings/user-rights');
            });
            Route::get('user-rights/definitions', function () {
                return view('backend/admin-settings/user-rights-definitions');
            });
        });
        Route::group(['middleware' => ['permission:View Users']], function () {
            Route::get('admin-settings/users', 'UserController@index');
        });
        Route::post('admin-settings/users', 'UserController@indexdt')->name('users.datatable');
        Route::group(['middleware' => ['permission:Add Users']], function () {
            Route::get('admin-settings/users/users-aeu', 'UserController@create');
        });
        Route::post('admin-settings/users/users-aeu', 'UserController@store');
        Route::group(['middleware' => ['permission:Edit Users']], function () {
            Route::get('admin-settings/users/users-aeu/{id}', 'UserController@edit');
        });
        Route::post('admin-settings/users/update/{id}', 'UserController@update');
        Route::group(['middleware' => ['permission:Edit Users']], function () {
            Route::get('admin-settings/users/users-aeu/{id}', 'UserController@edit');
        });
        Route::group(['middleware' => ['permission:Delete Users']], function () {
            Route::get('admin-settings/users/delete/{id}', 'UserController@destroy');
        });
        Route::group(['middleware' => ['permission:View Deleted Users']], function () {
            Route::get('admin-settings/users/deleted', 'UserController@index_deleted');
            Route::post('admin-settings/users/deleted', 'UserController@indexdt_deleted')->name('users_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Users']], function () {
        Route::get('admin-settings/users/restore/{id}', 'UserController@restore');
        });
        Route::group(['middleware' => ['permission:View Users']], function () {
        Route::resource('users', 'UserController');
        });

    // ASSIGN ROLES
        Route::group(['middleware' => ['permission:Assign Roles']], function () {
            Route::get('admin-settings/assign-roles', 'UserController@index_assign');
            Route::post('admin-settings/assign-roles', 'UserController@indexdt_assign')->name('assign_roles.datatable');

            Route::get('admin-settings/assign-roles/assign-roles-aeu/{id}', 'UserController@edit_assign');
            Route::post('admin-settings/assign-roles/update/{id}', 'UserController@update_assign')->name('assign_roles_update');
        });
    // ASSIGN ROLES


        Route::group(['middleware' => ['permission:View Roles']], function () {
            Route::get('admin-settings/roles', 'RolesController@index');
        });
        Route::post('admin-settings/roles', 'RolesController@indexdt')->name('roles.datatable');
        Route::group(['middleware' => ['permission:Add Roles']], function () {
            Route::get('admin-settings/roles/roles-aeu', 'RolesController@create');
        });
        Route::post('admin-settings/roles/roles-aeu', 'RolesController@store');
        Route::group(['middleware' => ['permission:Edit Roles']], function () {
            Route::get('admin-settings/roles/roles-aeu/{id}', 'RolesController@edit');
        });
        Route::post('admin-settings/roles/update/{id}', 'RolesController@update');
        Route::resource('roles', 'RolesController');



        Route::group(['middleware' => ['permission:View Permissions']], function () {
            Route::get('admin-settings/permissions', 'PermissionsController@index');
        });
        Route::post('admin-settings/permissions', 'PermissionsController@indexdt')->name('permissions.datatable');
        Route::group(['middleware' => ['permission:Add Permissions']], function () {
            Route::get('admin-settings/permissions/permissions-aeu', 'PermissionsController@create');
        });
        Route::post('admin-settings/permissions/permissions-aeu', 'PermissionsController@store');
        Route::group(['middleware' => ['permission:Edit Permissions']], function () {
            Route::get('admin-settings/permissions/permissions-aeu/{id}', 'PermissionsController@edit');
        });
        Route::post('admin-settings/permissions/update/{id}', 'PermissionsController@update');


    /*Permission Categories Routes*/
    Route::group(['middleware' => ['permission:View Permission Categories']], function () {
        Route::get('admin-settings/permission-categories', 'PermissionCategoryController@index');
        Route::post('admin-settings/permission-categories', 'PermissionCategoryController@indexdt')->name('permissioncategories.datatable');
    });
    Route::group(['middleware' => ['permission:Add Permission Categories']], function () {
        Route::get('admin-settings/permission-categories/permission-categories-aeu', 'PermissionCategoryController@create');
        Route::post('admin-settings/permission-categories/permission-categories-aeu', 'PermissionCategoryController@store');
    });
    Route::group(['middleware' => ['permission:Edit Permission Categories']], function () {
        Route::get('admin-settings/permission-categories/permission-categories-aeu/{id}', 'PermissionCategoryController@edit');
        Route::post('admin-settings/permission-categories/update/{id}', 'PermissionCategoryController@update');
    });
    Route::group(['middleware' => ['permission:Delete Permission Categories']], function () {
        Route::get('admin-settings/permission-categories/delete/{id}', 'PermissionCategoryController@destroy');
    });
    Route::group(['middleware' => ['permission:View Deleted Permission Categories']], function () {
        Route::get('admin-settings/permission-categories/deleted', 'PermissionCategoryController@index_deleted');
        Route::post('admin-settings/permission-categories/deleted', 'PermissionCategoryController@indexdt_deleted')->name('permissioncategories_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Permission Categories']], function () {
        Route::get('admin-settings/permission-categories/restore/{id}', 'PermissionCategoryController@restore');
        });
    /*Permission Categories Routes*/



        Route::group(['middleware' => ['permission:View Company Profile']], function () {
            Route::get('admin-settings/profile', 'AdminCompanyProfileController@index');
        });
        Route::post('admin-settings/profile', 'AdminCompanyProfileController@indexdt')->name('profile.datatable');
        Route::group(['middleware' => ['permission:Add Company Profile']], function () {
            Route::get('admin-settings/profile/profile-aeu', 'AdminCompanyProfileController@create');
        });
        Route::post('admin-settings/profile/profile-aeu', 'AdminCompanyProfileController@store');
        Route::group(['middleware' => ['permission:Edit Company Profile']], function () {
            Route::get('admin-settings/profile/profile-aeu/{id}', 'AdminCompanyProfileController@edit');
        });
        Route::post('admin-settings/profile/update/{id}', 'AdminCompanyProfileController@update');


        Route::group(['middleware' => ['permission:View Club Membership Management']], function () {
            Route::get('club-hospitality', function () {
                return view('backend/club-hospitality/club-hospitality');
            });
            Route::get('club-hospitality/definitions', function () {
                return view('backend/club-hospitality/club-hospitality-definitions');
            });
        });
        /*Member Relationship Routes*/
    Route::group(['middleware' => ['permission:View Member Relations']], function () {
            Route::get('club-hospitality/member-relation', 'MemRelationController@index');
            Route::post('club-hospitality/member-relation', 'MemRelationController@indexdt')->name('relation.datatable');
        });
    Route::group(['middleware' => ['permission:Add Member Relations']], function () {
            Route::get('club-hospitality/member-relation/members-relation-aeu', 'MemRelationController@create');
            Route::post('club-hospitality/member-relation/members-relation-aeu', 'MemRelationController@store');
        });
    Route::group(['middleware' => ['permission:View Deleted Member Relations']], function () {
            Route::get('club-hospitality/member-relation/deleted', 'MemRelationController@index_deleted');
            Route::post('club-hospitality/member-relation/deleted', 'MemRelationController@indexdt_deleted')->name('relation_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Edit Member Relations']], function () {
            Route::get('club-hospitality/member-relation/members-relation-aeu/{id}', 'MemRelationController@edit');
        });
    Route::post('club-hospitality/member-relation/update/{id}', 'MemRelationController@update');
    Route::group(['middleware' => ['permission:Delete Member Relations']], function () {
            Route::get('club-hospitality/member-relation/delete/{id}', 'MemRelationController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Member Relations']], function () {
    Route::get('club-hospitality/member-relation/restore/{id}', 'MemRelationController@restore');
    });
        /*Member Relationship Routes*/


        /*Member Classification*/
        Route::group(['middleware' => ['permission:View Member Type']], function () {
            Route::get('club-hospitality/member-classification', 'MemClassificationController@index');
            Route::post('club-hospitality/member-classification', 'MemClassificationController@indexdt')->name('classification.datatable');
        });
        Route::group(['middleware' => ['permission:Add Member Type']], function () {
            Route::get('club-hospitality/member-classification/member-classification-aeu', 'MemClassificationController@create');
            Route::post('club-hospitality/member-classification/member-classification-aeu', 'MemClassificationController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Member Types']], function () {
            Route::get('club-hospitality/member-classification/deleted', 'MemClassificationController@index_deleted');
            Route::post('club-hospitality/member-classification/deleted', 'MemClassificationController@indexdt_deleted')->name('classification_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Member Type']], function () {
            Route::get('club-hospitality/member-classification/member-classification-aeu/{id}', 'MemClassificationController@edit');
        });
        Route::post('club-hospitality/member-classification/update/{id}', 'MemClassificationController@update');
        Route::group(['middleware' => ['permission:Delete Member Type']], function () {
            Route::get('club-hospitality/member-classification/delete/{id}', 'MemClassificationController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Member Type']], function () {
        Route::get('club-hospitality/member-classification/restore/{id}', 'MemClassificationController@restore');
        });
        /*Member Classification*/


        /*Member Category*/
        Route::group(['middleware' => ['permission:View Membership Category']], function () {
        Route::get('club-hospitality/member-category', 'MemCategoryController@index');
        Route::post('club-hospitality/member-category', 'MemCategoryController@indexdt')->name('category.datatable');
        });
        Route::group(['middleware' => ['permission:Add Membership Category']], function () {
            Route::get('club-hospitality/member-category/member-category-aeu', 'MemCategoryController@create');
            Route::post('club-hospitality/member-category/member-category-aeu', 'MemCategoryController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Membership Categories']], function () {
            Route::get('club-hospitality/member-category/deleted', 'MemCategoryController@index_deleted');
            Route::post('club-hospitality/member-category/deleted', 'MemCategoryController@indexdt_deleted')->name('category_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Membership Category']], function () {
            Route::get('club-hospitality/member-category/member-category-aeu/{id}', 'MemCategoryController@edit');
            Route::post('club-hospitality/member-category/update/{id}', 'MemCategoryController@update');
        });
        Route::group(['middleware' => ['permission:Delete Membership Category']], function () {
            Route::get('club-hospitality/member-category/delete/{id}', 'MemCategoryController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Membership Category']], function () {
        Route::get('club-hospitality/member-category/restore/{id}', 'MemCategoryController@restore');
        });
        /*Member Category*/




        /*Corporate Companies*/
        Route::group(['middleware' => ['permission:View Corporate Companies']], function () {
        Route::get('club-hospitality/corporate-companies', 'MemCorporateCompaniesController@index');
        Route::post('club-hospitality/corporate-companies', 'MemCorporateCompaniesController@indexdt')->name('corporate.datatable');
        });
        Route::group(['middleware' => ['permission:Add Corporate Companies']], function () {
            Route::get('club-hospitality/corporate-companies/corporate-companies-aeu', 'MemCorporateCompaniesController@create');
            Route::post('club-hospitality/corporate-companies/corporate-companies-aeu', 'MemCorporateCompaniesController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Corporate Companies']], function () {
            Route::get('club-hospitality/corporate-companies/deleted', 'MemCorporateCompaniesController@index_deleted');
            Route::post('club-hospitality/corporate-companies/deleted', 'MemCorporateCompaniesController@indexdt_deleted')->name('corporate_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Corporate Companies']], function () {
            Route::get('club-hospitality/corporate-companies/corporate-companies-aeu/{id}', 'MemCorporateCompaniesController@edit');
            Route::post('club-hospitality/corporate-companies/update/{id}', 'MemCorporateCompaniesController@update');
        });
        Route::group(['middleware' => ['permission:Delete Corporate Companies']], function () {
            Route::get('club-hospitality/corporate-companies/delete/{id}', 'MemCorporateCompaniesController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Corporate Companies']], function () {
        Route::get('club-hospitality/corporate-companies/restore/{id}', 'MemCorporateCompaniesController@restore');
        });
    /*Corporate Companies*/


        /*Club Facilities*/
        Route::group(['middleware' => ['permission:View Club Facilities']], function () {
        Route::get('sports-subscription/club-facilities', 'MemClubFacilitiesController@index');
        Route::post('sports-subscription/club-facilities', 'MemClubFacilitiesController@indexdt')->name('facility.datatable');
        });
        Route::group(['middleware' => ['permission:Add Club Facilities']], function () {
        Route::get('sports-subscription/club-facilities/club-facilities-aeu', 'MemClubFacilitiesController@create');
        Route::post('sports-subscription/club-facilities/club-facilities-aeu', 'MemClubFacilitiesController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Club Facilities']], function () {
            Route::get('sports-subscription/club-facilities/deleted', 'MemClubFacilitiesController@index_deleted');
            Route::post('sports-subscription/club-facilities/deleted', 'MemClubFacilitiesController@indexdt_deleted')->name('facility_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Club Facilities']], function () {
        Route::get('sports-subscription/club-facilities/club-facilities-aeu/{id}', 'MemClubFacilitiesController@edit');
        });
        Route::post('sports-subscription/club-facilities/update/{id}', 'MemClubFacilitiesController@update');
        Route::group(['middleware' => ['permission:Delete Club Facilities']], function () {
            Route::get('sports-subscription/club-facilities/delete/{id}', 'MemClubFacilitiesController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Club Facilities']], function () {
        Route::get('sports-subscription/club-facilities/restore/{id}', 'MemClubFacilitiesController@restore');
        });
        /*Club Facilities*/



        //MEMBERSHIP STATUS
    Route::group(['middleware' => ['permission:View Membership Status']], function () {
            Route::get('club-hospitality/membership-status', 'MemStatusController@index');
            Route::post('club-hospitality/membership-status', 'MemStatusController@indexdt')->name('membership_status.datatable');
        });
    Route::group(['middleware' => ['permission:Add Membership Status']], function () {
            Route::get('club-hospitality/membership-status/membership-status-aeu', 'MemStatusController@create');
            Route::post('club-hospitality/membership-status/membership-status-aeu', 'MemStatusController@store');
        });
    Route::group(['middleware' => ['permission:Edit Membership Status']], function () {
            Route::get('club-hospitality/membership-status/membership-status-aeu/{id}', 'MemStatusController@edit');
            Route::post('club-hospitality/membership-status/update/{id}', 'MemStatusController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Membership Status']], function () {
            Route::get('club-hospitality/membership-status/deleted', 'MemStatusController@index_deleted');
            Route::post('club-hospitality/membership-status/deleted', 'MemStatusController@indexdt_deleted')->name('membership_status_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Membership Status']], function () {
            Route::get('club-hospitality/membership-status/delete/{id}', 'MemStatusController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Membership Status']], function () {
            Route::get('club-hospitality/membership-status/restore/{id}', 'MemStatusController@restore');
        });
        //MEMBERSHIP STATUS


    //MEMBER TITLES
    Route::group(['middleware' => ['permission:View Member Title']], function () {
            Route::get('club-hospitality/member-title', 'MemTitleController@index');
            Route::post('club-hospitality/member-title', 'MemTitleController@indexdt')->name('member_title.datatable');
        });
    Route::group(['middleware' => ['permission:Add Member Title']], function () {
            Route::get('club-hospitality/member-title/member-title-aeu', 'MemTitleController@create');
            Route::post('club-hospitality/member-title/member-title-aeu', 'MemTitleController@store');
        });
    Route::group(['middleware' => ['permission:Edit Member Title']], function () {
            Route::get('club-hospitality/member-title/member-title-aeu/{id}', 'MemTitleController@edit');
            Route::post('club-hospitality/member-title/update/{id}', 'MemTitleController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Member Title']], function () {
            Route::get('club-hospitality/member-title/deleted', 'MemTitleController@index_deleted');
            Route::post('club-hospitality/member-title/deleted', 'MemTitleController@indexdt_deleted')->name('member_title_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Member Title']], function () {
            Route::get('club-hospitality/member-title/delete/{id}', 'MemTitleController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Member Title']], function () {
            Route::get('club-hospitality/member-title/restore/{id}', 'MemTitleController@restore');
        });
        //MEMBERSHIP TITLES


    //MEMBER OCCUPATIONS
    Route::group(['middleware' => ['permission:View Member Occupation']], function () {
            Route::get('club-hospitality/member-occupations', 'MemOccupationController@index');
            Route::post('club-hospitality/member-occupations', 'MemOccupationController@indexdt')->name('member_occupation.datatable');
        });
    Route::group(['middleware' => ['permission:Add Member Occupation']], function () {
            Route::get('club-hospitality/member-occupations/member-occupations-aeu', 'MemOccupationController@create');
            Route::post('club-hospitality/member-occupations/member-occupations-aeu', 'MemOccupationController@store');
        });
    Route::group(['middleware' => ['permission:Edit Member Occupation']], function () {
            Route::get('club-hospitality/member-occupations/member-occupations-aeu/{id}', 'MemOccupationController@edit');
            Route::post('club-hospitality/member-occupations/update/{id}', 'MemOccupationController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Member Occupations']], function () {
            Route::get('club-hospitality/member-occupations/deleted', 'MemOccupationController@index_deleted');
            Route::post('club-hospitality/member-occupations/deleted', 'MemOccupationController@indexdt_deleted')->name('member_occupation_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Member Occupation']], function () {
            Route::get('club-hospitality/member-occupations/delete/{id}', 'MemOccupationController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Member Occupation']], function () {
            Route::get('club-hospitality/member-occupations/restore/{id}', 'MemOccupationController@restore');
        });
    //MEMBER OCCUPATIONS


    /* MAINTENANCE FEE REVENUE */
    Route::group(['middleware' => ['permission:View Maintenance Fee Revenue']], function () {
        Route::get('finance-and-management/reports/maintenance-fee-revenue', 'MemMaintenanceFeeRevenueController@index');
    });
    /* MAINTENANCE FEE REVENUE */

    /* MEMBERSHIP FEE REVENUE */
    /*Route::group(['middleware' => ['permission:View Membership Fee Revenue']], function () {
        Route::get('finance-and-management/reports/membership-fee-revenue', 'MemMaintenanceFeeRevenueController@index_membership');
    });*/
    /* MEMBERSHIP FEE REVENUE */


    // MAINTENANCE REPORT
    Route::group(['middleware' => ['permission:View Quarterly Maintenance Report']], function () {
        Route::get('finance-and-management/reports/maintenance-report', 'MembershipController@maintenance_report');
        Route::post('finance-and-management/reports/maintenance-report', 'MembershipController@maintenance_report_dt')->name('maintenance_report.datatable');
        Route::get('finance-and-management/reports/maintenance-report-vue', 'MembershipController@maintenance_report_vue');
        Route::get('finance-and-management/reports/maintenance-report-ini', 'MembershipController@maintenance_report_init');
    });


    Route::group(['middleware' => ['permission:View Membership Summary']], function () {
        Route::get('finance-and-management/reports/membership-summary-vue', 'MembershipController@memsummary_report_vue');
        Route::get('finance-and-management/reports/membership-summary-ini', 'MembershipController@memsummary_report_init');
    });

    Route::group(['middleware' => ['permission:View Available Membership Numbers']], function () {
        Route::get('finance-and-management/reports/available-membership-numbers-vue', 'MembershipController@availmems_vue');
        Route::get('finance-and-management/reports/available-membership-numbers-ini', 'MembershipController@availmems_init');
    });




    Route::group(['middleware' => ['permission:View Category-Wise Membership Summary']], function () {
        Route::get('finance-and-management/reports/category-membership-summary-vue', 'MembershipController@categorymem_report_vue');
        Route::get('finance-and-management/reports/category-membership-summary-ini', 'MembershipController@categorymem_report_init');
    });


    Route::group(['middleware' => ['permission:View Subscriptions and Maintenance Summary']], function () {
        Route::get('finance-and-management/reports/subscriptions-maintenance-summary-vue', 'MembershipController@subs_report_vue');
        Route::get('finance-and-management/reports/subscriptions-maintenance-summary-ini', 'MembershipController@subs_report_init');
    });
    Route::group(['middleware' => ['permission:View Category-Wise Subscriptions and Maintenance Summary']], function () {
        Route::get('finance-and-management/reports/category-subscriptions-maintenance-summary-vue', 'MembershipController@categorysubs_report_vue');
        Route::get('finance-and-management/reports/category-subscriptions-maintenance-summary-ini', 'MembershipController@categorysubs_report_init');
    });


    Route::group(['middleware' => ['permission:View Pending Maintenance Report']], function () {
        Route::get('finance-and-management/reports/pending-maintenance-report-vue', 'MembershipController@pending_report_vue');
        Route::get('finance-and-management/reports/pending-maintenance-report-ini', 'MembershipController@pending_report_init');

        Route::get('finance-and-management/reports/new-pending-maintenance-report-vue', 'MembershipController@npending_report_vue');
        Route::get('finance-and-management/reports/new-pending-maintenance-report-ini', 'MembershipController@npending_report_init');
    });
    Route::group(['middleware' => ['permission:View Category-Wise Pending Maintenance Report']], function () {
        Route::get('finance-and-management/reports/category-pending-maintenance-report-vue', 'MembershipController@category_report_vue');
        Route::get('finance-and-management/reports/category-pending-maintenance-report-ini', 'MembershipController@category_report_init');

        Route::get('finance-and-management/reports/new-category-pending-maintenance-report-vue', 'MembershipController@ncategory_report_vue');
        Route::get('finance-and-management/reports/new-category-pending-maintenance-report-ini', 'MembershipController@ncategory_report_init');
    });



    // MAINTENANCE REPORT

    // QUARTERLY MAINTENANCE REVENUE REPORT
    Route::group(['middleware' => ['permission:View Quarterly Maintenance Revenue Report']], function () {
    Route::get('finance-and-management/reports/maintenance-report-rev-vue', 'MembershipController@maintenance_report_rev_vue');
    Route::get('finance-and-management/reports/maintenance-report-ini-rev', 'MembershipController@maintenance_report_rev_init');
    });
    // QUARTERLY MAINTENANCE REVENUE REPORT



    // FAMILY MEMBERSHIPS
    Route::group(['middleware' => ['permission:View Family Memberships']], function () {
            Route::get('club-hospitality/family-membership-vue', 'MembershipController@fam_index_vue');
            Route::get('club-hospitality/family-membership/fam_init_vue', 'MembershipController@fam_init_vue');
    });
    // FAMILY MEMBERSHIPS


    Route::group(['middleware' => ['permission:Export Leads']], function () {
    Route::post('crm/leads/export', 'CrmLeadController@export')->name('leads.export');
        });

    /*Corporate Membership*/
        Route::group(['middleware' => ['permission:View Corporate Membership']], function () {
            Route::get('club-hospitality/corporate-membership-vue', 'CorporateMembershipController@index_vue');
            Route::get('club-hospitality/corporate-membership/init_vue', 'CorporateMembershipController@init_vue');

            Route::post('club-hospitality/corporate-membership/export', 'CorporateMembershipController@export')->name('comember.export');
    
        });
        Route::group(['middleware' => ['permission:Add Corporate Membership']], function () {
            Route::get('club-hospitality/corporate-membership/corporate-membership-aeu', 'CorporateMembershipController@create');
            Route::post('club-hospitality/corporate-membership/corporate-membership-aeu', 'CorporateMembershipController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Corporate Memberships']], function () {
            Route::get('club-hospitality/corporate-membership/deleted', 'CorporateMembershipController@index_deleted');
            Route::post('club-hospitality/corporate-membership/deleted', 'CorporateMembershipController@indexdt_deleted')->name('comem_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Corporate Membership']], function () {
            Route::get('club-hospitality/corporate-membership/corporate-membership-aeu/{id}', 'CorporateMembershipController@edit');
        });
        Route::post('club-hospitality/corporate-membership/update/{id}', 'CorporateMembershipController@update');
        Route::post('club-hospitality/corporate-membership/barcodeupdate/{id}', 'CorporateMembershipController@barcodeupdate');


        Route::group(['middleware' => ['permission:Delete Corporate Membership']], function () {
            Route::post('club-hospitality/corporate-membership/delete/{id}', 'CorporateMembershipController@destroy');
        });

        Route::group(['middleware' => ['permission:View Corporate Member']], function () {
            Route::get('club-hospitality/corporate-membership/corporate-membership-view/{id}', 'CorporateMembershipController@view');
        });
    

        Route::get('club-hospitality/membership/getcategory/{id}/{copid}', 'CorporateMembershipController@getmemnumber');
        Route::get('club-hospitality/membership/getfee/{id}', 'MembershipController@getmemfee');
        Route::get('club-hospitality/membership/getmaintenance/{id}', 'MembershipController@getmaintenancefee');
        Route::get('club-hospitality/membership/calculatefee/{id}', 'MembershipController@calculatefee');
        Route::group(['middleware' => ['permission:Restore Corporate Membership']], function () {
        Route::get('club-hospitality/corporate-membership/restore/{id}', 'CorporateMembershipController@restore');
        });




        Route::group(['middleware' => ['permission:Add Corporate Family Member']], function () {
        Route::post('club-hospitality/corporate-familymember/export', 'CorporateMemFamilyController@export')->name('corporate-familymember.export');
            Route::get('club-hospitality/corporate-membership/corporate-familymember-aeu/{id}', 'CorporateMemFamilyController@create')->name('comem.familymemeber.list');
        });
    Route::post('club-hospitality/corporate-membership/corporate-familymember-aeu/{id}', 'CorporateMemFamilyController@store');
    Route::group(['middleware' => ['permission:Edit Corporate Family Member']], function () {
        Route::get('club-hospitality/corporate-membership/corporate-familymember-aeu/{id}/{familyid}', 'CorporateMemFamilyController@edit')->name('co.familymemeber.list.edit');
        });
    Route::post('club-hospitality/corporate-familymember/update/{id}/{familyid}', 'CorporateMemFamilyController@update');
    Route::post('club-hospitality/corporate-familymember/barcodeupdate/{id}/{familyid}', 'CorporateMemFamilyController@barcodeupdate');


    Route::post('club-hospitality/corporate-membership/corporate-familymember-aeu2/{id}', 'CorporateMemFamilyController@indexdt')->name('co-familymember.datatable');
    Route::group(['middleware' => ['permission:Delete Corporate Family Member']], function () {
            Route::get('club-hospitality/corporate-familymember/delete/{id}/{familyid}', 'CorporateMemFamilyController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Corporate Family Members']], function () {
            Route::get('club-hospitality/corporate-familymember/deleted/{id}', 'CorporateMemFamilyController@index_deleted');
            Route::post('club-hospitality/corporate-familymember/deleted/{id}', 'CorporateMemFamilyController@indexdt_deleted')->name('co_familymember_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Corporate Family Member']], function () {
        Route::get('club-hospitality/corporate-familymember/restore/{id}/{familyid}', 'CorporateMemFamilyController@restore');
        });



    Route::group(['middleware' => ['permission:View Corporate Membership Documents']], function () {
        Route::get('club-hospitality/corporate-membership/corporate-membership-docs-aeu/{id}', 'MembershipDocumentsController@corporate_create');
        });
    Route::post('club-hospitality/corporate-membership/corporate-membership-docs-aeu/{id}', 'MembershipDocumentsController@corporate_store');

    Route::group(['middleware' => ['permission:Delete Corporate Membership Documents']], function () {
        Route::get('club-hospitality/corporate-membership/corporate-membership-docs/deleteimage/{url}', 'MembershipDocumentsController@corporate_destroy');
    });



    Route::group(['middleware' => ['permission:View Corporate Cards']], function () {
    Route::get('corporate-memberprint/{id}','CorporateMembershipController@cardPrint');
    });
    Route::group(['middleware' => ['permission:View Corporate Cards']], function () {
        Route::get('club-hospitality/corporate-membership/familymembercard/{id}', 'MemCardsController@corporate_fmcard');
    });
    Route::group(['middleware' => ['permission:View Corporate Cards']], function () {
            Route::get('corporate-familymemberprint/{id}', 'CorporateMembershipController@fmCardPrint');
        });

    /*Corporate Membership*/






        /*Membership*/
        Route::group(['middleware' => ['permission:View Membership']], function () {
            Route::get('club-hospitality/membership-vue', 'MembershipController@index_vue');
    Route::get('club-hospitality/membership/init_vue', 'MembershipController@init_vue');

        Route::get('club-hospitality/membership', 'MembershipController@index');
        Route::post('club-hospitality/membership/export', 'MembershipController@export')->name('member.export');
        Route::post('club-hospitality/membership', 'MembershipController@indexdt')->name('membership.datatable');
        });
        Route::group(['middleware' => ['permission:Add Membership']], function () {
            Route::get('club-hospitality/membership/membership-aeu', 'MembershipController@create');
            Route::post('club-hospitality/membership/membership-aeu', 'MembershipController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Memberships']], function () {
            Route::get('club-hospitality/membership/deleted', 'MembershipController@index_deleted');
            Route::post('club-hospitality/membership/deleted', 'MembershipController@indexdt_deleted')->name('membership_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Membership']], function () {
            Route::get('club-hospitality/membership/membership-aeu/{id}', 'MembershipController@edit');
        });
        Route::post('club-hospitality/membership/update/{id}', 'MembershipController@update');
        Route::post('club-hospitality/membership/barcodeupdate/{id}', 'MembershipController@barcodeupdate');


        Route::group(['middleware' => ['permission:Delete Membership']], function () {
            Route::post('club-hospitality/membership/delete/{id}', 'MembershipController@destroy');
        });
        Route::get('club-hospitality/membership/getcategory/{id}', 'MembershipController@getmemnumber');
        Route::get('club-hospitality/membership/getfee/{id}', 'MembershipController@getmemfee');
        Route::get('club-hospitality/membership/getmaintenance/{id}', 'MembershipController@getmaintenancefee');
        Route::get('club-hospitality/membership/calculatefee/{id}', 'MembershipController@calculatefee');
        Route::group(['middleware' => ['permission:View Member']], function () {
            Route::get('club-hospitality/membership/membership-view/{id}', 'MembershipController@view');
        });
        Route::group(['middleware' => ['permission:Restore Membership']], function () {
        Route::get('club-hospitality/membership/restore/{id}', 'MembershipController@restore');
        });



        Route::get('club-hospitality/membership/address-aeu/{id}', 'MemAddressController@create');
        Route::post('club-hospitality/address-aeu/{id}', 'MemAddressController@store_address');



    Route::group(['middleware' => ['permission:Add Family Member']], function () {
        Route::post('club-hospitality/familymember/export', 'MemFamilyController@export')->name('familymember.export');
            Route::get('club-hospitality/membership/familymember-aeu/{id}', 'MemFamilyController@create')->name('membership.familymemeber.list');
        });
    Route::post('club-hospitality/membership/familymember-aeu/{id}', 'MemFamilyController@store');
    Route::group(['middleware' => ['permission:Edit Family Member']], function () {
        Route::get('club-hospitality/membership/familymember-aeu/{id}/{familyid}', 'MemFamilyController@edit')->name('membership.familymemeber.list.edit');
        });
    Route::post('club-hospitality/familymember/update/{id}/{familyid}', 'MemFamilyController@update');
    Route::post('club-hospitality/familymember/barcodeupdate/{id}/{familyid}', 'MemFamilyController@barcodeupdate');


    Route::post('club-hospitality/membership/familymember-aeu2/{id}', 'MemFamilyController@indexdt')->name('familymember.datatable');
    Route::group(['middleware' => ['permission:Delete Family Member']], function () {
            Route::get('club-hospitality/familymember/delete/{id}/{familyid}', 'MemFamilyController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Family Members']], function () {
            Route::get('club-hospitality/familymember/deleted/{id}', 'MemFamilyController@index_deleted');
            Route::post('club-hospitality/familymember/deleted/{id}', 'MemFamilyController@indexdt_deleted')->name('familymember_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Family Member']], function () {
        Route::get('club-hospitality/familymember/restore/{id}/{familyid}', 'MemFamilyController@restore');
        });



    // EMPLOYEE EDUCATION
    Route::group(['middleware' => ['permission:Add Education']], function () {
    Route::get('human-resource/employment/education-aeu/{id}', 'HrEmployeeEducation@create')->name('employment.education.list');
    Route::post('human-resource/employment/education-aeu/{id}', 'HrEmployeeEducation@store');
        });

    Route::group(['middleware' => ['permission:Edit Education']], function () {
    Route::get('human-resource/employment/education-aeu/{id}/{eduid}', 'HrEmployeeEducation@edit')->name('employment.education.list.edit');
    Route::post('human-resource/education/update/{id}/{eduid}', 'HrEmployeeEducation@update');
    });

    Route::post('human-resource/employment/education-aeu2/{id}', 'HrEmployeeEducation@indexdt')->name('education.datatable');

    Route::group(['middleware' => ['permission:Delete Education']], function () {
            Route::get('human-resource/education/delete/{id}/{eduid}', 'HrEmployeeEducation@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Educations']], function () {
        Route::get('human-resource/education/deleted/{id}', 'HrEmployeeEducation@index_deleted');
        Route::post('human-resource/education/deleted/{id}', 'HrEmployeeEducation@indexdt_deleted')->name('education_deleted.datatable');
    });
    Route::group(['middleware' => ['permission:Restore Education']], function () {
        Route::get('human-resource/education/restore/{id}/{eduid}', 'HrEmployeeEducation@restore');
        });
    // EMPLOYEE EDUCATION


    // EMPLOYEE REFERENCES
    Route::group(['middleware' => ['permission:Add Reference']], function () {
    Route::get('human-resource/employment/reference-aeu/{id}', 'HrReferenceSubsController@create')->name('employment.reference.list');
    Route::post('human-resource/employment/reference-aeu/{id}', 'HrReferenceSubsController@store');
        });

    Route::group(['middleware' => ['permission:Edit Reference']], function () {
    Route::get('human-resource/employment/reference-aeu/{id}/{eduid}', 'HrReferenceSubsController@edit')->name('employment.reference.list.edit');
    Route::post('human-resource/reference/update/{id}/{eduid}', 'HrReferenceSubsController@update');
    });

    Route::post('human-resource/employment/reference-aeu2/{id}', 'HrReferenceSubsController@indexdt')->name('reference.datatable');

    Route::group(['middleware' => ['permission:Delete Reference']], function () {
            Route::get('human-resource/reference/delete/{id}/{eduid}', 'HrReferenceSubsController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted References']], function () {
        Route::get('human-resource/reference/deleted/{id}', 'HrReferenceSubsController@index_deleted');
        Route::post('human-resource/reference/deleted/{id}', 'HrReferenceSubsController@indexdt_deleted')->name('reference_deleted.datatable');
    });
    Route::group(['middleware' => ['permission:Restore Reference']], function () {
        Route::get('human-resource/reference/restore/{id}/{eduid}', 'HrReferenceSubsController@restore');
        });
    // EMPLOYEE REFERENCES



    // EMPLOYEE JOBS
    Route::group(['middleware' => ['permission:Add Job']], function () {
    Route::get('human-resource/employment/job-aeu/{id}', 'HrJobSubsController@create')->name('employment.job.list');
    Route::post('human-resource/employment/job-aeu/{id}', 'HrJobSubsController@store');
        });

    Route::group(['middleware' => ['permission:Edit Job']], function () {
    Route::get('human-resource/employment/job-aeu/{id}/{eduid}', 'HrJobSubsController@edit')->name('employment.job.list.edit');
    Route::post('human-resource/job/update/{id}/{eduid}', 'HrJobSubsController@update');
    });
    Route::post('human-resource/job/job-aeu2/{id}', 'HrJobSubsController@indexdt')->name('job.datatable');

    Route::group(['middleware' => ['permission:Delete Job']], function () {
            Route::get('human-resource/job/delete/{id}/{eduid}', 'HrJobSubsController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Jobs']], function () {
        Route::get('human-resource/job/deleted/{id}', 'HrJobSubsController@index_deleted');
        Route::post('human-resource/job/deleted/{id}', 'HrJobSubsController@indexdt_deleted')->name('job_deleted.datatable');
    });
    Route::group(['middleware' => ['permission:Restore Job']], function () {
        Route::get('human-resource/job/restore/{id}/{eduid}', 'HrJobSubsController@restore');
        });
    // EMPLOYEE JOBS



    Route::group(['middleware' => ['permission:Add Profession']], function () {
        Route::get('club-hospitality/membership/profession-aeu/{id}', 'MemProfessionController@create');
        });
        Route::post('club-hospitality/membership/profession-aeu/{id}', 'MemProfessionController@store');
    Route::group(['middleware' => ['permission:Edit Profession']], function () {
        Route::get('club-hospitality/profession/edit/{id}', 'MemProfessionController@edit');
        });
    Route::post('club-hospitality/profession/update/{id}', 'MemProfessionController@update');
    Route::get('club-hospitality/profession/findrel/{id}', 'MemProfessionController@findrel');
    Route::get('club-hospitality/profession/fmcontact/{id}', 'MemProfessionController@fmcontact');
    Route::get('club-hospitality/profession/fmrelationship/{id}', 'MemProfessionController@fmrelationship');


    /*Membership Cards Module*/
    Route::group(['middleware' => ['permission:View Cards']], function () {
        Route::get('club-hospitality/membership/cards/{id}', 'MemCardsController@index');
        });
    Route::post('club-hospitality/membership/cards/{id}', 'MemCardsController@indexdt')->name('cards.datatable');

    /*Route::get('club-hospitality/cards/{id}', 'MemCardsController@create');
        Route::post('club-hospitality/cards/{id}', 'MemCardsController@store');
        Route::get('club-hospitality/cards/edit/{id}', 'MemCardsController@edit');
        Route::post('club-hospitality/cards/update/{id}', 'MemCardsController@update');
        Route::get('club-hospitality/cards/delete/{id}', 'MemCardsController@destroy');*/

    /*Membership Cards Module*/


    Route::group(['middleware' => ['permission:View Membership Documents']], function () {
        Route::get('club-hospitality/membership/membership_docs-aeu/{id}', 'MembershipDocumentsController@create');
        });
    Route::post('club-hospitality/membership/membership_docs-aeu/{id}', 'MembershipDocumentsController@store');

    Route::group(['middleware' => ['permission:View Cards']], function () {
        Route::get('club-hospitality/membership/familymembercard/{id}', 'MemCardsController@fmcard');
        });

    Route::group(['middleware' => ['permission:View Credit Limit']], function () {
        Route::get('club-hospitality/membership/creditlimit/{id}', 'MembershipController@creditlimit');
        Route::post('club-hospitality/membership/updatecredit/{id}', 'MembershipController@updatecredit');
        });
    Route::group(['middleware' => ['permission:Delete Membership Documents']], function () {
        Route::get('club-hospitality/membership/membership_docs/deleteimage/{url}', 'MembershipDocumentsController@destroy');
    });

    Route::group(['middleware' => ['permission:View File Manager']], function () {
    Route::get('admin-settings/file-manager', 'FileManagerController@index');
    Route::get('admin-settings/file-manager/init', 'FileManagerController@init');
    Route::get('image/{url}/{size}', 'FileManagerController@image')->name('imageviewx');

    });
    Route::get('deleteimage/{url}', 'FileManagerController@delete')->name('deleteimage');



        Route::get('club-hospitality/membership/referal-aeu/{id}', 'MemReferalController@create');
        Route::post('club-hospitality/referal-aeu/{id}', 'MemReferalController@store_referal');

        Route::get('club-hospitality/membership/affiliation-aeu/{id}', 'MemAffiliationController@create');
        Route::post('club-hospitality/affiliation-aeu/{id}', 'MemAffiliationController@store_affiliation');



    Route::group(['middleware' => ['permission:Add Cars']], function () {
        Route::get('club-hospitality/membership/cars-aeu/{id}', 'MemCarController@create')->name('membership.cars.list');
        });
    Route::post('club-hospitality/membership/cars-aeu/{id}', 'MemCarController@store');
    Route::group(['middleware' => ['permission:Edit Cars']], function () {
        Route::get('club-hospitality/membership/cars-aeu/{id}/{carsid}', 'MemCarController@edit')->name('membership.cars.list.edit');
        });
    Route::post('club-hospitality/cars/update/{id}/{carsid}', 'MemCarController@update');
    Route::post('club-hospitality/membership/cars-aeu2/{id}', 'MemCarController@indexdt')->name('cars.datatable');
    Route::group(['middleware' => ['permission:View Deleted Cars']], function () {
            Route::get('club-hospitality/cars/deleted/{id}', 'MemCarController@index_deleted');
            Route::post('club-hospitality/cars/deleted/{id}', 'MemCarController@indexdt_deleted')->name('cars_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Cars']], function () {
        Route::get('club-hospitality/cars/delete/{id}/{carsid}', 'MemCarController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Cars']], function () {
        Route::get('club-hospitality/cars/restore/{id}/{carsid}', 'MemCarController@restore');
        });
    /*
        Route::get('club-hospitality/membership/cars-aeu/{id}', 'MemCarController@create');
        Route::post('club-hospitality/membership/cars-aeu/{id}', 'MemCarController@store');
        Route::get('club-hospitality/cars/edit/{id}', 'MemCarController@edit');
        Route::post('club-hospitality/cars/update/{id}', 'MemCarController@update');
        Route::post('club-hospitality/membership/cars-aeu', 'MemCarController@indexdt')->name('cars.datatable');
    */
    // Route::post('club-hospitality/cars-aeu/{id}', 'MemCarController@store_cars');

        Route::get('club-hospitality/membership/maintenance-aeu/{id}', 'MemMaintenanceController@create');
        Route::post('club-hospitality/maintenance-aeu/{id}', 'MemMaintenanceController@store_maintenance');


        Route::post('club-hospitality/membership/membership-aeu/address/{id}', 'MembershipController@address');
        Route::post('club-hospitality/membership/membership-aeu/professon/{id}', 'MembershipController@profession');
        Route::post('club-hospitality/membership/membership-aeu/affiliations/{id}', 'MembershipController@affiliations');
        Route::post('club-hospitality/membership/membership-aeu/referal/{id}', 'MembershipController@referal');
    /* Route::get('club-hospitality/membership/membership-aeu/familymember/{id}', 'MemFamilyController@create');*/
        Route::post('club-hospitality/membership/membership-aeu/maintenance/{id}', 'MembershipController@maintenance');
        Route::post('club-hospitality/membership/membership-aeu/cars/{id}', 'MembershipController@cars');
        /*Membership*/



    Route::group(['middleware' => ['permission:Print Booking Details']], function () {
            Route::get('room-management/room-booking-invoice/{id}', 'RoomInvoiceController@edit_booking');
        });
    Route::group(['middleware' => ['permission:Print Check Out Invoice']], function () {
            Route::get('room-management/room-invoice/{id}', 'RoomInvoiceController@edit')->name('roomInvoice');
        });


    Route::group(['middleware' => ['permission:Print Booking Details']], function () {
            Route::get('room-management/room-booking/room-invoice-download/{id}', 'PdfController@pdfinvoice');
        });
    Route::group(['middleware' => ['permission:Print Check Out Invoice']], function () {
            Route::get('room-management/room-check-out/room-invoice-download/{id}', 'PdfController@pdfinvoicetwo');
        });




    Route::group(['middleware' => ['permission:Print Payment Receipt']], function () {
        Route::get('room-management/room-payment-receipts/room-payment-receipts-invoice/{id}', 'PaymentReceiptsInvoiceController@edit');
        });
    Route::group(['middleware' => ['permission:Print Payment Receipt']], function () {
        Route::get('room-management/paymentreceipt-invoice-download/{id}', 'PaymentReceiptPDFController@pdfinvoice');
        });



        Route::group(['middleware' => ['permission:View Rooms Management']], function () {
            Route::get('room-management', function () {
                return view('backend/room-management/room-management');
            });
            Route::get('room-management/definitions', function () {
                return view('backend/room-management/room-management-definitions');
            });
        });
        Route::group(['middleware' => ['permission:View Room Type']], function () {
            Route::get('room-management/room-type', 'RoomTypeController@index');
            Route::post('room-management/room-type', 'RoomTypeController@indexdt')->name('roomtype.datatable');
        });
        Route::group(['middleware' => ['permission:Add Room Type']], function () {
            Route::get('room-management/room-type/room-type-aeu', 'RoomTypeController@create');
            Route::post('room-management/room-type/room-type-aeu', 'RoomTypeController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Room Types']], function () {
            Route::get('room-management/room-type/deleted', 'RoomTypeController@index_deleted');
            Route::post('room-management/room-type/deleted', 'RoomTypeController@indexdt_deleted')->name('roomtype_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Room Type']], function () {
            Route::get('room-management/room-type/room-type-aeu/{id}', 'RoomTypeController@edit');
        });
        Route::post('room-management/room-type/update/{id}', 'RoomTypeController@update');
        Route::group(['middleware' => ['permission:Delete Room Type']], function () {
            Route::get('room-management/room-type/delete/{id}', 'RoomTypeController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Room Type']], function () {
            Route::get('room-management/room-type/restore/{id}', 'RoomTypeController@restore');
        });


        Route::group(['middleware' => ['permission:View Customer']], function () {
            Route::get('room-management/room-customer', 'CustomerController@index');
            Route::post('room-management/room-customer', 'CustomerController@indexdt')->name('customer.datatable');

        });
        Route::post('club-hospitality/room-customer/export', 'CustomerController@export')->name('customer.export');
        Route::group(['middleware' => ['permission:Add Customer']], function () {
            Route::get('room-management/room-customer/room-customer-aeu', 'CustomerController@create');
            Route::post('room-management/room-customer/room-customer-aeu', 'CustomerController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Customers']], function () {
            Route::get('room-management/room-customer/deleted', 'CustomerController@index_deleted');
            Route::post('room-management/room-customer/deleted', 'CustomerController@indexdt_deleted')->name('customer_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Customer']], function () {
            Route::get('room-management/room-customer/room-customer-aeu/{id}', 'CustomerController@edit');
            Route::post('room-management/room-customer/update/{id}', 'CustomerController@update');
        });
        Route::group(['middleware' => ['permission:Delete Customer']], function () {
            Route::get('room-management/room-customer/delete/{id}', 'CustomerController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Customer']], function () {
            Route::get('room-management/room-customer/restore/{id}', 'CustomerController@restore');
        });



    // GUEST TYPES
        Route::group(['middleware' => ['permission:View Guest Types']], function () {
            Route::get('room-management/guest-types', 'GuestTypeController@index');
            Route::post('room-management/guest-types', 'GuestTypeController@indexdt')->name('guesttype.datatable');
        });
        Route::group(['middleware' => ['permission:Add Guest Types']], function () {
            Route::get('room-management/guest-types/guest-types-aeu', 'GuestTypeController@create');
            Route::post('room-management/guest-types/guest-types-aeu', 'GuestTypeController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Guest Types']], function () {
            Route::get('room-management/guest-types/deleted', 'GuestTypeController@index_deleted');
            Route::post('room-management/guest-types/deleted', 'GuestTypeController@indexdt_deleted')->name('guesttype_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Guest Types']], function () {
            Route::get('room-management/guest-types/guest-types-aeu/{id}', 'GuestTypeController@edit');
            Route::post('room-management/guest-types/update/{id}', 'GuestTypeController@update');
        });
        Route::group(['middleware' => ['permission:Delete Guest Types']], function () {
            Route::get('room-management/guest-types/delete/{id}', 'GuestTypeController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Guest Types']], function () {
            Route::get('room-management/guest-types/restore/{id}', 'GuestTypeController@restore');
        });
        // GUEST TYPES


        Route::group(['middleware' => ['permission:View Room Rate Categories']], function () {
            Route::get('room-management/room-category', 'RoomCategoryController@index');
            Route::post('room-management/room-category', 'RoomCategoryController@indexdt')->name('roomcategory.datatable');
        });
        Route::group(['middleware' => ['permission:Add Room Rate Categories']], function () {
            Route::get('room-management/room-category/room-category-aeu', 'RoomCategoryController@create');
            Route::post('room-management/room-category/room-category-aeu', 'RoomCategoryController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Room Rate Categories']], function () {
            Route::get('room-management/room-category/deleted', 'RoomCategoryController@index_deleted');
            Route::post('room-management/room-category/deleted', 'RoomCategoryController@indexdt_deleted')->name('roomcategory_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Room Rate Categories']], function () {
            Route::get('room-management/room-category/room-category-aeu/{id}', 'RoomCategoryController@edit');
        });
        Route::post('room-management/room-category/update/{id}', 'RoomCategoryController@update');
        Route::group(['middleware' => ['permission:Delete Room Rate Categories']], function () {
            Route::get('room-management/room-category/delete/{id}', 'RoomCategoryController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Room Rate Categories']], function () {
            Route::get('room-management/room-category/restore/{id}', 'RoomCategoryController@restore');
        });


        Route::group(['middleware' => ['permission:View Rooms']], function () {
            Route::get('room-management/room', 'RoomController@index');
            Route::post('room-management/room', 'RoomController@indexdt')->name('room.datatable');
        });
        Route::group(['middleware' => ['permission:Add Rooms']], function () {
            Route::get('room-management/room/room-aeu', 'RoomController@create');
            Route::post('room-management/room/room-aeu', 'RoomController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Rooms']], function () {
            Route::get('room-management/room/deleted', 'RoomController@index_deleted');
            Route::post('room-management/room/deleted', 'RoomController@indexdt_deleted')->name('room_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Rooms']], function () {
            Route::get('room-management/room/room-aeu/{id}', 'RoomController@edit');
        });
        Route::post('room-management/room/update/{id}', 'RoomController@update');
        Route::group(['middleware' => ['permission:Delete Rooms']], function () {
            Route::get('room-management/room/delete/{id}', 'RoomController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Rooms']], function () {
            Route::get('room-management/room/restore/{id}', 'RoomController@restore');
        });



        Route::group(['middleware' => ['permission:View Room Charges Type']], function () {
            Route::get('room-management/room-charges-type', 'RoomChargesTypeController@index');
            Route::post('room-management/room-charges-type', 'RoomChargesTypeController@indexdt')->name('roomcharges.datatable');
        });
        Route::group(['middleware' => ['permission:View Deleted Room Charges Type']], function () {
            Route::get('room-management/room-charges-type/deleted', 'RoomChargesTypeController@index_deleted');
            Route::post('room-management/room-charges-type/deleted', 'RoomChargesTypeController@indexdt_deleted')->name('roomcharges_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Add Room Charges Type']], function () {
            Route::get('room-management/room-charges-type/room-charges-type-aeu', 'RoomChargesTypeController@create');
        });
        Route::post('room-management/room-charges-type/room-charges-type-aeu', 'RoomChargesTypeController@store');
        Route::group(['middleware' => ['permission:Edit Room Charges Type']], function () {
            Route::get('room-management/room-charges-type/room-charges-type-aeu/{id}', 'RoomChargesTypeController@edit');
        });
        Route::post('room-management/room-charges-type/update/{id}', 'RoomChargesTypeController@update');
        Route::group(['middleware' => ['permission:Delete Room Charges Type']], function () {
            Route::get('room-management/room-charges-type/delete/{id}', 'RoomChargesTypeController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Room Charges Type']], function () {
            Route::get('room-management/room-charges-type/restore/{id}', 'RoomChargesTypeController@restore');
        });


        Route::group(['middleware' => ['permission:View Room Booking']], function () {
            Route::get('room-management/room-booking', 'RoomBookingController@index');
            Route::post('room-management/room-booking', 'RoomBookingController@indexdt')->name('roombooking.datatable');


            Route::get('room-management/room-booking-vue', 'RoomBookingController@booking_vue');
            Route::get('room-management/room-booking/booking_ini', 'RoomBookingController@booking_ini');
        });
        Route::group(['middleware' => ['permission:Add Room Booking']], function () {
            Route::get('room-management/room-booking/room-booking-aeu', 'RoomBookingController@create');
            Route::post('room-management/room-booking/room-booking-aeu', 'RoomBookingController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Room Bookings']], function () {
            Route::get('room-management/room-booking/deleted', 'RoomBookingController@index_deleted');
            Route::post('room-management/room-booking/deleted', 'RoomBookingController@indexdt_deleted')->name('roombooking_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Room Booking']], function () {
            Route::get('room-management/room-booking/room-booking-aeu/{id}', 'RoomBookingController@edit');
        });
        Route::group(['middleware' => ['permission:Edit Check In']], function () {
            Route::get('room-management/room-booking/room-check-in-aeu/{id}', 'RoomBookingController@edit_checkin');
        });
        Route::group(['middleware' => ['permission:Restore Room Booking']], function () {
            Route::get('room-management/room-booking/restore/{id}', 'RoomBookingController@restore');
        });


    // ROOM TABLE DEFINITION MAPPING
    Route::group(['middleware' => ['permission:View Room Table Definition Mapping']], function () {
            Route::get('room-management/room-table-mapping-vue', 'RoomController@mapping_vue');
            Route::get('room-management/room-table-mapping/mapping_init_vue', 'RoomController@mapping_init_vue');
        });
    Route::group(['middleware' => ['permission:Link Rooms and Table Definitions']], function () {
            Route::get('room-management/room-table-mapping/room-table-mapping-aeu/{id}', 'RoomController@mapping_edit');
            Route::post('room-management/room-table-mapping/update/{id}', 'RoomController@mapping_update');
    });
    // ROOM TABLE DEFINITION MAPPING


    Route::group(['middleware' => ['permission:Edit Final Check Out']], function () {
        Route::get('room-management/room-check-out/room-check-out-edit/{id}', 'RoomBookingController@edit_checkout');
        Route::post('room-management/room-check-out/room-check-out-edit/{id}', 'RoomBookingController@update_checkout');
    });

        Route::post('room-management/room-booking/update/{id}', 'RoomBookingController@update');
        Route::post('room-management/roomcheckin/update/{id}', 'RoomBookingController@update_checkin');

        Route::group(['middleware' => ['permission:Delete Room Booking']], function () {
            Route::post('room-management/room-booking/delete/{id}', 'RoomBookingController@destroy');
        });
        Route::post('room-management/room-booking/calculatecharges', 'RoomBookingController@calculatecharges');
        Route::get('room-management/room-booking/calculateextracharges/{id}', 'RoomBookingController@calculateextracharges');

        Route::get('room-management/room-check-out/export', 'RoomCheckOutController@export')->name('roomCheckout.export');

        Route::post('room-management/room-booking/roomallocation', 'RoomBookingController@roomallocation');


        Route::group(['middleware' => ['permission:View Check In']], function () {
            Route::get('room-management/room-check-in', 'RoomCheckInController@index');
        });
        Route::post('room-management/room-check-in', 'RoomCheckInController@indexdt')->name('checkin.datatable');
        Route::get('room-management/room-check-in/room-check-in-aeu/{id}', 'RoomCheckInController@create')->name('room.checkin');
        Route::post('room-management/room-check-in/room-check-in-aeu/{id}', 'RoomCheckInController@store');
        Route::get('room-management/room-check-in-aeu/{id}', 'RoomCheckInController@edit');
        Route::post('room-management/room-check-in/update/{id}', 'RoomCheckInController@update');


        Route::group(['middleware' => ['permission:View Check Out']], function () {
            Route::get('room-management/room-check-out', 'RoomCheckOutController@index');
            Route::post('room-management/room-check-out', 'RoomCheckOutController@indexdt')->name('checkout.datatable');
        });
    Route::group(['middleware' => ['permission:View Room Booking Documents']], function () {
        Route::get('room-management/room-check-out/room-documents/{id}', 'RoomCheckOutController@docs');
    });
        Route::group(['middleware' => ['permission:View Check Out']], function () {
            Route::get('room-management/room-check-out-vue', 'RoomCheckOutController@index_vue');
            Route::get('room-management/room-check-out/checkout-ini', 'RoomCheckOutController@checkout_init');
        Route::get('room-management/room-check-out/searchbookingno/{id}', 'RoomCheckOutController@searchbookingno');
        Route::get('room-management/room-check-out/searchstartdate/{id}', 'RoomCheckOutController@searchstartdate');
        Route::get('room-management/room-check-out/searchenddate/{id}', 'RoomCheckOutController@searchenddate');
        Route::get('room-management/room-check-out/searchname/{id}', 'RoomCheckOutController@searchname');
        });

    

        Route::group(['middleware' => ['permission:View Unpaid Check Out']], function () {
            Route::get('room-management/room-check-out-unpaid-vue', 'RoomCheckOutController@unpaid_vue');
            Route::get('room-management/room-check-out-unpaid/unpaid_init', 'RoomCheckOutController@unpaid_init');
        });


    Route::group(['middleware' => ['permission:View Expenses Documents']], function () {
        Route::get('finance-and-management/finance-expenses/documents/{id}', 'FinanceExpenseNewController@docs');
    });


        Route::post('room-management/room-check-out/room-check-out-aeu/{id}', 'RoomCheckOutController@store');
        Route::get('room-management/room-check-out/room-check-out-aeu/{id}', 'RoomCheckOutController@create')->name('room.checkout');
        Route::post('room-management/room-check-out/update/{id}', 'RoomCheckOutController@update');


    /*Route::group(['middleware' => ['permission:View Ledger Accounts']], function () {
            Route::get('room-management/room-ledgers', 'RoomLedgerController@index');
            Route::get('room-management/room-ledgers/print', 'RoomLedgerController@print');
        });
    Route::group(['middleware' => ['permission:View Ledger Accounts']], function () {
            Route::get('finance-and-management/finance-ledgers', 'RoomLedgerController@index_finance');
        });*/


    Route::group(['middleware' => ['permission:View Ledger Accounts']], function () {
            Route::get('room-management/room-ledger-accounts', 'FinanceLedgerAccountsController@index_rooms');
            Route::get('room-management/room-ledger-accounts/print', 'FinanceLedgerAccountsController@print');
        });
    Route::group(['middleware' => ['permission:View Ledger Accounts']], function () {
            Route::get('finance-and-management/finance-ledgers', 'RoomLedgerController@index_finance');
        });

    Route::group(['middleware' => ['permission:View Finance Ledger Accounts']], function () {
    Route::get('finance-and-management/member-guest-ledgers-vue', 'FinanceLedgerAccountsController@index_vue');
    Route::get('finance-and-management/member-guest-ledgers/legders_init_vue', 'FinanceLedgerAccountsController@legders_init_vue');

        Route::get('finance-and-management/member-guest-ledgers', 'FinanceLedgerAccountsController@index');
        Route::get('finance-and-management/finance-ledger-accounts/print', 'FinanceLedgerAccountsController@print');
    });


    // SUPPLIER LEDGERS AND TRIAL BALANCE
    Route::group(['middleware' => ['permission:View Supplier Ledger Accounts']], function () {
    Route::get('finance-and-management/supplier-ledgers-vue', 'FinanceLedgerAccountsController@supplier_vue');
    Route::get('finance-and-management/supplier-ledgers/supplier_init_vue', 'FinanceLedgerAccountsController@supplier_init_vue');
    });

    Route::group(['middleware' => ['permission:View Supplier Trial Balance']], function () {
    Route::get('finance-and-management/supplier-trial-balance-vue', 'FinanceTrialBalanceController@supplier_vue');
    Route::get('finance-and-management/supplier-trial-balance/supplier_init_vue', 'FinanceTrialBalanceController@supplier_init_vue');
    });
    // SUPPLIER LEDGERS AND TRIAL BALANCE



    // ACCOUNTS LEDGERS AND TRIAL BALANCE
    Route::group(['middleware' => ['permission:View Accounts Ledgers']], function () {
    Route::get('finance-and-management/accounts-ledgers-vue', 'FinanceAccountsLedgersController@acc_vue');
    Route::get('finance-and-management/accounts-ledgers/acc_init_vue', 'FinanceAccountsLedgersController@acc_init_vue');
    });

    Route::group(['middleware' => ['permission:View Accounts Trial Balance']], function () {
    Route::get('finance-and-management/accounts-trial-balance-vue', 'FinanceAccountsTrialBalanceController@acc_trial_vue');
    Route::get('finance-and-management/accounts-trial-balance/acc_trial_init_vue', 'FinanceAccountsTrialBalanceController@acc_trial_init_vue');
    });
    // ACCOUNTS LEDGERS AND TRIAL BALANCE



    // ACCOUNTS LEDGERS
    Route::group(['middleware' => ['permission:View COA Ledgers']], function () {
        Route::get('finance-and-management/coa-ledgers-vue', 'FinanceAccountsLedgersController@index_vue');
    Route::get('finance-and-management/coa-ledgers/coaledgers_init_vue', 'FinanceAccountsLedgersController@coaledgers_init_vue');

        Route::get('finance-and-management/accounts-ledgers', 'FinanceAccountsLedgersController@index');
    });
    // ACCOUNTS LEDGERS

    // ACCOUNTS TRIAL BALANCE
    Route::group(['middleware' => ['permission:View Accounts Trial Balance']], function () {
        Route::get('finance-and-management/coa-trial-balance-vue', 'FinanceAccountsTrialBalanceController@index_vue');
    Route::get('finance-and-management/coa-trial-balance/acc_init_vue', 'FinanceAccountsTrialBalanceController@acc_init_vue');


    Route::get('finance-and-management/accounts-trial-balance', 'FinanceAccountsTrialBalanceController@index');
    Route::post('finance-and-management/accounts-trial-balance', 'FinanceAccountsTrialBalanceController@indexdt')->name('acctrialbalance.datatable');
    });
    // ACCOUNTS TRIAL BALANCE

    // ACCOUNTS CASH FLOW
    Route::group(['middleware' => ['permission:View Accounts Cash Flow']], function () {
    Route::get('finance-and-management/accounts-cash-flow', 'FinanceAccountsCashFlowController@index');
    });
    // ACCOUNTS CASH FLOW

    Route::group(['middleware' => ['permission:View Check Out Report']], function () {
        Route::get('finance-and-management/finance-reports/rooms-revenue-report', 'FinanceReportsController@index');
        Route::get('finance-and-management/finance-reports/print', 'FinanceReportsController@print');
        });

    Route::post('finance-and-management/finance-reports', 'FinanceReportsController@indexdt')->name('financereports.datatable');

    Route::group(['middleware' => ['permission:View Check Out Report']], function () {
            Route::get('room-management/room-reports/check-out-report', 'FinanceReportsController@index_room');
        });
    Route::get('finance-and-management/finance-reports/export', 'FinanceReportsController@export')->name('financeReporting.export');





    Route::group(['middleware' => ['permission:View Ledger Account Details']], function () {
            Route::get('finance-and-management/finance-account-details', 'FinanceAccountDetailsController@index');
            Route::get('finance-and-management/finance-account-details/print', 'FinanceAccountDetailsController@print');
        });



    // MEMBER ACTIVITIES
    Route::group(['middleware' => ['permission:View Member Activities']], function () {
        Route::get('finance-and-management/reports/member-activities-vue', 'MembershipController@activities_index_vue');
    Route::get('finance-and-management/reports/member-activities/activities_init_vue', 'MembershipController@activities_init_vue');
    });
    // MEMBER ACTIVITIES


    Route::group(['middleware' => ['permission:View Finance Trial Balance']], function () {
        Route::get('finance-and-management/member-guest-trial-balance-vue', 'FinanceTrialBalanceController@index_vue');
    Route::get('finance-and-management/member-guest-trial-balance/trial_init_vue', 'FinanceTrialBalanceController@trial_init_vue');

    Route::get('finance-and-management/member-guest-trial-balance', 'FinanceTrialBalanceController@index');
    Route::post('finance-and-management/finance-trial-balance', 'FinanceTrialBalanceController@indexdt')->name('trialbalance.datatable');
    Route::get('finance-and-management/finance-trial-balance/print', 'FinanceTrialBalanceController@print');
    });
    Route::group(['middleware' => ['permission:View Ledger Account Details']], function () {
    Route::get('room-management/room-trial-balance', 'FinanceTrialBalanceController@index_room');
    });



    // CHART OF ACCOUNTS LIST

    Route::group(['middleware' => ['permission:View Chart of Accounts List']], function () {
        Route::get('finance-and-management/general-ledger-vue', 'FinanceAccountTypeController@index_vue');
        Route::get('finance-and-management/general-ledger/list_init_vue', 'FinanceAccountTypeController@list_init_vue');
    });

    // CHART OF ACCOUNTS LIST


    // ACCOUNTS BALANCE

    Route::group(['middleware' => ['permission:View Accounts Balance']], function () {
        Route::get('finance-and-management/accounts-balance-vue', 'FinanceAccountTypeController@acc_balance_index_vue');
        Route::get('finance-and-management/accounts-balance/acc_balance_init_vue', 'FinanceAccountTypeController@acc_balance_init_vue');
    });

    // ACCOUNTS BALANCE



    ///////////////MULTIPLE FINANCE INVOICES////////////////////////////////

    //////////// OLD //////////////////


    Route::group(['middleware' => ['permission:Add Finance Invoices']], function () {
        Route::get('finance-and-management/finance-invoices/invoices-aeu', 'FinanceNewInvoicesController@create');
        Route::get('finance-and-management/finance-invoices/invoices-aeu/init', 'FinanceNewInvoicesController@init');
        Route::post('finance-and-management/finance-invoices/invoices-aeu/save', 'FinanceNewInvoicesController@save');
    });
    Route::group(['middleware' => ['permission:Edit Finance Invoices']], function () {
    Route::get('finance-and-management/finance-invoices/invoices-aeu/{id}', 'FinanceNewInvoicesController@edit');
    Route::post('finance-and-management/invoices/update', 'FinanceNewInvoicesController@update');
    });

    








    Route::group(['middleware' => ['permission:View Finance Invoices']], function () {
        Route::get('finance-and-management/finance-new-invoices-vue', 'BackupNewFinanceInvoicesController@index_vue');

            Route::get('finance-and-management/new-invoices-vue', 'BackupNewFinanceInvoicesController@index_new_vue');
        /*  Route::get('finance-and-management/finance-new-invoices-ini', 'BackupNewFinanceInvoicesController@invoices_init');
    */
            Route::get('finance-and-management/finance-new-invoices', 'BackupNewFinanceInvoicesController@index');
            Route::get('finance-and-management/finance-new-invoices/print', 'BackupNewFinanceInvoicesController@print');

        });

    Route::post('finance-and-management/finance-new-invoices', 'BackupNewFinanceInvoicesController@indexdt')->name('invoice.datatable');
    Route::group(['middleware' => ['permission:Print Finance Invoices']], function () {
        Route::get('finance-and-management/finance-new-invoices/invoice/{id}', 'BackupNewFinanceInvoicesController@invoice')->name('financeInvoice');
        });
    Route::group(['middleware' => ['permission:Add Finance Invoices']], function () {
        Route::get('finance-and-management/finance-invoices/finance-new-invoices-aeu', 'BackupNewFinanceInvoicesController@create');
        });
    Route::post('finance-and-management/finance-invoices/finance-new-invoices-aeu', 'BackupNewFinanceInvoicesController@store');
    Route::group(['middleware' => ['permission:Edit Finance Invoices']], function () {
    Route::get('finance-and-management/finance-invoices/finance-new-invoices-aeu/{id}', 'BackupNewFinanceInvoicesController@edit');
        });
    Route::post('finance-and-management/finance-new-invoices/update/{id}', 'BackupNewFinanceInvoicesController@update');
    Route::group(['middleware' => ['permission:Print Finance Invoices']], function () {
        Route::get('finance-and-management/finance-new-invoices/invoice/{id}', 'BackupNewFinanceInvoicesController@invoice')->name('financeInvoice');
        });
    Route::group(['middleware' => ['permission:Delete Finance Invoices']], function () {
    Route::post('finance-and-management/finance-new-invoices/delete/{id}', 'BackupNewFinanceInvoicesController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Finance Invoices']], function () {
        Route::get('finance-and-management/finance-invoices/restore/{id}', 'BackupNewFinanceInvoicesController@restore');
        });
    ///////////////////////MULTIPLE FINANCE INVOICES///////////////////////






    Route::group(['middleware' => ['permission:View Finance Invoices']], function () {
        Route::get('finance-and-management/finance-invoices-vue', 'FinanceInvoicesController@index_vue');
            Route::get('finance-and-management/finance-invoices-ini', 'FinanceInvoicesController@invoices_init');
            Route::post('finance-and-management/finance-invoices-update', 'FinanceInvoicesController@updateinvoices');
            Route::get('finance-and-management/finance-new-invoices-ini', 'FinanceInvoicesController@new_invoices_init');

            Route::get('finance-and-management/finance-invoices', 'FinanceInvoicesController@index');
            Route::get('finance-and-management/finance-invoices/print', 'FinanceInvoicesController@print');


        Route::get('finance-and-management/finance-cancelled-invoices-vue', 'FinanceInvoicesController@canceled_index_vue');
        Route::get('finance-and-management/finance-cancelled-invoices-ini', 'FinanceInvoicesController@cancelled_invoices_init');
        });

    Route::group(['middleware' => ['permission:Restore Cancelled Finance Invoices']], function () {
    Route::get('finance-and-management/finance-cancelled-invoices/restore/{id}', 'BackupNewFinanceInvoicesController@restorecancelled');
    });

    Route::post('finance-and-management/finance-invoices', 'FinanceInvoicesController@indexdt')->name('invoice.datatable');
    Route::group(['middleware' => ['permission:Print Finance Invoices']], function () {
        Route::get('finance-and-management/finance-invoices/invoice/{id}', 'FinanceInvoicesController@invoice')->name('financeInvoice');
        });
    Route::group(['middleware' => ['permission:Add Finance Invoices']], function () {
        Route::get('finance-and-management/finance-invoices/finance-invoices-aeu', 'FinanceInvoicesController@create');
        });
    Route::post('finance-and-management/finance-invoices/finance-invoices-aeu', 'FinanceInvoicesController@store');
    Route::group(['middleware' => ['permission:Edit Finance Invoices']], function () {
    Route::get('finance-and-management/finance-invoices/finance-invoices-aeu/{id}', 'FinanceInvoicesController@edit');
        });
    Route::post('finance-and-management/finance-invoices/update/{id}', 'FinanceInvoicesController@update');
    Route::group(['middleware' => ['permission:Delete Finance Invoices']], function () {
    Route::get('finance-and-management/finance-invoices/delete/{id}', 'FinanceInvoicesController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Finance Invoices']], function () {
        Route::get('finance-and-management/finance-invoices/deleted', 'FinanceInvoicesController@index_deleted');
        Route::post('finance-and-management/finance-invoices/deleted', 'FinanceInvoicesController@indexdt_deleted')->name('invoice_deleted.datatable');
        });

    Route::get('finance-and-management/finance-invoices/calculateextracharges/{id}', 'FinanceInvoicesController@calculateextracharges');
    Route::get('finance-and-management/finance-invoices/calculatesportscharges/{memid}/{mog}/{id}', 'FinanceInvoicesController@calculatesportscharges');


    Route::group(['middleware' => ['permission:View Monthly Maintenance Fee Posting']], function () {
    Route::get('finance-and-management/maintenance-fee-posting/progress', 'MemMonthlyFeePosting@progress');
        Route::get('finance-and-management/maintenance-fee-posting/maintenance-fee-posting-aeu', 'MemMonthlyFeePosting@create');
        Route::get('finance-and-management/maintenance-fee-posting/maintenance-fee-posting-preview', 'MemMonthlyFeePosting@previewAll');
        Route::post('finance-and-management/maintenance-fee-posting/maintenance-fee-posting-aeu', 'MemMonthlyFeePosting@store');
        Route::post('finance-and-management/maintenance-fee-posting/storeall', 'MemMonthlyFeePosting@storeall');
        Route::post('finance-and-management/maintenance-fee-posting/printall', 'MemMonthlyFeePosting@printall');
        Route::post('finance-and-management/maintenance-fee-posting/printall2', 'MemMonthlyFeePosting@printall2');
    Route::post('finance-and-management/maintenance-fee-posting/printall3', 'MemMonthlyFeePosting@printall3');
    });






    // FINANCE EXPENSES
    Route::group(['middleware' => ['permission:View Expenses']], function () {
        /* Route::get('finance-and-management/finance-expenses-vue', 'FinanceExpenseController@index_vue');
        Route::get('finance-and-management/finance-expenses/expenses_init_vue', 'FinanceExpenseController@expenses_init_vue');
    */

        Route::get('finance-and-management/finance-expenses-vue', 'FinanceExpenseNewController@index_vue');
        Route::get('finance-and-management/finance-expenses/expenses_init_vue', 'FinanceExpenseNewController@sheet_init_vue');

        Route::get('finance-and-management/finance-expenses', 'FinanceExpenseController@index');
        Route::post('finance-and-management/finance-expenses', 'FinanceExpenseController@indexdt')->name('expenses.datatable');
    });
    Route::group(['middleware' => ['permission:Add Expenses']], function () {
        Route::get('finance-and-management/finance-expenses/finance-expenses-aeu', 'FinanceExpenseController@create');
        Route::post('finance-and-management/finance-expenses/finance-expenses-aeu', 'FinanceExpenseController@store');

    /*
        Route::get('finance-and-management/finance-expenses/finance-expenses-aeu-vue', 'FinanceExpenseController@expense_create');
        Route::get('finance-and-management/finance-expenses/finance-expenses-aeu/init', 'FinanceExpenseController@expense_init');
        Route::post('finance-and-management/finance-expenses/finance-expenses-aeu/save', 'FinanceExpenseController@expense_save');*/


        Route::get('finance-and-management/finance-expenses/finance-expenses-aeu-vue', 'FinanceExpenseNewController@create');
        Route::get('finance-and-management/finance-expenses/finance-expenses-aeu/init', 'FinanceExpenseNewController@init');
        Route::post('finance-and-management/finance-expenses/finance-expenses-aeu/save', 'FinanceExpenseNewController@save');

    });
    Route::group(['middleware' => ['permission:Edit Expenses']], function () {
    /*  Route::get('finance-and-management/finance-expenses/finance-expenses-aeu/{id}', 'FinanceExpenseController@edit');
        Route::post('finance-and-management/finance-expenses/update/{id}', 'FinanceExpenseController@update');*/

        Route::get('finance-and-management/finance-expenses/finance-expenses-aeu-vue/{id}', 'FinanceExpenseNewController@edit');
        Route::post('finance-and-management/finance-expenses/update', 'FinanceExpenseNewController@updated');
    });
    Route::group(['middleware' => ['permission:Delete Expenses']], function () {
    /*  Route::post('finance-and-management/finance-expenses/delete/{id}', 'FinanceExpenseController@destroy');*/
        Route::post('finance-and-management/payment-expenses/delete/{id}', 'FinanceExpenseNewController@destroy');
    });
    Route::group(['middleware' => ['permission:Print Expenses Voucher']], function () {
        Route::get('finance-and-management/finance-expenses/finance-expenses-invoice/{id}', 'FinanceExpenseNewController@invoice')->name('expenseInvoice');
    });
    Route::group(['middleware' => ['permission:View Expenses Documents']], function () {
        Route::get('finance-and-management/finance-expenses/finance-expenses-documents/{id}', 'FinanceExpenseController@docs');
    });
    Route::group(['middleware' => ['permission:View Deleted Expenses']], function () {
        Route::get('finance-and-management/finance-expenses/deleted', 'FinanceExpenseNewController@index_deleted');
        Route::post('finance-and-management/finance-expenses/deleted', 'FinanceExpenseNewController@indexdt_deleted')->name('payment_sheet_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Expenses']], function () {
    // Route::get('finance-and-management/finance-expenses/restore/{id}', 'FinanceExpenseController@restore');
        Route::get('finance-and-management/finance-expenses/restore/{id}', 'FinanceExpenseNewController@restore');
        });
    Route::get('finance-and-management/expense/payable/{id}', 'FinanceExpenseController@payables');
    // FINANCE EXPENSES



    // FINANCE EXPENSES new
    Route::group(['middleware' => ['permission:View Payment Finance Sheet']], function () {
        Route::get('finance-and-management/payment-finance-sheet-vue', 'FinanceExpenseNewController@index_vue');
        Route::get('finance-and-management/payment-finance-sheet/sheet_init_vue', 'FinanceExpenseNewController@sheet_init_vue');
    });
    Route::group(['middleware' => ['permission:Print Payment Finance Sheet']], function () {
        Route::get('finance-and-management/payment-finance-sheet/invoice/{id}', 'FinanceExpenseNewController@invoice')->name('paymentSheet');
    });
    Route::group(['middleware' => ['permission:Add Payment Finance Sheet']], function () {
        Route::get('finance-and-management/payment-finance-sheet/payment-finance-sheet-aeu-vue', 'FinanceExpenseNewController@create');
        Route::get('finance-and-management/payment-finance-sheet/payment-finance-sheet-aeu/init', 'FinanceExpenseNewController@init');
        Route::post('finance-and-management/payment-finance-sheet/payment-finance-sheet-aeu/save', 'FinanceExpenseNewController@save');
    });
    Route::group(['middleware' => ['permission:Edit Payment Finance Sheet']], function () {
        Route::get('finance-and-management/payment-finance-sheet/payment-finance-sheet-aeu-vue/{id}', 'FinanceExpenseNewController@edit');
        Route::post('finance-and-management/payment-finance-sheet/update', 'FinanceExpenseNewController@updated');
    });
    Route::group(['middleware' => ['permission:Delete Payment Finance Sheet']], function () {
        Route::post('finance-and-management/payment-finance-sheet/delete/{id}', 'FinanceExpenseNewController@destroy');
    });
    Route::group(['middleware' => ['permission:View Deleted Payment Finance Sheets']], function () {
        Route::get('finance-and-management/payment-finance-sheet/deleted', 'FinanceExpenseNewController@index_deleted');
        Route::post('finance-and-management/payment-finance-sheet/deleted', 'FinanceExpenseNewController@indexdt_deleted')->name('payment_sheet_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Payment Finance Sheet']], function () {
        Route::get('finance-and-management/payment-finance-sheet/restore/{id}', 'FinanceExpenseNewController@restore');
        });
    // FINANCE EXPENSES new



        Route::group(['middleware' => ['permission:View Payment Receipt']], function () {
            Route::get('room-management/room-payment-receipts', 'RoomPaymentReceiptController@index');
            Route::get('finance-and-management/payment-receipts', 'RoomPaymentReceiptController@index_finance');
            Route::get('events-management/payment-receipts', 'RoomPaymentReceiptController@index_events');
        });
        Route::post('room-management/room-payment-receipts', 'RoomPaymentReceiptController@indexdt')->name('payment.datatable');
        Route::group(['middleware' => ['permission:View Deleted Payment Receipts']], function () {
            Route::get('room-management/room-payment-receipts/deleted', 'RoomPaymentReceiptController@index_deleted');
            Route::post('room-management/room-payment-receipts/deleted', 'RoomPaymentReceiptController@indexdt_deleted')->name('payment_deleted.datatable');
            Route::get('finance-and-management/payment-receipts/deleted', 'RoomPaymentReceiptController@index_deleted_finance');
            Route::post('finance-and-management/payment-receipts/deleted', 'RoomPaymentReceiptController@indexdt_deleted')->name('payment_deleted.datatable');
            Route::get('events-management/payment-receipts/deleted', 'RoomPaymentReceiptController@index_deleted_events');
            Route::post('events-management/payment-receipts/deleted', 'RoomPaymentReceiptController@indexdt_deleted')->name('payment_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Add Payment Receipt']], function () {
            Route::get('room-management/room-payment-receipts/room-payment-receipts-aeu', 'RoomPaymentReceiptController@create');
            Route::get('finance-and-management/payment-receipts/payment-receipts-aeu', 'RoomPaymentReceiptController@create_finance');
            Route::get('events-management/payment-receipts/payment-receipts-aeu', 'RoomPaymentReceiptController@create_events');
            Route::post('room-management/room-payment-receipts/room-payment-receipts-aeu', 'RoomPaymentReceiptController@store');
            Route::post('events-management/payment-receipts/payment-receipts-aeu', 'RoomPaymentReceiptController@store_events');
            Route::post('finance-and-management/payment-receipts/payment-receipts-aeu', 'RoomPaymentReceiptController@store_finance');
        });

        Route::group(['middleware' => ['permission:Restore Payment Receipt']], function () {
            Route::get('room-management/room-payment-receipts/restore/{id}', 'RoomPaymentReceiptController@restore');
            Route::get('events-management/payment-receipts/restore/{id}', 'RoomPaymentReceiptController@restore_events');
            Route::get('finance-and-management/payment-receipts/restore/{id}', 'RoomPaymentReceiptController@restore_finance');
        });

        Route::group(['middleware' => ['permission:Edit Payment Receipt']], function () {
            Route::get('room-management/room-payment-receipts/room-payment-receipts-aeu/{id}', 'RoomPaymentReceiptController@edit');
            Route::get('finance-and-management/payment-receipts/payment-receipts-aeu/{id}', 'RoomPaymentReceiptController@edit_finance');
            Route::get('events-management/payment-receipts/payment-receipts-aeu/{id}', 'RoomPaymentReceiptController@edit_events');
            Route::post('room-management/room-payment-receipts/update/{id}', 'RoomPaymentReceiptController@update');
        Route::post('events-management/payment-receipts/update/{id}', 'RoomPaymentReceiptController@update_events');
        Route::post('finance-and-management/payment-receipts/update/{id}', 'RoomPaymentReceiptController@update_finance');
        });

        Route::group(['middleware' => ['permission:Delete Payment Receipt']], function () {
            Route::get('room-management/room-payment-receipts/delete/{id}', 'RoomPaymentReceiptController@destroy');
            Route::get('events-management/payment-receipts/delete/{id}', 'RoomPaymentReceiptController@destroy_events');
            Route::get('finance-and-management/payment-receipts/delete/{id}', 'RoomPaymentReceiptController@destroy_finance');
        });

    Route::group(['middleware' => ['permission:Print Payment Receipt']], function () {
        Route::get('room-management/room-payment-receipts/room-payment-receipts-invoice/{id}', 'PaymentReceiptsInvoiceController@edit');
        Route::get('finance-and-management/finance-payment-receipts/finance-payment-receipts-invoice/{id}', 'PaymentReceiptsInvoiceController@edit_finance');
            Route::get('events-management/events-payment-receipts/events-payment-receipts-invoice/{id}', 'PaymentReceiptsInvoiceController@edit_events');
        });
    Route::group(['middleware' => ['permission:Print Payment Receipt']], function () {
        Route::get('room-management/paymentreceipt-invoice-download/{id}', 'PaymentReceiptPDFController@pdfinvoice');
        });
        Route::post('room-management/room-payment-receipts/memdata', 'RoomPaymentReceiptController@memdata');
        Route::post('room-management/room-payment-receipts/memdatalike', 'RoomPaymentReceiptController@memdatalike');
        Route::get('room-management/room-payment-receipts/calculateextracharges/{id}', 'RoomPaymentReceiptController@calculateextracharges');


        Route::group(['middleware' => ['permission:View Finance and Management']], function () {
            Route::get('finance-and-management', function () {
                return view('backend/finance-and-management/finance-and-management');
            });
            Route::get('finance-and-management/definitions', function () {
                return view('backend/finance-and-management/finance-and-management-definitions');
            });
        });
        Route::group(['middleware' => ['permission:View Expenses Module Page']], function () {
            Route::get('finance-and-management/finance-expenses-submodules', function () {
                return view('backend/finance-and-management/finance-expenses-submodules');
            });
            Route::get('finance-and-management/finance-expenses-submodules/definitions', function () {
                return view('backend/finance-and-management/finance-expenses-definitions');
            });
        });
        Route::group(['middleware' => ['permission:View Vouchers Module Page']], function () {
            Route::get('finance-and-management/finance-vouchers-submodules', function () {
                return view('backend/finance-and-management/finance-vouchers-submodules');
            });
            Route::get('finance-and-management/finance-vouchers-submodules/definitions', function () {
                return view('backend/finance-and-management/finance-vouchers-definitions');
            });
        });
        Route::group(['middleware' => ['permission:View Invoices Module Page']], function () {
            Route::get('finance-and-management/finance-invoices-submodules', function () {
                return view('backend/finance-and-management/finance-invoices-submodules');
            });
            Route::get('finance-and-management/finance-invoices-submodules/definitions', function () {
                return view('backend/finance-and-management/finance-invoices-definitions');
            });
        });
        Route::get('finance-and-management/finance-invoices-submodules/sales', function () {
                return view('backend/finance-and-management/finance-invoices-sales');
            });
        Route::group(['middleware' => ['permission:View Payments Module Page']], function () {
            Route::get('finance-and-management/finance-payments-submodules', function () {
                return view('backend/finance-and-management/finance-payments-submodules');
            });
            Route::get('finance-and-management/finance-payments-submodules/definitions', function () {
                return view('backend/finance-and-management/finance-payments-definitions');
            });
        });
        Route::group(['middleware' => ['permission:View Reports Module Page']], function () {
            Route::get('finance-and-management/finance-reports-submodules', function () {
                return view('backend/finance-and-management/finance-reports-submodules');
            });
        });
        Route::group(['middleware' => ['permission:View Chart of Accounts']], function () {
            Route::get('finance-and-management/chart-of-accounts', function () {
                return view('backend/finance-and-management/chart-of-accounts');
            });
            Route::get('finance-and-management/chart-of-accounts/definitions', function () {
                return view('backend/finance-and-management/chart-of-accounts-definitions');
            });
            Route::get('finance-and-management/chart-of-accounts/definitions/levels-of-accounts', function () {
                return view('backend/finance-and-management/chart-of-accounts-levels');
            });
        });


        /*Route::get('finance-and-management/finance-invoices', 'FinanceInvoiceController@index');
        */


        /*Route::post('room-management/finance-invoices', 'FinanceInvoiceController@indexdt')->name('customer.datatable');
        *//*Route::get('room-management/room-customer/room-customer-aeu', 'CustomerController@create');
    Route::post('room-management/room-customer/room-customer-aeu', 'CustomerController@store');
    Route::get('room-management/room-customer/room-customer-aeu/{id}', 'CustomerController@edit');
    Route::post('room-management/room-customer/update/{id}', 'CustomerController@update');
    Route::get('room-management/room-customer/delete/{id}', 'CustomerController@destroy');
    */

    // FINANCE PAYMENT RECEIVABLES
    Route::group(['middleware' => ['permission:View Payment Receivables']], function () {
        Route::get('finance-and-management/finance-payment-receivables', 'FinancePaymentReceivableController@index');
        Route::post('finance-and-management/finance-payment-receivables', 'FinancePaymentReceivableController@indexdt')->name('finance_payment.datatable');
        });
    Route::group(['middleware' => ['permission:Add Payment Receivables']], function () {
        Route::get('finance-and-management/finance-payment-receivables/finance-payment-receivables-aeu', 'FinancePaymentReceivableController@create');
        Route::post('finance-and-management/finance-payment-receivables/finance-payment-receivables-aeu', 'FinancePaymentReceivableController@store');
        });
    Route::group(['middleware' => ['permission:Edit Payment Receivables']], function () {
        Route::get('finance-and-management/finance-payment-receivables/finance-payment-receivables-aeu/{id}', 'FinancePaymentReceivableController@edit');
        Route::post('finance-and-management/finance-payment-receivables/update/{id}', 'FinancePaymentReceivableController@update');
        });
    Route::group(['middleware' => ['permission:Delete Payment Receivables']], function () {
        Route::get('finance-and-management/finance-payment-receivables/delete/{id}', 'FinancePaymentReceivableController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Payment Receivables']], function () {
        Route::get('finance-and-management/finance-payment-receivables/deleted', 'FinancePaymentReceivableController@index_deleted');
        Route::post('finance-and-management/finance-payment-receivables/deleted', 'FinancePaymentReceivableController@indexdt_deleted')->name('finance_payment_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Payment Receivables']], function () {
        Route::get('finance-and-management/finance-payment-receivables/restore/{id}', 'FinancePaymentReceivableController@restore');
        });
    // FINANCE PAYMENT RECEIVABLES

    // FINANCE VOUCHER TYPES
    Route::group(['middleware' => ['permission:View Voucher Types']], function () {
        Route::get('finance-and-management/finance-voucher-types', 'FinanceVoucherTypeController@index');
        });
        Route::post('finance-and-management/finance-voucher-types', 'FinanceVoucherTypeController@indexdt')->name('voucher_types.datatable');
    Route::group(['middleware' => ['permission:Add Voucher Types']], function () {
        Route::get('finance-and-management/finance-voucher-types/finance-voucher-types-aeu', 'FinanceVoucherTypeController@create');
        });
        Route::post('finance-and-management/finance-voucher-types/finance-voucher-types-aeu', 'FinanceVoucherTypeController@store');
    Route::group(['middleware' => ['permission:Edit Voucher Types']], function () {
        Route::get('finance-and-management/finance-voucher-types/finance-voucher-types-aeu/{id}', 'FinanceVoucherTypeController@edit');
        });
        Route::post('finance-and-management/finance-voucher-types/update/{id}', 'FinanceVoucherTypeController@update');
    Route::group(['middleware' => ['permission:Delete Voucher Types']], function () {
        Route::get('finance-and-management/finance-voucher-types/delete/{id}', 'FinanceVoucherTypeController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Voucher Types']], function () {
        Route::get('finance-and-management/finance-voucher-types/deleted', 'FinanceVoucherTypeController@index_deleted');
        Route::post('finance-and-management/finance-voucher-types/deleted', 'FinanceVoucherTypeController@indexdt_deleted')->name('voucher_types_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Voucher Types']], function () {
        Route::get('finance-and-management/finance-voucher-types/restore/{id}', 'FinanceVoucherTypeController@restore');
        });
    // FINANCE VOUCHER TYPES


    // FINANCE GENERAL VOUCHER
    Route::group(['middleware' => ['permission:View General Voucher']], function () {
        Route::get('finance-and-management/finance-voucher', 'FinanceGeneralVoucherController@index');
        Route::post('finance-and-management/finance-voucher', 'FinanceGeneralVoucherController@indexdt')->name('general_voucher.datatable');
        Route::get('finance-and-management/finance-voucher/post/{id}', 'FinanceGeneralVoucherController@post');
        Route::get('finance-and-management/finance-voucher/unpost/{id}', 'FinanceGeneralVoucherController@unpost');
    });
    Route::get('finance-and-management/finance-voucher/vouchertype/{id}', 'FinanceGeneralVoucherController@vouchertype');
    Route::group(['middleware' => ['permission:Add General Voucher']], function () {
        Route::get('finance-and-management/finance-voucher/finance-voucher-aeu', 'FinanceGeneralVoucherController@create');
        Route::post('finance-and-management/finance-voucher/finance-voucher-aeu', 'FinanceGeneralVoucherController@store');
    });
    Route::group(['middleware' => ['permission:Edit General Voucher']], function () {
        Route::get('finance-and-management/finance-voucher/finance-voucher-aeu/{id}', 'FinanceGeneralVoucherController@edit');
        Route::post('finance-and-management/finance-voucher/update/{id}', 'FinanceGeneralVoucherController@update');
    });
    Route::group(['middleware' => ['permission:Delete General Voucher']], function () {
        Route::get('finance-and-management/finance-voucher/delete/{id}', 'FinanceGeneralVoucherController@destroy');
    });
    Route::group(['middleware' => ['permission:Print General Voucher']], function () {
        Route::get('finance-and-management/finance-voucher/finance-voucher-invoice/{id}', 'FinanceGeneralVoucherController@invoice')->name('JVinvoice');
    });
    Route::group(['middleware' => ['permission:View General Voucher Documents']], function () {
        Route::get('finance-and-management/finance-voucher/finance-voucher-documents/{id}', 'FinanceGeneralVoucherController@docs');
    });
    Route::group(['middleware' => ['permission:View Deleted General Vouchers']], function () {
        Route::get('finance-and-management/finance-voucher/deleted', 'FinanceGeneralVoucherController@index_deleted');
        Route::post('finance-and-management/finance-voucher/deleted', 'FinanceGeneralVoucherController@indexdt_deleted')->name('general_voucher_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore General Voucher']], function () {
        Route::get('finance-and-management/finance-voucher/restore/{id}', 'FinanceGeneralVoucherController@restore');
        });
    // FINANCE GENERAL VOUCHER



    // FINANCE EXPENSE PAID FOR
    Route::group(['middleware' => ['permission:View Expense Payables']], function () {
        Route::get('finance-and-management/finance-expense-paid-for', 'FinanceExpensePaidForController@index');
        });
        Route::post('finance-and-management/finance-expense-paid-for', 'FinanceExpensePaidForController@indexdt')->name('expense_payables.datatable');
    Route::group(['middleware' => ['permission:Add Expense Payables']], function () {
        Route::get('finance-and-management/finance-expense-paid-for/finance-expense-paid-for-aeu', 'FinanceExpensePaidForController@create');
        });
        Route::post('finance-and-management/finance-expense-paid-for/finance-expense-paid-for-aeu', 'FinanceExpensePaidForController@store');
    Route::group(['middleware' => ['permission:Edit Expense Payables']], function () {
        Route::get('finance-and-management/finance-expense-paid-for/finance-expense-paid-for-aeu/{id}', 'FinanceExpensePaidForController@edit');
        });
        Route::post('finance-and-management/finance-expense-paid-for/update/{id}', 'FinanceExpensePaidForController@update');
    Route::group(['middleware' => ['permission:Delete Expense Payables']], function () {
        Route::get('finance-and-management/finance-expense-paid-for/delete/{id}', 'FinanceExpensePaidForController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Expense Payables']], function () {
        Route::get('finance-and-management/finance-expense-paid-for/deleted', 'FinanceExpensePaidForController@index_deleted');
        Route::post('finance-and-management/finance-expense-paid-for/deleted', 'FinanceExpensePaidForController@indexdt_deleted')->name('expense_payables_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Expense Payables']], function () {
        Route::get('finance-and-management/finance-expense-paid-for/restore/{id}', 'FinanceExpensePaidForController@restore');
        });
    // FINANCE EXPENSE PAID FOR



    // LEVEL ONE
    Route::group(['middleware' => ['permission:View Level One']], function () {
        Route::get('finance-and-management/finance-level-one', 'FinanceLevelOneController@index');
        });
        Route::post('finance-and-management/finance-level-one', 'FinanceLevelOneController@indexdt')->name('level_one.datatable');
    Route::group(['middleware' => ['permission:Add Level One']], function () {
        Route::get('finance-and-management/finance-level-one/finance-level-one-aeu', 'FinanceLevelOneController@create');
        });
        Route::post('finance-and-management/finance-level-one/finance-level-one-aeu', 'FinanceLevelOneController@store');
    Route::group(['middleware' => ['permission:Edit Level One']], function () {
        Route::get('finance-and-management/finance-level-one/finance-level-one-aeu/{id}', 'FinanceLevelOneController@edit');
        });
        Route::post('finance-and-management/finance-level-one/update/{id}', 'FinanceLevelOneController@update');
    Route::group(['middleware' => ['permission:Delete Level One']], function () {
        Route::get('finance-and-management/finance-level-one/delete/{id}', 'FinanceLevelOneController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Level One']], function () {
        Route::get('finance-and-management/finance-level-one/deleted', 'FinanceLevelOneController@index_deleted');
        Route::post('finance-and-management/finance-level-one/deleted', 'FinanceLevelOneController@indexdt_deleted')->name('level_one_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Level One']], function () {
        Route::get('finance-and-management/finance-level-one/restore/{id}', 'FinanceLevelOneController@restore');
        });
    // LEVEL ONE
    // LEVEL TWO
    Route::group(['middleware' => ['permission:View Level Two']], function () {
        Route::get('finance-and-management/finance-level-two', 'FinanceLevelTwoController@index');
        });
        Route::post('finance-and-management/finance-level-two', 'FinanceLevelTwoController@indexdt')->name('level_two.datatable');
    Route::group(['middleware' => ['permission:Add Level Two']], function () {
        Route::get('finance-and-management/finance-level-two/finance-level-two-aeu', 'FinanceLevelTwoController@create');
        });
        Route::post('finance-and-management/finance-level-two/finance-level-two-aeu', 'FinanceLevelTwoController@store');
    Route::group(['middleware' => ['permission:Edit Level Two']], function () {
        Route::get('finance-and-management/finance-level-two/finance-level-two-aeu/{id}', 'FinanceLevelTwoController@edit');
        });
        Route::post('finance-and-management/finance-level-two/update/{id}', 'FinanceLevelTwoController@update');
    Route::group(['middleware' => ['permission:Delete Level Two']], function () {
        Route::get('finance-and-management/finance-level-two/delete/{id}', 'FinanceLevelTwoController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Level Two']], function () {
        Route::get('finance-and-management/finance-level-two/deleted', 'FinanceLevelTwoController@index_deleted');
        Route::post('finance-and-management/finance-level-two/deleted', 'FinanceLevelTwoController@indexdt_deleted')->name('level_two_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Level Two']], function () {
        Route::get('finance-and-management/finance-level-two/restore/{id}', 'FinanceLevelTwoController@restore');
        });
    // LEVEL TWO
        // LEVEL THREE
    Route::group(['middleware' => ['permission:View Level Three']], function () {
        Route::get('finance-and-management/finance-level-three', 'FinanceLevelThreeController@index');
        });
        Route::post('finance-and-management/finance-level-three', 'FinanceLevelThreeController@indexdt')->name('level_three.datatable');
    Route::group(['middleware' => ['permission:Add Level Three']], function () {
        Route::get('finance-and-management/finance-level-three/finance-level-three-aeu', 'FinanceLevelThreeController@create');
        });
        Route::post('finance-and-management/finance-level-three/finance-level-three-aeu', 'FinanceLevelThreeController@store');
    Route::group(['middleware' => ['permission:Edit Level Three']], function () {
        Route::get('finance-and-management/finance-level-three/finance-level-three-aeu/{id}', 'FinanceLevelThreeController@edit');
        });
        Route::post('finance-and-management/finance-level-three/update/{id}', 'FinanceLevelThreeController@update');
    Route::group(['middleware' => ['permission:Delete Level Three']], function () {
        Route::get('finance-and-management/finance-level-three/delete/{id}', 'FinanceLevelThreeController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Level Three']], function () {
        Route::get('finance-and-management/finance-level-three/deleted', 'FinanceLevelThreeController@index_deleted');
        Route::post('finance-and-management/finance-level-three/deleted', 'FinanceLevelThreeController@indexdt_deleted')->name('level_three_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Level Three']], function () {
        Route::get('finance-and-management/finance-level-three/restore/{id}', 'FinanceLevelThreeController@restore');
        });
        Route::get('finance-and-management/levelone/leveltwo/{id}', 'FinanceLevelThreeController@leveltwo');
        Route::get('finance-and-management/leveltwo/levelthree/{id}', 'FinanceLevelThreeController@levelthree');
        Route::get('finance-and-management/levelthree/levelfour/{id}', 'FinanceLevelThreeController@levelfour');
    // LEVEL THREE


    //ACCOUNT HEADS
    Route::group(['middleware' => ['permission:View Account Heads']], function () {
        Route::get('finance-and-management/finance-account-heads', 'FinanceAccountHeadController@index');
        });
        Route::post('finance-and-management/finance-account-heads', 'FinanceAccountHeadController@indexdt')->name('account_heads.datatable');
    Route::group(['middleware' => ['permission:Add Account Heads']], function () {
        Route::get('finance-and-management/finance-account-heads/finance-account-heads-aeu', 'FinanceAccountHeadController@create');
        });
        Route::post('finance-and-management/finance-account-heads/finance-account-heads-aeu', 'FinanceAccountHeadController@store');
    Route::group(['middleware' => ['permission:Edit Account Heads']], function () {
        Route::get('finance-and-management/finance-account-heads/finance-account-heads-aeu/{id}', 'FinanceAccountHeadController@edit');
        });
        Route::post('finance-and-management/finance-account-heads/update/{id}', 'FinanceAccountHeadController@update');
    Route::group(['middleware' => ['permission:Delete Account Heads']], function () {
        Route::get('finance-and-management/finance-account-heads/delete/{id}', 'FinanceAccountHeadController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Account Heads']], function () {
        Route::get('finance-and-management/finance-account-heads/deleted', 'FinanceAccountHeadController@index_deleted');
        Route::post('finance-and-management/finance-account-heads/deleted', 'FinanceAccountHeadController@indexdt_deleted')->name('account_heads_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Account Heads']], function () {
        Route::get('finance-and-management/finance-account-heads/restore/{id}', 'FinanceAccountHeadController@restore');
        });
    Route::get('finance-and-management/account_head/accounttypes/{id}', 'FinanceAccountHeadController@gettypes');
    //ACCOUNT HEADS



    //EXPENSE HEADS
    Route::group(['middleware' => ['permission:View Expense Heads']], function () {
        Route::get('finance-and-management/finance-expense-heads', 'FinanceExpenseHeadController@index');
        });
        Route::post('finance-and-management/finance-expense-heads', 'FinanceExpenseHeadController@indexdt')->name('expense_heads.datatable');
    Route::group(['middleware' => ['permission:Add Expense Heads']], function () {
        Route::get('finance-and-management/finance-expense-heads/finance-expense-heads-aeu', 'FinanceExpenseHeadController@create');
        });
        Route::post('finance-and-management/finance-expense-heads/finance-expense-heads-aeu', 'FinanceExpenseHeadController@store');
    Route::group(['middleware' => ['permission:Edit Expense Heads']], function () {
        Route::get('finance-and-management/finance-expense-heads/finance-expense-heads-aeu/{id}', 'FinanceExpenseHeadController@edit');
        });
        Route::post('finance-and-management/finance-expense-heads/update/{id}', 'FinanceExpenseHeadController@update');
    Route::group(['middleware' => ['permission:Delete Expense Heads']], function () {
        Route::get('finance-and-management/finance-expense-heads/delete/{id}', 'FinanceExpenseHeadController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Expense Heads']], function () {
        Route::get('finance-and-management/finance-expense-heads/deleted', 'FinanceExpenseHeadController@index_deleted');
        Route::post('finance-and-management/finance-expense-heads/deleted', 'FinanceExpenseHeadController@indexdt_deleted')->name('expense_heads_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Expense Heads']], function () {
        Route::get('finance-and-management/finance-expense-heads/restore/{id}', 'FinanceExpenseHeadController@restore');
        });
    //EXPENSE HEADS


    //ACCOUNT TYPES
    Route::group(['middleware' => ['permission:View Account Types']], function () {
        Route::get('finance-and-management/finance-account-types', 'FinanceAccountTypeController@index');
        });
        Route::post('finance-and-management/finance-account-types', 'FinanceAccountTypeController@indexdt')->name('account_types.datatable');
    Route::group(['middleware' => ['permission:Add Account Types']], function () {
        Route::get('finance-and-management/finance-account-types/finance-account-types-aeu', 'FinanceAccountTypeController@create');
        });
        Route::post('finance-and-management/finance-account-types/finance-account-types-aeu', 'FinanceAccountTypeController@store');
    Route::group(['middleware' => ['permission:Edit Account Types']], function () {
        Route::get('finance-and-management/finance-account-types/finance-account-types-aeu/{id}', 'FinanceAccountTypeController@edit');
        });
        Route::post('finance-and-management/finance-account-types/update/{id}', 'FinanceAccountTypeController@update');
    Route::group(['middleware' => ['permission:Delete Account Types']], function () {
        Route::get('finance-and-management/finance-account-types/delete/{id}', 'FinanceAccountTypeController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Account Types']], function () {
        Route::get('finance-and-management/finance-account-types/deleted', 'FinanceAccountTypeController@index_deleted');
        Route::post('finance-and-management/finance-account-types/deleted', 'FinanceAccountTypeController@indexdt_deleted')->name('account_types_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Account Types']], function () {
        Route::get('finance-and-management/finance-account-types/restore/{id}', 'FinanceAccountTypeController@restore');
        });
    //ACCOUNT TYPES


    // ACCOUNTS LINKING
    Route::group(['middleware' => ['permission:View Accounts Linking']], function () {
        Route::get('finance-and-management/coa-linking', 'FinanceAccountTypeController@linking_index');
        Route::post('finance-and-management/coa-linking', 'FinanceAccountTypeController@linking_indexdt')->name('accounts_linking.datatable');

        Route::get('finance-and-management/coa-linking/link/{id}', 'FinanceAccountTypeController@link');
        Route::post('finance-and-management/coa-linking/link/{id}', 'FinanceAccountTypeController@update_link');

    Route::get('finance-and-management/coa-linking/link/{id}/{account}', 'FinanceAccountTypeController@edit_link')->name('linking.edit');

    });
    // ACCOUNTS LINKING


    // FINANCE PAYMENT METHODS
    Route::group(['middleware' => ['permission:View Payment Methods']], function () {
        Route::get('finance-and-management/finance-payment-methods', 'FinancePaymentMethodsController@index');
        });
        Route::post('finance-and-management/finance-payment-methods', 'FinancePaymentMethodsController@indexdt')->name('payment_method.datatable');
    Route::group(['middleware' => ['permission:Add Payment Methods']], function () {
        Route::get('finance-and-management/finance-payment-methods/finance-payment-methods-aeu', 'FinancePaymentMethodsController@create');
        });
        Route::post('finance-and-management/finance-payment-methods/finance-payment-methods-aeu', 'FinancePaymentMethodsController@store');
    Route::group(['middleware' => ['permission:Edit Payment Methods']], function () {
        Route::get('finance-and-management/finance-payment-methods/finance-payment-methods-aeu/{id}', 'FinancePaymentMethodsController@edit');
        });
        Route::post('finance-and-management/finance-payment-methods/update/{id}', 'FinancePaymentMethodsController@update');
    Route::group(['middleware' => ['permission:Delete Payment Methods']], function () {
        Route::get('finance-and-management/finance-payment-methods/delete/{id}', 'FinancePaymentMethodsController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Payment Methods']], function () {
        Route::get('finance-and-management/finance-payment-methods/deleted', 'FinancePaymentMethodsController@index_deleted');
        Route::post('finance-and-management/finance-payment-methods/deleted', 'FinancePaymentMethodsController@indexdt_deleted')->name('payment_method_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Restore Payment Methods']], function () {
        Route::get('finance-and-management/finance-payment-methods/restore/{id}', 'FinancePaymentMethodsController@restore');
        });
    // FINANCE PAYMENT METHODS



    //not in use
    /* Route::get('club-hospitality/monthly-maintenance-fee-posting', function () {
            return view('backend/club-hospitality/monthly-maintenance-fee-posting/monthly-fee-posting');
        });*/
    //not in use

    });



    /* CASH FLOW*/
    Route::group(['middleware' => ['permission:View Cash Flow']], function () {
        Route::get('finance-and-management/finance-cash-flow', 'FinanceCashFlowController@index');
        Route::get('finance-and-management/finance-cash-flow/print', 'FinanceCashFlowController@print');

        Route::post('finance-and-management/finance-cash-flow', 'FinanceCashFlowController@indexdt')->name('cashflow.datatable');
        Route::get('finance-and-management/finance-cash-flow/export', 'FinanceCashFlowController@export')->name('cashflowExport.export');
    });
    /* CASH FLOW*/


    /* FINANCE SALES REPORT */
    Route::group(['middleware' => ['permission:View Sales Report']], function () {
        Route::get('finance-and-management/finance-sales-report-vue', 'FinanceCashFlowController@salesreport_vue');
        Route::get('finance-and-management/reports/finance-sales-report/salesreport_init_vue', 'FinanceCashFlowController@salesreport_init_vue');
    });

    Route::group(['middleware' => ['permission:View Sales Report']], function () {
        Route::get('finance-and-management/finance-sales-report', 'FinanceCashFlowController@salesreport');
    });
    /* FINANCE SALES REPORT */


    Route::group(['middleware' => ['permission:View Sports Subscription']], function () {
        Route::get('sports-subscription', function () {
            return view('backend/sports-subscription/sports-subscription');
        });
        Route::get('sports-subscription/definitions', function () {
                return view('backend/sports-subscription/sports-subscription-definitions');
        });
    });


    Route::group(['middleware' => ['permission:View Subscriptions Datatable']], function () {
        Route::get('sports-subscription/subscriptions-datatable-vue', 'FinanceInvoicesController@index_subscriptions_vue');
        Route::get('sports-subscription/subscriptions-datatable-ini', 'FinanceInvoicesController@subscriptions_init');
    });
    Route::group(['middleware' => ['permission:View Reinstating Fee Datatable']], function () {
        Route::get('sports-subscription/reinstating-fee-datatable-vue', 'FinanceInvoicesController@index_reinstating_vue');
        Route::get('sports-subscription/reinstating-fee-datatable-ini', 'FinanceInvoicesController@reinstating_init');
    });
    Route::group(['middleware' => ['permission:View Corporate Reinstating Fee Datatable']], function () {
        Route::get('sports-subscription/corporate-reinstating-fee-datatable-vue', 'FinanceInvoicesController@co_index_reinstating_vue');
        Route::get('sports-subscription/corporate-reinstating-fee-datatable-ini', 'FinanceInvoicesController@co_reinstating_init');
    });
    Route::group(['middleware' => ['permission:View Maintenance Fee Datatable']], function () {
    Route::get('sports-subscription/maintenance-fee-datatable-vue', 'FinanceInvoicesController@index_maintenance_vue');
        Route::get('sports-subscription/maintenance-fee-datatable-ini', 'FinanceInvoicesController@maintenance_init');
    });
    Route::group(['middleware' => ['permission:View Corporate Maintenance Fee Datatable']], function () {
    Route::get('sports-subscription/corporate-maintenance-fee-datatable-vue', 'FinanceInvoicesController@index_co_maintenance_vue');
        Route::get('sports-subscription/corporate-maintenance-fee-datatable-ini', 'FinanceInvoicesController@co_maintenance_init');
    });
    Route::group(['middleware' => ['permission:View Card Printing Datatable']], function () {
        Route::get('sports-subscription/card-printing-datatable-vue', 'FinanceInvoicesController@index_cardprinting_vue');
        Route::get('sports-subscription/card-printing-datatable-ini', 'FinanceInvoicesController@cardprinting_init');
    });
    Route::group(['middleware' => ['permission:View Corporate Card Printing Datatable']], function () {
        Route::get('sports-subscription/corporate-card-printing-datatable-vue', 'FinanceInvoicesController@index_co_cardprinting_vue');
        Route::get('sports-subscription/corporate-card-printing-datatable-ini', 'FinanceInvoicesController@co_cardprinting_init');
    });



    Route::group(['middleware' => ['permission:View Subscription Types']], function () {
        Route::get('sports-subscription/sports', 'SportsSubscriptionController@index');
        Route::post('sports-subscription/sports', 'SportsSubscriptionController@indexdt')->name('sports.datatable');
        });
    Route::group(['middleware' => ['permission:Add Subscription Types']], function () {
        Route::get('sports-subscription/sports/sports-aeu', 'SportsSubscriptionController@create');
        Route::post('sports-subscription/sports/sports-aeu', 'SportsSubscriptionController@store');
        });
    Route::group(['middleware' => ['permission:View Deleted Subscription Types']], function () {
            Route::get('sports-subscription/sports/deleted', 'SportsSubscriptionController@index_deleted');
            Route::post('sports-subscription/sports/deleted', 'SportsSubscriptionController@indexdt_deleted')->name('sports_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Edit Subscription Types']], function () {
        Route::get('sports-subscription/sports/sports-aeu/{id}', 'SportsSubscriptionController@edit');
        });
    Route::post('sports-subscription/sports/update/{id}', 'SportsSubscriptionController@update');
    Route::group(['middleware' => ['permission:Delete Subscription Types']], function () {
        Route::get('sports-subscription/sports/delete/{id}', 'SportsSubscriptionController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Subscription Types']], function () {
            Route::get('sports-subscription/sports/restore/{id}', 'SportsSubscriptionController@restore');
        });



    /*Calender Controller*/
    Route::group(['middleware' => ['permission:View Room Booking Calendar']], function () {
        Route::get('room-management/calender', 'BookingcalenderController@index');
    });
    Route::get('room-management/room-calender/calender-aeu/{id}', 'BookingcalenderController@create')->name('booking.calender.show');


    Route::group(['middleware' => ['permission:View Room Booking Calendar']], function () {
        Route::get('room-management/calender-vue', 'BookingcalenderController@calendar_vue');
        Route::get('room-management/calender/calendar_init_vue', 'BookingcalenderController@calendar_init_vue');
    });

    /*Calender Controller*/


    /*Event Calender Controller*/
    Route::group(['middleware' => ['permission:View Event Calendar']], function () {
        Route::get('events-management/calendar', 'EventCalendarController@index');
    });
    /*Event Calender Controller*/



    /*FINANCE LEDGER PERSON*/
    Route::group(['middleware' => ['permission:View Ledger Persons']], function () {
        Route::get('finance-and-management/suppliers', 'FinanceLedgerPersonController@index');
        });
        Route::post('finance-and-management/suppliers', 'FinanceLedgerPersonController@indexdt')->name('ledgerperson.datatable');
    Route::group(['middleware' => ['permission:Add Ledger Persons']], function () {
        Route::get('finance-and-management/suppliers/suppliers-aeu', 'FinanceLedgerPersonController@create');
        });
        Route::post('finance-and-management/suppliers/suppliers-aeu', 'FinanceLedgerPersonController@store');
    Route::group(['middleware' => ['permission:Edit Ledger Persons']], function () {
        Route::get('finance-and-management/suppliers/suppliers-aeu/{id}', 'FinanceLedgerPersonController@edit');
        });
        Route::post('finance-and-management/suppliers/update/{id}', 'FinanceLedgerPersonController@update');
    Route::group(['middleware' => ['permission:Delete Ledger Persons']], function () {
        Route::get('finance-and-management/suppliers/delete/{id}', 'FinanceLedgerPersonController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Ledger Persons']], function () {
        Route::get('finance-and-management/suppliers/deleted', 'FinanceLedgerPersonController@index_deleted');
        Route::post('finance-and-management/suppliers/deleted', 'FinanceLedgerPersonController@indexdt_deleted')->name('ledgerperson_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Ledger Persons']], function () {
        Route::get('finance-and-management/suppliers/restore/{id}', 'FinanceLedgerPersonController@restore');
        });
    /*FINANCE LEDGER PERSON*/



    /*FINANCE INVOICE CHARGES TYPES */

    Route::group(['middleware' => ['permission:View Invoice Charges Types']], function () {
    Route::get('finance-and-management/invoice-charges-types', 'FinanceInvoiceChargesTypeController@index');
        });
    Route::post('finance-and-management/invoice-charges-types', 'FinanceInvoiceChargesTypeController@indexdt')->name('invoicechargestypes.datatable');
    Route::group(['middleware' => ['permission:Add Invoice Charges Types']], function () {
    Route::get('finance-and-management/invoice-charges-types/invoice-charges-types-aeu', 'FinanceInvoiceChargesTypeController@create');
        });
    Route::post('finance-and-management/invoice-charges-types/invoice-charges-types-aeu', 'FinanceInvoiceChargesTypeController@store');
    Route::group(['middleware' => ['permission:Edit Invoice Charges Types']], function () {
    Route::get('finance-and-management/invoice-charges-types/invoice-charges-types-aeu/{id}', 'FinanceInvoiceChargesTypeController@edit');
        });
    Route::post('finance-and-management/invoice-charges-types/update/{id}', 'FinanceInvoiceChargesTypeController@update');
    Route::group(['middleware' => ['permission:Delete Invoice Charges Types']], function () {
    Route::get('finance-and-management/invoice-charges-types/delete/{id}', 'FinanceInvoiceChargesTypeController@destroy');
        });
    Route::group(['middleware' => ['permission:View Deleted Invoice Charges Types']], function () {
        Route::get('finance-and-management/invoice-charges-types/deleted', 'FinanceInvoiceChargesTypeController@index_deleted');
        Route::post('finance-and-management/invoice-charges-types/deleted', 'FinanceInvoiceChargesTypeController@indexdt_deleted')->name('invoicechargestypes_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Restore Invoice Charges Types']], function () {
        Route::get('finance-and-management/invoice-charges-types/restore/{id}', 'FinanceInvoiceChargesTypeController@restore');
        });
    /*FINANCE INVOICE CHARGES TYPES */




    /*reports module page*/
    Route::group(['middleware' => ['permission:View Reports']], function () {
            Route::get('room-management/room-reports', function () {
                return view('backend/room-management/room-reports-modulepage');
            });
        });
    Route::group(['middleware' => ['permission:View Reports']], function () {
            Route::get('finance-and-management/finance-reports', function () {
                return view('backend/finance-and-management/finance-reports-modulepage');
            });
        });
    /*reports module page*/

    Route::get('finance-and-management/food-and-beverage/reports', function () {
                return view('backend/finance-and-management/finance-reports/food-and-beverage-reports');
            });
    Route::get('finance-and-management/store-management/reports', function () {
                return view('backend/finance-and-management/finance-reports/store-management-reports');
            });
    Route::get('finance-and-management/sales/reports', function () {
                return view('backend/finance-and-management/finance-reports/sales-reports');
            });
    Route::get('finance-and-management/room-management/reports', function () {
                return view('backend/finance-and-management/finance-reports/room-management-reports');
            });
    Route::get('finance-and-management/reports', function () {
                return view('backend/finance-and-management/finance-reports/finance-and-management-reports');
            });
    Route::get('finance-and-management/ledgers-and-trial-balances', function () {
                return view('backend/finance-and-management/finance-reports/ledgers-and-trial-balances');
            });
    Route::get('finance-and-management/club-membership-management/reports', function () {
                return view('backend/finance-and-management/finance-reports/club-membership-management-reports');
            });
    Route::get('finance-and-management/club-membership-management/maintenance-reports', function () {
                return view('backend/finance-and-management/finance-reports/maintenance-reports');
            });
    Route::get('finance-and-management/club-membership-management/membership-reports', function () {
                return view('backend/finance-and-management/finance-reports/membership-reports');
            });
    Route::get('finance-and-management/crm/reports', function () {
                return view('backend/finance-and-management/finance-reports/crm-reports');
            });


    /*MEMBERS ACCES MANAGEMENT*/
    Route::group(['middleware' => ['permission:View Members Access Management']], function () {
        Route::get('members-access', function () {
            return view('backend/members-access/members-access');
        });
    });
    Route::get('club-hospitality/member-subscriptions', 'memberSubscriptions@index');
    Route::post('club-hospitality/member-subscriptions/{id}', 'memberSubscriptions@saveSubscriptions')->name('member.subscription.save');

        Route::group(['middleware' => ['permission:View Search Members']], function () {
    //        Route::get('members-access/search-members', 'AccessSearchMembersController@index');
        Route::get('members-access/search-members', 'AccessSearchMembersController@index');

        Route::get('members-access/search-members/{type}/{id}', 'AccessSearchMembersController@checkin')->name('access.checkin');

        Route::get('members-access/search-members-vue', 'AccessSearchMembersController@search_members_index_vue');
        Route::get('members-access/search-members/search_members_init_vue', 'AccessSearchMembersController@search_members_init_vue');

        });
    //  Route::post('members-access/search-members', 'AccessSearchMembersController@indexdt')->name('access.datatable');

    /*MEMBERS ACCES MANAGEMENT*/





    /*HUMAN RESOURCE MANAGEMENT*/
    Route::group(['middleware' => ['permission:View Human Resource Management']], function () {
        Route::get('human-resource', function () {
            return view('backend/human-resource/human-resource');
        });
        Route::get('human-resource/definitions', function () {
                return view('backend/human-resource/human-resource-definitions');
        });
    });


    // EMPLOYMENT
    Route::group(['middleware' => ['permission:View Employee Payroll']], function () {
        Route::get('human-resource/employment/payroll-vue', 'HrEmploymentController@payroll_vue');
        Route::get('human-resource/employment/payroll_init_vue', 'HrEmploymentController@payroll_init_vue');
    });
    Route::group(['middleware' => ['permission:View Employee Salary Voucher']], function () {
        Route::get('human-resource/employment/salary-vue', 'HrEmploymentController@salary_vue');
        Route::get('human-resource/employment/salary_init_vue', 'HrEmploymentController@salary_init_vue');
    });
    Route::group(['middleware' => ['permission:Generate Employee Salary Voucher']], function () {
        Route::post('human-resource/employment/voucher/save', 'HrEmploymentController@pay_salary');
    });
    Route::group(['middleware' => ['permission:Print Employee Salary Voucher']], function () {
        Route::get('human-resource/employment/voucher/print/{id}', 'HrEmploymentController@voucher')->name('EmploymentVoucher');
    });
    Route::group(['middleware' => ['permission:View Deleted Employee Salary Vouchers']], function () {
        Route::get('human-resource/employment/voucher/deleted-vue', 'HrEmploymentController@index_deleted_voucher');
        Route::get('human-resource/employment/voucher/indexdt_deleted', 'HrEmploymentController@indexdt_deleted_voucher');
    });
    Route::group(['middleware' => ['permission:Delete Employee Salary Voucher']], function () {
            Route::get('human-resource/employment/voucher/delete/{id}', 'HrEmploymentController@destroy_voucher');
    });
    Route::group(['middleware' => ['permission:Restore Employee Salary Voucher']], function () {
            Route::get('human-resource/employment/voucher/restore/{id}', 'HrEmploymentController@restore_voucher');
    });



    Route::group(['middleware' => ['permission:Check In Employee']], function () {
        Route::get('human-resource/employment/checkin', 'HrEmploymentController@checkin');
        Route::post('human-resource/employment/checkin', 'HrEmploymentController@checkinsave')->name('employee.checkin');
    });
    Route::group(['middleware' => ['permission:Check Out Employee']], function () {
        Route::get('human-resource/employment/check_out', 'HrEmploymentController@checkout');
        Route::post('human-resource/employment/check_out', 'HrEmploymentController@checkoutsave')->name('employee.checkout');
    });
    Route::group(['middleware' => ['permission:View Employee Attendance']], function () {
        Route::get('human-resource/employment/attend', 'HrEmploymentController@attend');
        Route::get('human-resource/employment/attend/export', 'HrEmploymentController@export');

        Route::get('human-resource/employment/attend-vue', 'HrEmploymentController@attend_vue');
        Route::get('human-resource/employment/attend_init_vue', 'HrEmploymentController@attend_init_vue');
        Route::get('human-resource/employment/visits', 'HrEmploymentController@visits');
    });

    Route::group(['middleware' => ['permission:View Monthly Employee Food Bills']], function () {
        Route::get('finance-and-management/reports/food-bills-vue', 'HrEmploymentController@foodbills_vue');
        Route::get('finance-and-management/reports/foodbills_init_vue', 'HrEmploymentController@foodbills_init_vue');
    });  

    Route::group(['middleware' => ['permission:View Total Monthly Employee Food Bills']], function () {
        Route::get('finance-and-management/reports/total-food-bills-vue', 'HrEmploymentController@totalfoodbills_vue');
        Route::get('finance-and-management/reports/totalfoodbills_init_vue', 'HrEmploymentController@totalfoodbills_init_vue');
    });  
    
    Route::group(['middleware' => ['permission:View Daily Employee Attendance']], function () {
        Route::get('human-resource/employment/daily-attend-vue', 'HrEmploymentController@daily_vue');
        Route::get('human-resource/employment/daily_init_vue', 'HrEmploymentController@daily_init_vue');
    });

    Route::group(['middleware' => ['permission:View Employment']], function () {
        Route::get('human-resource/employment', 'HrEmploymentController@index');
        Route::post('human-resource/employment', 'HrEmploymentController@indexdt')->name('employment.datatable');

        Route::get('human-resource/employment-vue', 'HrEmploymentController@index_vue');
        Route::get('human-resource/employment/init_vue', 'HrEmploymentController@init_vue');
        });
        Route::group(['middleware' => ['permission:Add Employment']], function () {
            Route::get('human-resource/employment/employment-aeu', 'HrEmploymentController@create');
            Route::post('human-resource/employment/employment-aeu', 'HrEmploymentController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Employments']], function () {
            Route::get('human-resource/employment/deleted', 'HrEmploymentController@index_deleted');
            Route::post('human-resource/employment/deleted', 'HrEmploymentController@indexdt_deleted')->name('employment_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Employment']], function () {
            Route::get('human-resource/employment/employment-aeu/{id}', 'HrEmploymentController@edit');
        });
        Route::post('human-resource/employment/update/{id}', 'HrEmploymentController@update');
        Route::group(['middleware' => ['permission:Delete Employment']], function () {
            Route::post('human-resource/employment/delete/{id}', 'HrEmploymentController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Employment']], function () {
        Route::get('human-resource/employment/restore/{id}', 'HrEmploymentController@restore');
        });


        Route::group(['middleware' => ['permission:View Employment Documents']], function () {
        Route::get('human-resource/employment/employment-docs-aeu/{id}', 'EmploymentDocumentsController@create');
        });
    Route::post('human-resource/employment/employment-docs-aeu/{id}', 'EmploymentDocumentsController@store');
    Route::get('human-resource/company/department/{id}', 'HrEmploymentController@department');
    Route::get('human-resource/department/subdepartment/{id}', 'HrEmploymentController@subdepartment');


    Route::group(['middleware' => ['permission:View Departments']], function () {
            Route::get('human-resource/departments', 'HrDepartmentController@index');
            Route::post('human-resource/departments', 'HrDepartmentController@indexdt')->name('departments.datatable');
        });
        Route::group(['middleware' => ['permission:Add Departments']], function () {
            Route::get('human-resource/departments/departments-aeu', 'HrDepartmentController@create');
            Route::post('human-resource/departments/departments-aeu', 'HrDepartmentController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Departments']], function () {
            Route::get('human-resource/departments/deleted', 'HrDepartmentController@index_deleted');
            Route::post('human-resource/departments/deleted', 'HrDepartmentController@indexdt_deleted')->name('departments_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Departments']], function () {
            Route::get('human-resource/departments/departments-aeu/{id}', 'HrDepartmentController@edit');
            Route::post('human-resource/departments/update/{id}', 'HrDepartmentController@update');
        });
        Route::group(['middleware' => ['permission:Delete Departments']], function () {
            Route::get('human-resource/departments/delete/{id}', 'HrDepartmentController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Departments']], function () {
            Route::get('human-resource/departments/restore/{id}', 'HrDepartmentController@restore');
        });


    Route::group(['middleware' => ['permission:View Sub-Departments']], function () {
            Route::get('human-resource/sub-departments', 'HrSubDepartmentController@index');
            Route::post('human-resource/sub-departments', 'HrSubDepartmentController@indexdt')->name('sub_departments.datatable');
        });
        Route::group(['middleware' => ['permission:Add Sub-Departments']], function () {
            Route::get('human-resource/sub-departments/sub-departments-aeu', 'HrSubDepartmentController@create');
            Route::post('human-resource/sub-departments/sub-departments-aeu', 'HrSubDepartmentController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Sub-Departments']], function () {
            Route::get('human-resource/sub-departments/deleted', 'HrSubDepartmentController@index_deleted');
            Route::post('human-resource/sub-departments/deleted', 'HrSubDepartmentController@indexdt_deleted')->name('sub_departments_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Sub-Departments']], function () {
            Route::get('human-resource/sub-departments/sub-departments-aeu/{id}', 'HrSubDepartmentController@edit');
            Route::post('human-resource/sub-departments/update/{id}', 'HrSubDepartmentController@update');
        });
        Route::group(['middleware' => ['permission:Delete Sub-Departments']], function () {
            Route::get('human-resource/sub-departments/delete/{id}', 'HrSubDepartmentController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Sub-Departments']], function () {
            Route::get('human-resource/sub-departments/restore/{id}', 'HrSubDepartmentController@restore');
        });



        Route::group(['middleware' => ['permission:View Companies']], function () {
            Route::get('human-resource/companies', 'HrCompanyController@index');
            Route::post('human-resource/companies', 'HrCompanyController@indexdt')->name('companies.datatable');
        });
        Route::group(['middleware' => ['permission:Add Companies']], function () {
            Route::get('human-resource/companies/companies-aeu', 'HrCompanyController@create');
            Route::post('human-resource/companies/companies-aeu', 'HrCompanyController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Companies']], function () {
            Route::get('human-resource/companies/deleted', 'HrCompanyController@index_deleted');
            Route::post('human-resource/companies/deleted', 'HrCompanyController@indexdt_deleted')->name('companies_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Companies']], function () {
            Route::get('human-resource/companies/companies-aeu/{id}', 'HrCompanyController@edit');
            Route::post('human-resource/companies/update/{id}', 'HrCompanyController@update');
        });
        Route::group(['middleware' => ['permission:Delete Companies']], function () {
            Route::get('human-resource/companies/delete/{id}', 'HrCompanyController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Companies']], function () {
            Route::get('human-resource/companies/restore/{id}', 'HrCompanyController@restore');
        });



    Route::group(['middleware' => ['permission:View Salary Deductions']], function () {
            Route::get('human-resource/salary-deductions', 'HrSalaryDeductionController@index');
            Route::post('human-resource/salary-deductions', 'HrSalaryDeductionController@indexdt')->name('salary_ded.datatable');
        });
        Route::group(['middleware' => ['permission:Add Salary Deductions']], function () {
            Route::get('human-resource/salary-deductions/salary-deductions-aeu', 'HrSalaryDeductionController@create');
            Route::post('human-resource/salary-deductions/salary-deductions-aeu', 'HrSalaryDeductionController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Salary Deductions']], function () {
            Route::get('human-resource/salary-deductions/deleted', 'HrSalaryDeductionController@index_deleted');
            Route::post('human-resource/salary-deductions/deleted', 'HrSalaryDeductionController@indexdt_deleted')->name('salary_ded_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Salary Deductions']], function () {
            Route::get('human-resource/salary-deductions/salary-deductions-aeu/{id}', 'HrSalaryDeductionController@edit');
            Route::post('human-resource/salary-deductions/update/{id}', 'HrSalaryDeductionController@update');
        });
        Route::group(['middleware' => ['permission:Delete Salary Deductions']], function () {
            Route::get('human-resource/salary-deductions/delete/{id}', 'HrSalaryDeductionController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Salary Deductions']], function () {
            Route::get('human-resource/salary-deductions/restore/{id}', 'HrSalaryDeductionController@restore');
        });
    Route::get('human-resource/salary-deductions/calculateextracharges/{id}', 'HrSalaryDeductionController@calculateextracharges');




        Route::group(['middleware' => ['permission:View Salary Add-Ons']], function () {
            Route::get('human-resource/salary-add-ons', 'HrSalaryAddOnController@index');
            Route::post('human-resource/salary-add-ons', 'HrSalaryAddOnController@indexdt')->name('salary_addons.datatable');
        });
        Route::group(['middleware' => ['permission:Add Salary Add-Ons']], function () {
            Route::get('human-resource/salary-add-ons/salary-add-ons-aeu', 'HrSalaryAddOnController@create');
            Route::post('human-resource/salary-add-ons/salary-add-ons-aeu', 'HrSalaryAddOnController@store');
        });
        Route::group(['middleware' => ['permission:View Deleted Salary Add-Ons']], function () {
            Route::get('human-resource/salary-add-ons/deleted', 'HrSalaryAddOnController@index_deleted');
            Route::post('human-resource/salary-add-ons/deleted', 'HrSalaryAddOnController@indexdt_deleted')->name('salary_addons_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Edit Salary Add-Ons']], function () {
            Route::get('human-resource/salary-add-ons/salary-add-ons-aeu/{id}', 'HrSalaryAddOnController@edit');
            Route::post('human-resource/salary-add-ons/update/{id}', 'HrSalaryAddOnController@update');
        });
        Route::group(['middleware' => ['permission:Delete Salary Add-Ons']], function () {
            Route::get('human-resource/salary-add-ons/delete/{id}', 'HrSalaryAddOnController@destroy');
        });
        Route::group(['middleware' => ['permission:Restore Salary Add-Ons']], function () {
            Route::get('human-resource/salary-add-ons/restore/{id}', 'HrSalaryAddOnController@restore');
        });
    Route::get('human-resource/salary-add-ons/calculateextracharges/{id}', 'HrSalaryAddOnController@calculateextracharges');
    // EMPLOYMENT



    // EMPLOYEE IN & OUT
    Route::group(['middleware' => ['permission:View Employee In and Out']], function () {
        Route::get('human-resource/employee-in-out-vue', 'HrEmploymentController@inout_vue');
        Route::get('human-resource/employee-in-out/inout_init_vue', 'HrEmploymentController@inout_init_vue');
        });
    Route::group(['middleware' => ['permission:View Deleted Employee In and Out']], function () {
        Route::get('human-resource/employee-in-out/deleted-vue', 'HrEmploymentController@index_deleted_inout');
        Route::get('human-resource/employee-in-out/indexdt_deleted', 'HrEmploymentController@indexdt_deleted_inout');
        });
    Route::group(['middleware' => ['permission:Add Employee In and Out']], function () {
            Route::get('human-resource/employee-in-out-aeu-vue', 'HrEmploymentController@create_inout');
            Route::get('human-resource/employee-in-out-aeu/init', 'HrEmploymentController@init_inout');
            Route::post('human-resource/employee-in-out-aeu/save', 'HrEmploymentController@save_inout');
        });
    Route::group(['middleware' => ['permission:Edit Employee In and Out']], function () {
            Route::get('human-resource/employee-in-out-aeu-vue/{id}', 'HrEmploymentController@edit_inout');
            Route::post('human-resource/employee-in-out-aeu/update', 'HrEmploymentController@updated_inout');
    });
    Route::group(['middleware' => ['permission:Delete Employee In and Out']], function () {
            Route::get('human-resource/employee-in-out/delete/{id}', 'HrEmploymentController@destroy_inout');
    });
    Route::group(['middleware' => ['permission:Restore Employee In and Out']], function () {
            Route::get('human-resource/employee-in-out/restore/{id}', 'HrEmploymentController@restore_inout');
    });
    // EMPLOYEE IN & OUT

    /*HUMAN RESOURCE MANAGEMENT*/





    /*Events Management Module*/
    Route::group(['middleware' => ['permission:View Events Management']], function () {
        Route::get('events-management', function () {
            return view('backend/events-management/events-management');
        });
        Route::get('events-management/definitions', function () {
                return view('backend/events-management/events-management-definitions');
        });
    });

    Route::group(['middleware' => ['permission:View Customer']], function () {
            Route::get('events-management/event-customer', 'CustomerController@index_events');
            Route::post('events-management/event-customer', 'CustomerController@indexdt')->name('customer.datatable');
        });
    Route::group(['middleware' => ['permission:Add Customer']], function () {
            Route::get('events-management/event-customer/event-customer-aeu', 'CustomerController@create_events');
            Route::post('events-management/event-customer/event-customer-aeu', 'CustomerController@store');
        });
    Route::group(['middleware' => ['permission:Edit Customer']], function () {
            Route::get('events-management/event-customer/event-customer-aeu/{id}', 'CustomerController@edit_events');
            Route::post('events-management/event-customer/update/{id}', 'CustomerController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Customers']], function () {
            Route::get('events-management/event-customer/deleted', 'CustomerController@index_deleted_events');
            Route::post('events-management/event-customer/deleted', 'CustomerController@indexdt_deleted')->name('customer_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Customer']], function () {
            Route::get('events-management/event-customer/delete/{id}', 'CustomerController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Customer']], function () {
            Route::get('events-management/event-customer/restore/{id}', 'CustomerController@restore');
        });


    Route::group(['middleware' => ['permission:View Menu Type']], function () {
            Route::get('events-management/menu-type', 'EventTypeController@index');
            Route::post('events-management/menu-type', 'EventTypeController@indexdt')->name('menutype.datatable');
        });
    Route::group(['middleware' => ['permission:Add Menu Type']], function () {
            Route::get('events-management/menu-type/menu-type-aeu', 'EventTypeController@create');
            Route::post('events-management/menu-type/menu-type-aeu', 'EventTypeController@store');
        });
    Route::group(['middleware' => ['permission:Edit Menu Type']], function () {
            Route::get('events-management/menu-type/menu-type-aeu/{id}', 'EventTypeController@edit');
            Route::post('events-management/menu-type/update/{id}', 'EventTypeController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Menu Types']], function () {
            Route::get('events-management/menu-type/deleted', 'EventTypeController@index_deleted');
            Route::post('events-management/menu-type/deleted', 'EventTypeController@indexdt_deleted')->name('menutype_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Menu Type']], function () {
            Route::get('events-management/menu-type/delete/{id}', 'EventTypeController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Menu Type']], function () {
            Route::get('events-management/menu-type/restore/{id}', 'EventTypeController@restore');
        });



    Route::group(['middleware' => ['permission:View Menu Rate Category']], function () {
            Route::get('events-management/menu-category', 'EventRateCategoryController@index');
            Route::post('events-management/menu-category', 'EventRateCategoryController@indexdt')->name('menucategory.datatable');
        });
    Route::group(['middleware' => ['permission:Add Menu Rate Category']], function () {
            Route::get('events-management/menu-category/menu-category-aeu', 'EventRateCategoryController@create');
            Route::post('events-management/menu-category/menu-category-aeu', 'EventRateCategoryController@store');
        });
    Route::group(['middleware' => ['permission:Edit Menu Rate Category']], function () {
            Route::get('events-management/menu-category/menu-category-aeu/{id}', 'EventRateCategoryController@edit');
            Route::post('events-management/menu-category/update/{id}', 'EventRateCategoryController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Menu Rate Categories']], function () {
            Route::get('events-management/menu-category/deleted', 'EventRateCategoryController@index_deleted');
            Route::post('events-management/menu-category/deleted', 'EventRateCategoryController@indexdt_deleted')->name('menucategory_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Menu Rate Category']], function () {
            Route::get('events-management/menu-category/delete/{id}', 'EventRateCategoryController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Menu Rate Category']], function () {
            Route::get('events-management/menu-category/restore/{id}', 'EventRateCategoryController@restore');
        });


    Route::group(['middleware' => ['permission:View Event Charges Type']], function () {
        Route::get('events-management/event-charges-type', 'EventChargesTypeController@index');
    Route::post('events-management/event-charges-type', 'EventChargesTypeController@indexdt')->name('eventcharges.datatable');
        });
    Route::group(['middleware' => ['permission:Add Event Charges Type']], function () {
        Route::get('events-management/event-charges-type/event-charges-type-aeu', 'EventChargesTypeController@create');
    Route::post('events-management/event-charges-type/event-charges-type-aeu', 'EventChargesTypeController@store');
        });
    Route::group(['middleware' => ['permission:Edit Event Charges Type']], function () {
        Route::get('events-management/event-charges-type/event-charges-type-aeu/{id}', 'EventChargesTypeController@edit');
    Route::post('events-management/event-charges-type/update/{id}', 'EventChargesTypeController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Event Charges Types']], function () {
            Route::get('events-management/event-charges-type/deleted', 'EventChargesTypeController@index_deleted');
            Route::post('events-management/event-charges-type/deleted', 'EventChargesTypeController@indexdt_deleted')->name('eventcharges_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Event Charges Type']], function () {
        Route::get('events-management/event-charges-type/delete/{id}', 'EventChargesTypeController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Event Charges Type']], function () {
            Route::get('events-management/event-charges-type/restore/{id}', 'EventChargesTypeController@restore');
        });


    Route::group(['middleware' => ['permission:View Venues']], function () {
    Route::get('events-management/event-venue', 'EventVenueController@index');
    Route::post('events-management/event-venue', 'EventVenueController@indexdt')->name('venue.datatable');
        });
    Route::group(['middleware' => ['permission:Add Venues']], function () {
        Route::get('events-management/event-venue/event-venue-aeu', 'EventVenueController@create');
    Route::post('events-management/event-venue/event-venue-aeu', 'EventVenueController@store');
        });
    Route::group(['middleware' => ['permission:Edit Venues']], function () {
        Route::get('events-management/event-venue/event-venue-aeu/{id}', 'EventVenueController@edit');
    Route::post('events-management/event-venue/update/{id}', 'EventVenueController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Venues']], function () {
            Route::get('events-management/event-venue/deleted', 'EventVenueController@index_deleted');
            Route::post('events-management/event-venue/deleted', 'EventVenueController@indexdt_deleted')->name('venue_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Venues']], function () {
        Route::get('events-management/event-venue/delete/{id}', 'EventVenueController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Venues']], function () {
            Route::get('events-management/event-venue/restore/{id}', 'EventVenueController@restore');
        });


    Route::group(['middleware' => ['permission:View Menus']], function () {
    Route::get('events-management/menus', 'EventMenuController@index');
    Route::post('events-management/menus', 'EventMenuController@indexdt')->name('menus.datatable');
        });
    Route::group(['middleware' => ['permission:Add Menus']], function () {
        Route::get('events-management/menus/menus-aeu', 'EventMenuController@create');
    Route::post('events-management/menus/menus-aeu', 'EventMenuController@store');
        });
    Route::group(['middleware' => ['permission:Edit Menus']], function () {
        Route::get('events-management/menus/menus-aeu/{id}', 'EventMenuController@edit');
    Route::post('events-management/menus/update/{id}', 'EventMenuController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Menus']], function () {
            Route::get('events-management/menus/deleted', 'EventMenuController@index_deleted');
            Route::post('events-management/menus/deleted', 'EventMenuController@indexdt_deleted')->name('menus_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Menus']], function () {
        Route::get('events-management/menus/delete/{id}', 'EventMenuController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Menus']], function () {
            Route::get('events-management/menus/restore/{id}', 'EventMenuController@restore');
        });



    Route::group(['middleware' => ['permission:View Menu Add Ons']], function () {
        Route::get('events-management/menu-add-ons', 'EventMenuAddOnController@index');
    Route::post('events-management/menu-add-ons', 'EventMenuAddOnController@indexdt')->name('menu_addon.datatable');
        });
    Route::group(['middleware' => ['permission:Add Menu Add Ons']], function () {
        Route::get('events-management/menu-add-ons/menu-add-ons-aeu', 'EventMenuAddOnController@create');
    Route::post('events-management/menu-add-ons/menu-add-ons-aeu', 'EventMenuAddOnController@store');
        });
    Route::group(['middleware' => ['permission:Edit Menu Add Ons']], function () {
        Route::get('events-management/menu-add-ons/menu-add-ons-aeu/{id}', 'EventMenuAddOnController@edit');
    Route::post('events-management/menu-add-ons/update/{id}', 'EventMenuAddOnController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Menu Add Ons']], function () {
            Route::get('events-management/menu-add-ons/deleted', 'EventMenuAddOnController@index_deleted');
            Route::post('events-management/menu-add-ons/deleted', 'EventMenuAddOnController@indexdt_deleted')->name('menu_addon_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Menu Add Ons']], function () {
        Route::get('events-management/menu-add-ons/delete/{id}', 'EventMenuAddOnController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Menu Add Ons']], function () {
            Route::get('events-management/menu-add-ons/restore/{id}', 'EventMenuAddOnController@restore');
        });


    Route::group(['middleware' => ['permission:View Event Booking']], function () {
    Route::get('events-management/event-booking', 'EventBookingController@index');
    Route::post('events-management/event-booking', 'EventBookingController@indexdt')->name('event_booking.datatable');

        Route::get('events-management/event-booking-vue', 'EventBookingController@index_vue');
        Route::get('events-management/event-booking/init_vue', 'EventBookingController@init_vue');
        });
    Route::group(['middleware' => ['permission:Add Event Booking']], function () {
        Route::get('events-management/event-booking/event-booking-aeu', 'EventBookingController@create');
        Route::post('events-management/event-booking/event-booking-aeu', 'EventBookingController@store');
        });
    Route::get('events-management/event-booking/fetchvenue', 'EventBookingController@fetchVenue')->name('fetch.venue');
    Route::group(['middleware' => ['permission:Edit Event Booking']], function () {
        Route::get('events-management/event-booking/event-booking-aeu/{id}', 'EventBookingController@edit')->name('event.booking.edit');
    Route::post('events-management/event-booking/update/{id}', 'EventBookingController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Event Bookings']], function () {
            Route::get('events-management/event-booking/deleted', 'EventBookingController@index_deleted');
            Route::post('events-management/event-booking/deleted', 'EventBookingController@indexdt_deleted')->name('event_booking_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:View Cancelled Event Bookings']], function () {
            Route::get('events-management/event-booking/cancelled', 'EventBookingController@index_cancelled');
            Route::post('events-management/event-booking/cancelled', 'EventBookingController@indexdt_cancelled')->name('event_booking_cancelled.datatable');

            Route::get('events-management/event-booking/cancelled-vue', 'EventBookingController@cancelled_vue');
            Route::get('events-management/event-booking/init_cancelled', 'EventBookingController@init_cancelled');
        });
    Route::group(['middleware' => ['permission:Delete Event Booking']], function () {
        Route::post('events-management/event-booking/delete/{id}', 'EventBookingController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Event Booking']], function () {
            Route::get('events-management/event-booking/restore/{id}', 'EventBookingController@restore');
        });
    Route::group(['middleware' => ['permission:Cancel Event']], function () {
        Route::post('events-management/event-booking/event-cancel/{id}', 'EventBookingController@cancel');
        /*   Route::get('events-management/event-booking/event-cancel/{id}', 'EventBookingController@edit_cancel')->name('event.booking.edit');
    Route::post('events-management/event-booking/cancel/{id}', 'EventBookingController@update_cancel');*/
        });
    Route::get('events-management/event-booking/calculateextracharges/{id}', 'EventBookingController@calculateextracharges');
    Route::get('events-management/event-booking/calculateaddoncharges/{id}', 'EventBookingController@calculateaddoncharges');
    Route::get('events-management/event-booking/calculatemenucharges/{id}', 'EventBookingController@calculatemenucharges');



    Route::group(['middleware' => ['permission:View Event Check Out']], function () {
            Route::get('events-management/event-checkout', 'EventBookingController@index_checkout');
            Route::post('events-management/event-checkout', 'EventBookingController@indexdt_checkout')->name('event_checkout.datatable');


        Route::get('events-management/event-checkout-vue', 'EventBookingController@checkout_vue');
        Route::get('events-management/event-checkout/init_checkout', 'EventBookingController@init_checkout');
        });
    Route::group(['middleware' => ['permission:Check Out Event']], function () {
        Route::get('events-management/event-booking/event-checkout-aeu/{id}', 'EventBookingController@create_checkout')->name('event.checkout');
        Route::post('events-management/event-booking/event-checkout-aeu/{id}', 'EventBookingController@store_checkout');
    });
    Route::group(['middleware' => ['permission:Edit Event Check Out']], function () {
        Route::get('events-management/event-checkout/edit/{id}', 'EventBookingController@edit_checkout');
    });
    Route::group(['middleware' => ['permission:Print Event Invoice']], function () {
            Route::get('events-management/event-checkout/invoice/{id}', 'EventBookingController@invoice')->name('eventInvoice');
            Route::get('events-management/event-booking/invoice/{id}', 'EventBookingController@invoice_booking');
        });
    Route::group(['middleware' => ['permission:Confirm Cancelled Event']], function () {
            Route::post('events-management/event-booking/reconfirm/{id}', 'EventBookingController@reconfirm');
        });




    // FINANCE CASH RECEIPT
        Route::group(['middleware' => ['permission:View Finance Cash Receipt']], function () {
            Route::get('finance-and-management/finance-cash-receipts', 'FinanceCashReceiptController@index');
            Route::get('finance-and-management/finance-cash-receipts-vue', 'FinanceCashReceiptController@index_vue');
            Route::get('finance-and-management/finance-cash-receipts/cashrecs_init', 'FinanceCashReceiptController@cashrecs_init');
            Route::post('finance-and-management/finance-cash-receipts', 'FinanceCashReceiptController@indexdt')->name('finance_payment.datatable');
        });
        Route::group(['middleware' => ['permission:View Deleted Finance Cash Receipts']], function () {
            Route::get('finance-and-management/finance-cash-receipts/deleted', 'FinanceCashReceiptController@index_deleted');
            Route::post('finance-and-management/finance-cash-receipts/deleted', 'FinanceCashReceiptController@indexdt_deleted')->name('finance_cash_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Add Finance Cash Receipt']], function () {
            Route::get('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu', 'FinanceCashReceiptController@create');
            Route::get('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/init', 'FinanceCashReceiptController@init');
            Route::post('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/save', 'FinanceCashReceiptController@save');
            Route::post('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu', 'FinanceCashReceiptController@store');
            Route::get('finance-and-management/finance-cash-receipts/calculateextracharges/{id}', 'FinanceCashReceiptController@calculateextracharges');
            Route::get('finance-and-management/finance-cash-receipts/invoices', 'FinanceCashReceiptController@invoices')->name('invoices.get');
        });
        Route::group(['middleware' => ['permission:Restore Finance Cash Receipt']], function () {
            Route::get('finance-and-management/finance-cash-receipts/restore/{id}', 'FinanceCashReceiptController@restore');
        });
        Route::group(['middleware' => ['permission:Edit Finance Cash Receipt']], function () {
            Route::get('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/{id}', 'FinanceCashReceiptController@edit');
            Route::post('finance-and-management/finance-cash-receipts/finance-cash-receipts-aeu/update', 'FinanceCashReceiptController@updated');

            Route::post('finance-and-management/finance-cash-receipts/update/{id}', 'FinanceCashReceiptController@update');
        });
        Route::get('finance-and-management/finance-cash-receipts/activate/{id}', 'FinanceCashReceiptController@activate')->name('transActive');
        Route::get('finance-and-management/finance-cash-receipts/inactivate/{id}', 'FinanceCashReceiptController@inactivate');
        Route::group(['middleware' => ['permission:Delete Finance Cash Receipt']], function () {
            Route::post('finance-and-management/finance-cash-receipts/delete/{id}', 'FinanceCashReceiptController@destroy');
        });
    Route::group(['middleware' => ['permission:Print Finance Cash Receipt']], function () {
        Route::get('finance-and-management/finance-cash-receipts/finance-cash-receipts-invoice/{id}', 'FinanceCashReceiptController@invoice')->name('cash.receipt.print');
        });
    // FINANCE CASH RECEIPT

    
    // FINANCE PAYMENT RECEIPT
        Route::group(['middleware' => ['permission:View Finance Payment Receipt']], function () {
            Route::get('finance-and-management/finance-payment-receipts', 'FinancePaymentReceiptController@index');
            Route::post('finance-and-management/finance-payment-receipts', 'FinancePaymentReceiptController@indexdt')->name('payment_receipt.datatable');
            Route::get('finance-and-management/finance-payment-receipts-vue', 'FinancePaymentReceiptController@index_vue');
            Route::get('finance-and-management/finance-payment-receipts/paymentrecs_init', 'FinancePaymentReceiptController@paymentrecs_init');
        });
        Route::group(['middleware' => ['permission:View Deleted Finance Payment Receipts']], function () {
            Route::get('finance-and-management/finance-payment-receipts/deleted', 'FinancePaymentReceiptController@index_deleted');
            Route::post('finance-and-management/finance-payment-receipts/deleted', 'FinancePaymentReceiptController@indexdt_deleted')->name('payment_receipt_deleted.datatable');
        });
        Route::group(['middleware' => ['permission:Add Finance Payment Receipt']], function () {
            Route::get('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu', 'FinancePaymentReceiptController@create');
            Route::get('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu/init', 'FinancePaymentReceiptController@init');
            Route::post('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu/save', 'FinancePaymentReceiptController@save');
            Route::post('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu', 'FinancePaymentReceiptController@store');
            Route::get('finance-and-management/finance-payment-receipts/calculateextracharges/{id}', 'FinancePaymentReceiptController@calculateextracharges');
            Route::get('finance-and-management/finance-payment-receipts/invoices', 'FinancePaymentReceiptController@invoices')->name('invoices.get');
        });
        Route::group(['middleware' => ['permission:Restore Finance Payment Receipt']], function () {
            Route::get('finance-and-management/finance-payment-receipts/restore/{id}', 'FinancePaymentReceiptController@restore');
        });
        Route::group(['middleware' => ['permission:Edit Finance Payment Receipt']], function () {
            Route::get('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu/{id}', 'FinancePaymentReceiptController@edit');
            Route::post('finance-and-management/finance-payment-receipts/finance-payment-receipts-aeu/update', 'FinancePaymentReceiptController@updated');

            Route::post('finance-and-management/finance-payment-receipts/update/{id}', 'FinancePaymentReceiptController@update');
        });
        Route::get('finance-and-management/finance-payment-receipts/activate/{id}', 'FinancePaymentReceiptController@activate')->name('ptransActive');
        Route::group(['middleware' => ['permission:Delete Finance Payment Receipt']], function () {
            Route::post('finance-and-management/finance-payment-receipts/delete/{id}', 'FinancePaymentReceiptController@destroy');
        });
    Route::group(['middleware' => ['permission:Print Finance Payment Receipt']], function () {
        Route::get('finance-and-management/finance-payment-receipts/finance-payment-receipts-invoice/{id}', 'FinancePaymentReceiptController@invoice')->name('payment.receipt.print');
        });
    // FINANCE PAYMENT RECEIPT



    // --------------------------------------------------FOOD AND BEVERAGE---------------------------------------------------- //


    Route::group(['middleware' => ['permission:View Food and Beverage']], function () {
            Route::get('food-and-beverage', function () {
                return view('backend/food-and-beverage/food-and-beverage');
            });
            Route::get('food-and-beverage/definitions', function () {
                return view('backend/food-and-beverage/food-and-beverage-definitions');
            });
        });
    // PRINTERS
    Route::group(['middleware' => ['permission:View Printers']], function () {
            Route::get('food-and-beverage/printers', 'FnbPrinterController@index');
            Route::post('food-and-beverage/printers', 'FnbPrinterController@indexdt')->name('printers.datatable');
        });
    Route::group(['middleware' => ['permission:Add Printers']], function () {
            Route::get('food-and-beverage/printers/printers-aeu', 'FnbPrinterController@create');
            Route::post('food-and-beverage/printers/printers-aeu', 'FnbPrinterController@store');
        });
    Route::group(['middleware' => ['permission:Edit Printers']], function () {
            Route::get('food-and-beverage/printers/printers-aeu/{id}', 'FnbPrinterController@edit');
            Route::post('food-and-beverage/printers/update/{id}', 'FnbPrinterController@update');
        });
    Route::group(['middleware' => ['permission:View Printers']], function () {
            Route::get('food-and-beverage/printers/deleted', 'FnbPrinterController@index_deleted');
            Route::post('food-and-beverage/printers/deleted', 'FnbPrinterController@indexdt_deleted')->name('printers_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Printers']], function () {
            Route::get('food-and-beverage/printers/delete/{id}', 'FnbPrinterController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Printers']], function () {
            Route::get('food-and-beverage/printers/restore/{id}', 'FnbPrinterController@restore');
        });
    // PRINTERS

    // POS LOCATIONS
    Route::group(['middleware' => ['permission:View POS Location']], function () {
            Route::get('food-and-beverage/pos-locations', 'FnbPosLocationController@index');
            Route::post('food-and-beverage/pos-locations', 'FnbPosLocationController@indexdt')->name('pos_locations.datatable');
        });
    Route::group(['middleware' => ['permission:Add POS Location']], function () {
            Route::get('food-and-beverage/pos-locations/pos-locations-aeu', 'FnbPosLocationController@create');
            Route::post('food-and-beverage/pos-locations/pos-locations-aeu', 'FnbPosLocationController@store');
        });
    Route::group(['middleware' => ['permission:Edit POS Location']], function () {
            Route::get('food-and-beverage/pos-locations/pos-locations-aeu/{id}', 'FnbPosLocationController@edit');
            Route::post('food-and-beverage/pos-locations/update/{id}', 'FnbPosLocationController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted POS Locations']], function () {
            Route::get('food-and-beverage/pos-locations/deleted', 'FnbPosLocationController@index_deleted');
            Route::post('food-and-beverage/pos-locations/deleted', 'FnbPosLocationController@indexdt_deleted')->name('pos_locations_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete POS Location']], function () {
            Route::get('food-and-beverage/pos-locations/delete/{id}', 'FnbPosLocationController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore POS Location']], function () {
            Route::get('food-and-beverage/pos-locations/restore/{id}', 'FnbPosLocationController@restore');
        });
    // POS LOCATIONS

    // ENT DETAILS
    Route::group(['middleware' => ['permission:View ENT Details']], function () {
            Route::get('food-and-beverage/ent-details', 'FnbEntDetailController@index');
            Route::post('food-and-beverage/ent-details', 'FnbEntDetailController@indexdt')->name('ent.datatable');
        });
    Route::group(['middleware' => ['permission:Add ENT Details']], function () {
            Route::get('food-and-beverage/ent-details/ent-details-aeu', 'FnbEntDetailController@create');
            Route::post('food-and-beverage/ent-details/ent-details-aeu', 'FnbEntDetailController@store');
        });
    Route::group(['middleware' => ['permission:Edit ENT Details']], function () {
            Route::get('food-and-beverage/ent-details/ent-details-aeu/{id}', 'FnbEntDetailController@edit');
            Route::post('food-and-beverage/ent-details/update/{id}', 'FnbEntDetailController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted ENT Details']], function () {
            Route::get('food-and-beverage/ent-details/deleted', 'FnbEntDetailController@index_deleted');
            Route::post('food-and-beverage/ent-details/deleted', 'FnbEntDetailController@indexdt_deleted')->name('ent_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete ENT Details']], function () {
            Route::get('food-and-beverage/ent-details/delete/{id}', 'FnbEntDetailController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore ENT Details']], function () {
            Route::get('food-and-beverage/ent-details/restore/{id}', 'FnbEntDetailController@restore');
        });
    // ENT DETAILS


    // CANCELLED ITEMS REMARKS
    Route::group(['middleware' => ['permission:View Cancelled Item Remark']], function () {
            Route::get('food-and-beverage/cancelled-item-remarks', 'FnbCancelledItemRemarkController@index');
            Route::post('food-and-beverage/cancelled-item-remarks', 'FnbCancelledItemRemarkController@indexdt')->name('cancelled_remark.datatable');
        });
    Route::group(['middleware' => ['permission:Add Cancelled Item Remark']], function () {
            Route::get('food-and-beverage/cancelled-item-remarks/cancelled-item-remarks-aeu', 'FnbCancelledItemRemarkController@create');
            Route::post('food-and-beverage/cancelled-item-remarks/cancelled-item-remarks-aeu', 'FnbCancelledItemRemarkController@store');
        });
    Route::group(['middleware' => ['permission:Edit Cancelled Item Remark']], function () {
            Route::get('food-and-beverage/cancelled-item-remarks/cancelled-item-remarks-aeu/{id}', 'FnbCancelledItemRemarkController@edit');
            Route::post('food-and-beverage/cancelled-item-remarks/update/{id}', 'FnbCancelledItemRemarkController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Cancelled Item Remarks']], function () {
            Route::get('food-and-beverage/cancelled-item-remarks/deleted', 'FnbCancelledItemRemarkController@index_deleted');
            Route::post('food-and-beverage/cancelled-item-remarks/deleted', 'FnbCancelledItemRemarkController@indexdt_deleted')->name('cancelled_remark_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Cancelled Item Remark']], function () {
            Route::get('food-and-beverage/cancelled-item-remarks/delete/{id}', 'FnbCancelledItemRemarkController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Cancelled Item Remark']], function () {
            Route::get('food-and-beverage/cancelled-item-remarks/restore/{id}', 'FnbCancelledItemRemarkController@restore');
        });
    // CANCELLED ITEM REMARKS

    // RESTAURANT LOCATIONS
    Route::group(['middleware' => ['permission:View Restaurant Location']], function () {
            Route::get('food-and-beverage/restaurant-locations', 'FnbRestaurantLocationController@index');
            Route::post('food-and-beverage/restaurant-locations', 'FnbRestaurantLocationController@indexdt')->name('restaurant_locations.datatable');
        });
    Route::group(['middleware' => ['permission:Add Restaurant Location']], function () {
            Route::get('food-and-beverage/restaurant-locations/restaurant-locations-aeu', 'FnbRestaurantLocationController@create');
            Route::post('food-and-beverage/restaurant-locations/restaurant-locations-aeu', 'FnbRestaurantLocationController@store');
        });
    Route::group(['middleware' => ['permission:Edit Restaurant Location']], function () {
            Route::get('food-and-beverage/restaurant-locations/restaurant-locations-aeu/{id}', 'FnbRestaurantLocationController@edit');
            Route::post('food-and-beverage/restaurant-locations/update/{id}', 'FnbRestaurantLocationController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Restaurant Locations']], function () {
            Route::get('food-and-beverage/restaurant-locations/deleted', 'FnbRestaurantLocationController@index_deleted');
            Route::post('food-and-beverage/restaurant-locations/deleted', 'FnbRestaurantLocationController@indexdt_deleted')->name('restaurant_locations_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Restaurant Location']], function () {
            Route::get('food-and-beverage/restaurant-locations/delete/{id}', 'FnbRestaurantLocationController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Restaurant Location']], function () {
            Route::get('food-and-beverage/restaurant-locations/restore/{id}', 'FnbRestaurantLocationController@restore');
        });
    // RESTAURANT LOCATIONS

    // TABLE DEFINITIONS
    Route::group(['middleware' => ['permission:View Table Definition']], function () {
            Route::get('food-and-beverage/table-definitions', 'FnbTableDefinitionController@index');
            Route::post('food-and-beverage/table-definitions', 'FnbTableDefinitionController@indexdt')->name('table_defs.datatable');
        });
    Route::group(['middleware' => ['permission:Add Table Definition']], function () {
            Route::get('food-and-beverage/table-definitions/table-definitions-aeu', 'FnbTableDefinitionController@create');
            Route::post('food-and-beverage/table-definitions/table-definitions-aeu', 'FnbTableDefinitionController@store');
        });
    Route::group(['middleware' => ['permission:Edit Table Definition']], function () {
            Route::get('food-and-beverage/table-definitions/table-definitions-aeu/{id}', 'FnbTableDefinitionController@edit');
            Route::post('food-and-beverage/table-definitions/update/{id}', 'FnbTableDefinitionController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Table Definitions']], function () {
            Route::get('food-and-beverage/table-definitions/deleted', 'FnbTableDefinitionController@index_deleted');
            Route::post('food-and-beverage/table-definitions/deleted', 'FnbTableDefinitionController@indexdt_deleted')->name('table_defs_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Table Definition']], function () {
            Route::get('food-and-beverage/table-definitions/delete/{id}', 'FnbTableDefinitionController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Table Definition']], function () {
            Route::get('food-and-beverage/table-definitions/restore/{id}', 'FnbTableDefinitionController@restore');
        });
    // TABLE DEFINITIONS

    // WAITER DEFINITIONS
    Route::group(['middleware' => ['permission:View Waiter Definition']], function () {
            Route::get('food-and-beverage/waiter-definitions', 'FnbWaitorDefinitionController@index');
            Route::post('food-and-beverage/waiter-definitions', 'FnbWaitorDefinitionController@indexdt')->name('waiter_defs.datatable');
        });
    Route::group(['middleware' => ['permission:Add Waiter Definition']], function () {
            Route::get('food-and-beverage/waiter-definitions/waiter-definitions-aeu', 'FnbWaitorDefinitionController@create');
            Route::post('food-and-beverage/waiter-definitions/waiter-definitions-aeu', 'FnbWaitorDefinitionController@store');
        });
    Route::group(['middleware' => ['permission:Edit Waiter Definition']], function () {
            Route::get('food-and-beverage/waiter-definitions/waiter-definitions-aeu/{id}', 'FnbWaitorDefinitionController@edit');
            Route::post('food-and-beverage/waiter-definitions/update/{id}', 'FnbWaitorDefinitionController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Waiter Definitions']], function () {
            Route::get('food-and-beverage/waiter-definitions/deleted', 'FnbWaitorDefinitionController@index_deleted');
            Route::post('food-and-beverage/waiter-definitions/deleted', 'FnbWaitorDefinitionController@indexdt_deleted')->name('waiter_defs_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Waiter Definition']], function () {
            Route::get('food-and-beverage/waiter-definitions/delete/{id}', 'FnbWaitorDefinitionController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Waiter Definition']], function () {
            Route::get('food-and-beverage/waiter-definitions/restore/{id}', 'FnbWaitorDefinitionController@restore');
        });
    // WAITER DEFINITIONS

    // DELIVERY RIDERS
    Route::group(['middleware' => ['permission:View Delivery Rider']], function () {
            Route::get('food-and-beverage/delivery-riders', 'FnbDeliveryRiderController@index');
            Route::post('food-and-beverage/delivery-riders', 'FnbDeliveryRiderController@indexdt')->name('riders.datatable');
        });
    Route::group(['middleware' => ['permission:Add Delivery Rider']], function () {
            Route::get('food-and-beverage/delivery-riders/delivery-riders-aeu', 'FnbDeliveryRiderController@create');
            Route::post('food-and-beverage/delivery-riders/delivery-riders-aeu', 'FnbDeliveryRiderController@store');
        });
    Route::group(['middleware' => ['permission:Edit Delivery Rider']], function () {
            Route::get('food-and-beverage/delivery-riders/delivery-riders-aeu/{id}', 'FnbDeliveryRiderController@edit');
            Route::post('food-and-beverage/delivery-riders/update/{id}', 'FnbDeliveryRiderController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Delivery Riders']], function () {
            Route::get('food-and-beverage/delivery-riders/deleted', 'FnbDeliveryRiderController@index_deleted');
            Route::post('food-and-beverage/delivery-riders/deleted', 'FnbDeliveryRiderController@indexdt_deleted')->name('riders_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Delivery Rider']], function () {
            Route::get('food-and-beverage/delivery-riders/delete/{id}', 'FnbDeliveryRiderController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Delivery Rider']], function () {
            Route::get('food-and-beverage/delivery-riders/restore/{id}', 'FnbDeliveryRiderController@restore');
        });
    // DELIVERY RIDERS

    // UNITS OF MEASUREMENT
    Route::group(['middleware' => ['permission:View Measurement Unit']], function () {
            Route::get('food-and-beverage/measurement-units', 'FnbMeasurementUnitController@index');
            Route::post('food-and-beverage/measurement-units', 'FnbMeasurementUnitController@indexdt')->name('units.datatable');
        });
    Route::group(['middleware' => ['permission:Add Measurement Unit']], function () {
            Route::get('food-and-beverage/measurement-units/measurement-units-aeu', 'FnbMeasurementUnitController@create');
            Route::post('food-and-beverage/measurement-units/measurement-units-aeu', 'FnbMeasurementUnitController@store');
        });
    Route::group(['middleware' => ['permission:Edit Measurement Unit']], function () {
            Route::get('food-and-beverage/measurement-units/measurement-units-aeu/{id}', 'FnbMeasurementUnitController@edit');
            Route::post('food-and-beverage/measurement-units/update/{id}', 'FnbMeasurementUnitController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Measurement Units']], function () {
            Route::get('food-and-beverage/measurement-units/deleted', 'FnbMeasurementUnitController@index_deleted');
            Route::post('food-and-beverage/measurement-units/deleted', 'FnbMeasurementUnitController@indexdt_deleted')->name('units_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Measurement Unit']], function () {
            Route::get('food-and-beverage/measurement-units/delete/{id}', 'FnbMeasurementUnitController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Measurement Unit']], function () {
            Route::get('food-and-beverage/measurement-units/restore/{id}', 'FnbMeasurementUnitController@restore');
        });
    // UNITS OF MEASUREMENT

    // ITEM MANUFACTURER
    Route::group(['middleware' => ['permission:View Item Manufacturer']], function () {
            Route::get('food-and-beverage/item-manufacturers', 'FnbItemManufacturerController@index');
            Route::post('food-and-beverage/item-manufacturers', 'FnbItemManufacturerController@indexdt')->name('manufacturers.datatable');
        });
    Route::group(['middleware' => ['permission:Add Item Manufacturer']], function () {
            Route::get('food-and-beverage/item-manufacturers/item-manufacturers-aeu', 'FnbItemManufacturerController@create');
            Route::post('food-and-beverage/item-manufacturers/item-manufacturers-aeu', 'FnbItemManufacturerController@store');
        });
    Route::group(['middleware' => ['permission:Edit Item Manufacturer']], function () {
            Route::get('food-and-beverage/item-manufacturers/item-manufacturers-aeu/{id}', 'FnbItemManufacturerController@edit');
            Route::post('food-and-beverage/item-manufacturers/update/{id}', 'FnbItemManufacturerController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Item Manufacturers']], function () {
            Route::get('food-and-beverage/item-manufacturers/deleted', 'FnbItemManufacturerController@index_deleted');
            Route::post('food-and-beverage/item-manufacturers/deleted', 'FnbItemManufacturerController@indexdt_deleted')->name('manufacturers_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Item Manufacturer']], function () {
            Route::get('food-and-beverage/item-manufacturers/delete/{id}', 'FnbItemManufacturerController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Item Manufacturer']], function () {
            Route::get('food-and-beverage/item-manufacturers/restore/{id}', 'FnbItemManufacturerController@restore');
        });
    // ITEM MANUFACTURER

    // ITEM CATEGORY
    Route::group(['middleware' => ['permission:View Item Category']], function () {
            Route::get('food-and-beverage/item-categories', 'FnbItemCategoryController@index');
            Route::post('food-and-beverage/item-categories', 'FnbItemCategoryController@indexdt')->name('categories.datatable');
        });
    Route::group(['middleware' => ['permission:Add Item Category']], function () {
            Route::get('food-and-beverage/item-categories/item-categories-aeu', 'FnbItemCategoryController@create');
            Route::post('food-and-beverage/item-categories/item-categories-aeu', 'FnbItemCategoryController@store');
        });
    Route::group(['middleware' => ['permission:Edit Item Category']], function () {
            Route::get('food-and-beverage/item-categories/item-categories-aeu/{id}', 'FnbItemCategoryController@edit');
            Route::post('food-and-beverage/item-categories/update/{id}', 'FnbItemCategoryController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Item Categories']], function () {
            Route::get('food-and-beverage/item-categories/deleted', 'FnbItemCategoryController@index_deleted');
            Route::post('food-and-beverage/item-categories/deleted', 'FnbItemCategoryController@indexdt_deleted')->name('categories_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Item Category']], function () {
            Route::get('food-and-beverage/item-categories/delete/{id}', 'FnbItemCategoryController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Item Category']], function () {
            Route::get('food-and-beverage/item-categories/restore/{id}', 'FnbItemCategoryController@restore');
        });
    // ITEM CATEGORY

    // ITEM SUB CATEGORY
    Route::group(['middleware' => ['permission:View Item Sub-Category']], function () {
            Route::get('food-and-beverage/item-sub-categories', 'FnbItemSubCategoryController@index');
            Route::post('food-and-beverage/item-sub-categories', 'FnbItemSubCategoryController@indexdt')->name('sub_categories.datatable');
        });
    Route::group(['middleware' => ['permission:Add Item Sub-Category']], function () {
            Route::get('food-and-beverage/item-sub-categories/item-sub-categories-aeu', 'FnbItemSubCategoryController@create');
            Route::post('food-and-beverage/item-sub-categories/item-sub-categories-aeu', 'FnbItemSubCategoryController@store');
        });
    Route::group(['middleware' => ['permission:Edit Item Sub-Category']], function () {
            Route::get('food-and-beverage/item-sub-categories/item-sub-categories-aeu/{id}', 'FnbItemSubCategoryController@edit');
            Route::post('food-and-beverage/item-sub-categories/update/{id}', 'FnbItemSubCategoryController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Item Sub-Categories']], function () {
            Route::get('food-and-beverage/item-sub-categories/deleted', 'FnbItemSubCategoryController@index_deleted');
            Route::post('food-and-beverage/item-sub-categories/deleted', 'FnbItemSubCategoryController@indexdt_deleted')->name('sub_categories_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Item Sub-Category']], function () {
            Route::get('food-and-beverage/item-sub-categories/delete/{id}', 'FnbItemSubCategoryController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Item Sub-Category']], function () {
            Route::get('food-and-beverage/item-sub-categories/restore/{id}', 'FnbItemSubCategoryController@restore');
        });
    // ITEM SUB CATEGORY

    // PRODUCT CLASSIFICATION
    Route::group(['middleware' => ['permission:View Product Classification']], function () {
            Route::get('food-and-beverage/product-classifications', 'FnbProductClassificationController@index');
            Route::post('food-and-beverage/product-classifications', 'FnbProductClassificationController@indexdt')->name('product_class.datatable');
        });
    Route::group(['middleware' => ['permission:Add Product Classification']], function () {
            Route::get('food-and-beverage/product-classifications/product-classifications-aeu', 'FnbProductClassificationController@create');
            Route::post('food-and-beverage/product-classifications/product-classifications-aeu', 'FnbProductClassificationController@store');
        });
    Route::group(['middleware' => ['permission:Edit Product Classification']], function () {
            Route::get('food-and-beverage/product-classifications/product-classifications-aeu/{id}', 'FnbProductClassificationController@edit');
            Route::post('food-and-beverage/product-classifications/update/{id}', 'FnbProductClassificationController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Product Classifications']], function () {
            Route::get('food-and-beverage/product-classifications/deleted', 'FnbProductClassificationController@index_deleted');
            Route::post('food-and-beverage/product-classifications/deleted', 'FnbProductClassificationController@indexdt_deleted')->name('product_class_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Product Classification']], function () {
            Route::get('food-and-beverage/product-classifications/delete/{id}', 'FnbProductClassificationController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Product Classification']], function () {
            Route::get('food-and-beverage/product-classifications/restore/{id}', 'FnbProductClassificationController@restore');
        });
    // PRODUCT CLASSIFICATION

    // CURRENCY DEFINITION
    Route::group(['middleware' => ['permission:View Currency Definition']], function () {
            Route::get('food-and-beverage/currency-definitions', 'FnbCurrencyController@index');
            Route::post('food-and-beverage/currency-definitions', 'FnbCurrencyController@indexdt')->name('currency_defs.datatable');
        });
    Route::group(['middleware' => ['permission:Add Currency Definition']], function () {
            Route::get('food-and-beverage/currency-definitions/currency-definitions-aeu', 'FnbCurrencyController@create');
            Route::post('food-and-beverage/currency-definitions/currency-definitions-aeu', 'FnbCurrencyController@store');
        });
    Route::group(['middleware' => ['permission:Edit Currency Definition']], function () {
            Route::get('food-and-beverage/currency-definitions/currency-definitions-aeu/{id}', 'FnbCurrencyController@edit');
            Route::post('food-and-beverage/currency-definitions/update/{id}', 'FnbCurrencyController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Currency Definitions']], function () {
            Route::get('food-and-beverage/currency-definitions/deleted', 'FnbCurrencyController@index_deleted');
            Route::post('food-and-beverage/currency-definitions/deleted', 'FnbCurrencyController@indexdt_deleted')->name('currency_defs_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Currency Definition']], function () {
            Route::get('food-and-beverage/currency-definitions/delete/{id}', 'FnbCurrencyController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Currency Definition']], function () {
            Route::get('food-and-beverage/currency-definitions/restore/{id}', 'FnbCurrencyController@restore');
        });
    // CURRENCY DEFINITION

    // PREDEFINED VALUES
    Route::group(['middleware' => ['permission:View Predefined Values']], function () {
            Route::get('admin-settings/predefined-values', 'PredefinedValueController@index');
            Route::post('admin-settings/predefined-values', 'PredefinedValueController@indexdt')->name('predefined_vals.datatable');
        });
    Route::group(['middleware' => ['permission:Add Predefined Values']], function () {
            Route::get('admin-settings/predefined-values/predefined-values-aeu', 'PredefinedValueController@create');
            Route::post('admin-settings/predefined-values/predefined-values-aeu', 'PredefinedValueController@store');
        });
    Route::group(['middleware' => ['permission:Edit Predefined Values']], function () {
            Route::get('admin-settings/predefined-values/predefined-values-aeu/{id}', 'PredefinedValueController@edit');
            Route::post('admin-settings/predefined-values/update/{id}', 'PredefinedValueController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Predefined Values']], function () {
            Route::get('admin-settings/predefined-values/deleted', 'PredefinedValueController@index_deleted');
            Route::post('admin-settings/predefined-values/deleted', 'PredefinedValueController@indexdt_deleted')->name('predefined_vals_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Predefined Values']], function () {
            Route::get('admin-settings/predefined-values/delete/{id}', 'PredefinedValueController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Predefined Values']], function () {
            Route::get('admin-settings/predefined-values/restore/{id}', 'PredefinedValueController@restore');
        });
    // PREDEFINED VALUES

    // ITEM DEFINITION
    Route::group(['middleware' => ['permission:View Item Definition']], function () {
        Route::get('food-and-beverage/item-definitions-vue', 'FnbItemDefinitionController@index_vue');
        Route::get('food-and-beverage/item-definitions/init_vue', 'FnbItemDefinitionController@init_vue');

            Route::get('food-and-beverage/item-definitions', 'FnbItemDefinitionController@index');
            Route::post('food-and-beverage/item-definitions', 'FnbItemDefinitionController@indexdt')->name('items.datatable');
        });

    Route::group(['middleware' => ['permission:Add Item Definition']], function () {
            Route::get('food-and-beverage/item-definitions/item-definitions-aeu', 'FnbItemDefinitionController@create');
            Route::post('food-and-beverage/item-definitions/item-definitions-aeu', 'FnbItemDefinitionController@store');


    Route::get('food-and-beverage/item-definitions/item-definitions-aeu-vue', 'FnbItemDefinitionController@itemdefs_vue');
    Route::get('food-and-beverage/item-definitions-aeu/itemdefs_init_vue', 'FnbItemDefinitionController@itemdefs_init_vue');


    Route::post('food-and-beverage/item-definitions/item-definitions-aeu/save', 'FnbItemDefinitionController@save');


        });
    Route::group(['middleware' => ['permission:Edit Item Definition']], function () {
            Route::get('food-and-beverage/item-definitions/item-definitions-aeu/{id}', 'FnbItemDefinitionController@edit');
            Route::post('food-and-beverage/item-definitions/update/{id}', 'FnbItemDefinitionController@update');


    Route::get('food-and-beverage/item-definitions/item-definitions-aeu-vue/{id}', 'FnbItemDefinitionController@edit_vue');
            Route::post('food-and-beverage/item-definitions/item-definitions-aeu/update', 'FnbItemDefinitionController@updated');
        });
    Route::group(['middleware' => ['permission:View Deleted Item Definitions']], function () {
            Route::get('food-and-beverage/item-definitions/deleted', 'FnbItemDefinitionController@index_deleted');
            Route::post('food-and-beverage/item-definitions/deleted', 'FnbItemDefinitionController@indexdt_deleted')->name('items_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Item Definition']], function () {
            Route::post('food-and-beverage/item-definitions/delete/{id}', 'FnbItemDefinitionController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Item Definition']], function () {
            Route::get('food-and-beverage/item-definitions/restore/{id}', 'FnbItemDefinitionController@restore');
        });


    Route::group(['middleware' => ['permission:View Item Closing Stock Sale Wise']], function () {
        Route::get('finance-and-management/reports/item-sale-closing-stock-vue', 'StoreManagementController@sale_closing_stock_vue');
        Route::get('finance-and-management/item-sale-closing-stock/init_vue', 'StoreManagementController@sale_closing_stock');
        });

    Route::group(['middleware' => ['permission:View Item Closing Stock Issuance Wise']], function () {
        Route::get('finance-and-management/reports/item-issue-closing-stock-vue', 'StoreManagementController@issue_closing_stock_vue');
        Route::get('finance-and-management/item-issue-closing-stock/init_vue', 'StoreManagementController@issue_closing_stock');
        });

    Route::group(['middleware' => ['permission:View Item Closing Stock Details Issuance Wise']], function () {
    Route::get('finance-and-management/reports/item-issue-closing-stock-details-vue', 'StoreManagementController@details_closing_stock_vue');
        Route::get('finance-and-management/item-issue-closing-stock-details/init_vue', 'StoreManagementController@details_closing_stock');
    });

    Route::group(['middleware' => ['permission:View Item Closing Stock Details Sale Wise']], function () {
        Route::get('finance-and-management/reports/item-sale-closing-stock-details-vue', 'StoreManagementController@sale_closing_details_vue');
        Route::get('finance-and-management/item-sale-closing-stock-details/init_vue', 'StoreManagementController@sale_closing_details');
        });
    // ITEM DEFINITION


    // CAKE TYPES
    Route::group(['middleware' => ['permission:View Cake Types']], function () {
            Route::get('food-and-beverage/cake-types', 'FnbCakeTypeController@index');
            Route::post('food-and-beverage/cake-types', 'FnbCakeTypeController@indexdt')->name('cake_types.datatable');
        });
    Route::group(['middleware' => ['permission:Add Cake Types']], function () {
            Route::get('food-and-beverage/cake-types/cake-types-aeu', 'FnbCakeTypeController@create');
            Route::post('food-and-beverage/cake-types/cake-types-aeu', 'FnbCakeTypeController@store');
        });
    Route::group(['middleware' => ['permission:Edit Cake Types']], function () {
            Route::get('food-and-beverage/cake-types/cake-types-aeu/{id}', 'FnbCakeTypeController@edit');
            Route::post('food-and-beverage/cake-types/update/{id}', 'FnbCakeTypeController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Cake Types']], function () {
            Route::get('food-and-beverage/cake-types/deleted', 'FnbCakeTypeController@index_deleted');
            Route::post('food-and-beverage/cake-types/deleted', 'FnbCakeTypeController@indexdt_deleted')->name('cake_types_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Cake Types']], function () {
            Route::get('food-and-beverage/cake-types/delete/{id}', 'FnbCakeTypeController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Cake Types']], function () {
            Route::get('food-and-beverage/cake-types/restore/{id}', 'FnbCakeTypeController@restore');
        });
    // CAKE TYPES



    // CAKE BOOKINGS
    Route::group(['middleware' => ['permission:View Cake Bookings']], function () {
        Route::get('food-and-beverage/cake-booking-vue', 'FnbCakeBookingController@cakebooking_dt');
        Route::get('food-and-beverage/cake-booking/cakebooking_init_vue', 'FnbCakeBookingController@cakebooking_init_dt');
    });

    Route::group(['middleware' => ['permission:Add Cake Bookings']], function () {
        Route::get('food-and-beverage/cake-booking/cake-booking-aeu-vue', 'FnbCakeBookingController@cakebooking');
        Route::post('food-and-beverage/cake-booking/cake-booking-aeu/save', 'FnbCakeBookingController@cakebooking_save');
        Route::post('food-and-beverage/cake-booking/saveandreceive', 'FnbCakeBookingController@received');
    });

    Route::group(['middleware' => ['permission:Edit Cake Bookings']], function () {
        Route::post('food-and-beverage/cake-booking/cake-booking-aeu/update', 'FnbCakeBookingController@updated');
        Route::get('food-and-beverage/cake-booking/cake-booking-aeu-vue/{id}', 'FnbCakeBookingController@cakebooking_edit');
    });


    Route::group(['middleware' => ['permission:Cancel Cake Bookings']], function () {
        Route::post('food-and-beverage/cake-booking/cancel/{id}', 'FnbCakeBookingController@cakebooking_cancel');
    });
    Route::group(['middleware' => ['permission:View Cancelled Cake Bookings']], function () {
        Route::get('food-and-beverage/cancelled-cake-booking-vue', 'FnbCakeBookingController@cancelled_cakebooking_dt');
        Route::get('food-and-beverage/cake-booking/cancelled_cakebooking_init_dt', 'FnbCakeBookingController@cancelled_cakebooking_init_dt');
    });
    Route::group(['middleware' => ['permission:Re-Confirm Cake Bookings']], function () {
        Route::get('food-and-beverage/cake-booking/reconfirm/{id}', 'FnbCakeBookingController@cakebooking_reconfirm');
    });


    Route::get('food-and-beverage/cake-booking/cake-booking-ini', 'FnbCakeBookingController@cakebooking_init');

    Route::group(['middleware' => ['permission:View Deleted Cake Bookings']], function () {
            Route::get('food-and-beverage/cake-booking/deleted', 'FnbCakeBookingController@index_deleted');
            Route::post('food-and-beverage/cake-booking/deleted', 'FnbCakeBookingController@indexdt_deleted')->name('cake_booking_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Cake Bookings']], function () {
            Route::post('food-and-beverage/cake-booking/delete/{id}', 'FnbCakeBookingController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Cake Bookings']], function () {
            Route::get('food-and-beverage/cake-booking/restore/{id}', 'FnbCakeBookingController@restore');
        });

    Route::group(['middleware' => ['permission:Print Cake Bookings Invoice']], function () {
        Route::get('food-and-beverage/cake-booking/cake-booking-invoice/{id}', 'FnbCakeBookingController@invoice')->name('CakeBookingInvoice');
    });
    Route::group(['middleware' => ['permission:View Cake Booking Documents']], function () {
        Route::get('food-and-beverage/cake-booking/cake-booking-documents/{id}', 'FnbCakeBookingController@docs');
    });

    Route::post('food-and-beverage/cake-booking/temporary_upload', 'FnbCakeBookingController@temp_upload');
    Route::post('food-and-beverage/cake-booking/temporary_remove', 'FnbCakeBookingController@temp_remove');
    // CAKE BOOKINGS


    //EXPENSE DOCUMENTS
    Route::post('finance-and-management/finance-expenses/temporary_upload', 'FinanceExpenseNewController@temp_upload');
    Route::post('finance-and-management/finance-expenses/temporary_remove', 'FinanceExpenseNewController@temp_remove');
    //EXPENSE DOCUMENTS




    Route::group(['middleware' => ['permission:View Member Card Detail Report']], function () {
    Route::get('finance-and-management/reports/member-card-detail-report-vue', 'MembershipController@card_vue');
    Route::get('finance-and-management/reports/member-card-detail/card_init_vue', 'MembershipController@card_init_vue');
    });

    Route::group(['middleware' => ['permission:View Supplementary Card Detail Report']], function () {
    Route::get('finance-and-management/reports/supplementary-card-detail-report-vue', 'MembershipController@summary_vue');
    Route::get('finance-and-management/reports/supplementary-card-detail/summary_init_vue', 'MembershipController@summary_init_vue');
    });




    // SALES

    Route::group(['middleware' => ['permission:View Revenue Summary Report']], function () {
    Route::get('finance-and-management/reports/revenue-summary-vue', 'FnbSaleController@revenuesummary_vue');
    Route::get('finance-and-management/reports/revenue-summary/revenuesummary_init_vue', 'FnbSaleController@revenuesummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Member Revenue Summary Report']], function () {
    Route::get('finance-and-management/reports/member-revenue-summary-vue', 'FnbSaleController@memrevenue_vue');
    Route::get('finance-and-management/reports/member-revenue-summary/memrevenue_init_vue', 'FnbSaleController@memrevenue_init_vue');
    });

    Route::group(['middleware' => ['permission:View Daily Finance Transaction Book']], function () {
    Route::get('finance-and-management/reports/transaction-book-vue', 'FinanceReportsController@book_vue');
    Route::get('finance-and-management/reports/transaction-book/book_init_vue', 'FinanceReportsController@book_init_vue');
    });

    Route::group(['middleware' => ['permission:View Daily Cash Book']], function () {
    Route::get('finance-and-management/reports/cash-book-vue', 'FinanceReportsController@cash_vue');
    Route::get('finance-and-management/reports/cash-book/cash_init_vue', 'FinanceReportsController@cash_init_vue');
    });

    Route::group(['middleware' => ['permission:View Bank Ledger']], function () {
    Route::get('finance-and-management/reports/bank-ledger-vue', 'FinanceReportsController@bank_vue');
    Route::get('finance-and-management/reports/bank-ledger/bank_init_vue', 'FinanceReportsController@bank_init_vue');
    });




    Route::group(['middleware' => ['permission:View Dish Breakdown Summary']], function () {

    Route::get('finance-and-management/reports/dish-breakdown-summary-vue', 'FnbSaleController@dishbreakdownsummary_vue');
    Route::get('finance-and-management/reports/dish-breakdown-summary/dishbreakdownsummary_init_vue', 'FnbSaleController@dishbreakdownsummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Dish Breakdown Summary Restaurant-wise']], function () {
    Route::get('finance-and-management/reports/restaurant-dish-breakdown-summary-vue', 'FnbSaleController@resdishbreakdownsummary_vue');
    Route::get('finance-and-management/reports/restaurant-dish-breakdown-summary/resdishbreakdownsummary_init_vue', 'FnbSaleController@resdishbreakdownsummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Dish Breakdown Summary Date-wise']], function () {
    Route::get('finance-and-management/reports/date-dish-breakdown-summary-vue', 'FnbSaleController@datedishbreakdownsummary_vue');
    Route::get('finance-and-management/reports/date-dish-breakdown-summary/datedishbreakdownsummary_init_vue', 'FnbSaleController@datedishbreakdownsummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Yearly Dish Breakdown Summary']], function () {
    Route::get('finance-and-management/reports/yearly-dish-breakdown-summary-vue', 'FnbSaleController@yearlydishbreakdownsummary_vue');
    Route::get('finance-and-management/reports/yearly-dish-breakdown-summary/yearlydishbreakdownsummary_init_vue', 'FnbSaleController@yearlydishbreakdownsummary_init_vue');

    });


    // KOT REPORT
    Route::group(['middleware' => ['permission:View Sales KOT Report']], function () {
    Route::get('finance-and-management/reports/sales-kot-report-vue', 'FnbSaleController@saleskot_vue');
    Route::get('finance-and-management/reports/sales-kot-report/saleskot_init_vue', 'FnbSaleController@saleskot_init_vue');
    });
    // KOT REPORT



    Route::group(['middleware' => ['permission:View Sold Quantity Report']], function () {
    Route::get('finance-and-management/reports/sold-quantity-report-vue', 'FnbSaleController@soldquantity_vue');
    Route::get('finance-and-management/reports/sold-quantity-report/soldquantity_init_vue', 'FnbSaleController@soldquantity_init_vue');
    });

    Route::group(['middleware' => ['permission:View Daily Dump Items List']], function () {
    Route::get('finance-and-management/reports/daily-dump-items-vue', 'FnbSaleController@dumpitems_vue');
    Route::get('finance-and-management/reports/daily-dump-items/dumpitems_init_vue', 'FnbSaleController@dumpitems_init_vue');
    });

    //shifts
    Route::group(['middleware' => ['permission:View Shifts']], function () {
    Route::get('food-and-beverage/shifts-vue', 'FnbSaleController@shifts_vue');
    });

    Route::group(['middleware' => ['permission:View User Shifts']], function () {
    Route::get('food-and-beverage/user-shifts-vue', 'FnbSaleController@user_shifts_vue');
    Route::get('food-and-beverage/sales/user-shifts-ini', 'FnbSaleController@user_shifts_init');
    Route::post('food-and-beverage/sales/start_user_shift', 'FnbSaleController@start_user_shift');
    Route::post('food-and-beverage/sales/end_user_shift', 'FnbSaleController@end_user_shift');
    Route::get('food-and-beverage/sales/check-user-shift', 'FnbSaleController@check_user_shift');
    });
    //shifts

    Route::group(['middleware' => ['permission:View Sales Summary']], function () {
        Route::get('food-and-beverage/sales-vue', 'FnbSaleController@index_vue');
    });

    Route::group(['middleware' => ['permission:View Sales']], function () {
            Route::get('food-and-beverage/sales-list-vue', 'FnbSaleController@index_list_vue');
            Route::get('food-and-beverage/sales/sales_init_vue', 'FnbSaleController@sales_init_vue');

            Route::get('food-and-beverage/sales', 'FnbSaleController@index');
            Route::post('food-and-beverage/sales', 'FnbSaleController@indexdt')->name('fnb_sales.datatable');
        });



    Route::group(['middleware' => ['permission:View Running Sales List']], function () {
    Route::get('food-and-beverage/running-sales-list-vue', 'FnbSaleController@index_running_list_vue');
    Route::get('food-and-beverage/sales/running_sales_init_vue', 'FnbSaleController@running_sales_init_vue');
    });

    Route::group(['middleware' => ['permission:Add Sales']], function () {
            Route::get('food-and-beverage/sales/sales-aeu', 'FnbSaleController@sales');
            Route::get('food-and-beverage/sales/sales-ini', 'FnbSaleController@sales_init');
            Route::post('food-and-beverage/sales/sales-aeu', 'FnbSaleController@store');
            Route::post('food-and-beverage/sales/sales-aeu/save', 'FnbSaleController@save');
            Route::get('food-and-beverage/sales/sales-kot/{id}', 'FnbSaleController@kot');

            Route::post('food-and-beverage/sales/sales-aeu/reserve', 'FnbSaleController@reserve');
        });





            Route::post('food-and-beverage/sales/update/{id}', 'FnbSaleController@update');
        Route::post('food-and-beverage/sales/sales-aeu/update', 'FnbSaleController@updated');
        Route::post('food-and-beverage/sales/sales-aeu/updateandreceive', 'FnbSaleController@updateandreceive');
            Route::post('food-and-beverage/sales/sales-aeu/move', 'FnbSaleController@moved');
            Route::post('food-and-beverage/sales/sales-aeu/receive', 'FnbSaleController@received');
            Route::get('food-and-beverage/sales/sales-aeu/confirmorder/{id}', 'FnbSaleController@confirmorder');
            Route::post('food-and-beverage/sales/sales-aeu/unpay', 'FnbSaleController@unpaid');


    Route::group(['middleware' => ['permission:Edit Final Sales']], function () {
            Route::get('food-and-beverage/sales/sales-aeu/{id}', 'FnbSaleController@edit');
    });


    Route::group(['middleware' => ['permission:View Deleted Sales']], function () {
            Route::get('food-and-beverage/sales/deleted', 'FnbSaleController@index_deleted');
            Route::post('food-and-beverage/sales/deleted', 'FnbSaleController@indexdt_deleted')->name('fnb_sales_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Sales']], function () {
            Route::post('food-and-beverage/sales/delete/{id}', 'FnbSaleController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Sales']], function () {
            Route::get('food-and-beverage/sales/restore/{id}', 'FnbSaleController@restore');
        });
    Route::group(['middleware' => ['permission:Print Sales Invoice']], function () {
            Route::get('food-and-beverage/sales/sales-invoice/{id}', 'FnbSaleController@invoice')->name('salesInvoice');
            Route::post('food-and-beverage/sales/generate_invoice', 'FnbSaleController@generate_invoice');
        });
    Route::post('food-and-beverage/sales/start_shift', 'FnbSaleController@start_shift');
    Route::post('food-and-beverage/sales/end_shift', 'FnbSaleController@end_shift');


    Route::get('finance-and-management/finance-voucher/payment-mode/{id}', 'FinanceGeneralVoucherController@paymentmethod');

    Route::get('food-and-beverage/sales/subcategory/{id}', 'FnbSaleController@subcategory');
    Route::get('food-and-beverage/sales/itemselect/{id}', 'FnbSaleController@itemselect');
    Route::get('food-and-beverage/sales/accounttypes/{id}', 'FnbSaleController@accounttypes');
    Route::get('food-and-beverage/sales/items/{id}', 'FnbSaleController@items');
    Route::get('food-and-beverage/sales/gettheitems/{id}', 'FnbSaleController@gettheitems');
    Route::get('food-and-beverage/sales/items', 'FnbSaleController@searcheditems');
    Route::get('food-and-beverage/sales/tables/{id}', 'FnbSaleController@tables');
    Route::get('food-and-beverage/sales/waiters/{id}', 'FnbSaleController@waiters');
    Route::get('food-and-beverage/sales/restaurants/{id}', 'FnbSaleController@restaurants');
    Route::get('food-and-beverage/sales/sales-aeu/booked/{id}', 'FnbSaleController@booked');
    Route::get('food-and-beverage/sales/sales-aeu/printed/{id}', 'FnbSaleController@printed');
    // SALES

    // SALES SUMMARY WITH ITEMS
    Route::group(['middleware' => ['permission:View Sales Summary With Items']], function () {
    Route::get('finance-and-management/reports/items-sales-summary-vue', 'FnbSaleController@itemsummary_vue');
    Route::get('finance-and-management/reports/items-sales-summary/itemsummary_init_vue', 'FnbSaleController@itemsummary_init_vue');
    });
    // SALES SUMMARY WITh ITEMS


    // SALES ERRORS
    Route::group(['middleware' => ['permission:View Sales Errors']], function () {
    Route::get('finance-and-management/reports/sales-errors-vue', 'FnbSaleController@saleserrors_vue');
    Route::get('finance-and-management/reports/sales-errors/saleserrors_init_vue', 'FnbSaleController@saleserrors_init_vue');
    });
    // SALES ERRORS


    /* CLOSING SALES REPORT */
    Route::group(['middleware' => ['permission:View Closing Sales Report']], function () {
        Route::get('finance-and-management/reports/closing-sales-report-vue', 'FnbSaleController@closingsales_vue');
        Route::get('finance-and-management/reports/closing-sales-report/closingsales_init_vue', 'FnbSaleController@closingsales_init_vue');

        Route::get('finance-and-management/reports/closing-sales-report', 'FnbSaleController@closingsalesreport');
    });
    /* CLOSING SALES REPORT */



    /* DAILY CASHIER SALES LIST */
    Route::group(['middleware' => ['permission:View Daily Cashier Sales List']], function () {
        Route::get('finance-and-management/reports/daily-cashier-sales-list-vue', 'FnbSaleController@cashiersales_vue');
        Route::get('finance-and-management/reports/daily-cashier-sales-list/cashiersales_init_vue', 'FnbSaleController@cashiersales_init_vue');
    });
    /* DAILY CASHIER SALES LIST */


    /* DAILY RESTAURANT SALES SUMMARY */
    Route::group(['middleware' => ['permission:View Daily Restaurant Sales Summary']], function () {
        Route::get('finance-and-management/reports/daily-restaurant-sales-summary-vue', 'FnbSaleController@dailyrestsales_vue');
        Route::get('finance-and-management/reports/daily-restaurant-sales-summary/dailyrestsales_init_vue', 'FnbSaleController@dailyrestsales_init_vue');
    });
    /* DAILY RESTAURANT SALES SUMMARY */


    /* SALES DASHBOARD */
    Route::group(['middleware' => ['permission:View Sales Dashboard']], function () {
    Route::get('finance-and-management/reports/sales-dashboard-vue', 'FnbSaleController@salesdashboard_vue');
    Route::get('finance-and-management/reports/sales-dashboard/salesdashboard_init_vue', 'FnbSaleController@salesdashboard_init_vue');
    });
    /* SALES DASHBOARD */



    // HOURLY SALES REPORT
    Route::group(['middleware' => ['permission:View Hourly Sales Report']], function () {
    Route::get('finance-and-management/reports/hourly-sales-vue', 'FnbSaleController@hourlysales_vue');
    Route::get('finance-and-management/reports/hourly-sales/hourlysales_init_vue', 'FnbSaleController@hourlysales_init_vue');
    });
    // HOURLY SALES REPORT



    /// FNB REPORTS
    Route::get('finance-and-management/food-and-beverage/reports/dish-breakdown-reports', function () {
                return view('backend/finance-and-management/finance-reports/fnb-reports/dish-breakdown-reports');
            });
    Route::get('finance-and-management/food-and-beverage/reports/graphs-and-charts', function () {
                return view('backend/finance-and-management/finance-reports/fnb-reports/graphs-and-charts');
            });
    Route::get('finance-and-management/food-and-beverage/reports/daily-reports', function () {
                return view('backend/finance-and-management/finance-reports/fnb-reports/daily-reports');
            });
    Route::get('finance-and-management/food-and-beverage/reports/sale-reports', function () {
                return view('backend/finance-and-management/finance-reports/fnb-reports/sale-reports');
            });
    /// FNB REPORTS


    // WEEKDAYS GRAPHICAL SALES REPORT
    Route::group(['middleware' => ['permission:View Weekdays Graphical Sales Report']], function () {
    Route::get('finance-and-management/reports/weekdays-graphical-sales-vue', 'FnbSaleController@weekdayssales_vue');
    Route::get('finance-and-management/reports/weekdays-graphical-sales/weekdayssales_init_vue', 'FnbSaleController@weekdayssales_init_vue');
    });
    // WEEKDAYS GRAPHICAL SALES REPORT


    // RESTAURANT GRAPHICAL SALES REPORT
    Route::group(['middleware' => ['permission:View Restaurant-wise Graphical Sales Report']], function () {
    Route::get('finance-and-management/reports/restaurant-graphical-sales-vue', 'FnbSaleController@restaurantsales_vue');
    Route::get('finance-and-management/reports/restaurant-graphical-sales/restaurantsales_init_vue', 'FnbSaleController@restaurantsales_init_vue');
    });
    // RESTAURANT GRAPHICAL SALES REPORT


    // SUBCATEGORY GRAPHICAL SALES REPORT
    Route::group(['middleware' => ['permission:View Subcategory-wise Graphical Sales Report']], function () {
    Route::get('finance-and-management/reports/subcategory-graphical-sales-vue', 'FnbSaleController@subcategorysales_vue');
    Route::get('finance-and-management/reports/subcategory-graphical-sales/subcategorysales_init_vue', 'FnbSaleController@subcategorysales_init_vue');
    });
    // SUBCATEGORY GRAPHICAL SALES REPORT




    /* DISH BREAKDOWN SUMMARY */
    Route::group(['middleware' => ['permission:View Dish Breakdown Summary']], function () {
        Route::get('finance-and-management/reports/dish-breakdown-summary', 'FnbSaleController@dishbreakdownsummary');
    });
    /* DISH BREAKDOWN SUMMARY */


    /* SOLD QUANTITY REPORT */
    Route::group(['middleware' => ['permission:View Sold Quantity Report']], function () {
        Route::get('finance-and-management/reports/sold-quantity-report', 'FnbSaleController@soldquantityreport');
    });
    /* SOLD QUANTITY REPORT */

    /* DAILY DUMP ITEMS LIST */
    Route::group(['middleware' => ['permission:View Daily Dump Items List']], function () {
        Route::get('finance-and-management/reports/daily-dump-items', 'FnbSaleController@dailydumpitems');
    });
    /* DAILY DUMP ITEMS LIST */

    /* RUNNING KITCHEN ORDER */
    Route::group(['middleware' => ['permission:View Running Kitchen Order']], function () {
        Route::get('food-and-beverage/reports/running-kitchen-order', 'FnbSaleController@runningkitchenorder');
    });
    Route::group(['middleware' => ['permission:View Running Kitchen Order']], function () {
        Route::get('food-and-beverage/reports/running-kitchen-order-vue', 'FnbSaleController@running_vue');
        Route::get('food-and-beverage/reports/running-kitchen-order/running_init_vue', 'FnbSaleController@running_init_vue');
    });
    /* RUNNING KITCHEN ORDER */

    /* RUNNING SALES ORDER */
    Route::group(['middleware' => ['permission:View Running Sales Order']], function () {
        Route::get('food-and-beverage/reports/running-sales-order', 'FnbSaleController@runningsalesorder');
    });
    /* RUNNING SALES ORDER */

    // DISCOUNT CARD
    Route::group(['middleware' => ['permission:View Discount Card']], function () {
            Route::get('food-and-beverage/discount-cards', 'FnbDiscountCardController@index');
            Route::post('food-and-beverage/discount-cards', 'FnbDiscountCardController@indexdt')->name('discount_card.datatable');
        });
    Route::group(['middleware' => ['permission:Add Discount Card']], function () {
            Route::get('food-and-beverage/discount-cards/discount-cards-aeu', 'FnbDiscountCardController@create');
            Route::post('food-and-beverage/discount-cards/discount-cards-aeu', 'FnbDiscountCardController@store');
        });
    Route::group(['middleware' => ['permission:Edit Discount Card']], function () {
            Route::get('food-and-beverage/discount-cards/discount-cards-aeu/{id}', 'FnbDiscountCardController@edit');
            Route::post('food-and-beverage/discount-cards/update/{id}', 'FnbDiscountCardController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Discount Cards']], function () {
            Route::get('food-and-beverage/discount-cards/deleted', 'FnbDiscountCardController@index_deleted');
            Route::post('food-and-beverage/discount-cards/deleted', 'FnbDiscountCardController@indexdt_deleted')->name('discount_card_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Discount Card']], function () {
            Route::get('food-and-beverage/discount-cards/delete/{id}', 'FnbDiscountCardController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Discount Card']], function () {
            Route::get('food-and-beverage/discount-cards/restore/{id}', 'FnbDiscountCardController@restore');
        });
    // DISCOUNT CARD

    // PARTNERS
    Route::group(['middleware' => ['permission:View Partners']], function () {
            Route::get('club-hospitality/partners', 'MemPartnersController@index');
            Route::post('club-hospitality/partners', 'MemPartnersController@indexdt')->name('partners.datatable');
        });
    Route::group(['middleware' => ['permission:Add Partners']], function () {
            Route::get('club-hospitality/partners/partners-aeu', 'MemPartnersController@create');
            Route::post('club-hospitality/partners/partners-aeu', 'MemPartnersController@store');
        });
    Route::group(['middleware' => ['permission:Edit Partners']], function () {
            Route::get('club-hospitality/partners/partners-aeu/{id}', 'MemPartnersController@edit');
            Route::post('club-hospitality/partners/update/{id}', 'MemPartnersController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Partners']], function () {
            Route::get('club-hospitality/partners/deleted', 'MemPartnersController@index_deleted');
            Route::post('club-hospitality/partners/deleted', 'MemPartnersController@indexdt_deleted')->name('partners_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Partners']], function () {
            Route::get('club-hospitality/partners/delete/{id}', 'MemPartnersController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Partners']], function () {
            Route::get('club-hospitality/partners/restore/{id}', 'MemPartnersController@restore');
        });
    // PARTNERS






    // CRM
    Route::group(['middleware' => ['permission:View CRM']], function () {
            Route::get('crm', function () {
                return view('backend/crm/crm');
            });
            Route::get('crm/definitions', function () {
                return view('backend/crm/crm-definitions');
            });
        });

    // LEADS STATUS
    Route::group(['middleware' => ['permission:View Leads Status']], function () {
            Route::get('crm/leads-status', 'CrmLeadsStatusController@index');
            Route::post('crm/leads-status', 'CrmLeadsStatusController@indexdt')->name('leads_status.datatable');
        });
    Route::group(['middleware' => ['permission:Add Leads Status']], function () {
            Route::get('crm/leads-status/leads-status-aeu', 'CrmLeadsStatusController@create');
            Route::post('crm/leads-status/leads-status-aeu', 'CrmLeadsStatusController@store');
        });
    Route::group(['middleware' => ['permission:Edit Leads Status']], function () {
            Route::get('crm/leads-status/leads-status-aeu/{id}', 'CrmLeadsStatusController@edit');
            Route::post('crm/leads-status/update/{id}', 'CrmLeadsStatusController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Leads Status']], function () {
            Route::get('crm/leads-status/deleted', 'CrmLeadsStatusController@index_deleted');
            Route::post('crm/leads-status/deleted', 'CrmLeadsStatusController@indexdt_deleted')->name('leads_status_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Leads Status']], function () {
            Route::get('crm/leads-status/delete/{id}', 'CrmLeadsStatusController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Leads Status']], function () {
            Route::get('crm/leads-status/restore/{id}', 'CrmLeadsStatusController@restore');
        });
    // LEADS STATUS

    // CALLS STATUS
    Route::group(['middleware' => ['permission:View Calls Status']], function () {
            Route::get('crm/calls-status', 'CrmCallsStatusController@index');
            Route::post('crm/calls-status', 'CrmCallsStatusController@indexdt')->name('calls_status.datatable');
        });
    Route::group(['middleware' => ['permission:Add Calls Status']], function () {
            Route::get('crm/calls-status/calls-status-aeu', 'CrmCallsStatusController@create');
            Route::post('crm/calls-status/calls-status-aeu', 'CrmCallsStatusController@store');
        });
    Route::group(['middleware' => ['permission:Edit Calls Status']], function () {
            Route::get('crm/calls-status/calls-status-aeu/{id}', 'CrmCallsStatusController@edit');
            Route::post('crm/calls-status/update/{id}', 'CrmCallsStatusController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Calls Status']], function () {
            Route::get('crm/calls-status/deleted', 'CrmCallsStatusController@index_deleted');
            Route::post('crm/calls-status/deleted', 'CrmCallsStatusController@indexdt_deleted')->name('calls_status_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Calls Status']], function () {
            Route::get('crm/calls-status/delete/{id}', 'CrmCallsStatusController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Calls Status']], function () {
            Route::get('crm/calls-status/restore/{id}', 'CrmCallsStatusController@restore');
        });
    // CALLS STATUS

    // LEAD SOURCES
    Route::group(['middleware' => ['permission:View Lead Sources']], function () {
            Route::get('crm/lead-sources', 'CrmLeadSourceController@index');
            Route::post('crm/lead-sources', 'CrmLeadSourceController@indexdt')->name('lead_sources.datatable');
        });
    Route::group(['middleware' => ['permission:Add Lead Sources']], function () {
            Route::get('crm/lead-sources/lead-sources-aeu', 'CrmLeadSourceController@create');
            Route::post('crm/lead-sources/lead-sources-aeu', 'CrmLeadSourceController@store');
        });
    Route::group(['middleware' => ['permission:Edit Lead Sources']], function () {
            Route::get('crm/lead-sources/lead-sources-aeu/{id}', 'CrmLeadSourceController@edit');
            Route::post('crm/lead-sources/update/{id}', 'CrmLeadSourceController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Lead Sources']], function () {
            Route::get('crm/lead-sources/deleted', 'CrmLeadSourceController@index_deleted');
            Route::post('crm/lead-sources/deleted', 'CrmLeadSourceController@indexdt_deleted')->name('lead_sources_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Lead Sources']], function () {
            Route::get('crm/lead-sources/delete/{id}', 'CrmLeadSourceController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Lead Sources']], function () {
            Route::get('crm/lead-sources/restore/{id}', 'CrmLeadSourceController@restore');
        });
    // LEAD SOURCES


    // REASONS / REMARKS
    Route::group(['middleware' => ['permission:View Reasons']], function () {
            Route::get('crm/reasons', 'CrmReasonController@index');
            Route::post('crm/reasons', 'CrmReasonController@indexdt')->name('reasons.datatable');
        });
    Route::group(['middleware' => ['permission:Add Reasons']], function () {
            Route::get('crm/reasons/reasons-aeu', 'CrmReasonController@create');
            Route::post('crm/reasons/reasons-aeu', 'CrmReasonController@store');
        });
    Route::group(['middleware' => ['permission:Edit Reasons']], function () {
            Route::get('crm/reasons/reasons-aeu/{id}', 'CrmReasonController@edit');
            Route::post('crm/reasons/update/{id}', 'CrmReasonController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Reasons']], function () {
            Route::get('crm/reasons/deleted', 'CrmReasonController@index_deleted');
            Route::post('crm/reasons/deleted', 'CrmReasonController@indexdt_deleted')->name('reasons_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Reasons']], function () {
            Route::get('crm/reasons/delete/{id}', 'CrmReasonController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Reasons']], function () {
            Route::get('crm/reasons/restore/{id}', 'CrmReasonController@restore');
        });
    // REASONS / REMARKS



    // DASHBOARD
    Route::group(['middleware' => ['permission:View CRM Dashboard']], function () {
        Route::get('crm/dashboard-vue', 'CrmLeadController@dashboard_vue');
        Route::get('crm/dashboard/dashboard_init_vue', 'CrmLeadController@dashboard_init_vue');
    });
    // DASHBOARD


    // LEADS
    Route::group(['middleware' => ['permission:View Leads']], function () {
        Route::get('crm/leads-vue', 'CrmLeadController@leads_vue');
        Route::get('crm/leads/leads_init_vue', 'CrmLeadController@leads_init_vue');
        });
    Route::group(['middleware' => ['permission:Add Leads']], function () {
            Route::get('crm/leads/leads-aeu-vue', 'CrmLeadController@create');
            Route::get('crm/leads/leads-aeu/init', 'CrmLeadController@init');
            Route::post('crm/leads/leads-aeu/save', 'CrmLeadController@save');

        Route::post('crm/leads/checkcontact/save', 'CrmLeadController@checkcontact_save');
        });
    Route::group(['middleware' => ['permission:Edit Leads']], function () {
            Route::get('crm/leads/leads-aeu-vue/{id}', 'CrmLeadController@edit');
            Route::post('crm/leads/leads-aeu/update', 'CrmLeadController@updated');

            Route::post('crm/leads/checkcontact/update', 'CrmLeadController@checkcontact_edit');
    });

    Route::group(['middleware' => ['permission:Assign Leads']], function () {
            Route::post('crm/leads/leads-aeu/assignlead/{id}', 'CrmLeadController@assignlead');
    });

    Route::group(['middleware' => ['permission:Add Call Details']], function () {
        Route::post('crm/leads/leads-aeu/calldetails/{id}', 'CrmLeadController@calldetails');
    });
    Route::group(['middleware' => ['permission:View Call Details']], function () {
        Route::get('crm/call-details-vue', 'CrmLeadController@calls_vue');
        Route::get('crm/call-details/calls_init_vue', 'CrmLeadController@calls_init_vue');
        });

    Route::group(['middleware' => ['permission:View Member Recoveries']], function () {
    /*  Route::get('crm/member-recoveries-vue', 'CrmLeadController@recoveries_vue');*/
        Route::get('crm/visits-comment-sheet-vue', 'CrmLeadController@recoveries_vue');
        Route::get('crm/member-recoveries/recoveries_init_vue', 'CrmLeadController@recoveries_init_vue');
        });

    Route::group(['middleware' => ['permission:View Follow Ups']], function () {
        Route::get('crm/follow-ups-vue', 'CrmLeadController@followups_vue');
        Route::get('crm/follow-ups/followups_init_vue', 'CrmLeadController@followups_init_vue');
    });

    Route::group(['middleware' => ['permission:View Visits']], function () {
        Route::get('crm/visits-vue', 'CrmLeadController@visits_vue');
        Route::get('crm/visits/visits_init_vue', 'CrmLeadController@visits_init_vue');
    });

    Route::group(['middleware' => ['permission:Add Visit Details']], function () {
        Route::post('crm/leads/leads-aeu/visitdetails/{id}', 'CrmLeadController@visitdetails');
    });

    Route::group(['middleware' => ['permission:View Deleted Leads']], function () {
            Route::get('crm/leads/deleted', 'CrmLeadController@index_deleted');
            Route::post('crm/leads/deleted', 'CrmLeadController@indexdt_deleted')->name('leads_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Leads']], function () {
            Route::post('crm/leads/delete/{id}', 'CrmLeadController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Leads']], function () {
            Route::get('crm/leads/restore/{id}', 'CrmLeadController@restore');
        });
    // LEADS


    // COMPLAINTS
    Route::group(['middleware' => ['permission:View Complaints']], function () {
        Route::get('crm/complaints-vue', 'CrmComplaintController@complaints_vue');
        Route::get('crm/complaints/complaints_init_vue', 'CrmComplaintController@complaints_init_vue');
        });
    Route::group(['middleware' => ['permission:View Deleted Complaints']], function () {
        Route::get('crm/complaints/deleted-vue', 'CrmComplaintController@index_deleted');
        Route::get('crm/complaints/indexdt_deleted', 'CrmComplaintController@indexdt_deleted');
        });
    Route::group(['middleware' => ['permission:Add Complaints']], function () {
            Route::get('crm/complaints/complaints-aeu-vue', 'CrmComplaintController@create');
            Route::get('crm/complaints/complaints-aeu/init', 'CrmComplaintController@init');
            Route::post('crm/complaints/complaints-aeu/save', 'CrmComplaintController@save');
        });
    Route::group(['middleware' => ['permission:Edit Complaints']], function () {
            Route::get('crm/complaints/complaints-aeu-vue/{id}', 'CrmComplaintController@edit');
            Route::post('crm/complaints/complaints-aeu/update', 'CrmComplaintController@updated');
    });
    Route::group(['middleware' => ['permission:Delete Complaints']], function () {
            Route::get('crm/complaints/delete/{id}', 'CrmComplaintController@destroy');
    });
    Route::group(['middleware' => ['permission:Restore Complaints']], function () {
            Route::get('crm/complaints/restore/{id}', 'CrmComplaintController@restore');
    });
    // COMPLAINTS

    // BD REPORT
    Route::group(['middleware' => ['permission:View BD Report']], function () {
    Route::get('finance-and-management/reports/bd-report-vue', 'CrmLeadController@bd_vue');
    Route::get('finance-and-management/reports/bd-report/bd_init_vue', 'CrmLeadController@bd_init_vue');
    });
    // BD REPORT

    // LEAD REPORT
    Route::group(['middleware' => ['permission:View Lead Report']], function () {
    Route::get('finance-and-management/reports/lead-report-vue', 'CrmLeadController@lead_vue');
    Route::get('finance-and-management/reports/lead-report/lead_init_vue', 'CrmLeadController@lead_init_vue');
    });
    // LEAD REPORT

    // CRM




    // MAINTENANCE MANAGEMENT
        Route::group(['middleware' => ['permission:View Maintenance Management']], function () {
            Route::get('maintenance-management', function () {
                return view('backend/maintenance-management/maintenance-management');
            });
            Route::get('maintenance-management/definitions', function () {
                return view('backend/maintenance-management/maintenance-management-definitions');
            });
        });

        // WORK ORDER DEAPRTMENTS
    Route::group(['middleware' => ['permission:View Work Order Departments']], function () {
            Route::get('maintenance-management/work-order-departments', 'MaintWorkOrderDepartmentController@index');
            Route::post('maintenance-management/work-order-departments', 'MaintWorkOrderDepartmentController@indexdt')->name('work_deps.datatable');
        });
    Route::group(['middleware' => ['permission:Add Work Order Departments']], function () {
            Route::get('maintenance-management/work-order-departments/work-order-departments-aeu', 'MaintWorkOrderDepartmentController@create');
            Route::post('maintenance-management/work-order-departments/work-order-departments-aeu', 'MaintWorkOrderDepartmentController@store');
        });
    Route::group(['middleware' => ['permission:Edit Work Order Departments']], function () {
            Route::get('maintenance-management/work-order-departments/work-order-departments-aeu/{id}', 'MaintWorkOrderDepartmentController@edit');
            Route::post('maintenance-management/work-order-departments/update/{id}', 'MaintWorkOrderDepartmentController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Work Order Departments']], function () {
            Route::get('maintenance-management/work-order-departments/deleted', 'MaintWorkOrderDepartmentController@index_deleted');
            Route::post('maintenance-management/work-order-departments/deleted', 'MaintWorkOrderDepartmentController@indexdt_deleted')->name('work_deps_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Work Order Departments']], function () {
            Route::get('maintenance-management/work-order-departments/delete/{id}', 'MaintWorkOrderDepartmentController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Work Order Departments']], function () {
            Route::get('maintenance-management/work-order-departments/restore/{id}', 'MaintWorkOrderDepartmentController@restore');
        });
        // WORK ORDER DEAPRTMENTS

    // WORK ORDER SHEET
    Route::group(['middleware' => ['permission:View Work Order Sheet']], function () {
        Route::get('maintenance-management/work-order-sheet-vue', 'MaintWorkOrderSheetController@sheet_dt');
        Route::get('maintenance-management/work-order-sheet/sheet_init_vue', 'MaintWorkOrderSheetController@sheet_init_vue');
    });

    Route::group(['middleware' => ['permission:Add Work Order Sheet']], function () {
        Route::get('maintenance-management/work-order-sheet/work-order-sheet-aeu-vue', 'MaintWorkOrderSheetController@create');
        Route::post('maintenance-management/work-order-sheet/work-order-sheet-aeu/save', 'MaintWorkOrderSheetController@save');
    });

    Route::group(['middleware' => ['permission:Edit Work Order Sheet']], function () {
        Route::post('maintenance-management/work-order-sheet/work-order-sheet-aeu/update', 'MaintWorkOrderSheetController@updated');
        Route::get('maintenance-management/work-order-sheet/work-order-sheet-aeu-vue/{id}', 'MaintWorkOrderSheetController@edit');
    });

    Route::get('maintenance-management/work-order-sheet/work-order-sheet-ini', 'MaintWorkOrderSheetController@init');

    Route::group(['middleware' => ['permission:View Deleted Work Order Sheets']], function () {
            Route::get('maintenance-management/work-order-sheet/deleted', 'MaintWorkOrderSheetController@index_deleted');
            Route::post('maintenance-management/work-order-sheet/deleted', 'MaintWorkOrderSheetController@indexdt_deleted')->name('sheet_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Work Order Sheet']], function () {
            Route::post('maintenance-management/work-order-sheet/delete/{id}', 'MaintWorkOrderSheetController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Work Order Sheet']], function () {
            Route::get('maintenance-management/work-order-sheet/restore/{id}', 'MaintWorkOrderSheetController@restore');
        });

    Route::group(['middleware' => ['permission:Print Work Order Sheet']], function () {
        Route::get('maintenance-management/work-order-sheet/work-order-sheet-invoice/{id}', 'MaintWorkOrderSheetController@invoice')->name('WorkOrderInvoice');
    });
    // WORK ORDER SHEET

    // MAINTENANCE MANAGEMENT





    //STORE MANAGEMENT
    Route::group(['middleware' => ['permission:View Store Management']], function () {
            Route::get('store-management', function () {
                return view('backend/store-management/store-management');
            });
            Route::get('store-management/definitions', function () {
                return view('backend/store-management/store-management-definitions');
            });
        });



    // CANCELLATION REMARKS
    Route::group(['middleware' => ['permission:View Cancellation Remarks']], function () {
        Route::get('store-management/cancellation-remarks-vue', 'StoreCancellationRemarkController@index_vue');
        Route::get('store-management/cancellation-remarks/init_vue', 'StoreCancellationRemarkController@init_vue');
        });
    Route::group(['middleware' => ['permission:View Deleted Cancellation Remarks']], function () {
        Route::get('store-management/cancellation-remarks/deleted-vue', 'StoreCancellationRemarkController@index_deleted');
        Route::get('store-management/cancellation-remarks/indexdt_deleted', 'StoreCancellationRemarkController@indexdt_deleted');
        });
    Route::group(['middleware' => ['permission:Add Cancellation Remarks']], function () {
            Route::get('store-management/cancellation-remarks/cancellation-remarks-aeu-vue', 'StoreCancellationRemarkController@create');
            Route::get('store-management/cancellation-remarks/cancellation-remarks-aeu/init', 'StoreCancellationRemarkController@init');
            Route::post('store-management/cancellation-remarks/cancellation-remarks-aeu/save', 'StoreCancellationRemarkController@save');
        });
    Route::group(['middleware' => ['permission:Edit Cancellation Remarks']], function () {
            Route::get('store-management/cancellation-remarks/cancellation-remarks-aeu-vue/{id}', 'StoreCancellationRemarkController@edit');
            Route::post('store-management/cancellation-remarks/cancellation-remarks-aeu/update', 'StoreCancellationRemarkController@updated');
    });
    Route::group(['middleware' => ['permission:Delete Cancellation Remarks']], function () {
            Route::get('store-management/cancellation-remarks/delete/{id}', 'StoreCancellationRemarkController@destroy');
    });
    Route::group(['middleware' => ['permission:Restore Cancellation Remarks']], function () {
            Route::get('store-management/cancellation-remarks/restore/{id}', 'StoreCancellationRemarkController@restore');
    });
    // CANCELLATION REMARKS



    // TERMS AND CONDITIONS
    Route::group(['middleware' => ['permission:View Sales Terms and Conditions']], function () {
            Route::get('sales/terms-and-conditions', 'SalesTermsandConditionsController@index');
            Route::post('sales/terms-and-conditions', 'SalesTermsandConditionsController@indexdt')->name('terms.datatable');
        });
    Route::group(['middleware' => ['permission:Add Sales Terms and Conditions']], function () {
            Route::get('sales/terms-and-conditions/terms-and-conditions-aeu', 'SalesTermsandConditionsController@create');
            Route::post('sales/terms-and-conditions/terms-and-conditions-aeu', 'SalesTermsandConditionsController@store');
        });
    Route::group(['middleware' => ['permission:Edit Sales Terms and Conditions']], function () {
            Route::get('sales/terms-and-conditions/terms-and-conditions-aeu/{id}', 'SalesTermsandConditionsController@edit');
            Route::post('sales/terms-and-conditions/update/{id}', 'SalesTermsandConditionsController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Sales Terms and Conditions']], function () {
            Route::get('sales/terms-and-conditions/deleted', 'SalesTermsandConditionsController@index_deleted');
            Route::post('sales/terms-and-conditions/deleted', 'SalesTermsandConditionsController@indexdt_deleted')->name('terms_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Sales Terms and Conditions']], function () {
            Route::get('sales/terms-and-conditions/delete/{id}', 'SalesTermsandConditionsController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Sales Terms and Conditions']], function () {
            Route::get('sales/terms-and-conditions/restore/{id}', 'SalesTermsandConditionsController@restore');
        });
    // TERMS AND CONDITIONS




    // RESTAURANT SECTION DEFINITIONS
    Route::group(['middleware' => ['permission:View Restaurant Section Definitions']], function () {
            Route::get('store-management/restaurant-section-definitions', 'StoreRestaurantSectionDefinitionController@index');
            Route::post('store-management/restaurant-section-definitions', 'StoreRestaurantSectionDefinitionController@indexdt')->name('sections.datatable');
        });
    Route::group(['middleware' => ['permission:Add Restaurant Section Definitions']], function () {
            Route::get('store-management/restaurant-section-definitions/restaurant-section-definitions-aeu', 'StoreRestaurantSectionDefinitionController@create');
            Route::post('store-management/restaurant-section-definitions/restaurant-section-definitions-aeu', 'StoreRestaurantSectionDefinitionController@store');
        });
    Route::group(['middleware' => ['permission:Edit Restaurant Section Definitions']], function () {
            Route::get('store-management/restaurant-section-definitions/restaurant-section-definitions-aeu/{id}', 'StoreRestaurantSectionDefinitionController@edit');
            Route::post('store-management/restaurant-section-definitions/update/{id}', 'StoreRestaurantSectionDefinitionController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Restaurant Section Definitions']], function () {
            Route::get('store-management/restaurant-section-definitions/deleted', 'StoreRestaurantSectionDefinitionController@index_deleted');
            Route::post('store-management/restaurant-section-definitions/deleted', 'StoreRestaurantSectionDefinitionController@indexdt_deleted')->name('sections_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Restaurant Section Definitions']], function () {
            Route::get('store-management/restaurant-section-definitions/delete/{id}', 'StoreRestaurantSectionDefinitionController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Restaurant Section Definitions']], function () {
            Route::get('store-management/restaurant-section-definitions/restore/{id}', 'StoreRestaurantSectionDefinitionController@restore');
        });
    // RESTAURANT SECTION DEFINITIONS



    // SECTION DEPARTMENT MAPPING
    Route::group(['middleware' => ['permission:View Section Department Mapping']], function () {
            Route::get('store-management/section-department-mapping', 'StoreRestaurantSectionDefinitionController@mapping_index');
            Route::post('store-management/section-department-mapping', 'StoreRestaurantSectionDefinitionController@mapping_indexdt')->name('mapping_sections.datatable');
        });
    Route::group(['middleware' => ['permission:Link Sections and Departments']], function () {
            Route::get('store-management/restaurant-section-definitions/section-department-mapping-aeu/{id}', 'StoreRestaurantSectionDefinitionController@mapping_edit');
            Route::post('store-management/section-department-mapping/update/{id}', 'StoreRestaurantSectionDefinitionController@mapping_update');
        });
    // SECTION DEPARTMENT MAPPING

    // STORE PURCHASES
    Route::group(['middleware' => ['permission:View Store Purchases']], function () {
        Route::get('store-management/store-purchases-vue', 'StoreManagementController@index_vue');
        Route::get('store-management/store-purchases/purchases_init_vue', 'StoreManagementController@purchases_init_vue');
        });
    Route::group(['middleware' => ['permission:Add Store Purchases']], function () {
            Route::get('store-management/store-purchases/store-purchases-aeu', 'StoreManagementController@create');
            Route::get('store-management/store-purchases/store-purchases-aeu/init', 'StoreManagementController@init');
            Route::post('store-management/store-purchases/store-purchases-aeu/save', 'StoreManagementController@save');
        });
    Route::group(['middleware' => ['permission:Edit Store Purchases']], function () {
            Route::get('store-management/store-purchases/store-purchases-aeu/{id}', 'StoreManagementController@edit');
            Route::post('store-management/store-purchases/store-purchases-aeu/update', 'StoreManagementController@updated');
    });
    Route::group(['middleware' => ['permission:View Deleted Store Purchases']], function () {
            Route::get('store-management/store-purchases/deleted', 'StoreManagementController@index_deleted');
            Route::post('store-management/store-purchases/deleted', 'StoreManagementController@indexdt_deleted')->name('store_purchases_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Store Purchases']], function () {
            Route::post('store-management/store-purchases/delete/{id}', 'StoreManagementController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Store Purchases']], function () {
            Route::get('store-management/store-purchases/restore/{id}', 'StoreManagementController@restore');
        });
    Route::group(['middleware' => ['permission:Print Store Purchases Invoice']], function () {
            Route::get('store-management/store-purchases/store-purchases-invoice/{id}', 'StoreManagementController@invoice')->name('storePurchaseInvoice');
            Route::post('store-management/store-purchases/generate_invoice', 'StoreManagementController@generate_invoice');
        });
    
    Route::group(['middleware' => ['permission:Approve and Unapprove Purchases']], function () {
        Route::get('store-management/store-purchases/approve/{id}', 'StoreManagementController@approve');
        Route::get('store-management/store-purchases/unapprove/{id}', 'StoreManagementController@unapprove');
    });

    Route::get('store-management/store-purchases/items/{id}', 'StoreManagementController@items');
    Route::get('store-management/store-sales/items/{id}', 'StoreManagementController@salesitems');
    Route::get('store-management/store-issue-note/items/{id}', 'StoreManagementController@issuenoteitems');
    Route::get('store-management/store-locations/department/{id}', 'StoreManagementController@department');


    Route::group(['middleware' => ['permission:View Dish Breakdown Purchase Summary']], function () {
    Route::get('finance-and-management/reports/dish-breakdown-purchase-summary-vue', 'StoreManagementController@dishbreakdownpurchase_vue');
    Route::get('finance-and-management/reports/dish-breakdown-purchase-summary/dishbreakdownpurchase_init_vue', 'StoreManagementController@dishbreakdownpurchase_init_vue');
    });

    Route::group(['middleware' => ['permission:View Closing Purchases Report']], function () {
    Route::get('finance-and-management/reports/closing-purchases-report-vue', 'StoreManagementController@closingpurchases_vue');
    Route::get('finance-and-management/reports/closing-purchases-report/closingpurchases_init_vue', 'StoreManagementController@closingpurchases_init_vue');
    });

    Route::group(['middleware' => ['permission:View Purchases Summary With Items']], function () {
    Route::get('finance-and-management/reports/items-purchases-summary-vue', 'StoreManagementController@itemsummary_vue');
    Route::get('finance-and-management/reports/items-purchases-summary/itemsummary_init_vue', 'StoreManagementController@itemsummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Purchases Errors']], function () {
    Route::get('finance-and-management/reports/purchases-errors-vue', 'StoreManagementController@purchaseserrors_vue');
    Route::get('finance-and-management/reports/purchases-errors/purchaseserrors_init_vue', 'StoreManagementController@purchaseserrors_init_vue');
    });

    //STORE PURCHASE DOCUMENTS
    Route::post('store-management/store-purchases/temporary_upload', 'StoreManagementController@temp_upload');
    Route::post('store-management/store-purchases/temporary_remove', 'StoreManagementController@temp_remove');
    //STORE PURCHASE DOCUMENTS

    Route::group(['middleware' => ['permission:View Store Purchase Documents']], function () {
        Route::get('store-management/store-purchases/documents/{id}', 'StoreManagementController@docs');
    });



    // STORE PURCHASES



    // STORE SALES
    Route::group(['middleware' => ['permission:View Store Sales']], function () {
        Route::get('store-management/store-sales-vue', 'StoreManagementController@sales_index_vue');
        Route::get('store-management/store-sales/sales_init_vue', 'StoreManagementController@sales_init_vue');
        });
    Route::group(['middleware' => ['permission:Add Store Sales']], function () {
        Route::get('store-management/store-sales/store-sales-aeu', 'StoreManagementController@sales_create');
        Route::get('store-management/store-sales/store-sales-aeu/init', 'StoreManagementController@sales_init');
        Route::post('store-management/store-sales/store-sales-aeu/save', 'StoreManagementController@sales_save');
    });
    Route::group(['middleware' => ['permission:Edit Store Sales']], function () {
        Route::get('store-management/store-sales/store-sales-aeu/{id}', 'StoreManagementController@sales_edit');
        Route::post('store-management/store-sales/store-sales-aeu/update', 'StoreManagementController@sales_updated');
    });
    Route::group(['middleware' => ['permission:View Deleted Store Sales']], function () {
            Route::get('store-management/store-sales/deleted', 'StoreManagementController@sales_index_deleted');
            Route::post('store-management/store-sales/deleted', 'StoreManagementController@sales_indexdt_deleted')->name('store_sales_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Store Sales']], function () {
            Route::post('store-management/store-sales/delete/{id}', 'StoreManagementController@sales_destroy');
        });
    Route::group(['middleware' => ['permission:Restore Store Sales']], function () {
            Route::get('store-management/store-sales/restore/{id}', 'StoreManagementController@sales_restore');
        });
    Route::group(['middleware' => ['permission:Print Store Sales Invoice']], function () {
            Route::get('store-management/store-sales/store-sales-invoice/{id}', 'StoreManagementController@sales_invoice')->name('storeSaleInvoice');
        });
    Route::group(['middleware' => ['permission:Approve and Unapprove Store Sales']], function () {
        Route::get('store-management/store-sales/approve/{id}', 'StoreManagementController@sales_approve');
        Route::get('store-management/store-sales/unapprove/{id}', 'StoreManagementController@sales_unapprove');
    });


    Route::group(['middleware' => ['permission:View Dish Breakdown Store Sale Summary']], function () {
    Route::get('finance-and-management/reports/dish-breakdown-store-sale-summary-vue', 'StoreManagementController@dishbreakdownsale_vue');
    Route::get('finance-and-management/reports/dish-breakdown-store-sale-summary/dishbreakdownsale_init_vue', 'StoreManagementController@dishbreakdownsale_init_vue');
    });

    Route::group(['middleware' => ['permission:View Closing Store Sales Report']], function () {
    Route::get('finance-and-management/reports/closing-store-sales-report-vue', 'StoreManagementController@closingstoresales_vue');
    Route::get('finance-and-management/reports/closing-store-sales-report/closingstoresales_init_vue', 'StoreManagementController@closingstoresales_init_vue');
    });

    Route::group(['middleware' => ['permission:View Store Sales Summary With Items']], function () {
    Route::get('finance-and-management/reports/items-store-sales-summary-vue', 'StoreManagementController@itemsalesummary_vue');
    Route::get('finance-and-management/reports/items-store-sales-summary/itemsalesummary_init_vue', 'StoreManagementController@itemsalesummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Store Sales Errors']], function () {
    Route::get('finance-and-management/reports/store-sales-errors-vue', 'StoreManagementController@storesaleserrors_vue');
    Route::get('finance-and-management/reports/store-sales-errors/storesaleserrors_init_vue', 'StoreManagementController@storesaleserrors_init_vue');
    });
    Route::group(['middleware' => ['permission:View Store Sales Documents']], function () {
        Route::get('store-management/store-sales/documents/{id}', 'StoreManagementController@sales_docs');
    });
    // STORE SALES




    // STORE MONTHLY REPORT
    Route::group(['middleware' => ['permission:View Monthly Store Report']], function () {
    Route::get('finance-and-management/reports/monthly-store-report-vue', 'StoreManagementController@monthly_index_vue');
    Route::get('finance-and-management/reports/monthly-store-report/monthly_init_vue', 'StoreManagementController@monthly_init_vue');
    });
    // STORE MONTHLY REPORT


    // STORE ISSUE NOTE
    Route::group(['middleware' => ['permission:View Store Issue Note']], function () {
        Route::get('store-management/store-issue-note-vue', 'StoreManagementController@issue_note_index_vue');
        Route::get('store-management/store-issue-note/issue_note_init_vue', 'StoreManagementController@issue_note_init_vue');
        });
    Route::group(['middleware' => ['permission:Add Store Issue Note']], function () {
        Route::get('store-management/store-issue-note/store-issue-note-aeu', 'StoreManagementController@issue_note_create');
        Route::get('store-management/store-issue-note/store-issue-note-aeu/init', 'StoreManagementController@issue_note_init');
        Route::post('store-management/store-issue-note/store-issue-note-aeu/save', 'StoreManagementController@issue_note_save');
    });
    Route::group(['middleware' => ['permission:Edit Store Issue Note']], function () {
        Route::get('store-management/store-issue-note/store-issue-note-aeu/{id}', 'StoreManagementController@issue_note_edit');
        Route::post('store-management/store-issue-note/store-issue-note-aeu/update', 'StoreManagementController@issue_note_updated');
    });
    Route::group(['middleware' => ['permission:View Deleted Store Issue Notes']], function () {
            Route::get('store-management/store-issue-note/deleted', 'StoreManagementController@issue_note_index_deleted');
            Route::post('store-management/store-issue-note/deleted', 'StoreManagementController@issue_note_indexdt_deleted')->name('issue_note_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Store Issue Note']], function () {
            Route::post('store-management/store-issue-note/delete/{id}', 'StoreManagementController@issue_note_destroy');
        });
    Route::group(['middleware' => ['permission:Restore Store Issue Note']], function () {
            Route::get('store-management/store-issue-note/restore/{id}', 'StoreManagementController@issue_note_restore');
        });
    Route::group(['middleware' => ['permission:Print Store Issue Note']], function () {
        Route::get('store-management/store-issue-note/store-issue-note-print/{id}', 'StoreManagementController@issue_note_print')->name('storeIssueNoteInvoice');

            Route::get('store-management/store-issue-note/store-issue-note-invoice/{id}', 'StoreManagementController@issue_note_invoice')->name('storeIssueNoteInvoice');
        });
    Route::group(['middleware' => ['permission:Approve and Unapprove Store Issue Notes']], function () {
        Route::get('store-management/store-issue-note/approve/{id}', 'StoreManagementController@issue_approve');
        Route::get('store-management/store-issue-note/unapprove/{id}', 'StoreManagementController@issue_unapprove');
    });

    Route::group(['middleware' => ['permission:View Store Issue Note Summary']], function () {
    Route::get('finance-and-management/reports/issue-note-summary-vue', 'StoreManagementController@issuenotesummary_vue');
    Route::get('finance-and-management/reports/issue-note-summary/issuenotesummary_init_vue', 'StoreManagementController@issuenotesummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Item Issue Summary']], function () {
    Route::get('finance-and-management/reports/item-issue-summary-vue', 'StoreManagementController@itemissuesummary_vue');
    Route::get('finance-and-management/reports/item-issue-summary/itemissuesummary_init_vue', 'StoreManagementController@itemissuesummary_init_vue');
    });

    Route::group(['middleware' => ['permission:View Issue Note Summary Detail']], function () {
    Route::get('finance-and-management/reports/issue-note-summary-detail-vue', 'StoreManagementController@issuesummarydetail_vue');
    Route::get('finance-and-management/reports/issue-note-summary-detail/issuesummarydetail_init_vue', 'StoreManagementController@issuesummarydetail_init_vue');
    });

    Route::group(['middleware' => ['permission:View Item Issue Detail']], function () {
    Route::get('finance-and-management/reports/item-issue-detail-vue', 'StoreManagementController@itemissuedetail_vue');
    Route::get('finance-and-management/reports/item-issue-detail/itemissuedetail_init_vue', 'StoreManagementController@itemissuedetail_init_vue');
    });
    // STORE ISSUE NOTE





    // STORE LOCATIONS
    Route::group(['middleware' => ['permission:View Store Location']], function () {
            Route::get('store-management/store-locations', 'StoreLocationController@index');
            Route::post('store-management/store-locations', 'StoreLocationController@indexdt')->name('store_locations.datatable');
        });
    Route::group(['middleware' => ['permission:Add Store Location']], function () {
            Route::get('store-management/store-locations/store-locations-aeu', 'StoreLocationController@create');
            Route::post('store-management/store-locations/store-locations-aeu', 'StoreLocationController@store');
        });
    Route::group(['middleware' => ['permission:Edit Store Location']], function () {
            Route::get('store-management/store-locations/store-locations-aeu/{id}', 'StoreLocationController@edit');
            Route::post('store-management/store-locations/update/{id}', 'StoreLocationController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Store Locations']], function () {
            Route::get('store-management/store-locations/deleted', 'StoreLocationController@index_deleted');
            Route::post('store-management/store-locations/deleted', 'StoreLocationController@indexdt_deleted')->name('store_locations_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Store Location']], function () {
            Route::get('store-management/store-locations/delete/{id}', 'StoreLocationController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Store Location']], function () {
            Route::get('store-management/store-locations/restore/{id}', 'StoreLocationController@restore');
        });
    // STORE LOCATIONS

    // STORE DEPARTMENTS
    Route::group(['middleware' => ['permission:View Store Departments']], function () {
            Route::get('store-management/store-departments', 'StoreDepartmentController@index');
            Route::post('store-management/store-departments', 'StoreDepartmentController@indexdt')->name('store_departments.datatable');
        });
    Route::group(['middleware' => ['permission:Add Store Departments']], function () {
            Route::get('store-management/store-departments/store-departments-aeu', 'StoreDepartmentController@create');
            Route::post('store-management/store-departments/store-departments-aeu', 'StoreDepartmentController@store');
        });
    Route::group(['middleware' => ['permission:Edit Store Departments']], function () {
        Route::get('store-management/store-departments/store-departments-aeu/{id}', 'StoreDepartmentController@edit');
        Route::post('store-management/store-departments/update/{id}', 'StoreDepartmentController@update');
        });
    Route::group(['middleware' => ['permission:View Deleted Store Departments']], function () {
            Route::get('store-management/store-departments/deleted', 'StoreDepartmentController@index_deleted');
            Route::post('store-management/store-departments/deleted', 'StoreDepartmentController@indexdt_deleted')->name('store_departments_deleted.datatable');
        });
    Route::group(['middleware' => ['permission:Delete Store Departments']], function () {
            Route::get('store-management/store-departments/delete/{id}', 'StoreDepartmentController@destroy');
        });
    Route::group(['middleware' => ['permission:Restore Store Departments']], function () {
            Route::get('store-management/store-departments/restore/{id}', 'StoreDepartmentController@restore');
        });
    // STORE DEPARTMENTS


    //STORE MANAGEMENT



    Route::get('food-and-beverage/running-sales-list-vue/kots/{invoiceno}', 'FnbSaleController@runningopenkots');
    Route::get('food-and-beverage/sales-list-vue/kots/{invoiceno}', 'FnbSaleController@openkots');

    Route::get('fb/sales/saleskot/{invoiceno}/{id}/{cat}', 'FnbSaleController@kotp');
    Route::get('kotget', 'FnbSaleController@kotget');
    Route::get('fb/sales/edittedsaleskot/{invoiceno}/{id}/{cat}', 'FnbSaleController@edittedsaleskot');
    Route::get('fb/sales/xpedittedsaleskot/{invoiceno}/{id}/{cat}', 'FnbSaleController@xpedittedsaleskot');
    Route::get('fb/sales/duplicatesaleskot/{invoiceno}/{id}', 'FnbSaleController@duplicatesaleskot');
    Route::get('fb/sales/xpduplicatesaleskot/{invoiceno}', 'FnbSaleController@xpduplicatesaleskot');
    Route::get('fb/sales/salesinv/{id}', 'FnbSaleController@invoicep');
    Route::get('printerip',function(){
        return env('printer');
    });

    Route::group(['middleware' => ['permission:View Cards']], function () {
    Route::get('memberprint/{id}','MembershipController@cardPrint');
    });
    Route::group(['middleware' => ['permission:View Cards']], function () {
            Route::get('familymemberprint/{id}', 'MembershipController@fmCardPrint');
        });



        Auth::routes();
        Route::get('/logout', 'Auth\LoginController@logout');
        Route::get('/process',function(){
        $b= \App\membership::all();
        foreach($b as $c){
        echo $c->id.'<br>';
            $res = preg_replace("/[^0-9]/", "", $c->total );
            $res2 = preg_replace("/[^0-9]/", "", $c->total_maintenance );
            $c->total=$res;
            $c->total_maintenance=$res;
        $c->save();

        }
        });
    Route::get('/permission/{permissionName}',function($permissionName){

            if (! Auth::user()->hasPermissionTo($permissionName)) {
                abort(403);
            }
            return response('', 204);

    });


    Route::get('book/docdata/{book}', 'FinanceExpenseNewController@getbook');

    Route::get('export', 'ImportExportController@export')->name('export');
    Route::post('export', 'ImportExportController@import')->name('import');
    Route::get('export2', 'ImportExportController@export2')->name('export2');
    Route::post('export2', 'ImportExportController@import2')->name('import2');


    Route::group(['middleware' => ['permission:View COA']], function () {
            Route::get('COA', 'accountsController@index');
            Route::get('COA-new', 'NewaccountsController@index');
    });
    Route::group(['middleware' => ['permission:View Deleted COA']], function () {
            Route::get('COA-new/deleted', 'NewaccountsController@index_deleted');
            Route::post('COA-new/deleted', 'NewaccountsController@indexdt_deleted')->name('coa_deleted.datatable');
    });
    Route::group(['middleware' => ['permission:Restore COA']], function () {
            Route::get('COA-new/restore/{id}', 'NewaccountsController@restore');
    });


    Route::post('coa/save/level/{action}', 'accountsController@api');
    Route::post('coa/update/level/{action}', 'accountsController@api_update');
    Route::post('coa/delete/level/{action}', 'accountsController@api_delete');


    Route::group(['middleware' => ['permission:Add COA']], function () {
        Route::post('coa/saveAccount', 'accountsController@saveControl');
    });
    Route::group(['middleware' => ['permission:Edit COA']], function () {
        Route::post('coa/updateAccount', 'accountsController@updateControl');
    });
    Route::group(['middleware' => ['permission:Delete COA']], function () {
        Route::post('coa/deleteAccount', 'accountsController@deleteControl');
    });

    Route::post('coa/checkmaincontrol', 'accountsController@checkmaincontrol');


    Route::get('coa/get/level/{action}', 'accountsController@apiget');
    Route::get('coa/get/levelx/{action}/{action2}', 'accountsController@apiget2');
    Route::get('coa/get/l/{action}', 'accountsController@getlevelChild');
    Route::get('coa/loadCategory', 'accountsController@loadCategories');
    Route::get('coa/loadCompany', 'accountsController@loadCompany');
    Route::get('coa/loadAccounts', 'accountsController@loadControls');

    Route::get('coa/loadAccountstwo', 'accountsController@loadControlst');

    Route::get('coa/default/l/{action}', 'accountsController@defaultAcc');
    Route::get('coa/accounts/{type}', 'accountsController@getAccounts');

    Route::group(['middleware' => ['permission:View COA Listing']], function () {
                Route::get('finance-and-management/COA-listing', 'NewaccountsController@index_vue');
                Route::get('finance-and-management/COA-listing/init_vue', 'NewaccountsController@init_vue');
        });

    Route::post('coa-new/save/level/{action}', 'NewaccountsController@api');
    Route::post('coa-new/update/level/{action}', 'NewaccountsController@api_update');
    Route::post('coa-new/delete/level/{action}', 'NewaccountsController@api_delete');

    Route::post('coa-new/delete/controls/{id}', 'NewaccountsController@apidelete');

    Route::group(['middleware' => ['permission:Add COA']], function () {
        Route::post('coa-new/saveAccount', 'NewaccountsController@saveControl');
    });
    Route::group(['middleware' => ['permission:Edit COA']], function () {
        Route::post('coa-new/updateAccount', 'NewaccountsController@updateControl');
    });
    Route::group(['middleware' => ['permission:Delete COA']], function () {
        Route::post('coa-new/deleteAccount', 'NewaccountsController@deleteControl');
    });


    Route::post('coa-new/checkmaincontrol', 'NewaccountsController@checkmaincontrol');
    Route::post('coa-new/checkcontrol', 'NewaccountsController@checkcontrol');

    Route::post('coa-new/checkchildren', 'NewaccountsController@checkchildren');

    Route::get('coa-new/get/level/{action}', 'NewaccountsController@apiget');
    Route::get('coa-new/get/levelx/{action}/{action2}', 'NewaccountsController@apiget2');
    Route::get('coa-new/get/l/{action}', 'NewaccountsController@getlevelChild');
    Route::get('coa-new/loadCategory', 'NewaccountsController@loadCategories');
    Route::get('coa-new/loadCompany', 'NewaccountsController@loadCompany');
    Route::get('coa-new/loadUnits', 'NewaccountsController@loadUnits');
    Route::get('coa-new/loadAccounts', 'NewaccountsController@loadControls');
    Route::get('coa-new/default/l/{action}', 'NewaccountsController@defaultAcc');
    Route::get('coa-new/accounts/{type}', 'NewaccountsController@getAccounts');

    // BOOKS
    Route::group(['middleware' => ['permission:View Books']], function () {
            Route::get('finance-and-management/books', 'FinanceBooksController@index');
            Route::post('finance-and-management/books', 'FinanceBooksController@indexdt')->name('books.datatable');
    });
    Route::group(['middleware' => ['permission:Add Books']], function () {
            Route::get('finance-and-management/books/books-aeu', 'FinanceBooksController@create');
            Route::post('finance-and-management/books/books-aeu', 'FinanceBooksController@store');
    });
    Route::group(['middleware' => ['permission:Edit Books']], function () {
            Route::get('finance-and-management/books/books-aeu/{id}', 'FinanceBooksController@edit');
            Route::post('finance-and-management/books/update/{id}', 'FinanceBooksController@update');
    });
    Route::group(['middleware' => ['permission:View Deleted Books']], function () {
            Route::get('finance-and-management/books/deleted', 'FinanceBooksController@index_deleted');
            Route::post('finance-and-management/books/deleted', 'FinanceBooksController@indexdt_deleted')->name('books_deleted.datatable');
    });
    Route::group(['middleware' => ['permission:Delete Books']], function () {
            Route::get('finance-and-management/books/delete/{id}', 'FinanceBooksController@destroy');
    });
    Route::group(['middleware' => ['permission:Restore Books']], function () {
            Route::get('finance-and-management/books/restore/{id}', 'FinanceBooksController@restore');
    });
});


// BOOKS

/*
QUERY TO DELETE FOREIGN KEY IN A TABLE:- (RUN 2 QUERIES IN A ROW)
1) ALTER TABLE mem_visits DROP FOREIGN KEY mem_visits_member_id_foreign;
THEN
2) ALTER TABLE mem_visits DROP INDEX mem_visits_member_id_foreign;
*/

