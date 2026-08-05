<?php
require_once 'models/products.php';

$pageTitle = 'Inventory Control';
$pageDescription = 'Pizza inventory control board — out-of-stock alerts and admin tools.';

$products = [];
try {
	$productModel = new Product();
	$products = $productModel->getProducts();
} catch (Exception $e) {
	$products = [];
}

$outOfStock = [];
foreach ($products as $product) {
	$stock = isset($product->stock) ? (int) $product->stock : 0;
	if ($stock === 0) {
		$outOfStock[] = $product;
	}
}

$outCount = count($outOfStock);

require_once 'templates/header.php';
require_once 'templates/nav.php';
?>
<main id="main" class="bg-cream">
	<section class="relative flex min-h-[55vh] items-end overflow-hidden bg-dominos-blue text-white"
		aria-label="System header">
		<div class="absolute inset-0" aria-hidden="true">
			<video class="h-full w-full object-cover contrast-[1.1] saturate-[1.15]" autoplay muted loop playsinline
				poster="images/promo-best-deal.jpg">
				<source src="videos/hero.mp4" type="video/mp4" />
			</video>
			<div
				class="absolute inset-0 bg-gradient-to-b from-dominos-blue-deep/60 via-dominos-blue-deep/75 to-dominos-blue-deep">
			</div>
			<div class="absolute inset-0 bg-gradient-to-r from-dominos-blue-deep via-dominos-blue-deep/55 to-transparent">
			</div>
		</div>
		<div class="relative z-[1] mx-auto w-full px-8 pb-8 pt-10">
			<p class="font-display text-xs uppercase tracking-[0.28em] text-dominos-red">Control board</p>
			<h1 class="mt-2 font-display text-[clamp(2.4rem,8vw,4.5rem)] uppercase leading-none tracking-wide text-white">
				Inventory
			</h1>
		</div>
	</section>

	
</main>

<?php require_once 'templates/footer.php'; ?>
