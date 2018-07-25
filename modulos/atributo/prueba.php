<?php
echo $test=$_POST['test'];
	if ($test){
	 foreach ($test as $t){echo 'You selected ',$t,'<br />';}
	}
?>
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<select name="test" multiple="multiple">
	<option value="one">one</option>
	<option value="two">two</option>
	<option value="three">three</option>
	<option value="four">four</option>
	<option value="five">five</option>
</select>
<select name="test" multiple="multiple">
	<option value="2one">one</option>
	<option value="2two">two</option>
	<option value="2three">three</option>
	<option value="2four">four</option>
	<option value="2five">five</option>
</select>
<input type="submit" value="Send" />
</form>