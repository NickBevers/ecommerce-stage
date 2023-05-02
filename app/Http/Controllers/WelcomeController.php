<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderLine;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Symfony\Component\Console\Application;

class WelcomeController extends Controller
{
    public function index(){
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'phpVersion' => PHP_VERSION,
            'recentOrderedProducts' => Sku::withAllRelations()
                ->whereIn('id', OrderLine::select('sku_id')->orderBy('created_at', 'desc')->take(4)->get())
                ->take(4)
                ->get(),
            "recentProducts" => Sku::withAllRelations()
                ->orderBy('created_at', 'desc')
                ->take(4)
                ->get(),
        ]);
    }
}
