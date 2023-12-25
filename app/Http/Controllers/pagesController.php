<?php

namespace App\Http\Controllers;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use App\Models\products;
use App\Models\tasks;

use App\Models\projects;
use App\Models\User;
use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\units;

class pagesController extends Controller
{
    function index()
    {

        if (Auth::user()->role == "admin")
            return view('home');

        else
            return view('User.Dashboard');
    }
    public function users()
    {
        $p=posts::get();
        $u = User::where("id", "!=", Auth::user()->id)->orderBy('id', 'ASC')->paginate(10);
        return view('users', compact('u','p'));
    }
    public function suppliers()
    {
        $u = User::where("id", "!=", Auth::user()->id)->where('role',"supplier")->orderBy('id', 'ASC')->paginate(10);
        return view('suppliers', compact('u'));
    }
    public function posts()
    {
        $t=tasks::all();
        $u = posts::orderBy('id', 'ASC')->paginate(10);
        return view('posts', compact('u','t'));
    }

    public function projects()
    {
        $p = projects::orderBy('id', 'ASC')->paginate(10);

        return view('projects', compact('p'));
    }
    public function products()
    {

        $p = products::orderBy('id', 'ASC')->paginate(5);
        $units=units::all();
        $supplier=User::where('role','supplier')->get();
        $barcodes = array();
        foreach ($p as $product) {
            $barcode = DNS1D::getBarcodeHTML($product->barcode, "C39");
            $barcodes[$product->id] = $barcode;
        }
        return view('products', compact('p','barcodes','units','supplier'));
    }
    public function new()
    {
        $p = products::get();
        $t=tasks::get();
        return view('newProject',compact('p','t'));
    }
    public function units()
    {
        $u = units::orderBy('id', 'ASC')->paginate(10);
        return view('units', compact('u'));
    }
    public function search()
    {
        return view('search');
    }
    public function projectSearch()
    {
      
        $projects = projects::orderBy('id', 'ASC')->paginate(5);
    return view('project-list', ['projects' => $projects]);
    }
    
    public function getTasks()
    {

            $t = tasks::orderBy('id', 'ASC')->paginate(5);

        return view('tasksList',compact('t'));
    }
}
