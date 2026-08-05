<?php
$success = isset($_GET['success']) && (string) $_GET['success'] === '1';
$msg = isset($_GET['message']) ? trim($_GET['message']) : '';
$isSuccess = $success;
$pageTitle = "Doomino's | Status";
$pageDescription = $isSuccess
	? 'Your request was completed successfully.'
	: 'Something went wrong with your request.';
?>
<?php
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>
<main id="main" class="mx-auto max-w-[980px] px-4 py-10">
	<div
		class="border border-line bg-white px-6 py-10 text-center shadow-sm <?php echo $isSuccess ? 'border-green-600' : 'border-dominos-red'; ?>"
		role="status">
		<?php if ($isSuccess) { ?>
			<h1 class="font-display text-3xl uppercase tracking-wide text-green-700">Success</h1>
			<p class="mt-3 text-muted">
				<?php echo ($msg ? htmlspecialchars($msg) : 'Your request was completed successfully.'); ?>
			</p>
		<?php } else { ?>
			<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-red">Failed</h1>
			<p class="mt-3 text-muted">
				<?php echo ($msg ? htmlspecialchars($msg) : 'Something went wrong. Please try again.'); ?>
			</p>
		<?php } ?>
		<a class="mt-6 inline-block rounded-sm bg-dominos-blue px-5 py-2 font-display text-sm uppercase tracking-wider text-white no-underline "
			href="javascript:history.back()">Go back</a>

		<a class="mt-6 inline-block rounded-sm bg-dominos-red px-5 py-2 font-display text-sm uppercase tracking-wider text-white no-underline"
			href="index.php">Back to Home</a>
	</div>
</main>

<?php require_once 'templates/footer.php'; ?>