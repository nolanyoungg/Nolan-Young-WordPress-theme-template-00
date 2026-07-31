<?php
defined( 'ABSPATH' ) || exit;
function nydemo003_customize( $customize ) { $customize->add_section( 'nydemo003_contact', array( 'title' => __( 'Studio contact details', 'nolan-young-demo-theme-003' ) ) ); $customize->add_setting( 'nydemo003_email', array( 'default' => 'hello@northstar.studio', 'sanitize_callback' => 'sanitize_email' ) ); $customize->add_control( 'nydemo003_email', array( 'label' => __( 'Email address', 'nolan-young-demo-theme-003' ), 'section' => 'nydemo003_contact', 'type' => 'email' ) ); }
add_action( 'customize_register', 'nydemo003_customize' );
