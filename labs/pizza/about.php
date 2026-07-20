<?php require_once 'templates/header.php'; ?>
<?php require_once 'templates/nav.php'; ?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			About This Lab
		</h1>
	</div>

	<section class="grid items-start gap-6 pb-6 md:grid-cols-[1.1fr_0.9fr]">
		<div class="rounded-md bg-white p-5">
			<h2 class="font-display text-2xl uppercase tracking-wide text-dominos-blue">
				A fictional school pizza brand
			</h2>
			<p class="mb-4">
				Doomino's is an original name for this coursework site. The layout
				practices common pizza-ordering patterns (blue header, background, delivery /
				carryout choice, menu) and is built with Tailwind CSS.
			</p>
			<p class="mb-5">
				This is not a real restaurant and is not affiliated with Domino's or any other pizza
				chain. The logo and brand name are student-made to avoid trademark use.
			</p>
			<a class="inline-block bg-accent-blue px-4 py-1.5 font-display text-sm uppercase tracking-wider text-white no-underline hover:bg-dominos-blue-deep"
				href="shop.php">Browse Menu</a>
		</div>
		<figure class="rounded-md overflow-hidden">
			<img class="w-full" src="images/about-store.jpg" width="1000" height="750"
				alt="Restaurant interior representing a pizza storefront" />
		</figure>
	</section>
</main>
<?php require_once 'templates/footer.php'; ?>