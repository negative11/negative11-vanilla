<style type="text/css">
.main{width:65%;border:2px solid #000;padding:10px;margin:10px auto 10px auto;font-family:courier;}
.result{padding:10px;margin:10px;border:1px solid #000;}
.pass{background-color:#B4E9B5;}
.fail{background-color:#ECA3A3;}
</style>
<div class="main <?=$outcome;?>">
<strong>
Outcome: <?=strtoupper($outcome);?>
<br/>
Generated <?=date('r');?>
<br/>
Status: <?=$status;?>
<br/>
Passes: <?=$passes;?>
<br/>
Fails: <?=$fails;?>
<br/>
Total: <?=$test_count;?>
<br/>
</strong>
</div>
<div class="main">
<?php
if (count($results))
{
	foreach ($results as $result)
	{
		?>
		<div class="result <?=$result->outcome;?>">
		<h2><?=$result->test;?>()</h2>
		<h3><?=strtoupper($result->outcome);?><h3>
		<?php
		if (isset($result->error))
		{
			?>
			<p><?=$result->error;?></p>
			<?php
		}
		?>
		</div>
		<?php
	}
}
else
{
	?>
	<p>No tests to run.</p>
	<?php
}
?>
</div>