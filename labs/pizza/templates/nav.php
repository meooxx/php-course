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

$navLink = 'shrink-0 whitespace-nowrap rounded-sm inline-block font-display text-xs uppercase tracking-widest no-underline px-3 py-2 text-sm';
?>

<body class="min-w-[320px] overflow-x-auto bg-cream font-body text-ink antialiased">
	<header class="bg-dominos-blue text-white">
		<div class="mx-auto flex max-w-[980px] flex-wrap items-center gap-x-3 gap-y-2 px-4 py-2 md:flex-nowrap">
			<a class="flex shrink-0 items-center gap-2 text-white no-underline hover:text-white" href="index.php">
				<img class="h-9 w-9" src="images/logo.svg" width="36" height="36" alt="" />
				<span class="hidden font-display text-xl uppercase tracking-wider min-[375px]:inline">Doomino's</span>
			</a>
			<nav
				class="order-3 w-full min-w-0 basis-full overflow-x-auto [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden md:order-none"
				aria-label="Primary"
			>
				<ul class="flex w-max flex-nowrap gap-0.5 md:w-auto">
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'index.php', true); ?>" href="index.php">Home</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'about.php'); ?>" href="about.php">About</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'shop.php'); ?>" href="shop.php">Menu</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'contact.php'); ?>" href="contact.php">Contact</a>
					</li>
					<li>
						<a class="<?php echo $navLink . ' ' . getActiveClass($current, 'orders.php'); ?>" href="orders.php">Orders</a>
					</li>
				</ul>
			</nav>
			<a
				class="order-2 ml-auto shrink-0 rounded-full bg-white px-3 py-1.5 font-display text-xs uppercase tracking-wider text-dominos-blue no-underline hover:bg-sky-50 sm:px-4 sm:text-sm md:order-none md:ml-auto"
				href="shop.php"
			>Order Online</a>
		</div>
	</header>
