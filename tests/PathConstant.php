<?php

namespace App\Tests;

class PathConstant
{
    const HOME = '/';
    const LOGIN = '/login';
    const REGISTRATION = '/registration';
    const MOVEMENT_LIST =  '/bank-account/1/movement/list';
    const MOVEMENT_LIST_END_TEST =  '/bank-account/2/movement/list';
    const MOVEMENT_LIST_END_TEST_WITHOUT_CATEGORIES =  '/bank-account/1/movement/list';
    const MOVEMENT_CREATE = '/movement/create';
    const BANK_ACCOUNT_LIST = '/bank-account/list';
    const BANK_ACCOUNT_CREATE = '/bank-account/create';
}
