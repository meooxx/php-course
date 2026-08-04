<?php 
$pageTitle = "Doomino's | Home";
$pageDescription = "Doomino's is a fictional pizza brand for academic purposes.";
?>
<?php require_once 'templates/header.php'; ?>
<?php require_once 'templates/nav.php'; ?>
	<main id="main" class="bg-cream">
		<section class="mx-auto max-w-[1100px] px-4 py-6" aria-label="Deals and promos">
			<div class="grid gap-3 lg:grid-cols-[1.2fr_1fr] lg:grid-rows-2">
				<a class="group relative block overflow-hidden rounded-sm border border-line bg-white shadow-sm lg:row-span-2"
					href="shop.php">
					<img class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.015]"
						src="images/promo-best-deal.jpg" width="1156" height="1040"
						alt="Best Deal Ever — any pizza, any toppings" />
				</a>

				<a class="group relative block overflow-hidden rounded-sm border border-line bg-white shadow-sm"
					href="shop.php">
					<img class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
						src="images/promo-dip-days.jpg" width="684" height="510" alt="$1 Dip Days — limited time" />
				</a>

				<a class="group relative block overflow-hidden rounded-sm border border-line bg-white shadow-sm"
					href="shop.php">
					<img class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
						src="images/promo-mix-match.jpg" width="684" height="510" alt="Mix and match — choose any 2 or more" />
				</a>
			</div>

			<a class="group relative mt-3 block overflow-hidden rounded-sm border border-line bg-white shadow-sm"
				href="shop.php">
				<img class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
					src="images/pepsi-bottle.jpg" width="1200" height="750" alt="Pepsi cola bottles" />
				<div class="absolute inset-0 bg-gradient-to-r from-dominos-blue/85 via-dominos-blue/55 to-transparent"></div>
				<div class="relative z-10 flex min-h-[160px] flex-col justify-center px-6 py-8 sm:min-h-[180px] sm:px-10">
					<p class="font-display text-sm uppercase tracking-[0.2em] text-white/85">Add a drink</p>
					<p class="mt-1 font-display text-3xl uppercase tracking-wide text-white sm:text-4xl">
						百事可乐 · Pepsi
					</p>
					<p class="mt-2 max-w-md text-sm text-white/90">Ice-cold Pepsi — pair with any pizza order.</p>
					<span class="promo-btn mt-4 w-fit">Order Now</span>
				</div>
			</a>

			<p class="mt-4 text-center text-xs text-muted">
				Promo images from
				<a class="text-dominos-blue underline-offset-2 hover:underline" href="https://www.dominos.ca/en/"
					rel="noopener noreferrer" target="_blank">dominos.ca</a>
				for academic layout practice · Doomino's is a fictional school brand
			</p>
		</section>
	</main>

	<?php require_once 'templates/footer.php'; ?>