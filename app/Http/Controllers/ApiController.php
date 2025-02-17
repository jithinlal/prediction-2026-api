<?php

namespace App\Http\Controllers;

use App\HttpApiResponse;

abstract class ApiController extends Controller
{
	use HttpApiResponse;
}
