<?php

class VeritweetWidget extends WP_Widget
{
	var $plurl;
	
	function VeritweetWidget()
	{
		$this->plurl = trailingslashit(plugins_url(basename(dirname(__FILE__))));
		
		$widget_ops = array('description' => __('Latest veritweet.com posts from veritweet.com channels', 'Veritweet') );
		parent::WP_Widget( 'VeritweetWidget', __('Veritweet Widget','Veritweet'), $widget_ops);
		
		if (is_active_widget(false, false, $this->id_base) ) {
			add_action( 'template_redirect', array($this, 'WidgetCss') );
			add_action( 'template_redirect', array($this, 'add_my_scripts') );
		}
	}
	
	function form($instance)
	{
		$instance = wp_parse_args((array) $instance, array('USERID'=>'','UserName'=>''));
		
		echo '
			<p>
			<label for="'. $this->get_field_id('USERID').'">'.__('Veritweet.com USERID','Veritweet').'</label>
			<input type="text" id="'. $this->get_field_id('USERID').'" name="'. $this->get_field_name('USERID').'" value="'.attribute_escape($instance['USERID']).'" class="widefat" />
			</p>';
		
		echo '
			<p>
			<label for="'. $this->get_field_id('UserName').'">'.__('Widget User Name','Veritweet').'</label>
			<input type="text" id="'. $this->get_field_id('UserName').'" name="'. $this->get_field_name('UserName').'" value="'.attribute_escape($instance['UserName']).'" class="widefat" />
			</p>';
			
		echo '
			<p>
			<label for="'. $this->get_field_id('TweetCount').'">'.__('Number of Tweets in widget','Veritweet').'</TweetCount>
			<input type="text" id="'. $this->get_field_id('TweetCount').'" name="'. $this->get_field_name('TweetCount').'" value="'.attribute_escape($instance['TweetCount']).'" class="widefat" />
			</p>';
		
	}
	
	function update($new_instance, $old_instance)
	{
		$instance['USERID'] = strip_tags($new_instance['USERID']);
		$instance['UserName'] = strip_tags($new_instance['UserName']);
		$instance['TweetCount'] = strip_tags($new_instance['TweetCount']);
		
		return $instance;
	}
	
	function widget( $args, $instance )
	{
		echo '<div style="display:none; " id="get_posts" name="get_posts">'.$this->plurl.'/api.get_posts.php'.'</div>';
		echo '<div style="display:none;" id="json" name="json">{"widget":{"USERID":'.$instance['USERID'].',"UserName":"'.$instance['UserName'].'","TweetCount":'.$instance['TweetCount'].'}}</div>';
				
		echo '<div id="VeritweetWidget">
		<div id="VeritweetWidgetHead">
			<div id="VeritweetChannelImage">
				<img id="alt_photo" alt="" src="">
			</div>
			<div id="VeritweetChannelNameBlock">
				<span id="VeritweetChannelName">'.$instance['UserName'].'</span>
			</div>

		</div>

		<div id="MsgContainer" name="MsgContainer"></div>

		<div id="VeritweetWidgetBottom">
			<img id="VeritweetWidgetBottomLogo" alt="Veritweet" src="'.$this->plurl.'/img/Veritweet-logo-vtw.png">
			<a id="VeritweetWidgetBottomButton" target="_blank" href="http://www.veritweet.com/"'.$instance['UserName'].'">Follow my channel</a>
		</div>
		</div>';
		
	}
	
	function WidgetCss()
	{
		wp_enqueue_style('VeritweetWidget',$this->plurl.'/css/veritweet.css');
	}
	
	function add_my_scripts()
	{
		wp_enqueue_script('jquery');
		wp_register_script('veritweet_widget', $this->plurl.'/js/veritweet_widget.js', array('jquery'), "", true);
		wp_enqueue_script('veritweet_widget');
	}
}



?>