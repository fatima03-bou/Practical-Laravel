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
        $viewData["title"] = "Statistiques - Tableau de bord";
        $viewData["subtitle"] = "Statistiques des ventes et bénéfices";

        // Récupération du paramètre de la période
        $periodType = $request->input('period', 'month'); // Valeur par défaut : mois
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
        $viewData["profit"] = Order::whereBetween('created_at', [$startDate, $endDate])->sum(DB::raw('total * 0.2'));

        // Revenus et bénéfices par catégorie
        $viewData["categorieRevenue"] = Categorie::join('products', 'categories.id', '=', 'products.categorie_id')
            ->join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('categories.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
            ->groupBy('categories.name')
            ->get();

        // Revenus et bénéfices par produit
        $viewData["productRevenue"] = Product::join('orders', 'products.id', '=', 'orders.product_id')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select('products.name')
            ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
            ->groupBy('products.name')
            ->get();

        // Vérification de la colonne 'country' avant d'exécuter la requête
        if (Schema::hasColumn('users', 'country')) {
            // Revenus et bénéfices par pays
            $viewData["countryRevenue"] = User::join('orders', 'users.id', '=', 'orders.user_id')
                ->whereBetween('orders.created_at', [$startDate, $endDate])
                ->select('users.country')
                ->selectRaw('SUM(orders.total) as revenue, SUM(orders.total * 0.2) as profit')
                ->groupBy('users.country')
                ->get();
        } else {
            $viewData["countryRevenue"] = collect(); // Retourne une collection vide si 'country' n'existe pas
        }

        // Passer la période sélectionnée à la vue
        $viewData["selectedPeriod"] = $periodType;
        $viewData["startDate"] = $startDate->toDateString();
        $viewData["endDate"] = $endDate->toDateString();

        return view('admin.statistics.index')->with("viewData", $viewData);
    }

    public function downloadPDF(Request $request)
{
    // Appeler `index()` et extraire `viewData`
    $viewData = $this->getStatisticsData($request);

    // Générer le PDF avec les données
    $pdf = Pdf::loadView('admin.statistics.pdf', compact('viewData'));

    return $pdf->download('statistics_'.$viewData["startDate"].'_to_'.$viewData["endDate"].'pdf');
}

// Nouvelle fonction pour récupérer les statistiques sans retourner une vue
private function getStatisticsData(Request $request)
{
    $viewData = [];
    $viewData["title"] = "Statistiques - Tableau de bord";
    $viewData["subtitle"] = "Statistiques des ventes et bénéfices";

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

    // Ajout des valeurs manquantes
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
