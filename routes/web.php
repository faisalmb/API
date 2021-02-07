<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


// --------------------------------------user Route---------------------------------------
$router->post('Login', ['uses' => 'User@loginRequest']);
$router->post('Registration', ['uses' => 'User@registrationRequest']);
$router->get('GenerateCodeResetPassword/{phone}', ['uses' => 'User@generateCodeResetRequest']);

$router->post('ResetPassword', ['uses' => 'User@resitPasswordRequest', 'middleware' => ['authReset']]);
$router->put('api/users/ChanePhone', ['uses' => 'User@chanePhoneRequest', 'middleware' => ['authReset']]);
// 
$router->group(['prefix' => 'api/users', 'middleware' => ['auth']], function () use ($router) {
    $router->post('AddUser', ['uses' => 'User@adduserRequest','middleware' => ['isSuperAdmin']]);
    $router->put('User', ['uses' => 'User@updateuserRequest']);
    
    $router->get('GenerateCodeChanePhone/{phone}', ['uses' => 'User@genCodeChanePhoneRequest']);
    $router->put('Activeuser', ['uses' => 'User@activeuserRequest','middleware' => ['isSuperAdmin']]);
    $router->put('UpdatePassword', ['uses' => 'User@updatePasswordRequest']);
    $router->get('UserInCompany/{page}', ['uses' => 'User@GetUserByCompanyRequest','middleware' => ['admin']]);
    $router->get('UserInStore/{page}', ['uses' => 'User@GetUserByStoreRequest','middleware' => ['isAdmin']]);
    $router->get('GetUserByID/{id}', ['uses' => 'User@GetUserByIDRequest']);
    $router->post('UserSearch/{page}', ['uses' => 'User@GetUserbyinfoRequest']);
  });
  // ------------------------------------------------------------------------------------------

 // --------------------------------------company Route------------------------------------------
    $router->group(['prefix' => 'api/company', 'middleware' => ['auth']], function () use ($router) {
    $router->post('AddCompanyByUser', ['uses' => 'CompanyController@addCompanyByUserRequest']);
    $router->post('AddCompanyBySycAdmin', ['uses' => 'CompanyController@addCompanyBySysAdminRequest','middleware' => ['isSuperAdmin']]);
    $router->put('UpdateCompany', ['uses' => 'CompanyController@updateCompanyRequest', 'middleware' => ['CheckCompanyId','isAdmin:true']]);
    // $router->put('activeuser', ['uses' => 'User@activeuserRequest']);
    // $router->put('updatePassword', ['uses' => 'User@updatePasswordRequest']);
    $router->get('companies/{page}', ['uses' => 'CompanyController@getCompaniesByPageRequest','middleware' => ['isSuperAdmin']]);
    $router->get('MyCompanies/{page}', ['uses' => 'CompanyController@getMyCompaniesByPageRequest']);
    $router->get('CompaniesIWorkForIt/{page}', ['uses' => 'CompanyController@getCompaniesThatIWorkForItByPageRequest']);
    $router->post('GetUserInCompanybyinfo/{page}', ['uses' => 'CompanyController@GetUserInCompanybyinfoRequest', 'middleware' => ['CheckCompanyId']]);
    $router->get('GetUserInCompany/{page}', ['uses' => 'CompanyController@GetUserInCompanyRequest', 'middleware' => ['CheckCompanyId']]);
    $router->post('AddUserToCompany', ['uses' => 'CompanyController@AddCompanyUserRequest', 'middleware' => ['CheckCompanyId','isAdmin:true']]);
    $router->put('ChangeUserStatus', ['uses' => 'CompanyController@ChangeCompanyUserRequest', 'middleware' => ['CheckCompanyId','isAdmin:true']]);
  });

   // ------------------------------------------------------------------------------------------

   

  // --------------------------------------branch Route------------------------------------------
  $router->group(['prefix' => 'api/branch', 'middleware' => ['auth']], function () use ($router) {
    $router->post('AddBranch', ['uses' => 'BranchController@addBranchByAdminRequest', 'middleware' => ['CheckCompanyId','isAdmin:true']]);
    $router->put('UpdateBranch', ['uses' => 'BranchController@updateBranchRequest', 'middleware' => ['CheckCompanyId','isAdmin:true']]);
    $router->get('Branches/{page}', ['uses' => 'BranchController@getBranchesByPageRequest','middleware' => ['CheckCompanyId','isAdmin:true']]);
    $router->get('MyBranches/{page}', ['uses' => 'BranchController@getMyBranchesByPageRequest','middleware' => ['CheckCompanyId']]);
    $router->get('BranchesIWorkForIt/{page}', ['uses' => 'BranchController@getBranchesThatIWorkForItByPageRequest','middleware' => ['CheckCompanyId']]);
    $router->post('GetUserInBranchByinfo/{page}', ['uses' => 'BranchController@GetUserInBranchbyinfoRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
    $router->get('GetUserInBranch/{page}', ['uses' => 'BranchController@GetUserInBranchRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
    $router->post('AddUserToBranchByAdmin', ['uses' => 'BranchController@AddUserToBranchRequest', 'middleware' => ['isAdmin:true']]);
    $router->post('AddUserToBranchByUser', ['uses' => 'BranchController@AddUserToBranchByUserRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
    $router->post('AddRoleToUesrInBranchByUser', ['uses' => 'BranchController@AddRoleToUserInBranchRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
   
    $router->put('ChangeUserStatus', ['uses' => 'BranchController@ChangeBranchUserRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  });

   // ------------------------------------------------------------------------------------------------

  // --------------------------------------currency Route------------------------------------------
  $router->group(['prefix' => 'api/currency', 'middleware' => ['auth']], function () use ($router) {
    $router->post('AddCurrency', ['uses' => 'CurrencyController@addCurrencyBySuperAdminRequest', 'middleware' => ['isSuperAdmin']]);
    $router->put('UpdateCurrency', ['uses' => 'CurrencyController@updateCurrencyRequest', 'middleware' => ['isSuperAdmin']]);
    $router->get('Currency/{id}', ['uses' => 'CurrencyController@getCurrencyByIdRequest']);
    $router->get('Currencies/{page}', ['uses' => 'CurrencyController@getCurrenciesByPageRequest']);
    $router->get('GetCurrencyInCompany', ['uses' => 'CurrencyController@GetCurrencyInCompanyRequest', 'middleware' => ['CheckCompanyId','isAdmin:false']]);
    $router->post('AddCurrencyToCompany', ['uses' => 'CurrencyController@addCurrencyToCompanyRequest', 'middleware' => ['CheckCompanyId','isAdmin:true']]);
   
  });

// ------------------------------------------------------------------------------------------

// --------------------------------------customer Route------------------------------------------
  $router->group(['prefix' => 'api/customer', 'middleware' => ['auth']], function () use ($router) {
    $router->post('AddCustomerType', ['uses' => 'CustomerController@addCustomerTypeRequest', 'middleware' => ['isSuperAdmin']]);
    $router->post('AddCustomer', ['uses' => 'CustomerController@addCustomerRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
    // $router->put('updateBranch', ['uses' => 'CustomerController@updateBranchRequest', 'middleware' => ['CheckCompanyId','isAdmin:true']]);
    $router->get('CustomerType', ['uses' => 'CustomerController@getAllCustomerTypeRequest']);
    $router->get('CustomerType/{id}', ['uses' => 'CustomerController@getCustomerTypeByIdRequest']);
    $router->get('Customer/{page}', ['uses' => 'CustomerController@getAllCustomerByBranchIdRequest','middleware' =>  ['HaveBrach','HaveRole:FR']]);
    $router->post('GetCustomerInBranchByinfo/{page}', ['uses' => 'CustomerController@GetCustomerInBranchbyinfoRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
    $router->get('CustomerByid/{id}', ['uses' => 'CustomerController@getCustomerByIdRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
    
  });

// ------------------------------------------------------------------------------------------------


// --------------------------------------group Route------------------------------------------
$router->group(['prefix' => 'api/group', 'middleware' => ['auth']], function () use ($router) {
  $router->post('AddMasterGroup', ['uses' => 'AccountGroupController@addMasterGroupRequest', 'middleware' => ['isSuperAdmin']]);
  $router->put('UpdateMasterGroup', ['uses' => 'AccountGroupController@updateMasterGroupRequest', 'middleware' => ['isSuperAdmin']]);
  $router->post('AddMasterSubGroup', ['uses' => 'AccountGroupController@addMasterSubGroupRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->post('AddSubGroup', ['uses' => 'AccountGroupController@addSubGroupRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->put('UpdateSubGroup', ['uses' => 'AccountGroupController@editSubGroupRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->get('MasterGroup', ['uses' => 'AccountGroupController@allMasterGroupRequest']);
  $router->get('MasterGroup/{id}', ['uses' => 'AccountGroupController@masterGroupByIdRequest']);
  $router->get('MasterGroupWithSub', ['uses' => 'AccountGroupController@allMasterWithSubGroupRequest','middleware' =>  ['HaveBrach','HaveRole:FR']]);
  $router->post('GetGroupInBranchByinfoAndMasterId/{page}', ['uses' => 'AccountGroupController@GetSubGroupInBranchbyinfoAndMasterIdRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->post('GetGroupInBranchByinfo/{page}', ['uses' => 'AccountGroupController@GetSubGroupInBranchbyinfoRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->get('SubGroupByParent/{id}', ['uses' => 'AccountGroupController@allSubGroupRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  
});

// ------------------------------------------------------------------------------------------------
// --------------------------------------UNIT CATEGORY ROUTE------------------------------------------
$router->group(['prefix' => 'api/unitcategory', 'middleware' => ['auth']], function () use ($router) {
  $router->post('AddUnitCategoryList', ['uses' => 'UnitCategoryController@addUnitCategoryListRequest', 'middleware' => ['isSuperAdmin']]);
  $router->post('AddUnitCategory', ['uses' => 'UnitCategoryController@addUnitCategoryRequest', 'middleware' => ['isSuperAdmin']]);
  $router->put('UpdateUnitCategory', ['uses' => 'UnitCategoryController@updateUnitCategoryRequest', 'middleware' => ['isSuperAdmin']]);
  $router->get('GetUnitCategoryById/{id}', ['uses' => 'UnitCategoryController@categoryByIdRequest']);
  $router->get('GetUnitCategory/{page}', ['uses' => 'UnitCategoryController@categoryByPageRequest']);
  $router->post('GetUnitCategoryByinfo/{page}', ['uses' => 'UnitCategoryController@categoryByPageAndInfoRequest']);
});

// ------------------------------------------------------------------------------------------------

// --------------------------------------UNIT  ROUTE------------------------------------------
$router->group(['prefix' => 'api/unit', 'middleware' => ['auth']], function () use ($router) {
  $router->post('AddUnitList', ['uses' => 'UnitController@addUnitListRequest', 'middleware' => ['isSuperAdmin']]);
  $router->post('AddUnit', ['uses' => 'UnitController@addUnitRequest', 'middleware' => ['isSuperAdmin']]);
  $router->put('UpdateUnit', ['uses' => 'UnitController@updateUnitRequest', 'middleware' => ['isSuperAdmin']]);
  $router->get('GetUnitById/{id}', ['uses' => 'UnitController@unitByIdRequest']);
  $router->get('GetUnit/{page}', ['uses' => 'UnitController@unitByPageRequest']);
  $router->get('GetUnitByCategoryId/{categoryId}/{page}', ['uses' => 'UnitController@unitByCategoryIdAndPageRequest']);
  $router->post('GetUnitByinfo/{page}', ['uses' => 'UnitController@unitByPageAndInfoRequest']);
  $router->post('GetUnitInfoAndCategoryId/{page}', ['uses' => 'UnitController@unitByPageAndInfoAndCategoryIdRequest']);
});

// ------------------------------------------------------------------------------------------------

// ----------------------------------  countries--------------------------------------
$router->group(['prefix' => 'api/countries'], function () use ($router) {
  $router->post('AddCountry', ['uses' => 'CountryController@addCountryRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->put('UpdateCountry', ['uses' => 'CountryController@updateCountryRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->post('GetCountriesByInfo/{page}', ['uses' => 'CountryController@countryByInfoRequest']);
  $router->get('GetCountriesByPage/{page}', ['uses' => 'CountryController@countriesByPageRequest']);
  $router->get('GetCountriesById/{id}', ['uses' => 'CountryController@countriesByIdRequest']);
});
// ------------------------------------------------------------------------------------------------

// ----------------------------------  states--------------------------------------
$router->group(['prefix' => 'api/states'], function () use ($router) {
  $router->post('AddState', ['uses' => 'StateController@addStateRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->put('UpdateState', ['uses' => 'StateController@updateStateRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->post('GetStatesByInfo/{page}', ['uses' => 'StateController@StateByInfoRequest']);
  $router->get('GetStatesByPage/{countryId}/{page}', ['uses' => 'StateController@statesByPageRequest']);
  $router->get('GetStateById/{id}', ['uses' => 'StateController@statesByIdRequest']);
});
// ------------------------------------------------------------------------------------------------
// ----------------------------------  Cities--------------------------------------
$router->group(['prefix' => 'api/cities'], function () use ($router) {
  $router->post('AddCity', ['uses' => 'CityController@addCityRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->put('UpdateCity', ['uses' => 'CityController@updateCityRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->post('GetCitiesByInfo/{page}', ['uses' => 'CityController@CityByInfoRequest']);
  $router->get('GetCitiesByPage/{stateId}/{page}', ['uses' => 'CityController@cityByPageRequest']);
  $router->get('GetCityById/{id}', ['uses' => 'CityController@cityByIdRequest']);
});
// ------------------------------------------------------------------------------------------------

// ----------------------------------  activities--------------------------------------
$router->group(['prefix' => 'api/activities'], function () use ($router) {
  $router->post('AddActivity', ['uses' => 'ActivityController@addActivityRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->put('UpdateActivity', ['uses' => 'ActivityController@updateActivityRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->post('GetActivitiesByInfo/{page}', ['uses' => 'ActivityController@activityByInfoRequest']);
  $router->get('GetActivitiesByPage/{page}', ['uses' => 'ActivityController@activityByPageRequest']);
  $router->get('GetActivitiesById/{id}', ['uses' => 'ActivityController@activityByIdRequest']);
});
// ------------------------------------------------------------------------------------------------

// ----------------------------------  roles--------------------------------------
$router->group(['prefix' => 'api/roles'], function () use ($router) {
  $router->post('AddRole', ['uses' => 'RolesController@addRoleRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->put('UpdateRole', ['uses' => 'RolesController@updateRoleRequest', 'middleware' => ['auth','isSuperAdmin']]);
  $router->post('GetRoleByInfo/{page}', ['uses' => 'RolesController@roleByInfoRequest']);
  $router->get('GetRoleByPage/{page}', ['uses' => 'RolesController@roleByPageRequest']);
  $router->get('GetRoleById/{id}', ['uses' => 'RolesController@roleByIdRequest']);
});
// ------------------------------------------------------------------------------------------------

// ----------------------------------  itemCategory--------------------------------------
$router->group(['prefix' => 'api/itemCategory', 'middleware' => ['auth']], function () use ($router) {
  $router->post('AddItemCategoryByCompanyUser', ['uses' => 'ItemCategoryController@addItemCategoryByCompanyIdRequest', 'middleware' => ['CheckCompanyId','isAdmin:false']]);
  $router->post('AddItemCategoryByBranchUser', ['uses' => 'ItemCategoryController@addItemCategoryByBranchIdRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->put('UpdateItemCategoryByCompanyUser', ['uses' => 'ItemCategoryController@updateItemCategoryByCompanyIdRequest', 'middleware' => ['CheckCompanyId','isAdmin:false']]);
  $router->put('UpdateItemCategoryByBranchUser', ['uses' => 'ItemCategoryController@updateItemCategoryByBranchIdRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->post('GetItemCategoryByCompanyUserAndInfo/{page}', ['uses' => 'ItemCategoryController@itemCategoryByCompanyIdAndInfoRequest', 'middleware' => ['CheckCompanyId','isAdmin:false']]);
  $router->post('GetItemCategoryByBranchUserAndInfo/{page}', ['uses' => 'ItemCategoryController@itemCategoryByBranchIdAndInfoRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->get('GetItemCategoryByCompanyUserAndPage/{page}', ['uses' => 'ItemCategoryController@itemCategoryByCompanyIdAndPageRequest', 'middleware' => ['CheckCompanyId','isAdmin:false']]);
  $router->get('GetItemCategoryByBranchUserAndPage/{page}', ['uses' => 'ItemCategoryController@itemCategoryByBranchIdAndPageRequest', 'middleware' => ['HaveBrach','HaveRole:FR']]);
  $router->get('GetItemCategoryById/{id}', ['uses' => 'ItemCategoryController@itemCategoryByIdRequest']);
});
// ------------------------------------------------------------------------------------------------