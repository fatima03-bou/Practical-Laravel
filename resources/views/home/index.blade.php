@extends('layouts.app')

@section('content')
<style>
    .hero {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('/storage/products/3.jpg') center/cover no-repeat;
        height: 70vh;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        border-radius: 20px;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .features {
        margin-top: 4rem;
    }

    .features .card {
        transition: transform 0.3s ease;
    }

    .features .card:hover {
        transform: translateY(-5px);
    }
</style>

<div class="container mt-4">
    <div class="hero">
        <div>
            <h1>Bienvenue sur notre boutique en ligne</h1>
            <p class="lead">Découvrez les meilleures offres et nos derniers produits</p>
            <a href="{{ route('product.index') }}" class="btn btn-warning btn-lg mt-3">Voir les produits</a>
        </div>
    </div>

    <div class="row features text-center">
        <div class="col-md-4 mt-4">
            <div class="card border-0 shadow">
                <img src="/storage/products/4.jpg" class="card-img-top" alt="Feature 1">
                <div class="card-body">
                    <h5 class="card-title">Livraison Rapide</h5>
                    <p class="card-text">Recevez vos produits en un temps record partout au Maroc.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card border-0 shadow">
                <img src="/storage/products/5.jpg" class="card-img-top" alt="Feature 2">
                <div class="card-body">
                    <h5 class="card-title">Paiement Sécurisé</h5>
                    <p class="card-text">Des options de paiement sûres pour une expérience sans souci.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-4">
            <div class="card border-0 shadow">
                <img src="/storage/products/6.jpg" class="card-img-top" alt="Feature 3">
                <div class="card-body">
                    <h5 class="card-title">Support 24/7</h5>
                    <p class="card-text">Notre équipe est à votre écoute tous les jours, à toute heure.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
