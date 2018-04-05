<?php
/**
 * API Library for CBM - Credit Bureau Malaysia System reports.
 * User: Mohd Nazrul Bin Mustaffa
 * Date: 03/04/2018
 * Time: 11:16 AM
 */

namespace MohdNazrul\CBMLaravel;

use Illuminate\Support\Facades\Facade;


class CBMApiFacade extends Facade
{
    protected static function getFacadeAccessor() { return 'CBMApi'; }
}