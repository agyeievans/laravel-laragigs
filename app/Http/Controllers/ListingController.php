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
    public function create()
    {
        return view('listings.create');
    }

    //store listing data
    public function store(Request $request)
    {
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
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // add user_id to job listing
        $formFields['user_id'] = auth()->id();

        // storing form data into listings database
        Listing::create($formFields);

        // redirect and creating flash message
        return redirect('/')->with('message', 'Job listing created successfully!');
    }

    // show edit form
    public function edit(Listing $listing)
    {
        return view('listings.edit', ['listing' => $listing]);
    }

    // update listing data
    public function update(Request $request, Listing $listing)
    {
        // make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort('403', 'Unauthorized action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'tags' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'description' => 'required'
        ]);

        // image upload
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // storing form data into listings database
        $listing->update($formFields);

        // return back and creating flash message
        return back()->with('message', 'Job listing updated successfully!');
    }

    // delete listing
    public function destroy(Listing $listing)
    {
        // make sure logged in user is owner
        if($listing->user_id != auth()->id()){
            abort('403', 'Unauthorized action');
        }

        $listing->delete();

        return redirect('/')->with('message', 'Job listing deleted successfully!');
    }

    // manage listings
    public function manage(){
        return view('listings.manage', ['listings' => auth()->user()->listings()->get()]);
    }

}
