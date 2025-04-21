<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h1, h2, h3 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>

    <h1>{{ $viewData["title"] }}</h1>
    <h2>{{ $viewData["subtitle"] }}</h2>
    <h3>Période sélectionnée</h3>
    <p>Du {{ $viewData["startDate"] }} au {{ $viewData["endDate"] }}</p>


    <h3>Chiffre d'affaires</h3>
    <ul>
        <li>Aujourd'hui: {{ number_format($viewData["dailyRevenue"], 2) }} €</li>
        <li>Ce mois-ci: {{ number_format($viewData["monthlyRevenue"], 2) }} €</li>
        <li>Cette année: {{ number_format($viewData["yearlyRevenue"], 2) }} €</li>
    </ul>

    <h3>Bénéfices</h3>
    <ul>
        <li>Aujourd'hui: {{ number_format($viewData["dailyProfit"], 2) }} €</li>
        <li>Ce mois-ci: {{ number_format($viewData["monthlyProfit"], 2) }} €</li>
        <li>Cette année: {{ number_format($viewData["yearlyProfit"], 2) }} €</li>
    </ul>

    <h3>Revenus par Catégorie</h3>
    <table>
        <tr><th>Catégorie</th><th>Revenu (€)</th></tr>
        @foreach ($viewData["categorieRevenue"] as $categorie)
            <tr>
                <td>{{ $categorie->name }}</td>
                <td>{{ number_format($categorie->revenue, 2) }} €</td>
            </tr>
        @endforeach
    </table>

    <h3>Revenus par Produit</h3>
    <table>
        <tr><th>Produit</th><th>Revenu (€)</th></tr>
        @foreach ($viewData["productRevenue"] as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ number_format($product->revenue, 2) }} €</td>
            </tr>
        @endforeach
    </table>

</body>
</html>
