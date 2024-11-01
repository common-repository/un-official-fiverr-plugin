<?php
// A class which will add and display a widget on the sidebar.
class fiverrWidgetSidebar extends WP_Widget
{
    function fiverrWidgetSidebar()
    {
        $fiverrWidgetData = array(
            'classname'   => 'widget_fiverr',
            'description' => 'Display your Fiverr account widget, with the latest gigs you own and favorite.'
        );
        
        $this->WP_Widget( 'fiverr_widget', 'Fiverr Account Widget', $fiverrWidgetData );
	}

	function form( $fiverrWidgetOptions )
    {
		$fiverrWidgetDefaults = array( 
            'username' => 'guest',
            'gigs'     => 5,
            'likes'    => 3,
            'height'   => 300,
            'width'    => 500
        );
        
        $fiverrWidgetOptions = wp_parse_args( (array) $fiverrWidgetOptions, $fiverrWidgetDefaults );
        
        $fiverr['username']        = esc_attr( secureVar( $fiverrWidgetOptions['username']     ) );
        $fiverr['user_gigs']       = esc_attr( secureVar( $fiverrWidgetOptions['gigs']  , true ) );
        $fiverr['user_likes']      = esc_attr( secureVar( $fiverrWidgetOptions['likes'] , true ) );
        $fiverr['widget_height']   = esc_attr( secureVar( $fiverrWidgetOptions['height'], true ) );
        $fiverr['widget_width']    = esc_attr( secureVar( $fiverrWidgetOptions['width'] , true ) );
        
        echo "<p>";
        echo "  <label for='" . $this->get_field_id('username') . "'>Username:</label>";
        echo "  <input class='widefat' id='" . $this->get_field_id('username') . "' name='" . $this->get_field_name('username') . "' type='text' value='{$fiverr['username']}' />";
        echo "</p>";
        echo "<p>";
        echo "  <label for='". $this->get_field_id( 'gigs' ) ."'>No. of user Gigs:</label>";
        echo "  <input class='widefat' id='". $this->get_field_id( 'gigs' ) ."' name='". $this->get_field_name( 'gigs' ) ."' type='text' value='{$fiverr['user_gigs']}' />";
        echo "</p>";
        echo "<p>";
        echo "  <label for='". $this->get_field_id( 'likes' ) ."'>No. of user liked Gigs:</label>";
        echo "  <input class='widefat' id='". $this->get_field_id( 'likes' ) ."' name='". $this->get_field_name( 'likes' ) ."' type='text' value='{$fiverr['user_likes']}' />";
        echo "</p>";
        echo "<p>";
        echo "  <label for='". $this->get_field_id( 'height' ) ."'>Widget height:</label>";
        echo "  <input class='widefat' id='". $this->get_field_id( 'height' ) ."' name='". $this->get_field_name( 'height' ) ."' type='text' value='{$fiverr['widget_height']}' />";
        echo "<small><i>Do not add 'px', only number.</i></small>";
        echo "</p>";
        echo "<p>";
        echo "  <label for='". $this->get_field_id( 'width' ) ."'>Widget width:</label>";
        echo "  <input class='widefat' id='". $this->get_field_id( 'width' ) ."' name='". $this->get_field_name( 'width' ) ."' type='text' value='{$fiverr['widget_width']}' />";
        echo "<small><i>Do not add 'px', only number.</i></small>";
        echo "</p>";
	}

	function update( $fiverrWidgetNewOptions, $fiverrWidgetOldOptions ) 
    {
		$fiverrWidgetDefaults = array( 
            'username' => 'guest',
            'gigs'     => 5,
            'likes'    => 3,
            'height'   => 300,
            'width'    => 500
        );
        
        $fiverr['username'] = esc_attr( secureVar( $fiverrWidgetNewOptions['username']     ) );
        $fiverr['gigs']     = esc_attr( secureVar( $fiverrWidgetNewOptions['gigs']  , true ) );
        $fiverr['likes']    = esc_attr( secureVar( $fiverrWidgetNewOptions['likes'] , true ) );
        $fiverr['height']   = esc_attr( secureVar( $fiverrWidgetNewOptions['height'], true ) );
        $fiverr['width']    = esc_attr( secureVar( $fiverrWidgetNewOptions['width'] , true ) );
        
        $fiverr['username'] = ( trim( $fiverr['username'] ) == '' )?$fiverrWidgetDefaults['username']:$fiverr['username'];
        $fiverr['gigs']     = ( $fiverr['gigs']             < 0   )?$fiverrWidgetDefaults['gigs']    :$fiverr['gigs'];
        $fiverr['likes']    = ( $fiverr['likes']            < 0   )?$fiverrWidgetDefaults['likes']   :$fiverr['likes'];
        $fiverr['height']   = ( $fiverr['height']           < 0   )?$fiverrWidgetDefaults['height']  :$fiverr['height'];
        $fiverr['width']    = ( $fiverr['width']            < 0   )?$fiverrWidgetDefaults['width']   :$fiverr['width'];
        
        return $fiverr;
	}

	function widget( $args, $fiverrWidgetOptions ) 
    {   
        extract($args, EXTR_SKIP);

        if( $fiverrWidgetOptions['height'] > 0 )
        {
            $widgetStyle .= " height: {$fiverrWidgetOptions['height']}px;";
        }
        if( $fiverrWidgetOptions['width'] > 0 )
        {
            $widgetStyle .= " width: {$fiverrWidgetOptions['width']}px;";
        }   
        
        echo $before_widget;
		echo "<div style='{$widgetStyle}'>";
        echo "  <script type=\"text/javascript\" src=\"http://fiverr.com/widget?username={$fiverrWidgetOptions['username']}&type=fv&gigs_count={$fiverrWidgetOptions['gigs']}&liked_gigs_count={$fiverrWidgetOptions['likes']}\"></script>";
        echo "</div>";
        echo "<div style='clear: both;'></div>";
        echo $after_widget;
	}

}

// Registering the widget so WordPress will process it.
add_action( 'widgets_init', 'fiverrWidgetRegister' );

function fiverrWidgetRegister()
{
    return register_widget( 'fiverrWidgetSidebar' );
}
?>