<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        // Capture date range from request
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());

        // 1. Chiffre d'affaires (Revenue)
        // ------------------------------
        $revenueToday = Order::whereDate('created_at', Carbon::today())->sum('total');
        $revenueMonth = Order::whereMonth('created_at', Carbon::now()->month)->sum('total');
        $revenueYear = Order::whereYear('created_at', Carbon::now()->year)->sum('total');
        $revenueByPeriod = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');

        // Revenue breakdown
        $revenueByProduct = Item::join('products', 'items.product_id', '=', 'products.id')
            ->selectRaw('products.name as produit, SUM(items.quantity * items.price) as revenue')
            ->whereBetween('items.created_at', [$startDate, $endDate])
            ->groupBy('products.name')
            ->get();

        $revenueByCategory = Item::join('products', 'items.product_id', '=', 'products.id')
            ->join('categories', 'products.categorie_id', '=', 'categories.id')
            ->selectRaw('categories.name as categorie, SUM(items.quantity * items.price) as revenue')
            ->whereBetween('items.created_at', [$startDate, $endDate])
            ->groupBy('categories.name')
            ->get();

        $revenueByCountry = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->selectRaw('users.country as pays, SUM(orders.total) as revenue')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->groupBy('users.country')
            ->get();

        // ------------------------------
        // 2. Bénéfice (Profit)
        // ------------------------------
        $profitToday = Item::whereDate('created_at', Carbon::today())->sum('quantity') * 5;
        $profitMonth = Item::whereMonth('created_at', Carbon::now()->month)->sum('quantity') * 5;
        $profitYear = Item::whereYear('created_at', Carbon::now()->year)->sum('quantity') * 5;
        $profitByPeriod = Item::whereBetween('created_at', [$startDate, $endDate])->sum('quantity') * 5;

        $profitByProduct = Item::join('products', 'items.product_id', '=', 'products.id')
            ->selectRaw('products.name as produit, SUM(items.quantity) * 5 as profit')
            ->whereBetween('items.created_at', [$startDate, $endDate])
            ->groupBy('products.name')
            ->get();

        $profitByCategory = Item::join('products', 'items.product_id', '=', 'products.id')
            ->join('categories', 'products.categorie_id', '=', 'categories.id')
            ->selectRaw('categories.name as categorie, SUM(items.quantity) * 5 as profit')
            ->whereBetween('items.created_at', [$startDate, $endDate])
            ->groupBy('categories.name')
            ->get();

        $profitByCountry = Order::join('users', 'orders.user_id', '=', 'users.id')
            ->join('items', 'orders.id', '=', 'items.order_id')
            ->selectRaw('users.country as pays, SUM(items.quantity) * 5 as profit')
            ->whereBetween('items.created_at', [$startDate, $endDate])
            ->groupBy('users.country')
            ->get();

        // Data for the view
        $viewData = [
            'title' => 'Statistiques Utiles',
            'revenueToday' => $revenueToday,
            'revenueMonth' => $revenueMonth,
            'revenueYear' => $revenueYear,
            'revenueByPeriod' => $revenueByPeriod,
            'revenueByProduct' => $revenueByProduct,
            'revenueByCategory' => $revenueByCategory,
            'revenueByCountry' => $revenueByCountry,
            'profitToday' => $profitToday,
            'profitMonth' => $profitMonth,
            'profitYear' => $profitYear,
            'profitByPeriod' => $profitByPeriod,
            'profitByProduct' => $profitByProduct,
            'profitByCategory' => $profitByCategory,
            'profitByCountry' => $profitByCountry,
        ];

        return view('admin.statistics.index',compact('viewData'));
    }

    public function exportPdf(Request $request)
    {
        // $viewData = $this->getAllStatistics($request);
        $viewData = $this->index($request)->getData()['viewData'];
        // dd($viewData);
        $pdf = FacadePdf::loadView('admin.statistics.pdf',compact('viewData'));
        return $pdf->download('admin.statistics.pdf');
    }

    private function getAllStatistics(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::today()->toDateString());
        $endDate = $request->input('end_date', Carbon::today()->toDateString());

        return $this->index($request)->getData();
    }
}
