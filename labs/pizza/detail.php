<?php require_once 'templates/header.php'; ?>
<?php require_once 'templates/nav.php'; ?>
<?php require_once 'models/database.php'; ?>
<?php
$_GET['id'] = $_GET['id'] ?? 1; // Default to 1 if not provided
$id = (int) $_GET['id'];
require_once 'models/products.php';
$db = new Database();

$conn = $db->connect();
$productModel = new Product($conn);

$product = null;
try {
	$product = $productModel->getDetail($id);
	if (!$product) {
		throw new Exception("Product not found");
	}
} catch (Exception $e) {
	echo "Error: " . $e->getMessage();
	exit; // Stop further execution if there's an error
}
// {name: string, description: string, price: float, tag: 'popular' | meat | veggie, pic: string}
$name = $product->name ?? 'No name';
$des = $product->description ?? 'No description available.';
$pic = $product->pic ? "/images/{$product->pic}" : "https://placehold.co/800x800?text=no+image";
$price = $product->price ?? "N/A";
$tag = $product->tag ?? 'N/A';
?>



<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<nav class="mb-2 text-sm text-muted"><a class="text-dominos-blue no-underline hover:underline" href="/">Menu</a> /
			<?php echo $name; ?>
		</nav>
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl"><?php echo $name; ?></h1>
	</div>
	<div class="mb-8 grid gap-6 md:grid-cols-2">
		<figure class="border border-line bg-white">
			<img class="aspect-square w-full object-cover" src="<?php echo $pic; ?>" width="800" height="800"
				alt="<?php echo $name; ?>" />
		</figure>
		<div class="border border-line bg-white p-5" id="order">
			<span
				class="mb-2 inline-block bg-dominos-red px-2 py-0.5 font-display text-xs uppercase tracking-wider text-white"><?php echo $tag; ?></span>
			<p class="font-display text-2xl text-dominos-blue"><?php echo $price; ?></p>
			<p class="mb-4"><?php echo htmlspecialchars($des ?? 'No description available.'); ?></p>
			<form action="/status.php" method="get">
				<fieldset class="mb-4 border-0 p-0">
					<legend class="mb-2 font-display uppercase tracking-wider text-dominos-blue">Size</legend>
					<div class="flex flex-wrap gap-2">
						<label class="option-chip cursor-pointer border-2 border-line bg-white px-3 py-1.5 text-sm font-bold"><input
								type="radio" name="size" value="s" checked />
							<span>Small</span>
						</label>
						<label class="option-chip cursor-pointer border-2 border-line bg-white px-3 py-1.5 text-sm font-bold"><input
								type="radio" name="size" value="m" />
							<span>Medium</span>
						</label>
						<label class="option-chip cursor-pointer border-2 border-line bg-white px-3 py-1.5 text-sm font-bold"><input
								type="radio" name="size" value="l" /> <span>Large</span></label>
					</div>
				</fieldset>
				<fieldset class="mb-4 border-0 p-0">
					<legend class="mb-2 font-display uppercase tracking-wider text-dominos-blue">Crust</legend>
					<div class="flex flex-wrap gap-2">
						<label class="option-chip cursor-pointer border-2 border-line bg-white px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="crust" value="ht" checked />
							<span>Hand Tossed</span>
						</label>
						<label class="option-chip cursor-pointer border-2 border-line bg-white px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="crust" value="pan" />
							<span>Handmade Pan</span>
						</label>
						<label class="option-chip">
							<!-- hidden input for success(always success) -->
							<input type="radio" checked name="success" value="1" />
						</label>
					</div>
				</fieldset>
				<button
					class="w-full bg-dominos-red px-4 py-2 font-display text-sm uppercase tracking-wider text-white hover:bg-red-700"
					type="submit">Add to Order</button>
			</form>
		</div>
	</div>

</main>
<?php
require_once 'templates/footer.php';
?>