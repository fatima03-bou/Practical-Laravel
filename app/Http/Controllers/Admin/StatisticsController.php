<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Categorie;
use App\Models\User;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as Pdf;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index(Request $request)
    {
        $viewData = [];
        $viewData["title"] = "Statistiques - Tableau de bord";
        $viewData["subtitle"] = "Statistiques des ventes et bénéfices";

        // Récupération du paramètre de la période
        $periodType = $request->input('period', 'month'); // Valeur par défaut: mois
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

        // Chiffre d'affaires et bénéfices par période sélectionnée
        $viewData["revenue"] = Order::whereBetween('created_at', [$startDate, $endDate])->sum('total');
        $viewData["profit"] = Order::whereBetween('created_at', [$startDate, $endDate])->sum('profit');

        // Revenus et bénéfices par catégorie sur la période choisie
        $viewData["categorieRevenue"] = Categorie::join('products', 'categories.id', '=', 'products.Categorie_id')
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('categories.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.profit) as profit')
            ->groupBy('categories.name')
            ->get();

        // Revenus et bénéfices par produit sur la période choisie
        $viewData["productRevenue"] = Product::join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('products.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.profit) as profit')
            ->groupBy('products.name')
            ->get();

        // Revenus et bénéfices par pays sur la période choisie
        $viewData["countryRevenue"] = User::join('orders', 'users.id', '=', 'orders.user_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('users.country')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.profit) as profit')
            ->groupBy('users.country')
            ->get();

        // Passer la période sélectionnée à la vue
        $viewData["selectedPeriod"] = $periodType;
        $viewData["startDate"] = $startDate->toDateString();
        $viewData["endDate"] = $endDate->toDateString();

        return view('admin.statistics.index')->with("viewData", $viewData);
    }

    public function downloadPDF(Request $request)
    {
        $viewData = $this->index($request)->getData()['viewData']; // Get the statistics data
        $pdf = Pdf::loadView('admin.statistics.pdf', compact('viewData'));
        return $pdf->download('statistics.pdf');
    }
}
