<?php 
class Restobar_Author_Widget extends WP_Widget {
 	
 	/**
     * Register widget with WordPress.
     */
    public function __construct() {
    	// Add Widget scripts
   		add_action('admin_enqueue_scripts', array($this, 'author_scripts'));

        parent::__construct(
            'author_widget', // Base ID
            'XP Author', // Name
            array( 'description' => esc_html__( 'A Author Widget', 'restobar' ), 'classname' => 'restobar_author-widget' ) // Args
        );
    }
 	
 	public function author_scripts() {
	   wp_enqueue_script( 'media-upload' );
	   wp_enqueue_media();
	   wp_enqueue_script('restobar_upload_media_admin', get_template_directory_uri() . '/inc/backend/js/upload_media_widget.js', array('jquery'));
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
 		// Our variables from the widget settings
        $title = apply_filters( 'widget_title', $instance['title'] );
        $text = ! empty( $instance['text'] ) ? $instance['text'] : '';
    	$image = ! empty( $instance['image'] ) ? $instance['image'] : '';
        $facebook = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
        $twitter = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
        $google = ! empty( $instance['google'] ) ? $instance['google'] : '';
        $linkedin = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $pinterest = ! empty( $instance['pinterest'] ) ? $instance['pinterest'] : '';
        $instagram = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
        $youtube = ! empty( $instance['youtube'] ) ? $instance['youtube'] : '';
        $dribbble = ! empty( $instance['dribbble'] ) ? $instance['dribbble'] : '';
    	
 		ob_start();
        echo wp_kses_post( $args['before_widget'] );
        ?>
        <div class="author-widget_wrapper text-center">
            <div class="author-widget_image-wrapper">
                <img class="author-widget_image" src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($title); ?>">
            </div>
            <div class="author-widget_info">
                <?php 
                if ( ! empty( $title ) ) {echo '<h6 class="author-widget_title">' . $title . '</h6>';} 
                if ( ! empty( $text ) ) {echo '<p class="author-widget_text">' . $text . '</p>';} 
                ?>
                <div class="author-widget_social">
                    <?php if ($twitter) { echo '<a class="social-twitter" href="'.esc_url($twitter).'"><i class="xp-webicon-twitter"></i></a>'; } ?>
                    <?php if ($facebook) { echo '<a class="social-facebook" href="'.esc_url($facebook).'"><i class="xp-webicon-facebook"></i></a>'; } ?>            
                    <?php if ($google) { echo '<a class="social-google" href="'.esc_url($google).'"><i class="xp-webicon-google-plus"></i></a>'; } ?>           
                    <?php if ($linkedin) { echo '<a class="social-linkedin" href="'.esc_url($linkedin).'"><i class="xp-webicon-linkedin"></i></a>'; } ?>
                    <?php if ($pinterest) { echo '<a class="social-pinterest" href="'.esc_url($pinterest).'"><i class="xp-webicon-pinterest"></i></a>'; } ?>
                    <?php if ($instagram) { echo '<a class="social-instagram" href="'.esc_url($instagram).'"><i class="xp-webicon-instagram"></i></a>'; } ?>
                    <?php if ($youtube) { echo '<a class="social-youtube" href="'.esc_url($youtube).'"><i class="xp-webicon-youtube"></i></a>'; } ?>
                    <?php if ($dribbble) { echo '<a class="social-dribbble" href="'.esc_url($dribbble).'"><i class="xp-webicon-dribble"></i></a>'; } ?>
                </div>
            </div>
        </div>


        <?php 
        echo wp_kses_post( $args['after_widget'] );
 		ob_end_flush();
    }
 	
 	/**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $text = ! empty( $instance['text'] ) ? $instance['text'] : '';
        $image = ! empty( $instance['image'] ) ? $instance['image'] : '';

        $facebook = ! empty( $instance['facebook'] ) ? $instance['facebook'] : '';
        $twitter = ! empty( $instance['twitter'] ) ? $instance['twitter'] : '';
        $google = ! empty( $instance['google'] ) ? $instance['google'] : '';
        $linkedin = ! empty( $instance['linkedin'] ) ? $instance['linkedin'] : '';
        $pinterest = ! empty( $instance['pinterest'] ) ? $instance['pinterest'] : '';
        $instagram = ! empty( $instance['instagram'] ) ? $instance['instagram'] : '';
        $youtube = ! empty( $instance['youtube'] ) ? $instance['youtube'] : '';
        $dribbble = ! empty( $instance['dribbble'] ) ? $instance['dribbble'] : '';
    	?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php echo esc_html__( 'Avatar:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_url( $image ); ?>" />
            <button class="upload_image_button button button-primary"><?php echo esc_html__( 'Upload Image', 'restobar' ); ?></button>
       </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html__( 'Name:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php echo esc_html__( 'Description:', 'restobar' ); ?></label>
            <textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" cols="30" rows="10"><?php echo esc_html( $text ); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>"><?php esc_html_e( 'Facebook URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'facebook' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'facebook' ) ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>"><?php esc_html_e( 'Twitter URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'twitter' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'twitter' ) ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'google' ) ); ?>"><?php esc_html_e( 'Google Plus URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'google' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'google' ) ); ?>" type="text" value="<?php echo esc_attr( $google ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'dribbble' ) ); ?>"><?php esc_html_e( 'Dribbble URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'dribbble' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'dribbble' ) ); ?>" type="text" value="<?php echo esc_attr( $dribbble ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>"><?php esc_html_e( 'Linkedin URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'linkedin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'linkedin' ) ); ?>" type="text" value="<?php echo esc_attr( $linkedin ); ?>" />
        </p>        
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>"><?php esc_html_e( 'Pinterest URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pinterest' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pinterest' ) ); ?>" type="text" value="<?php echo esc_attr( $pinterest ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>"><?php esc_html_e( 'Instagram URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'instagram' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'instagram' ) ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>"><?php esc_html_e( 'Youtube URL:', 'restobar' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'youtube' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'youtube' ) ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>" />

        </p>        
        <?php
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
 
        $instance['title'] = ( !empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['text'] = ( !empty( $new_instance['text'] ) ) ? $new_instance['text'] : '';
        $instance['image'] = ( ! empty( $new_instance['image'] ) ) ? $new_instance['image'] : '';
        $instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? $new_instance['facebook'] : '';
        $instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? $new_instance['twitter'] : '';
        $instance['google'] = ( ! empty( $new_instance['google'] ) ) ? $new_instance['google'] : '';
        $instance['linkedin'] = ( ! empty( $new_instance['linkedin'] ) ) ? $new_instance['linkedin'] : '';
        $instance['pinterest'] = ( ! empty( $new_instance['pinterest'] ) ) ? $new_instance['pinterest'] : '';
        $instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? $new_instance['instagram'] : '';
        $instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? $new_instance['youtube'] : '';
        $instance['dribbble'] = ( ! empty( $new_instance['dribbble'] ) ) ? $new_instance['dribbble'] : '';
 
        return $instance;
    }  
 
}
