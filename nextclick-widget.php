<?php
/*
Plugin Name: Nextclick Widget
Plugin URI: http://iworks.pl/
Description: Generates a widget to the nextclick.pl
Author: Marcin Pietrzak
Version: trunk
Author URI: http://iworks.pl
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/*

Copyright 2012 Marcin Pietrzak (marcin@iworks.pl)

this program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

 */

class Nextclick_Widget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'nextclick_widget', // Base ID
            'Nextclick_Widget', // Name
            array( 'description' => __( 'Nextclick', 'nextclick_widget' ), ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        extract( $args );
        $key = apply_filters( 'nextclick_key', $instance['key'] );
        if ( empty( $key ) ) {
            return;
        }
        echo $before_widget;
?>
<script type="text/javascript" data-key="<?php echo $key; ?>">

  var __nc_widgets = __nc_widgets || [];
  var __nc_j = __nc_j || null;

  __nc_widgets.push(['<?php echo $key; ?>', '<?php echo $_SERVER['HTTP_HOST']; ?>', 'recommendation', 1, 1]);

  (function() {
    var __nc = document.createElement('script'); __nc.type = 'text/javascript'; __nc.async = true; __nc.id = 'Nextclick_Manager';
    __nc.src = 'http://nextclick.pl/widget/widget.recommendation.1.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(__nc, s);
  })();
</script>
<?php
        echo $after_widget;
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['key'] = strip_tags( $new_instance['key'] );
        return $instance;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $key = '';
        if ( isset( $instance[ 'key' ] ) ) {
            $key = $instance[ 'key' ];
        }
        ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'key' ); ?>"><?php _e( 'key:' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id( 'key' ); ?>" name="<?php echo $this->get_field_name( 'key' ); ?>" type="text" value="<?php echo esc_attr( $key ); ?>" placeholder="<?php _e( 'Nextclick Key', 'nextclick_widget' ); ?>"/>
        </p>
        <?php 
    }

} // class Nextclick_Widget

add_action( 'widgets_init', create_function( '', 'register_widget( "nextclick_widget" );' ) );

