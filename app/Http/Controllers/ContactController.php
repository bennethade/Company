<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\ContactForm;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    ///TO AUTHENTICATE IF USER IS LOGGED IN 
    ///SO AS TO PROTECT THE REST OF THE PAGE AND REDIRECT TO THE LOGIN PAGE
    ///THE LOGIN ROUTE IS LOCATED IN THE DIRECTORY APP/HTTP/MIDDLEWARE/AUTHENTICATE.PHP
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    ///AUTHENTICATION ENDS HERE


    // public function render()
    // {
    //     return view('contact');
    // }





    public function adminContact()
    {
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }

    public function adminAddContact()
    {
        return view('admin.contact.create');
    }

    public function adminStoreContact(Request $request)
    {
        Contact::insert([
            'address' =>$request->address,
            'email' =>$request->email,
            'phone' =>$request->phone,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('admin.contact')->with('success','Contact inserted successfully!');        
    }

    public function editContact($id)
    {
        $contacts = Contact::find($id);
        return view('admin.contact.edit',compact('contacts'));
    }

    public function updateContact(Request $request, $id)
    {
        Contact::find($id)->update([
            'address' =>$request->address,
            'email' =>$request->email,
            'phone' =>$request->phone
        ]);

        return redirect()->route('admin.contact')->with('success','Contact updated successfully!');
    }

    public function deleteContact($id)
    {
        Contact::find($id)->delete();
        return redirect()->back()->with('success','Contact deleted successfully!');
    }

    public function contact()
    {
        $contacts = Contact::first();
        return view('pages.contact',compact('contacts'));
    }

    public function contactForm(Request $request)
    {
        ContactForm::insert([
            'name' =>$request->name,
            'email' =>$request->email,
            'subject' =>$request->subject,
            'message' =>$request->message,
            'created_at' => Carbon::now()
        ]);

        return redirect()->route('contact')->with('success','Your message has been sent successfully!');                
    }

    public function adminMessage()
    {
        $messages = ContactForm::all();
        return view('admin.contact.message', compact('messages'));
    }

    public function adminDeleteMessage($id)
    {
        ContactForm::find($id)->delete();
        return redirect()->back()->with('success','Message deleted successfully');
    }


}
