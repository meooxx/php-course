<?php
$current = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : '';

function getActiveClass($current, $path, bool $ishome = false): string
{
	$normal = 'text-white hover:bg-white/15';
	$active = 'bg-white text-dominos-blue hover:bg-sky-50';
	if ($ishome && ($current === '/' || str_contains($current, 'index.php'))) {
		return $active;
	}
	return str_contains($current, $path) ? $active : $normal;
}
?>

<body class="bg-cream font-body text-ink antialiased">
	<header class="bg-dominos-blue text-white">
		<div class="mx-auto flex min-h-14 max-w-[980px] flex-wrap items-center gap-3 px-4 py-1.5">
			<a class="flex items-center gap-2 text-white no-underline hover:text-white" href="index.php">
				<img class="h-9 w-9" src="images/logo.svg" width="36" height="36" alt="" />
				<span class="font-display text-xl uppercase tracking-wider">Doomino's</span>
			</a>
			<nav class="flex-1" aria-label="Primary">
				<ul class="flex flex-wrap gap-0.5">
					<li>
						<a class="rounded-sm inline-block px-3 py-2 font-display text-sm uppercase tracking-widest no-underline <?php echo getActiveClass($current, 'index.php', true); ?>"
							href="index.php" aria-current="page">Home</a>
					</li>
					<li>
						<a class="rounded-sm inline-block px-3 py-2 font-display text-sm uppercase tracking-widest no-underline <?php echo getActiveClass($current, 'about.php'); ?>"
							href="about.php">About</a>
					</li>
					<li>
						<a class="rounded-sm inline-block px-3 py-2 font-display text-sm uppercase tracking-widest no-underline <?php echo getActiveClass($current, 'shop.php'); ?>"
							href="shop.php">Menu</a>
					</li>
					<li>
						<a class="rounded-sm inline-block px-3 py-2 font-display text-sm uppercase tracking-widest no-underline  <?php echo getActiveClass($current, 'contact.php'); ?>"
							href="contact.php">Contact</a>
					</li>
					<li>
						<a class="rounded-sm inline-block px-3 py-2 font-display text-sm uppercase tracking-widest no-underline <?php echo getActiveClass($current, 'orders.php'); ?>"
							href="orders.php">Orders</a>
					</li>
				</ul>
			</nav>
			<a class="rounded-full bg-white px-4 py-1.5 font-display text-sm uppercase tracking-wider text-dominos-blue no-underline hover:bg-sky-50"
				href="shop.php">Order Online</a>
		</div>
	</header>