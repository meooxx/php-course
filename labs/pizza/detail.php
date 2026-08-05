<?php
require_once 'models/products.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 1;

try {
	$productModel = new Product();
	$product = $productModel->getDetail($id);
	if (!$product) {
		throw new Exception('Product not found');
	}
} catch (Exception $e) {
	header('Location: status.php?success=0&message=Product not found.');
	exit;
}

$validPic = !empty($product->pic) ? $product->pic : 'https://placehold.co/800x800?text=no+image';
$name = $product->name ?? 'No name';
$des = $product->description ?? 'No description available.';
$pic = str_starts_with($validPic, 'https://') ? $validPic : "images/{$validPic}";
$price = $product->price ?? 'N/A';
$tag = $product->tag ?? 'Specialty';

$ingredients = ['Mozzarella', 'Tomato sauce', 'Fresh herbs', 'House seasoning', 'Olive oil finish'];

$pageTitle = "Doomino's | " . $name;
$pageDescription = "{$name} — {$des}";
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="bg-cream">
	<section class="mx-auto max-w-[980px] px-4 py-6 md:py-8" aria-labelledby="product-title">
		<div class="grid items-start gap-6 md:grid-cols-2 md:gap-8">
			<figure class="group overflow-hidden rounded-sm border border-line bg-white shadow-sm">
				<img
					class="aspect-square w-full object-cover transition duration-500 group-hover:scale-[1.03] group-hover:brightness-105 group-hover:saturate-110"
					src="<?php echo htmlspecialchars($pic); ?>"
					width="800"
					height="800"
					alt="<?php echo htmlspecialchars($name); ?>"
				/>
				<figcaption class="border-t border-line px-3.5 py-2.5 text-sm tracking-wide text-muted">
					Fresh from the Doomino's demo kitchen
				</figcaption>
			</figure>

			<div>
				<nav class="mb-3 text-sm text-muted" aria-label="Breadcrumb">
					<a class="text-dominos-blue no-underline hover:underline" href="shop.php">Shop</a>
					<span class="mx-1" aria-hidden="true">/</span>
					<span><?php echo htmlspecialchars($name); ?></span>
				</nav>

				<p class="inline-block bg-dominos-red px-2 py-0.5 font-display text-xs uppercase tracking-[0.14em] text-white">
					<?php echo htmlspecialchars($tag); ?>
				</p>
				<h1 id="product-title" class="mt-2 font-display text-4xl uppercase tracking-wide text-dominos-blue md:text-5xl">
					<?php echo htmlspecialchars($name); ?>
				</h1>
				<p class="mt-3 font-display text-3xl tracking-wide text-ink">
					$<?php echo htmlspecialchars((string) $price); ?>
				</p>
				<p class="mt-3 max-w-md text-muted leading-relaxed">
					<?php echo htmlspecialchars($des); ?>
				</p>

				<div class="mt-7 flex flex-wrap items-center gap-x-5 gap-y-3">
					<a
						class="inline-block rounded-full bg-dominos-red px-5 py-2.5 font-display text-sm uppercase tracking-wider text-white no-underline transition hover:-translate-y-0.5 hover:bg-red-700 hover:shadow-lg"
						href="contact.php"
					>Ask about this pizza</a>
					<a
						class="font-display text-sm uppercase tracking-widest text-dominos-blue no-underline hover:underline"
						href="shop.php"
					>Back to shop</a>
				</div>
			</div>
		</div>
	</section>

	<section class="bg-dominos-blue py-9 text-white" aria-labelledby="ingredients-title">
		<div class="mx-auto grid max-w-[980px] items-center gap-6 px-4 md:grid-cols-[0.9fr_1.1fr] md:gap-10">
			<div>
				<p class="font-display text-xs uppercase tracking-[0.18em] text-white/75">On the pie</p>
				<h2 id="ingredients-title" class="mt-2 font-display text-3xl uppercase tracking-wide md:text-4xl">
					Featured ingredients
				</h2>
				<p class="mt-3 max-w-sm text-white/90">
					Decorative flavor notes for this coursework product page — not a live ordering checklist.
				</p>
			</div>
			<ul class="flex flex-wrap gap-2.5">
				<?php foreach ($ingredients as $ingredient) { ?>
					<li class="border border-white/35 bg-white/10 px-3.5 py-2 font-display text-xs uppercase tracking-wider transition hover:-translate-y-0.5 hover:border-white hover:bg-white/20">
						<?php echo htmlspecialchars($ingredient); ?>
					</li>
				<?php } ?>
			</ul>
		</div>
	</section>
</main>

<?php require_once 'templates/footer.php'; ?>
