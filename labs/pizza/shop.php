<?php require_once 'templates/header.php'; ?>
<?php require_once 'models/Database.php'; ?>
<?php require_once 'models/products.php'; ?>
<?php

$db = new Database();
$conn = $db->connect();
$productModel = new Product($conn);
$productsList = [];
try {
	$productsList = $productModel->getProducts();
} catch (Exception $e) {
	echo "Error: " . $e->getMessage();
}

?>


<body class="bg-cream font-body text-ink antialiased">
	<a class="sr-only focus:not-sr-only focus:absolute focus:left-3 focus:top-3 focus:z-50 focus:bg-dominos-red focus:px-4 focus:py-2 focus:text-white"
		href="#main">Skip to main content</a>

	<header class="bg-dominos-blue text-white">
		<div class="mx-auto flex min-h-14 max-w-[980px] flex-wrap items-center gap-3 px-4 py-1.5">
			<a class="flex items-center gap-2 text-white no-underline hover:text-white" href="index.html">
				<img class="h-9 w-9" src="images/logo.svg" width="36" height="36" alt="" />
				<span class="font-display text-xl uppercase tracking-wider">Doomino's</span>
			</a>
			<nav class="flex-1" aria-label="Primary">
				<ul class="flex flex-wrap gap-0.5">
					<li>
						<a class="inline-block px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline hover:bg-black/20"
							href="index.html">Home</a>
					</li>
					<li>
						<a class="inline-block px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline hover:bg-black/20"
							href="about.html">About</a>
					</li>
					<li>
						<a class="inline-block bg-black/20 px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline"
							href="shop.html" aria-current="page">Menu</a>
					</li>
					<li>
						<a class="inline-block px-3 py-2 font-display text-sm uppercase tracking-widest text-white no-underline hover:bg-black/20"
							href="contact.html">Contact</a>
					</li>
				</ul>
			</nav>
			<a class="rounded-full bg-white px-4 py-1.5 font-display text-sm uppercase tracking-wider text-dominos-blue no-underline hover:bg-sky-50"
				href="#menu">Order Online</a>
		</div>
	</header>

	<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
		<div class="pb-4 pt-7">
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Specialty Pizzas
			</h1>
		</div>

		<section class="pb-6" id="menu">
			<div class="grid gap-4 md:grid-cols-3">
				<?php
				foreach ($productsList as $product) {
					$picurl = "images/{$product->pic}";
					$alt = "{$product->name} pizza";
					$tag = $product->tag;
					$name = $product->name;
					$desc = isset($product->description) ? htmlspecialchars($product->description) : '';
					$price = $product->price;
					$id = $product->id; ?>
					<article class="flex flex-col overflow-hidden  rounded-lg border border-line bg-white">
						<a class="aspect-square overflow-hidden bg-neutral-200" href="products/pepperoni.html">
							<img class="h-full w-full object-cover" src="<?php echo $picurl; ?>" width="800" height="800"
								alt="<?php echo $alt; ?>" />
						</a>
						<div class="flex flex-1 flex-col gap-1.5 p-3.5">
							<span class="w-fit bg-dominos-red px-2 py-0.5 font-display text-xs uppercase tracking-wider text-white">
								<?php echo $tag; ?>
							</span>
							<h3 class="font-display text-lg uppercase tracking-wide text-dominos-blue">
								<a class="text-inherit no-underline hover:text-dominos-red" href="products/<?php echo $id; ?>.html">
									<?php echo $name; ?>
								</a>
							</h3>
							<p class="flex-1 text-sm text-muted">
								<?php echo $desc; ?>
							</p>
							<div class="mt-2 flex items-center justify-between gap-2">
								<span class="font-display text-xl text-dominos-blue">
									<?php echo $price; ?>
								</span>
								<a class="bg-dominos-red px-3 py-1.5 font-display text-sm uppercase tracking-wider text-white no-underline hover:bg-red-700"
									href="products/<?php echo $id; ?>.html">Order</a>
							</div>
						</div>
					</article>
				<?php } ?>
			</div>
		</section>
	</main>

	<?php require_once 'templates/footer.php'; ?>