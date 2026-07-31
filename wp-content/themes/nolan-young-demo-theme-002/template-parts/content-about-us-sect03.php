<?php
/**
 * About team-role profiles.
 *
 * @package NolanYoungDemoTheme002
 */

defined( 'ABSPATH' ) || exit;

$roles = array(
	array( 'ST', __( 'Strategy lead', 'nolan-young-demo-theme-002' ), __( 'Finds the pressure point and frames the decision.', 'nolan-young-demo-theme-002' ), __( 'Research · Alignment · Roadmaps', 'nolan-young-demo-theme-002' ), __( 'Partners with executive and product leadership', 'nolan-young-demo-theme-002' ) ),
	array( 'XD', __( 'Experience lead', 'nolan-young-demo-theme-002' ), __( 'Turns direction into journeys and interfaces people can use.', 'nolan-young-demo-theme-002' ), __( 'Journeys · Systems · Testing', 'nolan-young-demo-theme-002' ), __( 'Partners with users, content, and service teams', 'nolan-young-demo-theme-002' ) ),
	array( 'EN', __( 'Engineering lead', 'nolan-young-demo-theme-002' ), __( 'Builds the dependable system and visible release path.', 'nolan-young-demo-theme-002' ), __( 'WordPress · Integration · Quality', 'nolan-young-demo-theme-002' ), __( 'Partners with technology and operations', 'nolan-young-demo-theme-002' ) ),
);
?>
<section id="team" class="section section--cream">
	<div class="content-wrap team-roles">
		<header class="section__heading" data-reveal>
			<div>
				<p class="eyebrow"><?php esc_html_e( 'Meet the team', 'nolan-young-demo-theme-002' ); ?></p>
				<h2><?php esc_html_e( 'Different disciplines. One shared standard.', 'nolan-young-demo-theme-002' ); ?></h2>
			</div>
			<p class="section__lede"><?php esc_html_e( 'A compact senior group stays involved from the first question to the last production detail.', 'nolan-young-demo-theme-002' ); ?></p>
		</header>
		<div class="team-roles__grid">
			<?php foreach ( $roles as $index => $role ) : ?>
				<article data-reveal>
					<header><span><?php echo esc_html( $role[0] ); ?></span><i><?php echo esc_html( sprintf( '%02d', $index + 1 ) ); ?></i></header>
					<div class="team-roles__portrait" aria-hidden="true"><span></span><span></span><span></span></div>
					<p class="eyebrow"><?php echo esc_html( $role[1] ); ?></p>
					<h3><?php echo esc_html( $role[2] ); ?></h3>
					<dl>
						<div>
							<dt><?php esc_html_e( 'Core practice', 'nolan-young-demo-theme-002' ); ?></dt>
							<dd><?php echo esc_html( $role[3] ); ?></dd>
						</div>
						<div>
							<dt><?php esc_html_e( 'Works closest with', 'nolan-young-demo-theme-002' ); ?></dt>
							<dd><?php echo esc_html( $role[4] ); ?></dd>
						</div>
					</dl>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
