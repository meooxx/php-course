<?php
$pageTitle = "Inventory";
$pageDescription = 'Pizza inventory system — manage stock and users with PHP and MySQL.';

require_once 'templates/header.php';
require_once 'templates/nav.php';
?>
<main id="main" class="bg-cream">
	<section class="relative flex min-h-[calc(100vh-7.5rem)] items-end overflow-hidden bg-dominos-blue text-white"
		aria-label="Homepage hero">
		<div class="absolute inset-0" aria-hidden="true">
			<video class="motion-safe-video h-full w-full object-cover contrast-[1.1] saturate-[1.15]" autoplay muted loop
				playsinline poster="images/promo-best-deal.jpg">
				<source src="videos/hero.mp4" type="video/mp4" />
			</video>
			<img class="js-hero-fallback absolute inset-0 hidden h-full w-full object-cover" src="images/promo-best-deal.jpg"
				width="1280" height="720" alt="" />
			<div
				class="absolute inset-0 bg-gradient-to-b from-dominos-blue-deep/55 via-dominos-blue-deep/70 to-dominos-blue-deep">
			</div>
			<div class="absolute inset-0 bg-gradient-to-r from-dominos-blue-deep via-dominos-blue-deep/50 to-transparent">
			</div>
			<div class="absolute inset-x-0 bottom-0 h-px bg-gradient-to-r from-transparent via-dominos-red to-transparent">
			</div>
		</div>
		<div class="relative z-[1] mx-auto w-full max-w-[980px] px-4 pb-14 pt-12">
			<h1 class="font-display text-[clamp(3.2rem,12vw,7rem)] uppercase leading-none tracking-[0.06em] text-white">
				Inventory
			</h1>
			<p class="mt-4 max-w-md border-dominos-red pl-4 text-base text-white/85">
				Stock, products, and users — PHP inventory control.
			</p>
			<div class="mt-6 flex flex-wrap gap-3">
				<a class="inline-block rounded-sm bg-dominos-red px-5 py-2.5 font-display text-sm uppercase tracking-wider text-white no-underline transition hover:-translate-y-px hover:bg-dominos-red-deep"
					href="product.php">Open inventory</a>
				<a class="inline-block rounded-sm border border-white/50 px-5 py-2.5 font-display text-sm uppercase tracking-wider text-white no-underline transition hover:border-white hover:bg-white/10"
					href="shop.php">Browse catalog</a>
			</div>
		</div>
	</section>
</main>

<?php require_once 'templates/footer.php'; ?>