<?php
/**
 * Sample PHP template for displaying output.
 * This is instanced via the controller.
 * Variable assignment and output is handled by the View_Component.
 * 
 * @package core
 */
?>
<html>
	<head>
		<title>Welcome to the negative(-11) PHP Framework!</title>
		<style type="text/css">
		body
		{
			width:65%;
			margin:50px auto 50px auto;
			line-height:1.8em;
		}
		h1, h2
		{
			border-bottom:1px dashed #ccc;
			padding-bottom:.5em;
		}
		</style>
	</head>
	<body>
		<h1>Welcome to the negative(-11) PHP Framework!</h1>
		<p>If you can see this page, then everything is working correctly!</p>
		<h2>Getting Started</h2>
		<p>If you have never worked with this framework before, you should start by reading the <a href="http://negative11.com/documentation">online documentation</a>. The documentation explains the entire framework and provides additional resources in the form of <em>packages</em>, which may be downloaded and installed to provide extended functionality.</p>
		<h2>Unit Tests</h2>
		<?=$examples;?>
		<h2>License</h2>
		<p>This framework is licensed under the GPL version 3. You may modify it and redistribute it as you wish. View the full license <a href="<?=$framework['license'];?>">here</a>.</p>
		<textarea rows="10" cols="80">
This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see &lt;http://www.gnu.org/licenses/&gt;.
		</textarea>
		<h2>About</h2>
		<p>
		Version: <?=$framework['version'];?>
		<br/>
		Codename: <?=$framework['codename'];?>
		<br/>
		Author: <?=$framework['author'];?>
		<br/>
		&copy; <?=$framework['copyright'];?>
		</p>
		<h2>History</h2>
		<p>negative(-11) is inspired by a number of frameworks that its author has worked with in the past. It strives to be lightweight, easy to extend, and a breeze to implement. The name is derived from a long-standing inside joke we won't get into here.</p>
		<h2>Participate</h2>
		<p>Keep up with the latest framework news via <a href="http://strem.in/profile/view/negative11">strem.in</a>. You are encouraged to join in on 
		the discussion and provide feedback or bug reports. If you would like to submit a feature or modification, please contact the <a href="http://johnsquibb.com/contact">maintainer</a></p>
	</body>
</html>