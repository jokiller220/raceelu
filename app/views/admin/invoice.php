<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Facture #<?= str_pad($data['order']->id, 5, '0', STR_PAD_LEFT) ?></title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.5; padding: 40px; }
        .invoice-header { display: flex; justify-content: space-between; border-bottom: 2px solid #2e7d32; padding-bottom: 20px; margin-bottom: 40px; }
        .brand { color: #2e7d32; }
        .brand h1 { margin: 0; font-size: 28px; }
        .invoice-info { text-align: right; }
        .invoice-info h2 { margin: 0; color: #666; }
        .details-row { display: flex; justify-content: space-between; margin-bottom: 40px; }
        .details-box h3 { border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; font-size: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 40px; }
        th { background: #f8f9fa; text-align: left; padding: 12px; border-bottom: 2px solid #dee2e6; }
        td { padding: 12px; border-bottom: 1px solid #dee2e6; }
        .text-right { text-align: right; }
        .totals { float: right; width: 300px; }
        .totals-row { display: flex; justify-content: space-between; padding: 5px 0; }
        .grand-total { font-weight: bold; font-size: 20px; color: #2e7d32; border-top: 2px solid #2e7d32; margin-top: 10px; padding-top: 10px; }
        .footer { margin-top: 100px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #ddd; padding-top: 20px; }
        @media print {
            .no-print { display: none; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="background: #f8f9fa; padding: 10px; margin-bottom: 20px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Imprimer cette facture</button>
    </div>

    <div class="invoice-header">
        <div class="brand">
            <img src="<?= BASE_URL ?>/public/assets/images/logo.png" alt="Logo" height="60" style="margin-bottom: 10px;" onerror="this.style.display='none'">
            <h1>RACE ÉLU</h1>
            <p>Vente en gros Alimentaire - Assiganmé, Lomé</p>
        </div>
        <div class="invoice-info">
            <h2>FACTURE</h2>
            <p>#<?= str_pad($data['order']->id, 5, '0', STR_PAD_LEFT) ?><br>
            Date: <?= date('d/m/Y', strtotime($data['order']->created_at)) ?></p>
        </div>
    </div>

    <div class="details-row">
        <div class="details-box" style="width: 45%;">
            <h3>CLIENT</h3>
            <strong><?= h($data['order']->nom_client) ?></strong><br>
            Tél: <?= h($data['order']->telephone_client) ?><br>
            Adresse: <?= h($data['order']->adresse_livraison) ?><br>
            Ville: <?= h($data['order']->ville_livraison) ?>
        </div>
        <div class="details-box" style="width: 45%;">
            <h3>PAIEMENT</h3>
            Mode: <?= h($data['order']->mode_paiement) ?><br>
            Statut: <?= h($data['order']->status) ?>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Désignation</th>
                <th class="text-right">Prix Unit.</th>
                <th class="text-right">Qté</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data['items'] as $item): ?>
            <tr>
                <td><?= h($item->product_name ?? 'Produit inconnu') ?></td>
                <td class="text-right"><?= number_format($item->prix_unitaire, 0, ',', ' ') ?> F</td>
                <td class="text-right"><?= $item->quantite ?></td>
                <td class="text-right"><?= number_format($item->prix_unitaire * $item->quantite, 0, ',', ' ') ?> F</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <div class="totals-row">
            <span>Sous-total:</span>
            <span><?= number_format($data['order']->total - 2000, 0, ',', ' ') ?> F</span>
        </div>
        <div class="totals-row">
            <span>Frais de livraison:</span>
            <span>2 000 F</span>
        </div>
        <?php if($data['order']->reduction_fidelite > 0): ?>
        <div class="totals-row" style="color: #d32f2f;">
            <span>Réduction Fidélité:</span>
            <span>- <?= number_format($data['order']->reduction_fidelite, 0, ',', ' ') ?> F</span>
        </div>
        <?php endif; ?>
        <div class="totals-row grand-total">
            <span>TOTAL À PAYER:</span>
            <span><?= number_format($data['order']->total, 0, ',', ' ') ?> FCFA</span>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="footer">
        <p>Merci pour votre confiance chez Race Élu !<br>
        Besoin d'aide ? Appelez-nous au +228 XX XX XX XX</p>
    </div>
</body>
</html>
