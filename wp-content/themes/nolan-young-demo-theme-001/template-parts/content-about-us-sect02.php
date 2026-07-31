<?php
/**
 * About operating principles.
 *
 * @package NolanYoungDemoTheme001
 */

defined( 'ABSPATH' ) || exit;

$principles = array(
	array( '01', __( 'Clarity', 'nolan-young-demo-theme-001' ), __( 'Make the decision visible.', 'nolan-young-demo-theme-001' ), __( 'Name what matters, what is constrained, and what evidence will change the choice.', 'nolan-young-demo-theme-001' ), __( 'Fewer reversals', 'nolan-young-demo-theme-001' ) ),
	array( '02', __( 'Utility', 'nolan-young-demo-theme-001' ), __( 'Make it useful.', 'nolan-young-demo-theme-001' ), __( 'Every polished idea should help a customer or colleague do something better.', 'nolan-young-demo-theme-001' ), __( 'Higher adoption', 'nolan-young-demo-theme-001' ) ),
	array( '03', __( 'Ownership', 'nolan-young-demo-theme-001' ), __( 'Leave capability behind.', 'nolan-young-demo-theme-001' ), __( 'The internal team should understand, maintain, and improve the system after handover.', 'nolan-young-demo-theme-001' ), __( 'Durable autonomy', 'nolan-young-demo-theme-001' ) ),
	array( '04', __( 'Evidence', 'nolan-young-demo-theme-001' ), __( 'Test the risky thing first.', 'nolan-young-demo-theme-001' ), __( 'Early evidence is more valuable than late certainty.', 'nolan-young-demo-theme-001' ), __( 'Controlled risk', 'nolan-young-demo-theme-001' ) ),
	array( '05', __( 'Care', 'nolan-young-demo-theme-001' ), __( 'Details are operational.', 'nolan-young-demo-theme-001' ), __( 'Accessibility, performance, documentation, and release quality are part of the product.', 'nolan-young-demo-theme-001' ), __( 'Reliable quality', 'nolan-young-demo-theme-001' ) ),
);
?>
<section id="values" class="section section--cool">
	<div class="content-wrap principles">
		<header class="section__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Operating principles', 'nolan-young-demo-theme-001' ); ?></p>
				<h2><?php esc_html_e( 'Standards that survive real delivery pressure.', 'nolan-young-demo-theme-001' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'Useful principles show up in how evidence is handled, decisions are made, and ownership is transferred.', 'nolan-young-demo-theme-001' ); ?></p>
		</header>
		<div class="principles__grid">
			<?php foreach ( $principles as $index => $principle ) : ?>
				<article class="<?php echo 0 === $index ? 'principle-card principle-card--lead' : 'principle-card'; ?>" data-reveal>
					<header><span><?php echo esc_html( $principle[0] ); ?></span><strong><?php echo esc_html( $principle[1] ); ?></strong></header>
					<h3><?php echo esc_html( $principle[2] ); ?></h3>
					<p><?php echo esc_html( $principle[3] ); ?></p>
					<footer><span><?php esc_html_e( 'What changes', 'nolan-young-demo-theme-001' ); ?></span><strong><?php echo esc_html( $principle[4] ); ?></strong></footer>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
