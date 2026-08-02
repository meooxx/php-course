<?php
$pageTitle = "Doomino's | Contact";
require_once 'templates/header.php';
require_once 'templates/nav.php';
?>

<main id="main" class="mx-auto max-w-[980px] px-4 pb-10">
	<div class="pb-4 pt-7">
		<h1 class="font-display text-3xl uppercase tracking-wide text-dominos-blue md:text-4xl">
			Contact
		</h1>
	</div>

	<section class="grid gap-5 pb-6 md:grid-cols-[0.9fr_1.1fr]">
		<aside class="rounded-md bg-dominos-blue p-5 text-white">
			<h2 class="font-display text-2xl uppercase tracking-wide text-white">Demo Store</h2>
			<ul class="mt-4 space-y-4">
				<li>
					<span class="mb-1 block font-display uppercase tracking-wider">Address</span>
					123 Pizza Lab Way<br />
					Toronto, ON M5V 2T6
				</li>
				<li>
					<span class="mb-1 block font-display uppercase tracking-wider">Phone </span>
					(555) 123-4567
				</li>
				<li>
					<span class="mb-1 block font-display uppercase tracking-wider">Hours</span>
					Mon–Sun: 11:00 AM – 11:00 PM
				</li>
			</ul>
		</aside>

		<form class="rounded-md bg-white p-5" action="status.php" method="get">
			<input type="hidden" name="success" value="1" />
			<h2 class="font-display mb-4 text-2xl uppercase tracking-wide text-dominos-blue">
				Send a Message
			</h2>
			<div class="mb-3.5">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue"
					for="name">Name</label>
				<input class="w-full rounded-sm border border-line bg-white px-3 py-2" id="name" name="name" type="text"
					required />
			</div>
			<div class="mb-3.5">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue"
					for="email">Email</label>
				<input class="w-full rounded-sm border border-line bg-white px-3 py-2" id="email" name="email" type="email"
					required />
			</div>
			<div class="mb-4">
				<label class="mb-1 block font-display text-sm uppercase tracking-wider text-dominos-blue"
					for="message">Message</label>
				<textarea class="rounded-sm min-h-[120px] w-full resize-y border border-line bg-white px-3 py-2" id="message"
					name="message" required></textarea>
			</div>
			<button
				class="rounded-sm bg-dominos-blue px-4 py-1.5 font-display text-sm uppercase tracking-wider text-white hover:bg-dominos-blue-deep"
				type="submit">
				Submit
			</button>
		</form>
	</section>
</main>

<?php require_once 'templates/footer.php'; ?>