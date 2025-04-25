<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f4f4f4;
        }
        .table td {
            background-color: #f9f9f9;
        }
        .summary {
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1>{{ $viewData['title'] }}</h1>

    <h2>Statistics Report</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Type</th>
                <th>Revenue ($)</th>
                <th>Profit ($)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Today</strong></td>
                <td>{{ number_format($viewData['revenueToday'], 2) }}</td>
                <td>{{ number_format($viewData['profitToday'], 2) }}</td>
            </tr>
            <tr>
                <td><strong>This Month</strong></td>
                <td>{{ number_format($viewData['revenueMonth'], 2) }}</td>
                <td>{{ number_format($viewData['profitMonth'], 2) }}</td>
            </tr>
            <tr>
                <td><strong>This Year</strong></td>
                <td>{{ number_format($viewData['revenueYear'], 2) }}</td>
                <td>{{ number_format($viewData['profitYear'], 2) }}</td>
            </tr>
        </tbody>
    </table>

    <h2>Breakdown</h2>

    <!-- By Product -->
    <h3>By Product</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Revenue ($)</th>
                <th>Profit ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($viewData['revenueByProduct'] as $product)
                <tr>
                    <td>{{ $product->produit }}</td>
                    <td>{{ number_format($product->revenue, 2) }}</td>
                    <td>
                        @php
                            $profit = $viewData['profitByProduct']->firstWhere('produit', $product->produit);
                        @endphp
                        {{ number_format($profit ? $profit->profit : 0, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- By Category -->
    <h3>By Category</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Revenue ($)</th>
                <th>Profit ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($viewData['revenueByCategory'] as $category)
                <tr>
                    <td>{{ $category->categorie }}</td>
                    <td>{{ number_format($category->revenue, 2) }}</td>
                    <td>
                        @php
                            $profit = $viewData['profitByCategory']->firstWhere('categorie', $category->categorie);
                        @endphp
                        {{ number_format($profit ? $profit->profit : 0, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- By Country -->
    <h3>By Country</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Country</th>
                <th>Revenue ($)</th>
                <th>Profit ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($viewData['revenueByCountry'] as $country)
                <tr>
                    <td>{{ $country->pays }}</td>
                    <td>{{ number_format($country->revenue, 2) }}</td>
                    <td>
                        @php
                            $profit = $viewData['profitByCountry']->firstWhere('pays', $country->pays);
                        @endphp
                        {{ number_format($profit ? $profit->profit : 0, 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
