<?php
/**
 * Services engagement FAQ.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$questions = array(
	array( __( 'How does an engagement begin?', 'nolan-young-demo-theme-002' ), __( 'With a focused conversation, a short evidence review, and a shared view of the first useful decision. The initial scope is deliberately small enough to validate before larger delivery begins.', 'nolan-young-demo-theme-002' ) ),
	array( __( 'Can the team work alongside internal specialists?', 'nolan-young-demo-theme-002' ), __( 'Yes. Responsibilities, decision rights, working rhythms, and handoffs are made explicit from the beginning so internal expertise remains central.', 'nolan-young-demo-theme-002' ) ),
	array( __( 'Can strategy continue through implementation?', 'nolan-young-demo-theme-002' ), __( 'Yes. The connected model supports research, design, WordPress engineering, launch, measurement, and improvement without replacing the team at each stage.', 'nolan-young-demo-theme-002' ) ),
	array( __( 'What does success measurement include?', 'nolan-young-demo-theme-002' ), __( 'A focused set of adoption, completion, quality, and operational measures tied to the original business objective and observable after launch.', 'nolan-young-demo-theme-002' ) ),
	array( __( 'What is needed from our organization?', 'nolan-young-demo-theme-002' ), __( 'Access to the right decision-makers, representative users or evidence, timely feedback, and a shared willingness to keep constraints and tradeoffs visible.', 'nolan-young-demo-theme-002' ) ),
);
?>
<section class="section section--cream">
	<div class="content-wrap services-faq">
		<header class="services-faq__intro" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Practical answers', 'nolan-young-demo-theme-002' ); ?></p>
			<h2><?php esc_html_e( 'Know what the engagement will feel like.', 'nolan-young-demo-theme-002' ); ?></h2>
			<p><?php esc_html_e( 'Clear expectations are part of the delivery system. These are the questions teams usually need answered before work begins.', 'nolan-young-demo-theme-002' ); ?></p>
			<div><span><?php esc_html_e( 'Response time', 'nolan-young-demo-theme-002' ); ?></span><strong><?php esc_html_e( 'Usually within two working days', 'nolan-young-demo-theme-002' ); ?></strong></div>
		</header>
		<div class="faq-list" data-reveal>
			<?php foreach ( $questions as $index => $question ) : ?>
				<details <?php echo 0 === $index ? 'open' : ''; ?>>
					<summary>
						<span><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></span>
						<?php echo esc_html( $question[0] ); ?>
					</summary>
					<p><?php echo esc_html( $question[1] ); ?></p>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
