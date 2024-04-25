<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
</head>

<style>
	body {
		margin-top: 5vh;
		padding: 0;
		display: flex;
		justify-content: center;
		align-items: center;
	}
</style>

<body>
	<table>
		<tr>
			<td>
				<!-- Login Form -->
				<table style="border: 2px solid black; padding: 30px;">
					<tr>
						<td>
							<form action="/login" method="POST">
								<table>
									<tr>
										<td style="text-align: right; padding: 5px;">Username</td>
										<td><input type="text" name="username"></td>
									</tr>
									<tr>
										<td style="text-align: right; padding: 5px;">Password</td>
										<td><input type="password" name="password"></td>
									</tr>
									<tr>
										<td></td>
										<td style="padding-top: 5px;">
											<input type="submit" value="Login">
										</td>
									</tr>
								</table>
							</form>
						</td>
					</tr>
					<?php if (!is_null($error)) : ?>
						<tr>
							<td style="text-align: center;">
								<!-- Message Box -->
								<table style="border: 2px solid black; padding: 10px; margin: 0 auto; margin-top: 4vh; width: 100%">
									<tr>
										<td>
											<?= $error ?>
										</td>
									</tr>
								</table>
								<!-- Message Box -->
							</td>
						</tr>
					<?php endif; ?>
				</table>
				<!-- Login Form -->
			</td>
		</tr>
	</table>
</body>

</html>