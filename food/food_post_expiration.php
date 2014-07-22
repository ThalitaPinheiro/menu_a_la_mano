

<?php
    class food_post_expiration() {
        
        
        function __construct() {

            add_action('post_expire', array($this,'food_expiration')); 
    
        }
        
        static function apext_activation() {
            wp_schedule_event( current_time( 'timestamp'), 'daily', 'post_expire' );
		}
       
        static function apext_deactivation() {
			wp_clear_scheduled_hook( 'post_expire' );
		}
        
        
        function food_expiration( $post_id ) {
            
            $today = current_time(Y-m-d);
            
            $key = '_my_meta_value_key';
                    
            $custom_fields = get_post_custom($post_ID, $key, true);
            $food_exit_date = $custom_fields['food_exit_date'][0];

            //Recupera o campo data e verifica se é igual ao dia atual
            if($today == $food_exit_date) {            
                // Update post 37
                $my_post_food = array(
                    'ID'            => $post_id,
                    'post_status'   => 'draft'
                );
                
                // update the post
                wp_update_post( $my_post_food );
            
            }
        }

    }

?>