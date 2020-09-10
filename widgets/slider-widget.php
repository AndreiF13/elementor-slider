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
		return [ 'elementor-slider' ];
	}

	public function get_keywords() {
		return [ 'slide', 'carousel', 'slider', 'elementor', 'element' ];
	}

	public function get_script_depends() {
		return [ 'elementor-slider', 'imagesloaded', 'jquery-slick' ];
	}

	/**
	 * Register Slider widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {

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
					'{{WRAPPER}} .elementor-slider-wrapper .slick-slider > .slick-prev:before, {{WRAPPER}} .elementor-slider-wrapper .slick-slider > .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .elementor-slider-wrapper .slick-slider > .slick-prev:before, {{WRAPPER}} .elementor-slider-wrapper .slick-slider > .slick-next:before' => 'color: {{VALUE}};',
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

		$this->add_responsive_control(
			'dots_size',
			[
				'label' => __( 'Dots Size', 'elementor-slider' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 15,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .elementor-slider-wrapper .elementor-slider > .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .elementor-slider-wrapper .elementor-slider > .slick-dots li button:before' => 'color: {{VALUE}};',
				],
				'condition' => [
					'navigation' => [ 'dots', 'both' ],
				],
			]
		);

		$this->end_controls_section();

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
		$show_dots   = ( in_array( $settings['navigation'], [ 'dots', 'both' ] ) );
		$show_arrows = ( in_array( $settings['navigation'], [ 'arrows', 'both' ] ) );

		$slick_options = [
			'centerMode'    => true,
			'centerPadding' => '60px',
			'slidesToShow'  => absint( 3 ),
			'autoplaySpeed' => absint( $settings['autoplay_speed'] ),
			'autoplay'      => ( 'yes' === $settings['autoplay'] ),
			'infinite'      => ( 'yes' === $settings['infinite'] ),
			'pauseOnHover'  => ( 'yes' === $settings['pause_on_hover'] ),
			'speed'         => absint( $settings['transition_speed'] ),
			'arrows'        => $show_arrows,
			'dots'          => $show_dots,
			'rtl'           => $is_rtl
		];

		if ( 'fade' === $settings['transition'] ) {
			$slick_options['fade'] = true;
		}

		$this->add_render_attribute( 'slides', [
			'class'               => [ 'elementor-slider', 'slick-arrows-inside', 'slick-dots-inside' ],
			'data-slider_options' => wp_json_encode( $slick_options ),
			'data-animation'      => $settings['content_animation'],
		] );
		?>

		<div class="elementor-slider-wrapper elementor-slick-slider" dir="<?php echo esc_attr( $direction ); ?>">
			<div <?php echo $this->get_render_attribute_string( 'slides' ); ?>>
				<?php foreach ( $slides as $key => $id ) : ?>
					<div class="elementor-slider-item elementor-slider-item-<?php echo esc_attr( $key + 1 ); ?>">
						<?php 
							$query = new \WP_Query( array( 'page_id' => $id ) );
							while ( $query->have_posts() ) : $query->the_post();
						?>
						<article class="post-item" role="tab" id="post-<?php echo $id; ?>" itemscope itemtype="http://schema.org/Article">
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
									</div>
								</div>
							</a>
						</article>
						<?php endwhile; ?>
					</div>
				<?php endforeach; ?>

			</div>
		</div>
		<?php
	}
}
