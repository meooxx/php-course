<?php
require_once 'models/Order.php';

$orders = [];

try {
	$orderModel = new Order();
	$orders = $orderModel->getOrders();
} catch (Exception $e) {
	header("Location: status.php?success=0&message={$e->getMessage()}");
	exit;
}
$pageTitle = "Doomino's | Orders";
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			Orders
		</h1>
		<p class="mt-1 text-muted">Recent pizza orders from the menu.</p>
	</div>

	<?php if (count($orders) === 0) { ?>
		<p class="border border-line bg-white px-4 py-8 text-center text-muted">
			No orders yet.
			<a class="text-dominos-blue underline-offset-2 hover:underline" href="shop.php">Browse the menu</a>
		</p>
	<?php } else { ?>
		<div class="overflow-x-auto border border-line bg-white">
			<table class="w-full min-w-[640px] text-left text-sm">
				<thead class="bg-dominos-blue text-white">
					<tr>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">#</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Customer</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Item</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">IMG</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Size</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Qty</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Method</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">When</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($orders as $order) {
						$imgUrl = str_starts_with($order->product_image, 'https://') ? $order->product_image : 'images/' . $order->product_image; ?>
						<tr class="border-t border-line">
							<td class="px-3 py-2"><?php echo (int) $order->id; ?></td>
							<td class="px-3 py-2">
								<?php echo htmlspecialchars($order->name); ?>
								<br />
								<span class="text-xs text-muted"><?php echo htmlspecialchars($order->email); ?></span>
							</td>
							<td class="px-3 py-2">
								<?php echo htmlspecialchars($order->product_name ?? 'Product #' . $order->product_id); ?>
							</td>
							<td class="px-3 py-2">
								<img class="aspect-square w-full max-w-[50px] rounded-md border border-line object-cover"
									src="<?php echo $imgUrl; ?>" alt="Product Image" />
							</td>
							<td class="px-3 py-2"><?php echo htmlspecialchars($order->size); ?></td>
							<td class="px-3 py-2"><?php echo (int) $order->quantity; ?></td>
							<td class="px-3 py-2"><?php echo htmlspecialchars($order->fulfillment); ?></td>
							<td class="px-3 py-2 text-muted">
								<?php echo htmlspecialchars($order->created_at ?? ''); ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	<?php } ?>
</main>

<?php require_once 'templates/footer.php'; ?>