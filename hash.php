<?php
if($_SERVER['REQUEST_METHOD'] == "POST")
{
	echo password_hash($_POST['haslo'], PASSWORD_DEFAULT);
}
else
{
	?>
	<form action="hash.php" method="post">
	<input type="text" name="haslo">
	<input type="submit" value="OK">
	</form
	?>
	<?php
}

?>