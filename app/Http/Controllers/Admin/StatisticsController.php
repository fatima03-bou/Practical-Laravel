<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Schema;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Statistics - Dashboard";
        $viewData["subtitle"] = "Sales and Profit Statistics";

        // Get selected period parameter
        $periodType = $request->input('period', 'month'); // Default value: month
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($periodType === 'day') {
            $startDate = Carbon::today();
            $endDate = Carbon::today();
        } elseif ($periodType === 'year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($periodType === 'custom') {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
        }

        // Revenue and profit for the selected period
        $viewData["revenue"] = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $viewData["profit"] = Order::whereBetween('created_at', [$startDate, $endDate])->sum(DB::raw('total * 0.2'));

        // Revenue and profit by category
        $viewData["categorieRevenue"] = Categorie::join('products', 'categories.id', '=', 'products.categorie_id')
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('categories.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
            ->groupBy('categories.name')
            ->get();

        // Revenue and profit by product
        $viewData["productRevenue"] = Product::join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('products.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
            ->groupBy('products.name')
            ->get();

        // Check if 'country' column exists before querying
        if (Schema::hasColumn('users', 'country')) {
            // Revenue and profit by country
            $viewData["countryRevenue"] = User::join('orders', 'users.id', '=', 'orders.user_id')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->select('users.country')
                ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
                ->groupBy('users.country')
                ->get();
        } else {
            $viewData["countryRevenue"] = collect(); // Return empty collection if 'country' column doesn't exist
        }

        $viewData["selectedPeriod"] = $periodType;
        $viewData["startDate"] = $startDate->toDateString();
        $viewData["endDate"] = $endDate->toDateString();

        return view('admin.statistics.index')->with("viewData", $viewData);
    }

    public function downloadPDF(Request $request)
    {
        // Call getStatisticsData() and extract viewData
        $viewData = $this->getStatisticsData($request);

        // Generate the PDF with the data
        $pdf = Pdf::loadView('admin.statistics.pdf', compact('viewData'));

        return $pdf->download('statistics_'.$viewData["startDate"].'_to_'.$viewData["endDate"].'.pdf');
    }

    // Helper function to get statistics without returning a view
    private function getStatisticsData(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Statistics - Dashboard";
        $viewData["subtitle"] = "Sales and Profit Statistics";

        $periodType = $request->input('period', 'month'); 
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        if ($periodType === 'day') {
            $startDate = Carbon::today();
            $endDate = Carbon::today();
        } elseif ($periodType === 'year') {
            $startDate = Carbon::now()->startOfYear();
            $endDate = Carbon::now()->endOfYear();
        } elseif ($periodType === 'custom') {
            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
        }

        // Add missing values
        $viewData["dailyRevenue"] = Order::whereDate('created_at', Carbon::today())->sum('total');
        $viewData["monthlyRevenue"] = Order::whereMonth('created_at', Carbon::now()->month)->sum('total');
        $viewData["yearlyRevenue"] = Order::whereYear('created_at', Carbon::now()->year)->sum('total');

        $viewData["dailyProfit"] = $viewData["dailyRevenue"] * 0.2;
        $viewData["monthlyProfit"] = $viewData["monthlyRevenue"] * 0.2;
        $viewData["yearlyProfit"] = $viewData["yearlyRevenue"] * 0.2;

        $viewData["revenue"] = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $viewData["profit"] = Order::whereBetween('created_at', [$startDate, $endDate])->sum(DB::raw('total * 0.2'));

        $viewData["categorieRevenue"] = Categorie::join('products', 'categories.id', '=', 'products.categorie_id')
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('categories.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
            ->groupBy('categories.name')
            ->get();

        $viewData["productRevenue"] = Product::join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('products.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
            ->groupBy('products.name')
            ->get();

        if (Schema::hasColumn('users', 'country')) {
            $viewData["countryRevenue"] = User::join('orders', 'users.id', '=', 'orders.user_id')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->select('users.country')
                ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
                ->groupBy('users.country')
                ->get();
        } else {
            $viewData["countryRevenue"] = collect();
        }

        $viewData["selectedPeriod"] = $periodType;
        $viewData["startDate"] = $startDate->toDateString();
        $viewData["endDate"] = $endDate->toDateString();

        return $viewData;
    }

}
