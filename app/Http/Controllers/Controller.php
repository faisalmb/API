<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

use Illuminate\Http\Request;
use App\Traits\Cityfunction;
use App\Traits\Itemfunction;
use App\Traits\Unitfunction;
use App\Traits\Userfunction;
use App\Traits\Rolesfunction;
use App\Traits\Statefunction;
use App\Traits\Stockfunction;
use App\Traits\Branchfunction;
use App\Traits\Genralfunction;
use App\Traits\Companyfunction;
use App\Traits\Countryfunction;
use App\Traits\Activityfunction;
use App\Traits\Currencyfunction;
use App\Traits\Customerfunction;
use App\Traits\CompanyUserfunction;
use App\Traits\AccountGroupfunction;
use App\Traits\CompanyPhonefunction;
use App\Traits\ItemCategoryfunction;
use App\Traits\ConversionUnitfunction;

class Controller extends BaseController
{
    use Genralfunction,
     Userfunction,
     Unitfunction,
     Stockfunction,
     Statefunction,
     Rolesfunction,
     Itemfunction,
     ItemCategoryfunction,
     Customerfunction,
     Currencyfunction,
     Countryfunction,
     ConversionUnitfunction,
     CompanyUserfunction,
     CompanyPhonefunction,
     Companyfunction,
     Cityfunction,
     Branchfunction,
     Activityfunction,
     AccountGroupfunction;

    
}
