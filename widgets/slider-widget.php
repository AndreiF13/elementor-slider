<?php
namespace Elementor_Slider\Widget;

/**
 * Elementor Slider Widget.
 *
 * Elementor widget that inserts an embedded-able content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Slider extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve Elementor Slider widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'elementor-slider';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve Elementor Slider widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Elementor Slider', 'elementor-slider' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve Slider widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-slideshow';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the Slider widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'elementor-slider' );
	}

	public function get_keywords() {
		return array( 'slide', 'carousel', 'slider', 'elementor', 'element', 'swiper' );
	}

	public function get_script_depends() {
		return array( 'elementor-slider', 'swiper', 'imagesloaded' );
	}

	/**
	 * Register Slider widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'elementor-slider' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$library_ids = get_posts( array(
			'post_type'      => 'page',
			'fields'         => 'ids',
			'posts_per_page' => -1
		));

		$templates = array();

		if ( $library_ids ) {
			foreach ( $library_ids as $id ) {
				$templates[ $id ] = get_the_title( $id );
			}
		}

		$this->add_control(
			'slides',
			[
				'label'       => __( 'Select Pages for Slides', 'elementor-slider' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => $templates,
				'label_block' => true,
				'multiple'    => true,
			]
		);

		$this->add_responsive_control(
			'items',
			array(
				'label'          => __( 'Visible Items', 'elementor-slider' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'default'        => array( 'size' => 3 ),
				'tablet_default' => array( 'size' => 2 ),
				'mobile_default' => array( 'size' => 1 ),
				'range'          => array(
					'px' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 0.5,
					),
				),
				'size_units'     => '',
				'condition'      => array(
					'transition' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'          => __( 'Items By Slides', 'elementor-slider' ),
				'type'           => \Elementor\Controls_Manager::SLIDER,
				'default'        => array( 'size' => 3 ),
				'tablet_default' => array( 'size' => 2 ),
				'mobile_default' => array( 'size' => 1 ),
				'range'          => array(
					'px' => array(
						'min'  => 1,
						'max'  => 10,
						'step' => 0.5,
					),
				),
				'size_units'     => '',
				'condition'      => array(
					'transition' => array( 'slide' ),
				),
			)
		);

		$this->add_responsive_control(
			'margin',
			array(
				'label'      => __( 'Items Gap', 'elementor-slider' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'default'    => array( 'size' => 10 ),
				'tablet_default' => array( 'size' => 10 ),
				'mobile_default' => array( 'size' => 10 ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => '',
				'condition'  => array(
					'transition' => array( 'slide' ),
				),
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_slider_options',
			[
				'label' => __( 'Slider Options', 'elementor-slider' ),
				'type'  => \Elementor\Controls_Manager::SECTION,
			]
		);

		$this->add_control(
			'navigation',
			[
				'label'   => __( 'Navigation', 'elementor-slider' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'both',
				'options' => [
					'both'   => __( 'Arrows and Dots', 'elementor-slider' ),
					'arrows' => __( 'Arrows', 'elementor-slider' ),
					'dots'   => __( 'Dots', 'elementor-slider' ),
					'none'   => __( 'None', 'elementor-slider' ),
				],
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label'   => __( 'Pause on Hover', 'elementor-slider' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label'   => __( 'Autoplay', 'elementor-slider' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label'     => __( 'Autoplay Speed', 'elementor-slider' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
			]
		);

		$this->add_control(
			'infinite',
			[
				'label'   => __( 'Infinite Loop', 'elementor-slider' ),
				'type'    => \Elementor\Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);

		$this->add_control(
			'transition',
			[
				'label'   => __( 'Transition', 'elementor-slider' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => __( 'Slide', 'elementor-slider' ),
					'fade'  => __( 'Fade', 'elementor-slider' ),
				],
			]
		);

		$this->add_control(
			'transition_speed',
			[
				'label'   => __( 'Transition Speed (ms)', 'elementor-slider' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => 500,
			]
		);

		$this->add_control(
			'content_animation',
			[
				'label'   => __( 'Content Animation', 'elementor-slider' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'fadeInUp',
				'options' => [
					''            => __( 'None', 'elementor-slider' ),
					'fadeInDown'  => __( 'Down', 'elementor-slider' ),
					'fadeInUp'    => __( 'Up', 'elementor-slider' ),
					'fadeInRight' => __( 'Right', 'elementor-slider' ),
					'fadeInLeft'  => __( 'Left', 'elementor-slider' ),
					'zoomIn'      => __( 'Zoom', 'elementor-slider' ),
				],
			]
		);

		$this->add_control(
			'direction',
			[
				'label' => esc_html__( 'Direction', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'ltr',
				'options' => [
					'ltr' => esc_html__( 'Left', 'elementor-slider' ),
					'rtl' => esc_html__( 'Right', 'elementor-slider' ),
				],
			]
		);

		$this->add_control(
			'template',
			[
				'label' => esc_html__( 'Template', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'normal',
				'options' => [
					'normal' => esc_html__( 'Normal', 'elementor-slider' ),
					'skew' => esc_html__( 'Skew', 'elementor-slider' ),
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => __( 'Navigation', 'elementor-slider' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => [
					'navigation' => [ 'arrows', 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_arrows',
			[
				'label' => __( 'Arrows', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'arrows_position',
			[
				'label' => esc_html__( 'Position', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'inside',
				'options' => [
					'inside' => esc_html__( 'Inside', 'elementor-slider' ),
					'outside' => esc_html__( 'Outside', 'elementor-slider' ),
				],
				'prefix_class' => 'elementor-slider-arrows-position-',
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_size',
			[
				'label' => __( 'Arrows Size', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 60,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-wrapper .swiper-slider > .swiper-prev:before, {{WRAPPER}} .elementor-slider-wrapper .swiper-slider > .swiper-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_responsive_control(
			'arrows_color',
			[
				'label' => __( 'Arrows Color', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-wrapper .swiper-slider > .swiper-prev:before, {{WRAPPER}} .elementor-slider-wrapper .swiper-slider > .swiper-next:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'arrows', 'both' ],
				],
			]
		);

		$this->add_control(
			'heading_style_dots',
			[
				'label' => __( 'Dots', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_position',
			[
				'label' => esc_html__( 'Position', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'outside',
				'options' => [
					'outside' => esc_html__( 'Outside', 'elementor-slider' ),
					'inside' => esc_html__( 'Inside', 'elementor-slider' ),
				],
				'prefix_class' => 'elementor-slider-pagination-position-',
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_responsive_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'default'   => array( 'size' => 8 ),
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 15,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-wrapper .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_responsive_control(
			'dots_color',
			[
				'label' => __( 'Dots Color', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-wrapper .swiper-pagination-bullet' => 'background: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->add_control(
			'dots_active_color',
			array(
				'label'     => __( 'Active Color', 'elementor-slider' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .elementor-slider-wrapper .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function next_icon() {
		$icon = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 58.3 57.9" style="enable-background:new 0 0 58.3 57.9;" xml:space="preserve"><path fill-opacity="89%" d="M58.2,30.9C57.6,24,55.1,17.5,50.9,12C46.6,6.3,40.4,3.1,33.7,0.8C21.9-2.6,11.9,5.5,5.6,14.7c-6.9,10.1-7.9,22.6-0.1,32.6c7.2,9.3,20.1,12.6,31.2,9.5C48.1,53.5,59.3,43.7,58.2,30.9z M39.9,30.4c-0.1,0.2-0.3,0.4-0.5,0.5L22.7,43.4c-1.2,0.8-2.7,0.8-3.9,0c-0.8-0.5-1.1-1.6-0.6-2.4c0.1-0.2,0.3-0.4,0.6-0.6l14.6-11l-14.7-11C18,18,17.8,17,18.3,16.2c0.1-0.2,0.3-0.4,0.6-0.6c1.2-0.8,2.7-0.8,3.9,0L39.3,28C40.2,28.6,40.4,29.6,39.9,30.4z"></path></svg>';

		return $icon;
	}

	protected function prev_icon() {
		$icon = '<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 58.3 57.9" style="enable-background:new 0 0 58.3 57.9;" xml:space="preserve"><path fill-opacity="89%" d="M21.7,56.7c11.1,3.1,24-0.2,31.2-9.5c7.8-10,6.8-22.5-0.1-32.6C46.4,5.5,36.4-2.6,24.6,0.8C17.9,3.1,11.7,6.3,7.4,12c-4.1,5.5-6.7,12-7.3,18.8C-1,43.7,10.2,53.5,21.7,56.7z M19,28l16.6-12.4c1.2-0.8,2.7-0.8,3.9,0			c0.2,0.1,0.4,0.3,0.6,0.6c0.5,0.8,0.3,1.9-0.6,2.4l-14.7,11l14.6,11c0.2,0.1,0.4,0.3,0.6,0.6c0.5,0.8,0.3,1.9-0.6,2.4c-1.2,0.8-2.7,0.8-3.9,0L18.9,30.9c-0.2-0.1-0.3-0.3-0.5-0.5C17.9,29.6,18.2,28.6,19,28z"></path></svg>';

		return $icon;
	}

	/**
	 * Render Slider widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( empty( $slides = $settings['slides'] ) ) {
			return;
		}

		$is_rtl      = is_rtl();
		$direction   = $is_rtl ? 'rtl' : 'ltr';

		// Icons RTL
		if ( is_RTL() ) {
			$next = $this->prev_icon();
			$prev = $this->next_icon();
		} else {
			$next = $this->next_icon();
			$prev = $this->prev_icon();
		}

		$show_dots   = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$swiper_options = array();

		if ( ! empty( $settings['items']['size'] ) ) {
			$swiper_options['itemsDesktop'] = $settings['items']['size'];
		}

		if ( ! empty( $settings['items_tablet']['size'] ) ) {
			$swiper_options['itemsTablet'] = $settings['items_tablet']['size'];
		}

		if ( ! empty( $settings['items_mobile']['size'] ) ) {
			$swiper_options['itemsMobile'] = $settings['items_mobile']['size'];
		}

		if ( ! empty( $settings['slides_to_show']['size'] ) ) {
			$swiper_options['slidesToShowDesktop'] = $settings['slides_to_show']['size'];
		}

		if ( ! empty( $settings['slides_to_show_tablet']['size'] ) ) {
			$swiper_options['slidesToShowTablet'] = $settings['slides_to_show_tablet']['size'];
		}

		if ( ! empty( $settings['slides_to_show_mobile']['size'] ) ) {
			$swiper_options['slidesToShowMobile'] = $settings['slides_to_show_mobile']['size'];
		}
		if ( ! empty( $settings['margin']['size'] ) ) {
			$swiper_options['marginDesktop'] = $settings['margin']['size'];
		}

		if ( ! empty( $settings['margin_tablet']['size'] ) ) {
			$swiper_options['marginTablet'] = $settings['margin_tablet']['size'];
		}

		if ( ! empty( $settings['margin_mobile']['size'] ) ) {
			$swiper_options['marginMobile'] = $settings['margin_mobile']['size'];
		}
		
		if ( $settings['transition'] ) {
			$swiper_options['effect'] = $settings['transition'];
		}

		if ( ! empty( $settings['transition_speed']['size'] ) ) {
			$swiper_options['speed'] = $settings['transition_speed']['size'];
		}

		if ( $settings['autoplay'] == 'yes' && ! empty( $settings['autoplay_speed']['size'] ) ) {
			$swiper_options['autoplay'] = 1;
		} else {
			$swiper_options['autoplay'] = 0;
		}

		if ( $settings['pause_on_hover'] == 'yes' ) {
			$swiper_options['pauseOnHover'] = true;
		}

		if ( $settings['infinite'] == 'yes' ) {
			$swiper_options['loop'] = 1;
		}

		if ( $show_arrows ) {
			$swiper_options['arrows'] = 1;
		}

		if ( $show_dots ) {
			$swiper_options['dots'] = 1;
		}

		if ( 'fade' === $settings['transition'] ) {
			$swiper_options['fade'] = true;
		}

		$this->add_render_attribute( 'slides', [
			'class' => [ 'elementor-slider', 'swiper-wrapper', 'swiper-arrows-inside', 'swiper-dots-inside' ],
			'id'	=> 'elementor-slider-wmt',
			'data-settings' 	  => wp_json_encode( $swiper_options ),
			'data-animation'      => $settings['content_animation'],
		] );

		$slides_count = count( $slides );
		$has_dots = $show_dots ? 'has-dots' : '';
		$template = $settings['template'];
		?>

		<div class="elementor-slider-wrapper swiper-container <?php echo esc_attr( $template ); ?> <?php echo esc_attr( $has_dots ); ?>" dir="<?php echo esc_attr( $direction ); ?>">
			<div <?php echo $this->get_render_attribute_string( 'slides' ); ?>>
				<?php foreach ( $slides as $key => $id ) : ?>
					<div class="elementor-slider-item elementor-slider-item-<?php echo esc_attr( $key + 1 ); ?> swiper-slide">
						<?php 
							$query = new \WP_Query( array( 'page_id' => $id ) );
							while ( $query->have_posts() ) : $query->the_post();
						?>
						<article id="custom-image" class="post-item" role="tab" id="post-<?php echo $id; ?>" itemscope itemtype="http://schema.org/Article">
							<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" aria-label="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" data-title="<?php the_title_attribute(); ?>">
								<div class="featured-image">
									<?php
										if ( has_post_thumbnail() ) {
										the_post_thumbnail('grid');
										} else {
										$entity_no_image = get_template_directory_uri().'/img/no-image.png';
										?>
										<img src="<?php echo esc_url($entity_no_image); ?>" class="img-responsive no-image" alt="<?php esc_attr_e( 'No image uploaded yet', 'entity' ); ?>">
									<?php } ?>
									<div class="caption">
										<header class="entry-header">
											<?php the_title( sprintf( '<div class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></div>' ); ?>
										</header>
										<div class="entry-content">
											<?php the_excerpt(); ?>
										</div><!-- .entry-content -->
									</div>
								</div>
							</a>
						</article>
						<?php endwhile; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		<?php if ( 1 < $slides_count ) : ?>
				<?php if ( $show_arrows ) : ?>
					<div class="elementor-swiper-button swiper-button-prev">
						<?php echo $prev; ?>
						<span class="elementor-screen-only"><?php echo esc_html__( 'Previous', 'elementor' ); ?></span>
					</div>
					<div class="elementor-swiper-button swiper-button-next">
						<?php  echo $next; ?>
						<span class="elementor-screen-only"><?php echo esc_html__( 'Next', 'elementor' ); ?></span>
					</div>
				<?php endif; ?>
				<?php if ( $show_dots ) : ?>
					<div class="swiper-pagination"></div>
				<?php endif; ?>
			<?php endif; ?>
		<?php
	}
}
