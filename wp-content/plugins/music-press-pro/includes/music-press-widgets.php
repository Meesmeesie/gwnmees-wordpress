<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Music Press Widget base
 */

class Music_Press_Widget extends WP_Widget
{

    public $widget_cssclass;
    public $widget_description;
    public $widget_id;
    public $widget_name;
    public $settings;

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        $widget_ops = array(
            'classname' => $this->widget_cssclass,
            'description' => $this->widget_description
        );

        parent::__construct($this->widget_id, $this->widget_name, $widget_ops);

        add_action('save_post', array($this, 'flush_widget_cache'));
        add_action('deleted_post', array($this, 'flush_widget_cache'));
        add_action('switch_theme', array($this, 'flush_widget_cache'));
    }

    /**
     * get_cached_widget function.
     */
    function get_cached_widget($args)
    {
        $cache = wp_cache_get($this->widget_id, 'widget');

        if (!is_array($cache))
            $cache = array();

        if (isset($cache[$args['widget_id']])) {
            echo $cache[$args['widget_id']];
            return true;
        }

        return false;
    }

    /**
     * Cache the widget
     */
    public function cache_widget($args, $content)
    {
        $cache[$args['widget_id']] = $content;

        wp_cache_set($this->widget_id, $cache, 'widget');
    }

    /**
     * Flush the cache
     * @return [type]
     */
    public function flush_widget_cache()
    {
        wp_cache_delete($this->widget_id, 'widget');
    }

    /**
     * update function.
     *
     * @see WP_Widget->update
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;

        if (!$this->settings)
            return $instance;

        foreach ($this->settings as $key => $setting) {
            $instance[$key] = sanitize_text_field($new_instance[$key]);
        }

        $this->flush_widget_cache();

        return $instance;
    }

    /**
     * form function.
     *
     * @see WP_Widget->form
     * @access public
     * @param array $instance
     * @return void
     */
    function form($instance)
    {

        if (!$this->settings)
            return;

        foreach ($this->settings as $key => $setting) {

            $value = isset($instance[$key]) ? $instance[$key] : $setting['std'];

            switch ($setting['type']) {
                case 'text' :
                    ?>
                    <p>
                        <label for="<?php echo $this->get_field_id($key); ?>"><?php echo $setting['label']; ?></label>
                        <input class="widefat" id="<?php echo esc_attr($this->get_field_id($key)); ?>"
                               name="<?php echo $this->get_field_name($key); ?>" type="text"
                               value="<?php echo esc_attr($value); ?>"/>
                    </p>
                    <?php
                    break;
                case 'number' :
                    ?>
                    <p>
                        <label for="<?php echo $this->get_field_id($key); ?>"><?php echo $setting['label']; ?></label>
                        <input class="widefat" id="<?php echo esc_attr($this->get_field_id($key)); ?>"
                               name="<?php echo $this->get_field_name($key); ?>" type="number"
                               step="<?php echo esc_attr($setting['step']); ?>"
                               min="<?php echo esc_attr($setting['min']); ?>"
                               max="<?php echo esc_attr($setting['max']); ?>" value="<?php echo esc_attr($value); ?>"/>
                    </p>
                    <?php
                    break;
                case 'select' :
                    ?>
                    <p>
                        <label for="<?php echo $this->get_field_id($key); ?>"><?php echo $setting['label']; ?></label>
                        <select name="<?php echo $this->get_field_name($key); ?>"
                                id="<?php echo esc_attr($this->get_field_id($key)); ?>"
                                value="<?php echo esc_attr($value); ?>">
                            <?php foreach ($setting['choices'] as $key => $val) { ?>
                                <option <?php if ($value == $val) {
                                    echo 'selected ';
                                } ?>value="<?php echo $val; ?>"><?php echo $val; ?></option>
                            <?php } ?>

                        </select>
                    </p>
                    <?php
                    break;
                case 'taxonomy' :
                    ?>
                    <p>
                        <label for="<?php echo $this->get_field_id($key); ?>"><?php echo $setting['label']; ?> </label>
                        <?php wp_dropdown_categories(array(
                            'show_option_all' => __('All', 'music-press-pro'),
                            'taxonomy' => $setting['taxonomy'],
                            'name' => $this->get_field_name($key),
                            'selected' => $value
                        )); ?>
                    </p>
                    <?php
                    break;
            }
        }
    }
}

/**
 * Recent Songs
 */
class Music_Press_Widget_Recent_Songs extends Music_Press_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->widget_cssclass = 'music_press_widget widget_recent_songs';
        $this->widget_description = __('Display a list of the most recent songs on your site.', 'music-press-pro');
        $this->widget_id = 'widget_recent_songs';
        $this->widget_name = __('Recent Songs', 'music-press-pro');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('Recent Songs', 'music-press-pro'),
                'label' => __('Title', 'music-press-pro')
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __('Number of Songs to show', 'music-press-pro')
            )
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget($args, $instance)
    {
        global $music_press_pro;

        if ($this->get_cached_widget($args))
            return;

        ob_start();

        extract($args);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $number = absint($instance['number']);

        $query_args = array(
            'post_type' => 'mp_song',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $number,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $songs = new WP_Query($query_args);

        if ($songs->have_posts()) : ?>

            <?php echo $before_widget; ?>

            <?php if ($title) echo $before_title . $title . $after_title; ?>

            <ul class="songs_listings">

                <?php while ($songs->have_posts()) : $songs->the_post(); ?>

                    <li class="song_listing">
                        <a href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail(array(50, 50), array('class' => 'alignright')) ?></a>
                        <h4><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h4>
                        <div class="clr"></div>
                    </li>

                <?php endwhile; ?>

            </ul>

            <?php echo $after_widget; ?>

        <?php endif;

        wp_reset_postdata();

        $content = ob_get_clean();

        echo $content;

        $this->cache_widget($args, $content);
    }
}

register_widget('Music_Press_Widget_Recent_Songs');

/**
 * Recent Songs
 */
class Music_Press_Widget_Albums extends Music_Press_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->widget_cssclass = 'music_press_widget widget_get_albums';
        $this->widget_description = __('Display a list of the albums on your site.', 'music-press-pro');
        $this->widget_id = 'widget_albums';
        $this->widget_name = __('Music Press Albums', 'music-press-pro');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('Music Press Albums', 'music-press-pro'),
                'label' => __('Title', 'music-press-pro')
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __('Number of albums to show', 'music-press-pro')
            ),
            'orderby' => array(
                'label' => esc_html__('Order By', 'music-press-pro'),
                'desc' => '',
                'type' => 'select',
                'std' => 'audio',
                'class' => '',
                'choices' => array(
                    esc_html__('Audio', 'music-press-pro') => 'audio',
                    esc_html__('Video', 'music-press-pro') => 'video',
                ),
            ),
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget($args, $instance)
    {
        global $music_press_pro;

        if ($this->get_cached_widget($args))
            return;

        ob_start();

        extract($args);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $number = absint($instance['number']);


        $query_args = array(
            'post_type' => 'mp_album',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $number,
            'orderby' => 'date',
            'order' => 'DESC',
        );

        $songs = new WP_Query($query_args);

        if ($songs->have_posts()) : ?>

            <?php echo $before_widget; ?>

            <?php if ($title) echo $before_title . $title . $after_title; ?>

            <ul class="mp-list albums">

                <?php while ($songs->have_posts()) : $songs->the_post(); ?>

                    <li class="mp-item">
                        <a class="mp-img"
                           href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail(array(250, 250), array('class' => 'center')) ?></a>
                        <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="clr"></div>
                    </li>

                <?php endwhile; ?>

            </ul>

            <?php echo $after_widget; ?>

        <?php endif;

        wp_reset_postdata();

        $content = ob_get_clean();

        echo $content;

        $this->cache_widget($args, $content);
    }
}

register_widget('Music_Press_Widget_Albums');

/**
 * Recent Video Songs
 */
class Music_Press_Widget_Video_Songs extends Music_Press_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->widget_cssclass = 'music_press_widget widget_get_video_songs mp';
        $this->widget_description = __('Display a list of the video songs on your site.', 'music-press-pro');
        $this->widget_id = 'widget_video_song';
        $this->widget_name = __('Music Press Video Songs', 'music-press-pro');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('Music Press Video Songs', 'music-press-pro'),
                'label' => __('Title', 'music-press-pro')
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __('Number of video to show', 'music-press-pro')
            ),
            'orderby' => array(
                'label' => esc_html__('Order By', 'music-press-pro'),
                'desc' => '',
                'type' => 'select',
                'class' => '',
                'std' => 'title',
                'choices' => array(
                    esc_html__('Title', 'music-press-pro') => 'title',
                    esc_html__('Date', 'music-press-pro') => 'date',
                    esc_html__('Plays', 'music-press-pro') => 'view',
                ),
            ),
            'order' => array(
                'label' => esc_html__('Order', 'music-press-pro'),
                'desc' => '',
                'type' => 'select',
                'class' => '',
                'std' => 'DESC',
                'choices' => array(
                    esc_html__('Descending order from highest to lowest values', 'music-press-pro') => 'DESC',
                    esc_html__('Ascending order from lowest to highest values', 'music-press-pro') => 'ASC',
                ),
            ),
            'thumbnail' => array(
                'type' => 'select',
                'std' => 'show',
                'label' => __('Show/hide thumbnail image', 'music-press-pro'),
                'choices' => array(
                    esc_html__('Show', 'music-press-pro') => 'show',
                    esc_html__('Hide', 'music-press-pro') => 'hide',
                ),
            ),
            'displayview' => array(
                'type' => 'select',
                'std' => 'show',
                'label' => __('Show/hide views', 'music-press-pro'),
                'choices' => array(
                    esc_html__('Show', 'music-press-pro') => 'show',
                    esc_html__('Hide', 'music-press-pro') => 'hide',
                ),
            ),
            'iteminline' => array(
                'type' => 'select',
                'std' => '4',
                'label' => __('Number item in 1 line', 'music-press-pro'),
                'choices' => array(
                    esc_html__('4', 'music-press-pro') => '4',
                    esc_html__('3', 'music-press-pro') => '3',
                    esc_html__('2', 'music-press-pro') => '2',
                    esc_html__('1', 'music-press-pro') => '1',
                ),
            ),

        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget($args, $instance)
    {
        global $music_press_pro,$post;

        if ($this->get_cached_widget($args))
            return;

        ob_start();

        extract($args);
        $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $number = absint($instance['number']);
        $thumbnail = $instance['thumbnail'];
        $orderby = $instance['orderby'];
        $order = $instance['order'];
        $displayview = $instance['displayview'];
        $iteminline = $instance['iteminline'];

        $custom_order = "";
        $metakey = '';
        if ($orderby == 'view') {
            $custom_order = 'meta_value_num';
            $metakey = 'mp_count_play';
        } else {
            $custom_order = $orderby;
        }

        $itemclass = '';
        if ($iteminline == 4) {
            $itemclass = 'w25';
        } elseif ($iteminline == 3) {
            $itemclass = 'w33';
        } elseif ($iteminline == 2) {
            $itemclass = 'w50';
        } else {
            $itemclass = 'w100';
        }
        $query_args = array(
            'post_type' => 'mp_song',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'meta_query' => array(
                array(
                    'key' => 'song_type',
                    'value' => 'video'
                )
            ),
            'order' => $order,
            'orderby' => $custom_order,
            'meta_key' => $metakey,
            'posts_per_page' => $number,

        );

        $videosongs = new WP_Query($query_args);
        $i = 0;
        if ($videosongs->have_posts()) : ?>

            <?php echo $before_widget; ?>

            <?php if ($title) echo $before_title . $title . $after_title; ?>

            <ul class="mp-list video-songs <?php echo esc_attr($itemclass); ?>">

                <?php
                while ($videosongs->have_posts()) : $videosongs->the_post();
                    $i++;
                    $songID = get_the_ID();
                    ?>

                    <li class="mp-item">
                        <?php
                        if ($thumbnail == 'show' && has_post_thumbnail($post->ID)):
                            ?>
                            <a class="mp-img"
                               href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail(array(250, 250), array('class' => 'center')) ?>
                                <span><i class="fa fa-play"></i></span>
                            </a>
                        <?php endif; ?>
                        <h3>
                            <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                        </h3>
                        <?php
                        /*  Get Artists */
                        $artists = get_field('song_artist', $songID);
                        if ($artists != null) {
                            echo '<div class="artist">';
                            $count = count($artists);
                            $i = 1;
                            $song_artist = '';
                            foreach ($artists as $artist) {
                                if ($i == $count) {
                                    $song_artist .= get_the_title($artist);
                                    echo '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>';
                                } else {
                                    $song_artist .= get_the_title($artist) . esc_html__(', ', 'music-press-pro');
                                    echo '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>' . esc_html__(', ', 'music-press-pro');
                                }
                                $i++;
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="artist">';
                            echo '<a href="#" title="updating...">' . esc_html__('Updating...', 'music-press-pro') . '</a>';
                            echo '</div>';
                        }
                        ?>
                        <?php if ($displayview == 'show'): ?>
                            <span class="mp-item__view">
                            <?php
                            $view = get_post_meta(get_the_ID(), 'mp_count_play', true);
                            echo esc_html($view) . esc_html__(' views', 'music-press-pro');
                            ?>
                        </span>
                        <?php endif; ?>
                        <div class="clr"></div>
                    </li>

                    <!--Show div.clearfix-->
                    <?php

                    if ($iteminline == 4) {
                        if ($i % 4 == 0) {
                            echo '<div class="clr"></div>';
                        }
                    } elseif ($iteminline == 3) {
                        if ($i % 3 == 0) {
                            echo '<div class="clr"></div>';
                        }
                    } elseif ($iteminline == 2) {
                        if ($i % 2 == 0) {
                            echo '<div class="clr"></div>';
                        }
                    } else {

                    }
                    ?>

                <?php
                endwhile;
                ?>

            </ul>

            <?php echo $after_widget; ?>

        <?php endif;

        wp_reset_postdata();

        $content = ob_get_clean();

        echo $content;

        $this->cache_widget($args, $content);
    }

}

register_widget('Music_Press_Widget_Video_Songs');

/**
 * Recent Artists
 */
class Music_Press_Widget_Artists extends Music_Press_Widget
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->widget_cssclass = 'music_press_widget widget_get_artists';
        $this->widget_description = __('Display a list of artists on your site.', 'music-press-pro');
        $this->widget_id = 'widget_artist';
        $this->widget_name = __('Music Press Artists', 'music-press-pro');
        $this->settings = array(
            'title' => array(
                'type' => 'text',
                'std' => __('Music Press Artists', 'music-press-pro'),
                'label' => __('Title', 'music-press-pro')
            ),
            'number' => array(
                'type' => 'number',
                'step' => 1,
                'min' => 1,
                'max' => '',
                'std' => 5,
                'label' => __('Number of albums to show', 'music-press-pro')
            ),
            'orderby' => array(
                'label' => esc_html__('Order By', 'music-press-pro'),
                'desc' => '',
                'type' => 'select',
                'class' => '',
                'std' => 'date',
                'choices' => array(
                    esc_html__('Title', 'music-press-pro') => 'title',
                    esc_html__('Date', 'music-press-pro') => 'date',
                ),
            ),
            'order' => array(
                'label' => esc_html__('Order', 'music-press-pro'),
                'desc' => '',
                'type' => 'select',
                'class' => '',
                'std' => 'DESC',
                'choices' => array(
                    esc_html__('Descending order from highest to lowest values', 'music-press-pro') => 'DESC',
                    esc_html__('Ascending order from lowest to highest values', 'music-press-pro') => 'ASC',
                ),
            ),
            'thumbnail' => array(
                'type' => 'select',
                'step' => '',
                'min' => '',
                'max' => '',
                'std' => 'show',
                'label' => __('Show/hide Avatar', 'music-press-pro'),
                'choices' => array(
                    esc_html__('Show', 'music-press-pro') => 'show',
                    esc_html__('Hide', 'music-press-pro') => 'hide',
                ),
            ),
        );
        parent::__construct();
    }

    /**
     * widget function.
     *
     * @see WP_Widget
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget($args, $instance)
    {
        global $music_press_pro;

        if ($this->get_cached_widget($args))
            return;

        ob_start();

        extract($args);

        $title = apply_filters('widget_title', $instance['title'], $instance, $this->id_base);
        $number = absint($instance['number']);
        $thumbnail = $instance['thumbnail'];
        $orderby = $instance['orderby'];
        $order = $instance['order'];

        $query_args = array(
            'post_type' => 'mp_artist',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $number,
            'orderby' => $orderby,
            'order' => $order,
        );

        global $post;

        $artist = new WP_Query($query_args);

        if ($artist->have_posts()) : ?>

            <?php echo $before_widget; ?>

            <?php if ($title) echo $before_title . $title . $after_title; ?>

            <ul class="mp-list artists">

                <?php while ($artist->have_posts()) : $artist->the_post(); ?>

                    <li class="mp-item">
                        <?php
                        if ($thumbnail == 'show'):
                            if(has_post_thumbnail($post->ID)):
                            ?>
                            <a class="mp-img"
                               href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail(array(50, 50), array('class' => 'center')) ?>
                            </a>
                            <?php else: ?>
                                <a class="mp-img"
                                   href="<?php echo get_permalink(); ?>">
                                    <img width="50px" height="50px" src="<?php echo MUSIC_PRESS_PRO_PLUGIN_URL ?>/assets/images/no_avt.png" alt="<?php echo esc_html__('No Avatar','music-press-pro'); ?>"
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="clr"></div>
                    </li>

                <?php endwhile; ?>

            </ul>

            <?php echo $after_widget; ?>

        <?php endif;

        wp_reset_postdata();

        $content = ob_get_clean();

        echo $content;

        $this->cache_widget($args, $content);
    }
}

register_widget('Music_Press_Widget_Artists');

/**
 * login
 */
if (class_exists('MusicPressMember')) {
    class Music_Press_Widget_Login extends Music_Press_Widget
    {

        /**
         * Constructor
         */
        public function __construct()
        {
            $this->widget_cssclass = 'music_press_widget widget_get_login';
            $this->widget_description = __('Display a list of artists on your site.', 'music-press-pro');
            $this->widget_id = 'widget_login';
            $this->widget_name = __('Music Press Login', 'music-press-pro');
            $this->settings = array();
            parent::__construct();
        }

        /**
         * widget function.
         *
         * @see WP_Widget
         * @access public
         * @param array $args
         * @param array $instance
         * @return void
         */
        function widget($args, $instance)
        {
            global $music_press_pro;

            if ($this->get_cached_widget($args))
                return;

            ob_start();

            extract($args);

            /**
             * Detect plugin. For use on Front End only.
             */
            include_once(ABSPATH . 'wp-admin/includes/plugin.php');

            // check for plugin using plugin name
            if (is_plugin_active('music-press-member/music-press-member.php')) {
                $music_press_member_page_id = get_option('music_press_member_page_id');
                $music_press_member_page_url = get_permalink($music_press_member_page_id);
                $music_press_member_edit_id = get_option('music_press_member_edit_page_id');
                $music_press_member_edit_url = get_permalink($music_press_member_edit_id);
                ?>
                <aside id="widget_login" class="widget music_press_widget music_press_widget_login">
                    <?php

                    if (!is_user_logged_in()):
                        ?>

                        <div class="after-login">
                            <p><?php echo esc_html__('Hello Guest'); ?></p>
                            <a class="login" href="<?php echo esc_url(wp_login_url()); ?>"
                               alt="<?php esc_attr_e('Login', 'music-press-pro'); ?>">
                                <?php esc_html_e('Login', 'music-press-pro'); ?>
                            </a>
                            <span>
                        <?php echo esc_html__('Or', 'music-press-pro'); ?>
                    </span>
                            <a class="register" href="<?php echo esc_url(wp_registration_url()); ?>"
                               alt="<?php esc_attr_e('Register', 'music-press-pro'); ?>">
                                <?php esc_html_e('Register', 'music-press-pro'); ?>
                            </a>
                        </div>

                        <?php
                    else:
                        ?>

                        <div class="before-login">
                            <div class="before-login__hover">
                                <div class="before-login__showcontent">
                                    <?php
                                    $currentuser = wp_get_current_user();
                                    $curentID = get_current_user_id();
                                    echo get_avatar($curentID, 32);
                                    ?>
                                    <span class="user-name">
                            <?php echo $currentuser->user_nicename; ?>
                        </span>
                                </div>
                                <div class="before-login__hiddencontent">
                                    <div class="hiddencontent__leftcontent">
                                        <?php echo get_avatar($curentID, 64); ?>
                                    </div>
                                    <div class="hiddencontent__rightcontent">
                                        <div class="rightcontent__wrapprer">
                                            <a href="<?php echo esc_url($music_press_member_page_url);?>"
                                               title="<?php esc_html_e('Show Profile', 'music-press-pro'); ?>">
                                                <?php esc_html_e('My profile', 'music-press-pro'); ?>
                                            </a>
                                            <a href="<?php echo esc_url($music_press_member_edit_url); ?>"
                                               title="<?php esc_html_e('Edit Profile', 'music-press-pro'); ?>"
                                               class="edit">
                                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                            </a>
                                        </div>
                                        <a href="<?php echo esc_url(wp_logout_url()); ?>" class="logout"
                                           title="log out">
                                            <?php esc_html_e('Logout', 'music-press-pro'); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                    endif;
                    ?>
                </aside>
                <?php
            }
            $content = ob_get_clean();

            echo $content;

            $this->cache_widget($args, $content);
        }
    }

    register_widget('Music_Press_Widget_Login');

}


