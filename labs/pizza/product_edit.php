<?php
require_once 'controllers/ProductController.php';

$controller = new ProductController();
$controller->requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$controller->handlePost($_POST);
}

$view = $controller->loadForEdit($_GET['id'] ?? null);
$productId = $view['productId'];
$name = $view['name'];
$des = $view['des'];
$pic = $view['pic'];
$price = $view['price'];
$tag = $view['tag'];
$stock = $view['stock'];
$validPic = $view['validPic'];

$pageTitle = "Doomino's | " . (isset($productId) ? 'Edit' : 'Add') . " Product";
$pageDescription = 'Product add/edit page for a dish';

require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			<?php echo empty($productId) ? 'Edit' : 'Add'; ?> product item
		</h1>
	</div>

	<section class="grid gap-5 pb-6 md:grid-cols-[1.2fr_0.8fr]">

		<form class="rounded-md bg-white p-5" action="product_edit.php?id=<?php echo $productId; ?>" method="post">
			<input type="hidden" name="targetId" value="<?php echo $productId; ?>" />
			<input type="hidden" name="action" value="update" />
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
					<input value="<?php echo htmlspecialchars($validPic); ?>" class="w-full rounded-sm border border-line px-3 py-2" id="picture"
						name="pic" required />
					<?php if (!empty($pic)): ?>
						<img class="mt-2 max-w-20 md:max-w-[50px] md:mt-0 aspect-square rounded-md border border-line object-fill"
							src="<?php echo htmlspecialchars($pic); ?>" alt="Product Image" />
					<?php endif; ?>
				</div>
			</div>

			<button
				class="rounded-sm mt-2 bg-dominos-blue px-4 py-1.5 font-display uppercase tracking-wider text-white hover:bg-dominos-blue-deep"
				type="submit">
				Submit
			</button>
		</form>
	</section>
</main>

<?php require_once 'templates/footer.php'; ?>
