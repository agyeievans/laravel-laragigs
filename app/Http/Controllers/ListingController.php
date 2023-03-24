<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;

class ListingController extends Controller
{
    //show all listings
    public function index()
    {
        return view('listings.index', [
            //using scopefilter
            'listings' => Listing::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }

    // show single listing
    public function show(Listing $listing)
    {
        return view('listings.show', [
            'listing' => $listing
        ]);
    }

    // Show create Form
    public function create(){
        return view('listings.create');
    }

    //store listing data
    public function store(Request $request){
        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required'
        ]);

        // image upload
        if($request->hasFile('logo')){
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // storing form data into listings database
        Listing::create($formFields);

        // redirect and creating flash message
        return redirect('/')->with('message', 'Job listing created successfully!');
    }

}
