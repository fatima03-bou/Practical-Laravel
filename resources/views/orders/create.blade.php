<form method="POST" action="{{ route('orders.store') }}">
    @csrf
    
    <!-- Champs d'adresse existants -->
    <div class="form-group">
        <label for="address">Adresse</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    
    <div class="form-group">
        <label for="city">Ville</label>
        <input type="text" class="form-control" id="city" name="city" required>
    </div>
    
    <div class="form-group">
        <label for="postal_code">Code postal</label>
        <input type="text" class="form-control" id="postal_code" name="postal_code" required>
    </div>
    
    <!-- Nouvelle section pour le choix de la méthode de paiement -->
    <div class="form-group mt-4">
        <label><strong>Méthode de paiement</strong></label>
        
        <div class="form-check mt-2">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_livraison" value="livraison" checked>
            <label class="form-check-label" for="payment_livraison">
                Paiement à la livraison
            </label>
        </div>
        
        <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" id="payment_en_ligne" value="en_ligne">
            <label class="form-check-label" for="payment_en_ligne">
                Paiement en ligne (Carte bancaire)
            </label>
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary mt-3">Valider la commande</button>
</form>