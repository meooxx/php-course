<?php
require_once 'models/products.php';

$productsList = [];
$pageTitle = "Doomino's | Shop";
$pageDescription = 'Browse our specialty pizzas and open a product page.';
try {
	$productModel = new Product();
	$productsList = $productModel->getProducts();
} catch (Exception $e) {
	header("Location: status.php?success=0&message={$e->getMessage()}");
	exit;
}

require_once 'templates/header.php';
require_once 'templates/nav.php';
?>
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
				$picurl = str_starts_with($product->pic, 'https://') ? $product->pic : "images/{$product->pic}";
				$alt = "{$product->name} pizza";
				$tag = $product->tag;
				$name = $product->name;
				$desc = isset($product->description) ? htmlspecialchars($product->description) : '';
				$price = $product->price;
				$id = $product->id; ?>
				<article class="flex flex-col overflow-hidden rounded-lg border border-line bg-white">
					<a class="aspect-square overflow-hidden bg-neutral-200" href="detail.php?id=<?php echo $id; ?>">
						<img class="h-full w-full object-cover" src="<?php echo $picurl; ?>" width="800" height="800"
							alt="<?php echo $alt; ?>" />
					</a>
					<div class="flex flex-1 flex-col gap-1.5 p-3.5">
						<span
							class="w-fit overflow-hidden rounded-sm bg-dominos-red px-2 py-0.5 font-display text-xs uppercase tracking-wider text-white">
							<?php echo $tag; ?>
						</span>
						<h3 class="font-display text-lg uppercase tracking-wide text-dominos-blue">
							<a class="text-inherit no-underline hover:text-dominos-red" href="detail.php?id=<?php echo $id; ?>">
								<?php echo $name; ?>
							</a>
						</h3>
						<p class="flex-1 text-sm text-muted">
							<?php echo $desc; ?>
						</p>
						<div class="mt-2 flex items-center justify-between gap-2">
							<span class="font-display text-xl text-dominos-blue">
								$<?php echo $price; ?>
							</span>
							<a class="inline-block rounded-sm bg-dominos-red px-3 py-1.5 font-display text-sm uppercase tracking-wider text-white no-underline hover:bg-red-700"
								href="detail.php?id=<?php echo $id; ?>">View</a>
						</div>
					</div>
				</article>
			<?php } ?>
		</div>
	</section>
</main>

<?php require_once 'templates/footer.php'; ?>
