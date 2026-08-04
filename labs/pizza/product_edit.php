<?php
require_once 'models/Auth.php';
require_once 'models/products.php';
new Auth()->requireAdmin();
$productId = isset($_GET['id']) ? (int) $_GET['id'] : null;
$name = '';
$des = '';
$pic = '';
$price = '';
$tag = '';
$stock = '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Handle form submission
	$name = trim($_POST['name'] ?? '');
	$description = trim($_POST['description'] ?? '');
	$stock = (int) ($_POST['stock'] ?? 0);
	$pic = trim($_POST['pic'] ?? '');
	$tag = trim($_POST['tag'] ?? '');
	$price = (float) ($_POST['price'] ?? 0);

	if (empty($name) || empty($description) || $price <= 0 || $stock > 99 || $stock <= 0 || empty($pic)) {

		header('Location: status.php?success=0&message=Invalid input.' . urlencode(" Name: $name, Description: $description, Price: $price, Stock: $stock, Pic: $pic"));
		exit;
	}

	try {
		$productModel = new Product();

		if (isset($productId)) {
			// Update existing product
			$productModel->updateProduct($productId, $name, $description, $price, $pic, $stock, $tag);
			header('Location: status.php?success=1&message=Product updated successfully.');
			exit;
		} else {
			// Add new product
			$productId = $productModel->newProduct($name, $description, $price, $pic, $stock, $tag);
			header('Location: status.php?success=1&message=Product added successfully.');
			exit;
		}
	} catch (Exception $e) {
		header("Location: status.php?success=0&message={$e->getMessage()}");
		exit;
	}
}
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
	$product = null;
	try {
		$productModel = new Product();
		$product = $productModel->getDetail((int) $productId);
		if (!$product) {
			throw new Exception('Product not found');
		}
		$validPic = !empty($product->pic) ? $product->pic : 'https://placehold.co/800x800?text=no+image';
		$name = $product->name ?? '';
		$des = $product->description ?? '';
		$pic = str_starts_with($validPic, 'https://') ? $validPic : "images/{$validPic}";
		$price = $product->price ?? '';
		$tag = $product->tag ?? '';
		$stock = $product->stock ?? '';
	} catch (Exception $e) {
		header('Location: status.php?success=0&message=Product not found.');
		exit;
	}
}

// require_once 
$pageTitle = "Doomino's | " . (isset($productId) ? 'Edit' : 'Add') . " Product";

require_once 'templates/header.php';
require_once 'templates/nav.php';


?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			<?php echo isset($productId) ? 'Edit' : 'Add'; ?> product item
		</h1>
	</div>

	<section class="grid gap-5 pb-6 md:grid-cols-[1.2fr_0.8fr]">

		<form class="rounded-md bg-white p-5" action="product_edit.php?id=<?php echo $productId; ?>" method="post">
			<input type="hidden" name="productId" value="<?php echo $productId; ?>" />
			<div class="mb-3.5">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue"
					for="name">Name</label>
				<input class="w-full rounded-sm border border-line bg-white px-3 py-2" id="name" name="name" type="text"
					value="<?php echo htmlspecialchars($name); ?>" required />
			</div>
			<div class="mb-3.5 flex flex-wrap gap-2">
				<label class="option-chip rounded-sm cursor-pointer border-2 border-line px-3 py-1.5 text-sm font-bold">
					<input type="radio" name="tag" value="popular" <?php echo $tag == '' || $tag == 'popular' ? 'checked' : ''; ?> />
					<span>Popular</span>
				</label>
				<label class="option-chip rounded-sm cursor-pointer border-2 border-line  px-3 py-1.5 text-sm font-bold">
					<input type="radio" name="tag" value="meat" <?php echo $tag == 'meat' ? 'checked' : ''; ?> /> <span>Meat</span>
				</label>
				<label class="option-chip rounded-sm cursor-pointer border-2 border-line  px-3 py-1.5 text-sm font-bold">
					<input type="radio" name="tag" value="veggie" <?php echo $tag == 'veggie' ? 'checked' : ''; ?> />
					<span>Veggie</span>
				</label>

			</div>

			<div class="mb-3.5">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue"
					for="description">description</label>
				<textarea class="rounded-sm min-h-[80px] w-full resize-y border border-line bg-white px-3 py-2" id="description"
					name="description" required><?php echo htmlspecialchars($des); ?></textarea>
			</div>
			<div class="mb-3">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue" for="stock">
					Stock
				</label>
				<input class="w-full rounded-sm border border-line px-3 py-2" id="stock" name="stock" type="number" min="1"
					max="99" value="<?php echo $stock; ?>" required />
			</div>
			<div class="mb-3">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue" for="price">
					price
				</label>
				<input class="w-full rounded-sm border border-line px-3 py-2" id="price" name="price" type="number" min="0.1"
					max="999" step="any" value="<?php echo $price; ?>" required />
			</div>
			<div class="mb-3">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue" for="picture">
					Picture
				</label>
				<div class="md:grid md:grid-cols-[9fr_1fr] items-center gap-1">
					<input value="<?php echo $validPic; ?>" class="w-full rounded-sm border border-line px-3 py-2" id="picture"
						name="pic" required />
					<?php if (!empty($pic)): ?>
						<img class="mt-2 max-w-20 md:max-w-[50px] md:mt-0 aspect-square rounded-md border border-line object-fill"
							src="<?php echo $pic; ?>" alt="Product Image" />
					</div>


				<?php endif; ?>
			</div>

			<button
				class="rounded-sm bg-dominos-blue px-4 py-1.5 font-display uppercase tracking-wider text-white hover:bg-dominos-blue-deep"
				type="submit">
				Submit
			</button>
		</form>
	</section>
</main>

<?php
require_once 'templates/footer.php';
?>