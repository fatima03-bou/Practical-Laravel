<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques - PDF</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #212529;
            margin: 20px;
        }

        h1, h2, h3 {
            color: #343a40;
            margin-bottom: 10px;
        }

        p, li {
            font-size: 14px;
            line-height: 1.6;
        }

        ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 14px;
        }

        th, td {
            padding: 10px 8px;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .section {
            margin-bottom: 30px;
        }

        .highlight {
            font-weight: bold;
            color: #0d6efd;
        }

        .text-muted {
            color: #6c757d;
        }

    </style>
</head>
<body>

    <h1>{{ $viewData["title"] }}</h1>
    <h2 class="text-muted">{{ $viewData["subtitle"] }}</h2>

    <div class="section">
        <h3>Période sélectionnée</h3>
        <p>Du <span class="highlight">{{ $viewData["startDate"] }}</span> au <span class="highlight">{{ $viewData["endDate"] }}</span></p>
    </div>

    <div class="section">
        <h3>Chiffre d'affaires</h3>
        <ul>
            <li>Aujourd'hui: <span class="highlight">{{ number_format($viewData["dailyRevenue"], 2) }} €</span></li>
            <li>Ce mois-ci: <span class="highlight">{{ number_format($viewData["monthlyRevenue"], 2) }} €</span></li>
            <li>Cette année: <span class="highlight">{{ number_format($viewData["yearlyRevenue"], 2) }} €</span></li>
        </ul>
    </div>

    <div class="section">
        <h3>Bénéfices</h3>
        <ul>
            <li>Aujourd'hui: <span class="highlight">{{ number_format($viewData["dailyProfit"], 2) }} €</span></li>
            <li>Ce mois-ci: <span class="highlight">{{ number_format($viewData["monthlyProfit"], 2) }} €</span></li>
            <li>Cette année: <span class="highlight">{{ number_format($viewData["yearlyProfit"], 2) }} €</span></li>
        </ul>
    </div>

    <div class="section">
        <h3>Revenus par Catégorie</h3>
        <table>
            <thead>
                <tr>
                    <th>Catégorie</th>
                    <th>Revenu (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData["categorieRevenue"] as $categorie)
                    <tr>
                        <td>{{ $categorie->name }}</td>
                        <td>{{ number_format($categorie->revenue, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <h3>Revenus par Produit</h3>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Revenu (€)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($viewData["productRevenue"] as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ number_format($product->revenue, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
