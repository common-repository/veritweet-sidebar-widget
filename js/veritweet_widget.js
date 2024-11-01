jQuery(document).ready(function() {
			main_loop();
		});
		
		function main_loop() {
			new_tweets();
			setTimeout('main_loop()', 15 * 1000);
		}
		
		function new_tweets() {
			var json = JSON.parse(jQuery("#json").html());
			//alert( json.widget.USERID );
			jQuery.get(jQuery("#get_posts").html(), { "channel_id":json.widget.USERID, "limit":json.widget.TweetCount },
				
				function(data) {
					jQuery("#MsgContainer").html("");
					var j = 0;
					//alert(data.channel.ppic_m);
					jQuery("#alt_photo").attr("src", data.channel.ppic_m);
					jQuery("#alt_photo").attr("alt", data.channel.channel_name);
					jQuery("#VeritweetWidgetBottomButton").attr("href", "http://www.veritweet.com/profile/"+json.widget.USERID+"/"+data.channel.channel_name+"");
					var VeritweetChannelName = jQuery("#VeritweetChannelName").html();
					if ( VeritweetChannelName == "" ) jQuery("#VeritweetChannelName").html(data.channel.channel_name);
					if ( parseInt(data.channel.verified) > 1 ) {
						jQuery("#VeritweetChannelVerifiedText").html("Verified channel");
					} else {
						jQuery("#VeritweetChannelVerifiedText").html("Unverified channel");
					}
					if (data.channel.verified > 1) {
					for(var i=0; i < data.updates.length; i++) {
						//if (j > 0) jQuery("#data1").append("<br />");
						var time = formatTime(data.updates[i].time_added);
						var msg = data.updates[i].msg;
						
						var replacePattern = /(\b(http?|https?|ftp):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/gim; 
						msg = msg.replace(replacePattern, '<span class="blue">$1</span>');
						//twitter usernames
						replacePattern = /(@([a-zA-Z0-9_]+))/gim;
						msg = msg.replace(replacePattern, '<span class="blue">$1</span>');
						//veritweet usernames (.username)
						replacePattern = / (\.[a-zA-Z0-9_.]*)/g;
						msg = msg.replace(replacePattern, ' <span class="blue">$1</span>');
						//twitter hastags (#hashtag)		
						msg = msg.replace(/(^|\s)#(\w+)/g, '$1<span class="blue">#$2</span>');
						
						var imageurl = data.updates[i].user.ppic;
						imageurl =  imageurl.replace("-l.jpg", "-s.jpg");
						
						var image = '<img class="VeritweetProfileImage" alt="'+data.updates[i].user.username+'" src="'+imageurl+'">';
						//image = "";
						
						jQuery("#MsgContainer").append("<div>"+image+"<a class=\"latesttweet\"  target=\"_blank\" href=\"http://www.veritweet.com/update/"+data.updates[i].id+"\">"+msg+"</a><br /><div class=\"details\"><a class=\"latestchannel\" target=\"_blank\" href=\"http://www.veritweet.com/profile/"+data.updates[i].user.userid+"/"+data.updates[i].user.username+"\">"+data.updates[i].user.username+"</a>&nbsp;&nbsp;<span class=\"laiks\">"+time+"</span></div></div>");
						j++;
					}
					} else {
						jQuery("#MsgContainer").html("<div>Channel not verified! Please verify to view posts!</div>");
					}
				}, 
				"json"
			);
		}
		
		var formatTime = function(timestamp) {
			var t = timestamp*1000;
		
			var now = new Date();
			var nt = now.getTime();
			var pt =parseInt(t);
			var diff = parseInt((now.getTime() - pt) / 1000);
		
			if (diff < 60) { return diff.toString() + " seconds ago"; }
				else if (diff < 120) { 		return 'less than minute ago'; }
				else if (diff < (2700)) { 	return (parseInt(diff / 60)).toString() + ' minutes ago'; }
				else if (diff < (5400)) { 	return 'about an hour ago'; }
				else if (diff < (7200)) { 	return 'about 2 hours ago'; }
				else if (diff < (86400)) { 	return 'about ' + (parseInt(diff / 3600)).toString() + ' hours ago'; }
				else if (diff < (172800)) { return '1 day ago'; } 
				else {return (parseInt(diff / 86400)).toString() + ' days ago'; }
		}