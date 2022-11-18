<?php

namespace App\Http\Controllers;

use App\Http\Services;
use App\Models\FAQ;
use App\Models\Requests;
use App\Models\Options;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.welcome');
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        return view('adminHome');
    }

    /**
     * Show the application faqs.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function faq()
    {
        $faq = FAQ::all();
        return view('admin.faq.view', compact('faq'));
    }

    /**
     * Show the application Requests.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function requests()
    {
        $requests = requests::all();
        return view('admin.requests.view', compact('requests'));
    }

    /**
     * Show the application Options.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function options()
    {
        $options = Options::all();
        return view('admin.options.view', compact('options'));
    }

    
    /**
     * Show the application Reviews.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function reviews()
    {
        $reviews = Review::all();
        return view('admin.reviews.view', compact('reviews'));
    }

}
