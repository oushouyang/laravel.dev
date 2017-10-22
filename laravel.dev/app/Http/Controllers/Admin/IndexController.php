<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function head()
    {
        return view('admin.head');
    }

    public function left()
    {
        return view('admin.left');
    }

     public function right()
    {
        return view('admin.right');
    }
}
