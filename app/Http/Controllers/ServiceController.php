<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Supplier $supplier) {
      return $supplier;
    }
}
