<?php
defined( 'ABSPATH' ) || exit;
function nydemo001_customize( $customize ) { $customize->add_section( 'nydemo001_contact', array( 'title' => __( 'Studio contact details', 'nolan-young-demo-theme-001' ) ) ); $customize->add_setting( 'nydemo001_email', array( 'default' => 'hello@northstar.studio', 'sanitize_callback' => 'sanitize_email' ) ); $customize->add_control( 'nydemo001_email', array( 'label' => __( 'Email address', 'nolan-young-demo-theme-001' ), 'section' => 'nydemo001_contact', 'type' => 'email' ) ); }
add_action( 'customize_register', 'nydemo001_customize' );
