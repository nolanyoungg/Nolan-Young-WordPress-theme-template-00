<?php
defined( 'ABSPATH' ) || exit;
function nydemo002_customize( $customize ) { $customize->add_section( 'nydemo002_contact', array( 'title' => __( 'Studio contact details', 'nolan-young-demo-theme-002' ) ) ); $customize->add_setting( 'nydemo002_email', array( 'default' => 'hello@northstar.studio', 'sanitize_callback' => 'sanitize_email' ) ); $customize->add_control( 'nydemo002_email', array( 'label' => __( 'Email address', 'nolan-young-demo-theme-002' ), 'section' => 'nydemo002_contact', 'type' => 'email' ) ); }
add_action( 'customize_register', 'nydemo002_customize' );
