<?php 
include_once 'config.php';
include_once 'functions.php';
include_once 'db.php';

if(isset($_POST['enable']))
{
	if(is_support_range_download($_POST['url']))
	{
		$db->addUrl($_POST['url']);
		$submitResult = "your link added in download queue.";
	}
	else
	{
		$submitResult = '<div style="color:red" >your link does not support range download</div>';
	}
}
?>

<html>
<body style="text-align: center;">

<table align=center>
	<tr>
		<td>
			<?php echo isset($submitResult) ? $submitResult : ''; ?>
		</td>
	</tr>
	<tr>
		<td>
			<form action="" method="post">
				<input type="hidden" name="enable" value="true">
				<input type="text" size="50" name="url" value="http://">
				<input type="submit" value="Download it!">
			</form>
		</td>
	</tr>
</table>

<table align=center>
<tr>
	<td>id</td>
	<td>link</td>
	<td>status</td>
	<td>log</td>
</tr>
<?php 
$rows = $db->getList();
foreach($rows as $row)
{
	echo '<tr>';
	echo '	<td>' . $row->id . '</td>';
	echo '	<td>' . $row->url . '</td>';
	echo '	<td>' . $row->status . '</td>';
	echo '	<td><a href="showLog.php?id=' . $row->id . ' ">show</a></td>';
	echo '</tr>';
}
?>
</table>
</body>
</html>