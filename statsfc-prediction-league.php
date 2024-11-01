<?php
/*
Plugin Name: StatsFC Prediction League
Plugin URI: https://statsfc.com/prediction-league
Description: StatsFC Prediction League
Version: 2.0.1
Author: Will Woodward
Author URI: https://willjw.co.uk
License: GPL2
*/

/*  Copyright 2020  Will Woodward  (email : will@willjw.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('STATSFC_PREDICTIONLEAGUE_ID',      'StatsFC_PredictionLeague');
define('STATSFC_PREDICTIONLEAGUE_NAME',    'StatsFC Prediction League');
define('STATSFC_PREDICTIONLEAGUE_VERSION', '2.0.1');

/**
 * Adds StatsFC widget.
 */
class StatsFC_PredictionLeague extends WP_Widget
{
    public $isShortcode = false;

    private static $defaults = array(
        'title'    => '',
        'key'      => '',
        'id'       => '',
        'timezone' => 'Europe/London',
    );

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(STATSFC_PREDICTIONLEAGUE_ID, STATSFC_PREDICTIONLEAGUE_NAME, array('description' => 'StatsFC Prediction League'));
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $instance = wp_parse_args((array) $instance, self::$defaults);
        $title    = strip_tags($instance['title']);
        $key      = strip_tags($instance['key']);
        $id       = strip_tags($instance['id']);
        $timezone = strip_tags($instance['timezone']);
        ?>
        <p>
            <label>
                <?php _e('Title', STATSFC_PREDICTIONLEAGUE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('StatsFC Key', STATSFC_PREDICTIONLEAGUE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('key'); ?>" type="text" value="<?php echo esc_attr($key); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('League ID', STATSFC_PREDICTIONLEAGUE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('id'); ?>" type="text" value="<?php echo esc_attr($id); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Timezone', STATSFC_PREDICTIONLEAGUE_ID); ?>
                <select class="widefat" name="<?php echo $this->get_field_name('timezone'); ?>">
                    <?php
                    $zones = timezone_identifiers_list();

                    foreach ($zones as $zone) {
                        $selected = ($zone == $timezone ? ' selected' : '');

                        echo '<option value="' . esc_attr($zone) . '"' . $selected . '>' . esc_attr($zone) . '</option>' . PHP_EOL;
                    }
                    ?>
                </select>
            </label>
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance             = $old_instance;
        $instance['title']    = strip_tags($new_instance['title']);
        $instance['key']      = strip_tags($new_instance['key']);
        $instance['id']       = strip_tags($new_instance['id']);
        $instance['timezone'] = strip_tags($new_instance['timezone']);

        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);

        $title    = apply_filters('widget_title', (array_key_exists('title', $instance) ? $instance['title'] : ''));
        $key      = (array_key_exists('key', $instance) ? $instance['key'] : '');
        $id       = (array_key_exists('id', $instance) ? $instance['id'] : '');
        $timezone = (array_key_exists('timezone', $instance) ? $instance['timezone'] : '');

        $html = '';

        if (isset($before_widget)) {
            $html .= $before_widget;
        }

        if (isset($before_title)) {
            $html .= $before_title;
        }

        $html .= $title;

        if (isset($after_title)) {
            $html .= $after_title;
        }

        try {
            if (strlen($id) === 0) {
                throw new Exception('Please choose a League ID from the widget options');
            }

            wp_enqueue_script(STATSFC_PREDICTIONLEAGUE_ID, plugins_url('script.js', __FILE__), null, STATSFC_PREDICTIONLEAGUE_VERSION, true);

            $key      = esc_attr($key);
            $id       = esc_attr($id);
            $lang     = substr(get_bloginfo('language'), 0, 2);
            $timezone = esc_attr($timezone);

            $html .= <<< HTML
            <iframe id="statsfc-prediction-league" src="https://pl.statsfc.com/{$key}/{$id}?lang={$lang}&amp;timezone={$timezone}" width="100%" height="600" scrolling="no" frameborder="no"></iframe>
HTML;
        } catch (Exception $e) {
            $html .= '<p style="text-align: center;">StatsFC.com – ' . esc_attr($e->getMessage()) . '</p>' . PHP_EOL;
        }


        if (isset($after_widget)) {
            $html .= $after_widget;
        }

        if ($this->isShortcode) {
            return $html;
        } else {
            echo $html;
        }
    }

    public static function shortcode($atts)
    {
        $args = shortcode_atts(static::$defaults, $atts);

        $widget              = new static;
        $widget->isShortcode = true;

        return $widget->widget(array(), $args);
    }
}

// Register StatsFC widget
add_action('widgets_init', function () {
    register_widget(STATSFC_PREDICTIONLEAGUE_ID);
});

add_shortcode('statsfc-prediction-league', STATSFC_PREDICTIONLEAGUE_ID . '::shortcode');
