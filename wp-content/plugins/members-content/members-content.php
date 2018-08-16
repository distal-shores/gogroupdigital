<?php
/*
Plugin Name: GO Group Members Privileged Content
Plugin URI: 
description: User gating for privileged content
Version: 1.0
Author: Sam Coll
Author URI: https://www.sam-coll.com
License: GPL2
*/

// Add the 'Go Member' user role
add_role(
    'managing_partner',
    __( 'Managing Partner' ),
    array(
        'read'         => true,
        'edit_posts'   => true,
    )
);
add_role(
    'strategic_partner',
    __( 'Strategic Partner' ),
    array(
        'read'         => true,
        'edit_posts'   => true,
    )
);
add_role(
    'associate_partner',
    __( 'Associate Partner' ),
    array(
        'read'         => true,
        'edit_posts'   => true,
    )
);

/**
 * Fire on the initialization of WordPress.
 */
function add_member_privileges() {
    
    $user = wp_get_current_user();

    if(in_array('managing_partner', $user->roles)) {
        if(!in_array('strategic_partner', $user->roles)) {
            $user->add_role( 'strategic_partner');
        }
        if(!in_array('associate_partner', $user->roles)) {
            $user->add_role( 'associate_partner');
        }
    } elseif(in_array('strategic_partner', $user->roles)) {
        if(!in_array('associate_partner', $user->roles)) {
            $user->add_role( 'associate_partner');
        }
    }

}
add_action( 'init', 'add_member_privileges', 10, 3 );

?>
