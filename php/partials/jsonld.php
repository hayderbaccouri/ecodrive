<?php
if (!isset($jsonld_type)) return;

if ($jsonld_type === 'localbusiness') {
  $jsonld = [
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => 'EcoDrive',
    'description' => 'Premier showroom électrique en Tunisie',
    'url' => 'https://ecodrive.tn',
    'telephone' => '+216 90 311 428',
    'address' => [
      '@type' => 'PostalAddress',
      'streetAddress' => '123 Rue de la Liberté',
      'addressLocality' => 'Tunis',
      'addressCountry' => 'TN',
    ],
    'sameAs' => [],
  ];
  if (!empty($jsonld_products)) {
    $offers = [];
    foreach ($jsonld_products as $car) {
      $offers[] = ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Product', 'name' => $car]];
    }
    $jsonld['makesOffer'] = $offers;
  }
} elseif ($jsonld_type === 'product' && !empty($jsonld_product)) {
  $p = $jsonld_product;
  $jsonld = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $p['name'] ?? '',
    'description' => $p['description'] ?? '',
    'image' => $p['image'] ?? '',
    'brand' => ['@type' => 'Brand', 'name' => $p['brand'] ?? ''],
    'offers' => [
      '@type' => 'Offer',
      'priceCurrency' => 'TND',
      'price' => $p['price'] ?? '',
      'availability' => 'https://schema.org/InStock',
    ],
  ];
} else {
  return;
}
?>
<script type="application/ld+json">
<?= json_encode($jsonld, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) ?>
</script>
