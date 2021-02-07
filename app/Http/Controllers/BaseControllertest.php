<?php

namespace App\Http\Controllers;

use App\Traits\Cityfunction;
use App\Traits\Itemfunction;
use App\Traits\Unitfunction;
use App\Traits\Userfunction;
use Illuminate\Http\Request;
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

class BaseController extends Controller
{
    use Genralfunction;
    use Userfunction;
    use Unitfunction;
    use Stockfunction;
    use Statefunction;
    use Rolesfunction;
    use Itemfunction;
    use ItemCategoryfunction;
    use Customerfunction;
    use Currencyfunction;
    use Countryfunction;
    use ConversionUnitfunction;
    use CompanyUserfunction;
    use CompanyPhonefunction;
    use Companyfunction;
    use Cityfunction;
    use Branchfunction;
    use Activityfunction;
    use AccountGroupfunction;
}
