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
			<div class="mt-6 flex flex-wrap gap-3">
				<a class="inline-block rounded-sm bg-dominos-red px-5 py-2.5 font-display text-sm uppercase tracking-wider text-white no-underline transition hover:-translate-y-px hover:bg-dominos-red-deep"
					href="product.php">Open inventory</a>
				<a class="inline-block rounded-sm border border-white/50 px-5 py-2.5 font-display text-sm uppercase tracking-wider text-white no-underline transition hover:border-white hover:bg-white/10"
					href="shop.php">Browse catalog</a>
			</div>
		</div>
	</section>

	<section class="mx-auto w-full max-w-[980px] px-4 py-8 sm:px-8" aria-label="Out of stock alerts">
		<div class="mb-5 flex flex-wrap items-end justify-between gap-3">
			<div>
				<h2 class="font-display text-2xl uppercase tracking-wide text-dominos-blue">Out of stock</h2>
				<p class="mt-1 text-base text-muted">These items have 0 units left and need restocking.</p>
			</div>
			<span class="rounded-sm bg-dominos-blue px-3 py-1.5 font-display text-sm uppercase tracking-wider text-white">
				<?php echo $outCount; ?> items
			</span>
		</div>

		<?php if ($outCount === 0): ?>
			<p class="border border-line bg-white px-5 py-8 text-base leading-relaxed text-muted">
				All clear — nothing is out of stock.
				<a class="ml-1 font-display text-sm uppercase tracking-wider text-dominos-red no-underline hover:underline"
					href="product.php">Open stock board</a>
			</p>
		<?php else: ?>
			<ul class="space-y-3">
				<?php foreach ($outOfStock as $item): ?>
					<li
						class="rounded-sm flex flex-col gap-3 border border-line bg-white px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
						<div class="min-w-0 flex items-start gap-3 sm:items-center">
							<span
								class="rounded-sm shrink-0 bg-dominos-blue px-2 py-1 font-display text-xs uppercase tracking-wider text-white">
								Out
							</span>
							<div class="min-w-0">
								<a class="block font-display text-lg uppercase tracking-wide text-dominos-blue no-underline hover:text-dominos-red"
									href="detail.php?id=<?php echo $item->id; ?>">
									<?php echo htmlspecialchars($item->name); ?>
								</a>
								<p class="mt-0.5 text-sm text-muted">Product ID #<?php echo $item->id; ?> · Qty 0</p>
							</div>
						</div>
						<div class="flex shrink-0 gap-2 sm:pl-4">
							<a class="rounded-sm inline-block border border-dominos-red px-3 py-1.5 font-display text-sm uppercase tracking-wider text-dominos-red no-underline hover:bg-dominos-red-soft"
								href="detail.php?id=<?php echo $item->id; ?>">View</a>
							<?php if ($isAdmin): ?>
								<a class="rounded-sm inline-block bg-dominos-blue px-3 py-1.5 font-display text-sm uppercase tracking-wider text-white no-underline hover:bg-dominos-blue-deep"
									href="product_edit.php?id=<?php echo $item->id; ?>">Restock</a>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</section>
</main>

<?php require_once 'templates/footer.php'; ?>