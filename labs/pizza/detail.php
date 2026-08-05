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
$tag = $product->tag ?? 'N/A';
$stock = isset($product->stock) ? (int) $product->stock : 0;

$pageTitle = "Doomino's | Product Detail";
$pageDescription = "Details for {$name} pizza.";
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<nav class="mb-2 text-sm text-muted">
			<a class="text-dominos-blue no-underline hover:underline" href="shop.php">Menu</a>
			/ <?php echo htmlspecialchars($name); ?>
		</nav>
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			<?php echo htmlspecialchars($name); ?>
		</h1>
	</div>

	<div class="mb-8 grid items-start gap-6 md:grid-cols-2">
		<figure class="overflow-hidden rounded-md border border-line bg-white">
			<img class="aspect-square w-full object-cover" src="<?php echo htmlspecialchars($pic); ?>" width="800"
				height="800" alt="<?php echo htmlspecialchars($name); ?>" />
		</figure>

		<div class="rounded-md border border-line bg-white p-5">
			<span
				class="mb-2 inline-block overflow-hidden rounded-sm bg-dominos-red px-2 py-0.5 font-display text-xs uppercase tracking-wider text-white">
				<?php echo htmlspecialchars($tag); ?>
			</span>
			<p class="font-display text-2xl text-dominos-blue">$<?php echo htmlspecialchars((string) $price); ?></p>
			<p class="mb-2 text-sm text-muted">In stock: <?php echo $stock; ?></p>
			<p class="mb-5 text-muted"><?php echo htmlspecialchars($des); ?></p>
			<a class="inline-block rounded-sm bg-dominos-red px-4 py-2 font-display text-sm uppercase tracking-wider text-white no-underline hover:bg-dominos-red-deep"
				href="shop.php">Back to menu</a>
		</div>
	</div>
</main>

<?php require_once 'templates/footer.php'; ?>
