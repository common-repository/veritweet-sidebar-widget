<?php
/*
Plugin Name: Veritweet
Plugin URI: http://www.veritweet.com
Description: View your Veritweet.com channel posts
Version: 0.01
Author: Ä¢irts Beiers
Author URI: 
License: GPL2
*/

$Veritweet = new Veritweet();

class Veritweet
{
	function Veritweet()
	{
		add_action('widgets_init', array($this,'InitializeWidget'));
	}
	
	function InitializeWidget()
	{
		require_once('VeritweetWidget.php'); // Include the widget file
		register_widget('VeritweetWidget'); // Register the widget 'VeritweetWidget' is the class name of the widget.
	}
}




?>