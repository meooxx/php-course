<?php
require_once 'models/Auth.php';
$auth = new Auth();
// main project requirement: only logged-in users can view products
$isLoggedIn = $auth->isLoggedIn();
$user = $auth->getUser();
$showAdminFeatures = $user && $user->role === 'admin';

require_once 'models/products.php';

$products = [];
$pageTitle = "Doomino's | Products";
try {
	$productModel = new Product();
	$products = $productModel->getProducts();
} catch (Exception $e) {
	header("Location: status.php?success=0&message={$e->getMessage()}");
	exit;
}
$pageTitle = "Doomino's | Products";
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			Products
		</h1>
		<p class="mt-1 text-muted">Products in the menu.</p>
	</div>

	<?php if (count($products) === 0) { ?>
		<p class="border border-line bg-white px-4 py-8 text-center text-muted">
			No products yet.
			<a class="text-dominos-blue underline-offset-2 hover:underline" href="index.php">Browse the Home page</a>
		</p>
	<?php } else { ?>

		<?php if ($showAdminFeatures): ?>
			<a class="w-20 justify-self-end justify-center mr-0 grow-0 flex mb-2 shrink-0 rounded-full bg-white px-3 py-1.5 font-display  font-normal text-xs tracking-wider text-dominos-blue no-underline hover:bg-sky-50 sm:px-4 sm:text-sm md:order-none md:ml-auto"
				href="product_edit.php">Add</a>
		<?php endif; ?>
		<div class="overflow-x-auto border border-line bg-white">

			<table class="w-full min-w-[640px] text-left text-sm">
				<thead class="bg-dominos-blue text-white">
					<tr>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">#</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Name</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Tag</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Des</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">price</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">image</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">stock</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">action</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($products as $product) {
						$imgUrl = str_starts_with($product->pic, 'https://') ? $product->pic : 'images/' . $product->pic;
						?>
						<tr class="border-t border-line">
							<td class="px-3 py-2">
								<?php echo (int) $product->id; ?>
							</td>
							<td class="px-3 py-2">
								<?php echo htmlspecialchars($product->name); ?>
								<br />

							</td>
							<td class="px-3 py-2">
								<?php echo htmlspecialchars($product->tag); ?>
							</td>
							<td class="px-3 py-2">
								<?php echo htmlspecialchars($product->description); ?>
							</td>
							<td class="px-3 py-2">
								<?php echo htmlspecialchars($product->price); ?>
							</td>
							<td class="px-3 py-2">
								<img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="<?php echo htmlspecialchars($product->name); ?>"
									class="h-10 w-10 rounded object-cover" />
							</td>
							<td class="px-3 py-2">
								<?php echo $product->stock; ?>
							</td>
							<td class="px-3 py-2">
								<?php if ($showAdminFeatures): ?>
									<a href="product_edit.php?id=<?php echo $product->id; ?>" class="text-dominos-blue underline-offset-2 hover:underline">Edit</a>
								<?php else: ?>
									<span class="text-muted">#</span>
								<?php endif; ?>
							</td>

						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
</main>

<?php require_once 'templates/footer.php'; ?>