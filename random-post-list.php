<?php
/*
Plugin Name: random post list
Plugin URI: http://www.dlinkbring.com/main/labo/wp-random-post-list.html
Description: make random post list and feeling lucky link
Version: 0.2
Author: Rogi073
Author URI: http://d.hatena.ne.jp/dzd12061/
*/
/*  Copyright rogi073 (email : dzd12061@nifty.ne.jp)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
	function rpl_random_lists($num_limit = 5 , $exclude = "" , $date_limit = "" , $echo = true , $list = true){
		$out = "";
		if ( $num_limit < 1 ) $num_limit = "-1";
		if ( !$date_limit_ts = strtotime($date_limit) ) $date_limit = false;
		if ( !$date_limit ){
        	$posts = get_posts('offset=0&numberposts='.$num_limit.'&exclude='.$exclude.'&orderby=rand');
		} else {
        	$posts = get_posts('offset=0&numberposts=-1&exclude='.$exclude.'&orderby=rand');
		}
		$postscount = count($posts);
		if ( $num_limit < 1 ) $num_limit = $postscount;
		if ( $postscount < $num_limit ) $num_limit = $postscount ;
		for ( $i = 0 ; $i < $num_limit ; $i++ ){
			if ( !$date_limit or $date_limit_ts < strtotime( $posts[$i]->post_date )){
				if ( $list ) $out.= '<li class="random-post-link">'."\n";
  				$out.= '<a href="'.get_permalink($posts[$i]->ID).'" title="'.$posts[$i]->post_title.'">'.$posts[$i]->post_title.'</a>'."\n";
				if ( $list ) $out.= '</li>'."\n";
			}else{
				if ( $postscount > $num_limit ) $num_limit++;
			}
		}
		if ( $list ) $out = '<ul class="random-post-link">'."\n".$out.'</ul>'."\n";
		if ( $echo ){
  			echo $out;
		} else {
			return $out;
		}
	}
	function rpl_feelinig_lucky($text = "feeling lucky!" , $exclude = "" , $date_limit = "" , $echo = true ){
        $posts = get_posts('offset=0&numberposts=1&exclude='.$exclude.'&orderby=rand');
		if ( $exclude != "") $excludes[] = $exclude;
		if ( !$date_limit_ts = strtotime($date_limit) ) $date_limit = false;
		if ( $date_limit ){
			$excludes = array();
			while ( $date_limit_ts > strtotime($post->post_date)){
				$excludes[]=$post->ID;
        		$posts = get_posts('offset=0&numberposts=1&exclude='.implode(',',$excludes).'&orderby=rand');
			}
		}
		$out = '<a class="random-post-link" href="'.get_permalink($posts[0]->ID).'">'.$text.'</a>'."\n";
		if ( $echo ){
  			echo $out;
		} else {
			return $out;
		}
	}
?>
