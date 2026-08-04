<?php
require_once 'models/Auth.php';
$auth = new Auth();
$auth->requireAdmin();
// main project requirement: only logged-in users can view products
$isLoggedIn = $auth->isLoggedIn();
$showAdminFeatures = $auth->isAdmin();


require_once 'models/Auth.php';

$users = [];
$pageTitle = "Doomino's | User";
$pageDescription = 'View and manage users in the system.';
try {
	$auth = new Auth();
	$users = $auth->getUsers();
} catch (Exception $e) {
	header("Location: status.php?success=0&message={$e->getMessage()}");
	exit;
}
$pageTitle = "Doomino's | Users";
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			Users
		</h1>
		<p class="mt-1 text-muted">Users in the system.</p>
	</div>
	<a class="w-20 justify-self-end justify-center mr-0 grow-0 flex mb-2 shrink-0 rounded-full bg-white px-3 py-1.5 font-display  font-normal text-xs tracking-wider text-dominos-blue no-underline hover:bg-sky-50 sm:px-4 sm:text-sm md:order-none md:ml-auto"
		href="auth.php?act=register">ADD</a>
	<?php if (count($users) === 0) { ?>
		<p class="border border-line bg-white px-4 py-8 text-center text-muted">
			No users yet.
			<a class="text-dominos-blue underline-offset-2 hover:underline" href="index.php">Browse the Home page</a>
		</p>
	<?php } else { ?>



		<div class="overflow-x-auto border border-line bg-white">

			<table class="w-full min-w-[640px] text-left text-sm">
				<thead class="bg-dominos-blue text-white">
					<tr>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">#</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Name</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Email</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Admin</th>
						<th class="px-3 py-2 font-display text-xs uppercase tracking-wider">Action</th>

					</tr>
				</thead>
				<tbody>
					<?php foreach ($users as $user) { ?>

						<tr class="border-t border-line">
							<td class="px-3 py-2">
								<?php echo $user->id; ?>
							</td>
							<td class="px-3 py-2">
								<?php echo htmlspecialchars($user->username); ?>
								<br />
							</td>

							<td class="px-3 py-2">
								<span>
									<?php echo htmlspecialchars($user->email); ?>
								</span>

							</td>
							<td class="px-3 py-2">
								<?php echo $user->role == 'admin' ? 'Yes' : 'No'; ?>
							</td>
							<td class="px-3 py-2 flex gap-2">
								<?php if ($showAdminFeatures): ?>
									<a href="auth.php?act=update&id=<?php echo $user->id; ?>"
										class="text-dominos-blue underline-offset-2 hover:underline">Edit</a>
									<form method="POST" action="auth.php">
										<input type="hidden" name="action" value="delete" />
										<input type="hidden" name="targetUserId" value="<?php echo $user->id; ?>" />
										<button type="submit" class="text-dominos-red underline-offset-2 hover:underline">Del</button>
									</form>

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