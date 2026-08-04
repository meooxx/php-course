<?php
require_once 'models/Auth.php';
$auth = new Auth();
// main project requirement: only logged-in users can view products
$isLoggedIn = $auth->isLoggedIn();
$user = $auth->getUser();
$showAdminFeatures = $auth->isAdmin();

require_once 'models/products.php';

$products = [];
$pageTitle = "Doomino's | Products";
$pageDescription = 'Browse available pizzas and other products.';
try {
	$productModel = new Product();
	$products = $productModel->getProducts();
} catch (Exception $e) {
	header("Location: status.php?success=0&message={$e->getMessage()}");
	exit;
}

$totalProducts = count($products);


$pageTitle = "Doomino's | Products";
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="flex flex-wrap items-end justify-between gap-3 pb-4 pt-7">
		<div>
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
				Inventory
			</h1>
			<p class="mt-1 text-muted">Stock board for menu items.</p>
		</div>
		<?php if ($showAdminFeatures): ?>
			<a class="shrink-0 rounded-full bg-dominos-blue px-4 py-1.5 font-display text-sm tracking-wider text-white no-underline hover:bg-dominos-blue-deep"
				href="product_edit.php">+ Add item</a>
		<?php endif; ?>
	</div>

	<?php if ($totalProducts === 0) { ?>
		<p class="border border-line bg-white px-4 py-8 text-center text-muted">
			No products yet.
			<a class="text-dominos-blue underline-offset-2 hover:underline" href="index.php">Browse the Home page</a>
		</p>
	<?php } else { ?>
		<ul class="flex flex-col gap-3">
			<?php foreach ($products as $product) {
				$imgUrl = str_starts_with($product->pic, 'https://') ? $product->pic : 'images/' . $product->pic;
				$stock = isset($product->stock) ? (int) $product->stock : 0;
				if ($stock <= 0) {
					$statusLabel = 'Sold out';
					$statusClass = 'bg-dominos-red text-white';
					$qtyClass = 'text-dominos-red';
				} elseif ($stock <= 10) {
					$statusLabel = 'Low';
					$statusClass = 'bg-amber-500 text-white';
					$qtyClass = 'text-amber-600';
				} else {
					$statusLabel = 'In stock';
					$statusClass = 'bg-emerald-600 text-white';
					$qtyClass = 'text-emerald-700';
				}
				?>
				<li class="rounded-sm overflow-hidden border border-line bg-white">
					<div class="flex flex-col sm:flex-row">
						<div class="relative h-36 shrink-0 overflow-hidden bg-neutral-200 sm:h-auto sm:w-36 md:w-44">
							<img class="h-full w-full object-cover" src="<?php echo htmlspecialchars($imgUrl); ?>"
								alt="<?php echo htmlspecialchars($product->name); ?>" width="400" height="400" />
						</div>

						<div class="flex min-w-0 flex-1 flex-col gap-2 p-3.5 sm:p-4">
							<div class="flex flex-wrap items-start justify-between gap-2">
								<div class="min-w-0">
									<p class="text-xs text-muted">#<?php echo (int) $product->id; ?> ·
										<?php echo htmlspecialchars($product->tag); ?>
									</p>
									<h3 class="font-display text-xl uppercase tracking-wide text-dominos-blue">
										<?php echo htmlspecialchars($product->name); ?>
									</h3>
								</div>
								<span class="shrink-0 font-display text-2xl text-dominos-blue">
									$<?php echo htmlspecialchars($product->price); ?>
								</span>
							</div>

							<p class="line-clamp-2 text-sm text-muted">
								<?php echo htmlspecialchars($product->description); ?>
							</p>

							<div class="mt-auto flex flex-wrap items-end justify-between gap-3 pt-1">
								<div class="flex items-center gap-2">
									<span class="rounded-sm <?php echo $statusClass; ?> px-2 py-0.5 font-display text-[10px] uppercase tracking-wider">
										<?php echo $statusLabel; ?>
									</span>
									<span class="font-display text-sm tracking-wide <?php echo $qtyClass; ?>">
										<?php echo $stock <= 0 ? '0 left' : $stock . ' left'; ?>
									</span>
								</div>

								<?php if ($showAdminFeatures): ?>
									<div class="flex items-center gap-2">
										<a href="product_edit.php?id=<?php echo (int) $product->id; ?>"
											class="rounded-sm border border-dominos-blue px-3 py-1.5 font-display text-xs uppercase tracking-wider text-dominos-blue no-underline hover:bg-sky-50">Edit</a>
										<form method="POST" action="product_edit.php" class="inline">
											<input type="hidden" name="deleteId" value="<?php echo (int) $product->id; ?>" />
											<input type="hidden" name="action" value="delete" />
											<button type="submit"
												class="rounded-sm border border-dominos-red px-3 py-1.5 font-display text-xs uppercase tracking-wider text-dominos-red hover:bg-red-50">Del</button>
										</form>
									</div>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</li>
			<?php } ?>
		</ul>
	<?php } ?>
</main>

<?php require_once 'templates/footer.php'; ?>