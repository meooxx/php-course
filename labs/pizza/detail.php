<?php
require_once 'models/products.php';
require_once 'models/Order.php';


$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['product_id']) ? (int) $_POST['product_id'] : 1);

// Save order then redirect
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$success = false;
	$orderModel = new Order();
	$name = trim($_POST['name'] ?? '');
	$email = trim($_POST['email'] ?? '');
	$phone = trim($_POST['phone'] ?? '');
	$productId = (int) ($_POST['product_id'] ?? 0);
	$size = $_POST['size'] ?? 'medium';
	$crust = $_POST['crust'] ?? 'hand_tossed';
	$quantity = max(1, min(99, (int) ($_POST['quantity'] ?? 1)));
	$fulfillment = $_POST['fulfillment'] ?? 'carryout';

	if (empty($name) || empty($email) || empty($phone) || $productId <= 0) {
		$ok = false;
	} else {
		$ok = true;
	}

	if ($ok) {
		try {
			$success = $orderModel->placeOrder([
				'name' => $name,
				'email' => $email,
				'phone' => $phone,
				'product_id' => $productId,
				'size' => $size,
				'crust' => $crust,
				'quantity' => $quantity,
				'fulfillment' => $fulfillment,
			]);
			if ($success) {
				header('Location: status.php?success=1');
				exit;
			} else {
				header('Location: status.php?success=0&message=Failed to place order.');
				exit;
			}
		} catch (Exception $e) {
			header("Location: status.php?success=0&message={$e->getMessage()}");
			exit;
		}



	}
	exit;
}

$product = null;
try {
	$productModel = new Product();
	$product = $productModel->getDetail($id);
	if (!$product) {
		throw new Exception('Product not found');
	}
} catch (Exception $e) {
	error_log("Error fetching product detail: " . $e->getMessage());
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
$pageDescription = "Details for {$name} pizza. Order online now!";
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

	<div class="mb-8 grid gap-6 md:grid-cols-2 items-start ">
		<figure class="border border-line bg-white rounded-md overflow-hidden">
			<img class="aspect-square w-full object-cover" src="<?php echo htmlspecialchars($pic); ?>" width="800"
				height="800" alt="<?php echo htmlspecialchars($name); ?>" />
		</figure>

		<div class="rounded-md overflow-hidden border border-line bg-white p-5" id="order">
			<span
				class="mb-2 inline-block bg-dominos-red px-2 py-0.5 font-display text-xs uppercase tracking-wider text-white rounded-sm overflow-hidden">
				<?php echo htmlspecialchars($tag); ?>
			</span>
			<p class="font-display text-2xl text-dominos-blue">$<?php echo htmlspecialchars((string) $price); ?></p>
			<p class="mb-2 text-sm text-muted">In stock: <?php echo $stock; ?></p>
			<p class="mb-5 text-muted"><?php echo htmlspecialchars($des); ?></p>

			<form action="detail.php?id=<?php echo $id; ?>" method="post">
				<input type="hidden" name="product_id" value="<?php echo (int) $id; ?>" />

				<div class="mb-3">
					<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue" for="customer_name">
						Name
					</label>
					<input class="rounded-sm w-full border border-line bg-cream px-3 py-2" id="customer_name" name="name"
						type="text" required />
				</div>

				<div class="mb-3">
					<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue" for="email">
						Email
					</label>
					<input class="w-full rounded-sm border border-line bg-cream px-3 py-2" id="email" name="email" type="email"
						required />
				</div>

				<div class="mb-3">
					<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue" for="phone">
						Phone
					</label>
					<input class="w-full rounded-sm border border-line bg-cream px-3 py-2" id="phone" name="phone" type="tel"
						required />
				</div>

				<div class="mb-3">
					<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue" for="quantity">
						Qty
					</label>
					<input class="w-full rounded-sm border border-line bg-cream px-3 py-2" id="quantity" name="quantity"
						type="number" min="1" max="99" value="1" required />
				</div>

				<fieldset class="mb-3 border-0 p-0">
					<legend class="mb-2 font-display text-sm uppercase tracking-wider text-dominos-blue">Size</legend>
					<div class="flex flex-wrap gap-2">
						<label
							class="option-chip rounded-sm cursor-pointer border-2 border-line bg-cream px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="size" value="small" /> <span>Small</span>
						</label>
						<label
							class="option-chip rounded-sm cursor-pointer border-2 border-line bg-cream px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="size" value="medium" checked /> <span>Medium</span>
						</label>
						<label
							class="option-chip rounded-sm cursor-pointer border-2 border-line bg-cream px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="size" value="large" /> <span>Large</span>
						</label>
					</div>
				</fieldset>

				<fieldset class="mb-3 border-0 p-0">
					<legend class="mb-2 font-display text-sm uppercase tracking-wider text-dominos-blue">Crust</legend>
					<div class="flex flex-wrap gap-2">
						<label
							class="option-chip rounded-sm cursor-pointer border-2 border-line bg-cream px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="crust" value="hand_tossed" checked /> <span>Hand Tossed</span>
						</label>
						<label
							class="option-chip rounded-sm cursor-pointer border-2 border-line bg-cream px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="crust" value="handmade_pan" /> <span>Handmade Pan</span>
						</label>
					</div>
				</fieldset>

				<fieldset class="mb-4 border-0 p-0">
					<legend class="mb-2 font-display text-sm uppercase tracking-wider text-dominos-blue">Method</legend>
					<div class="flex flex-wrap gap-2">
						<label
							class="option-chip rounded-sm cursor-pointer border-2 border-line bg-cream px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="fulfillment" value="carryout" checked /> <span>Carryout</span>
						</label>
						<label
							class="option-chip rounded-sm rounded-sm cursor-pointer border-2 border-line bg-cream px-3 py-1.5 text-sm font-bold">
							<input type="radio" name="fulfillment" value="delivery" /> <span>Delivery</span>
						</label>
					</div>
				</fieldset>

				<button
					class="rounded-sm w-full bg-dominos-red px-4 py-2 font-display text-sm uppercase tracking-wider text-white hover:bg-red-700"
					type="submit">
					Place Order
				</button>
			</form>
		</div>
	</div>
</main>

<?php require_once 'templates/footer.php'; ?>