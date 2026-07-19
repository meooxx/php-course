<?php require_once 'templates/header.php'; ?>


<body class="bg-cream font-body text-ink antialiased">
	<a class="sr-only focus:not-sr-only focus:absolute focus:left-3 focus:top-3 focus:z-50 focus:bg-dominos-red focus:px-4 focus:py-2 focus:text-white"
		href="#main">Skip to main content</a>

	<header class="bg-dominos-blue text-white">
		<div class="mx-auto flex min-h-14 max-w-[980px] flex-wrap items-center gap-3 px-4 py-1.5">
			<a class="flex items-center gap-2 text-white no-underline hover:text-white" href="index.php">
				<img class="h-9 w-9" src="images/logo.svg" width="36" height="36" alt="" />
				<span class="font-display text-xl uppercase tracking-wider">Doomino's</span>
			</a>
			<nav class="flex-1" aria-label="Primary">
				<ul class="flex flex-wrap gap-0.5">
					<li>
						<a class="inline-block px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline hover:bg-black/20"
							href="index.php" aria-current="page">Home</a>
					</li>
					<li>
						<a class="inline-block px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline hover:bg-black/20"
							href="about.html">About</a>
					</li>
					<li>
						<a class="inline-block px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline hover:bg-black/20"
							href="shop.php">Menu</a>
					</li>
					<li>
						<a class="inline-block px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline hover:bg-black/20"
							href="contact.html">Contact</a>
					</li>
				</ul>
			</nav>
			<a class="rounded-full bg-white px-4 py-1.5 font-display text-sm uppercase tracking-wider text-dominos-blue no-underline hover:bg-sky-50"
				href="shop.php">Order Online</a>
		</div>
	</header>

	<main id="main" class="bg-cream">
		<section class="mx-auto max-w-[1100px] px-4 py-6" aria-label="Deals and promos">
			<div class="grid gap-3 lg:grid-cols-[1.2fr_1fr] lg:grid-rows-2">
				<a
					class="group relative block overflow-hidden rounded-sm border border-line bg-white shadow-sm lg:row-span-2"
					href="shop.php"
				>
					<img
						class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.015]"
						src="images/promo-best-deal.jpg"
						width="1156"
						height="1040"
						alt="Best Deal Ever — any pizza, any toppings"
					/>
				</a>

				<a
					class="group relative block overflow-hidden rounded-sm border border-line bg-white shadow-sm"
					href="shop.php"
				>
					<img
						class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
						src="images/promo-dip-days.jpg"
						width="684"
						height="510"
						alt="$1 Dip Days — limited time"
					/>
				</a>

				<a
					class="group relative block overflow-hidden rounded-sm border border-line bg-white shadow-sm"
					href="shop.php"
				>
					<img
						class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
						src="images/promo-mix-match.jpg"
						width="684"
						height="510"
						alt="Mix and match — choose any 2 or more"
					/>
				</a>
			</div>

			<a
				class="group relative mt-3 block overflow-hidden rounded-sm border border-line bg-white shadow-sm"
				href="shop.php"
			>
				<img
					class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]"
					src="images/pepsi-bottle.jpg"
					width="1200"
					height="750"
					alt="Pepsi cola bottles"
				/>
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
				<a class="text-dominos-blue underline-offset-2 hover:underline" href="https://www.dominos.ca/en/" rel="noopener noreferrer" target="_blank">dominos.ca</a>
				for academic layout practice · Doomino's is a fictional school brand
			</p>
		</section>
	</main>

	<?php require_once 'templates/footer.php'; ?>
