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
	<table style="border-collapse: collapse; width: 70%;">
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
		<!-- Product -->
		<tr>
			<td style="border: 2px solid black;">

				<table style="padding: 5px; width: 100%;">
					<tr>
						<?php for ($i = 0; $i < $dataLine; ++$i) : ?>
							<?php for ($j = 0; $j < $dataNum; ++$j) : ?>
								<td style="width: 20%;">
									<?php
									$product = $data[$i * $dataNum + $j] ?? null;
									if (!is_null($product)) :
									?>
										<table style="padding: 10px; margin: 5px; border: 2px solid black;">
											<tr>
												<td>
													<img src="<?= $product['image_url'] ?>" alt="product-name" style="width: 100%;">
												</td>
											</tr>
											<tr>
												<td style="padding-top: 15px; text-align: center;">
													<?= $product['name'] ?>
												</td>
											</tr>
											<tr>
												<td style="padding-top: 15px; text-align: center;">
													<?= $priceFmt->formatCurrency((float)$product['price'], "IDR") ?>
												</td>
											</tr>
										</table>
									<?php endif; ?>
								</td>
							<?php endfor; ?>
						<?php endfor; ?>
					</tr>
				</table>

			</td>
		</tr>
		<!-- Product -->
		<tr>
			<td style="border: 2px solid black; padding: 5px; text-align: center;">
				2024 (C) Renol P. H.
			</td>
		</tr>
	</table>
</body>

</html>