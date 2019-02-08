<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tax;

class TaxController extends Controller
{
    public function __construct() {
        $this->middleware('admin');
    }

    public function index() {
    	if(!Tax::find(1)) {
        	return view('admin_panel.taxes.tax_create');
    	} else {
    		$tax = Tax::find(1);
    		return view('admin_panel.taxes.tax_configure', compact('tax'));
    	}
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'tax_rate' => 'required|integer',
            'global_discount' => 'nullable|integer',
        ]);
        Tax::create([
            'name' => request('name'),
            'tax_rate' => request('tax_rate'),
            'global_discount' => request('global_discount'),
            'enabled' =>request('enable')
        ]);
        return redirect('/admin_panel')->with('success', 'Tax Settings Saved');
    }

    public function update(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'tax_rate' => 'required|integer',
            'global_discount' => 'nullable|integer',
        ]);
        $tax = Tax::find(1);
        $tax->update([
            'name' => request('name'),
            'tax_rate' => request('tax_rate'),
            'global_discount' => request('global_discount'),
            'enabled' =>request('enable')
        ]);
        return redirect('/admin_panel')->with('success', 'Tax Settings Saved');
    }
}
