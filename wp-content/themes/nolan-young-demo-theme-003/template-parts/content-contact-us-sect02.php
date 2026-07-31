<?php
/**
 * Non-submitting demonstration project form.
 *
 * @package NolanYoungDemoTheme003
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section contact-brief" id="project-brief">
	<div class="content-wrap contact-brief__layout">
		<aside class="contact-brief__intro" data-reveal>
			<p class="eyebrow"><?php esc_html_e( 'Project signal / 01', 'nolan-young-demo-theme-003' ); ?></p>
			<h2><?php esc_html_e( 'Give the first conversation an intelligent starting point.', 'nolan-young-demo-theme-003' ); ?></h2>
			<p><?php esc_html_e( 'A useful brief is not a list of deliverables. It explains what is changing, why it matters now, and what a better future must enable.', 'nolan-young-demo-theme-003' ); ?></p>
			<ol class="brief-checklist">
				<li>
					<span>01</span>
					<div>
						<strong><?php esc_html_e( 'Outcome', 'nolan-young-demo-theme-003' ); ?></strong>
						<small><?php esc_html_e( 'What must become possible?', 'nolan-young-demo-theme-003' ); ?></small>
					</div>
				</li>
				<li>
					<span>02</span>
					<div>
						<strong><?php esc_html_e( 'Pressure', 'nolan-young-demo-theme-003' ); ?></strong>
						<small><?php esc_html_e( 'What is creating urgency?', 'nolan-young-demo-theme-003' ); ?></small>
					</div>
				</li>
				<li>
					<span>03</span>
					<div>
						<strong><?php esc_html_e( 'Decision', 'nolan-young-demo-theme-003' ); ?></strong>
						<small><?php esc_html_e( 'Who needs confidence?', 'nolan-young-demo-theme-003' ); ?></small>
					</div>
				</li>
			</ol>
			<div class="contact-brief__privacy">
				<span aria-hidden="true">◎</span>
				<p><?php esc_html_e( 'Theme demonstration only. This interface does not submit, store, email, or transmit information.', 'nolan-young-demo-theme-003' ); ?></p>
			</div>
		</aside>

		<form class="project-brief-form" aria-describedby="project-brief-note" data-reveal onsubmit="return false;">
			<header class="project-brief-form__header">
				<div>
					<span><?php esc_html_e( '01 / Project context', 'nolan-young-demo-theme-003' ); ?></span>
					<strong><?php esc_html_e( 'Confidential working brief', 'nolan-young-demo-theme-003' ); ?></strong>
				</div>
				<em><?php esc_html_e( 'Demo interface', 'nolan-young-demo-theme-003' ); ?></em>
			</header>
			<div class="project-brief-form__body">
				<div class="field-grid">
					<label>
						<span><?php esc_html_e( 'Your name', 'nolan-young-demo-theme-003' ); ?></span>
						<input type="text" name="demo_name" autocomplete="name" placeholder="<?php esc_attr_e( 'Name', 'nolan-young-demo-theme-003' ); ?>">
					</label>
					<label>
						<span><?php esc_html_e( 'Work email', 'nolan-young-demo-theme-003' ); ?></span>
						<input type="email" name="demo_email" autocomplete="email" placeholder="<?php esc_attr_e( 'you@company.com', 'nolan-young-demo-theme-003' ); ?>">
					</label>
				</div>
				<label>
					<span><?php esc_html_e( 'What needs to change?', 'nolan-young-demo-theme-003' ); ?></span>
					<textarea name="demo_context" rows="5" placeholder="<?php esc_attr_e( 'Describe the opportunity, the pressure, and the result that would matter…', 'nolan-young-demo-theme-003' ); ?>"></textarea>
				</label>
				<fieldset>
					<legend><?php esc_html_e( 'Where is the strongest pressure?', 'nolan-young-demo-theme-003' ); ?></legend>
					<div class="choice-grid">
						<label>
							<input type="checkbox" name="demo_area[]" value="strategy">
							<span><strong><?php esc_html_e( 'Strategy', 'nolan-young-demo-theme-003' ); ?></strong><small><?php esc_html_e( 'Direction and alignment', 'nolan-young-demo-theme-003' ); ?></small></span>
						</label>
						<label>
							<input type="checkbox" name="demo_area[]" value="experience">
							<span><strong><?php esc_html_e( 'Experience', 'nolan-young-demo-theme-003' ); ?></strong><small><?php esc_html_e( 'Customer and employee journeys', 'nolan-young-demo-theme-003' ); ?></small></span>
						</label>
						<label>
							<input type="checkbox" name="demo_area[]" value="platform">
							<span><strong><?php esc_html_e( 'Platform', 'nolan-young-demo-theme-003' ); ?></strong><small><?php esc_html_e( 'Technology and operations', 'nolan-young-demo-theme-003' ); ?></small></span>
						</label>
						<label>
							<input type="checkbox" name="demo_area[]" value="growth">
							<span><strong><?php esc_html_e( 'Growth', 'nolan-young-demo-theme-003' ); ?></strong><small><?php esc_html_e( 'Demand and conversion', 'nolan-young-demo-theme-003' ); ?></small></span>
						</label>
					</div>
				</fieldset>
				<div class="field-grid">
					<label>
						<span><?php esc_html_e( 'Useful timing', 'nolan-young-demo-theme-003' ); ?></span>
						<select name="demo_timing">
							<option value=""><?php esc_html_e( 'Select a planning window', 'nolan-young-demo-theme-003' ); ?></option>
							<option value="now"><?php esc_html_e( 'Within 30 days', 'nolan-young-demo-theme-003' ); ?></option>
							<option value="quarter"><?php esc_html_e( 'This quarter', 'nolan-young-demo-theme-003' ); ?></option>
							<option value="exploring"><?php esc_html_e( 'Exploring the opportunity', 'nolan-young-demo-theme-003' ); ?></option>
						</select>
					</label>
					<label>
						<span><?php esc_html_e( 'Investment signal', 'nolan-young-demo-theme-003' ); ?></span>
						<select name="demo_investment">
							<option value=""><?php esc_html_e( 'Select a working range', 'nolan-young-demo-theme-003' ); ?></option>
							<option value="focused"><?php esc_html_e( 'Focused engagement', 'nolan-young-demo-theme-003' ); ?></option>
							<option value="program"><?php esc_html_e( 'Transformation program', 'nolan-young-demo-theme-003' ); ?></option>
							<option value="unknown"><?php esc_html_e( 'Needs definition', 'nolan-young-demo-theme-003' ); ?></option>
						</select>
					</label>
				</div>
			</div>
			<footer class="project-brief-form__footer">
				<p id="project-brief-note"><?php esc_html_e( 'Nothing is transmitted. This button intentionally performs no network action.', 'nolan-young-demo-theme-003' ); ?></p>
				<button class="button button--primary" type="button" aria-describedby="project-brief-note">
					<?php esc_html_e( 'Preview next step', 'nolan-young-demo-theme-003' ); ?>
					<span aria-hidden="true">→</span>
				</button>
			</footer>
		</form>
	</div>
</section>
