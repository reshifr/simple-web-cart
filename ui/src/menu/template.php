<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home</title>
</head>

<style>
	body {
		margin-top: 5vh;
		padding: 0;
		display: flex;
		justify-content: center;
		align-items: center;
	}

	/* 
	table {
		border: 1px solid black
	} */
</style>

<body>
	<table style="border-collapse: collapse; width: 960px;">
		<tr>
			<td style="border: 2px solid black; height: 5vh;">
			</td>
		</tr>
		<!-- Menu -->
		<tr>
			<td style="border: 2px solid black;">
				<table style="border: 0; padding: 5px;">
					<tr>
						<td style="padding-left: 5px; padding-right: 5px;">
							<a href="/menu/product">Product</a>
						</td>
						<td>|</td>
						<td style="padding-left: 5px; padding-right: 5px;">
							<a href="/menu/history">History</a>
						</td>
						<td style="text-align: right; padding-right: 5px; width: 100%;">
							<a href="/menu/cart">
								<img src="/menu/cart-icon.png" alt="cart-icon" style="width: 30px; height: 30px;">
							</a>
						</td>
				</table>
			</td>
		</tr>
		<!-- Menu -->

		<!-- Cart -->
		<?php if (!empty($items)) : ?>
			<tr>
				<td style="border: 2px solid black;">
					<table style="padding: 5px; width: 100%;">
						<?php
						foreach ($items as $item) :
							$itemImageUrl = $item['image_url'] ?? null;
							$itemName = $item['name'] ?? null;
							$itemAmount = $item['amount'] ?? null;
							$itemPrice = $item['price'] ?? null;
							$itemSubTotal = $priceFmt->formatCurrency((float)$itemAmount * $itemPrice, "IDR");
							$itemPrice = $priceFmt->formatCurrency((float)$itemPrice, "IDR");
						?>
							<tr>
								<td>
									<table style="padding: 10px; margin: 5px; border: 2px solid black; width: calc(100% - 10px);">
										<tr>
											<td style="width: 50%;">
												<img src="<?= $itemImageUrl ?>" alt="product-name" style="height: 100px; aspect-ratio: 1/1; object-fit: scale-down;">
											</td>
											<td style="width: 22%;">
												<table>
													<tr>
														<td style="padding: 5px;">Product: <?= $itemName ?></td>
													</tr>
													<tr>
														<td style="padding: 5px;">Price: <?= $itemPrice ?></td>
													</tr>
													<tr>
														<td style="padding: 5px;">Amount: <?= $itemAmount ?></td>
													</tr>
												</table>
											</td>
											<td style="padding: 5px; text-align: left">Subtotal: <?= $itemSubTotal ?></td>
										</tr>
									</table>
								</td>
							</tr>
						<?php endforeach; ?>
						<tr>
							<td style="padding-left: 10px; padding-top: 10px">Total: <?= $total ?></td>
						</tr>
						<tr>
							<td style="padding-left: 10px; padding-top: 10px">You will get: <?= $coupons ?> Coupons</td>
						</tr>
						<form action="/menu/history" method="POST">
							<tr>
								<td style="padding: 10px;"><input type="submit" value="Checkout"></td>
							</tr>
						</form>
					</table>
				</td>
			</tr>
		<?php endif; ?>

		<!-- Cart -->




		<!-- Product -->
		<?php if (!empty($products)) : ?>
			<tr>
				<td style="border: 2px solid black;">
					<table style="padding: 5px; width: 100%;">
						<?php for ($i = 0; $i < $productsLine; ++$i) : ?>
							<tr>
								<?php for ($j = 0; $j < $productsNum; ++$j) : ?>
									<td style="width: 20%;">
										<?php
										$product = $products[$i * $productsNum + $j] ?? null;
										$productId = $product['id'] ?? null;
										$productName = $product['name'] ?? null;
										$productImageUrl = $product['image_url'] ?? null;
										$productPrice = $priceFmt->formatCurrency((float)($product['price'] ?? null), "IDR");
										if (!is_null($product)) :
										?>
											<table style="padding: 10px; margin: 5px; border: 2px solid black;">
												<tr>
													<td>
														<img src="<?= $productImageUrl ?>" alt="product-name" style="width: 100%; aspect-ratio: 1/1; object-fit: scale-down;">
													</td>
												</tr>
												<tr>
													<td style="padding-top: 15px; text-align: center;">
														<?= $productName ?>
													</td>
												</tr>
												<tr>
													<td style="padding-top: 15px; text-align: center;">
														<?= $productPrice ?>
													</td>
												</tr>
												<form action="/menu/cart" method="POST">
													<tr>
														<td style="padding-top: 10px; text-align: center;">
															<input type="hidden" name="id" value="<?= $productId ?>">
															<input type="number" name="amount" value="1" min="1" max="100" style="width: 30%;">
														</td>
													</tr>
													<tr>
														<td style="padding-top: 10px; text-align: center;">
															<input type="submit" value="Add to Cart">
														</td>
													</tr>
												</form>
											</table>
										<?php endif; ?>
									</td>
								<?php endfor; ?>
							</tr>
						<?php endfor; ?>
					</table>
				</td>
			</tr>
		<?php endif; ?>
		<!-- Product -->
		<tr>
			<td style="border: 2px solid black; padding: 5px; text-align: center;">
				2024 (C) Renol P. H.
			</td>
		</tr>
	</table>
</body>

</html>