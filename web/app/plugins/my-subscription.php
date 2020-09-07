<?php
/*
Plugin Name: My Simple Subscription
Plugin URI: https://manishlok.com.np
Description: This plugin helps you to get subscriptions through email and you can get email for every user signup for news letters.
Author: Manish Sahu
Version: 1.0
Author URI: http://www.manishlok.com.np/
*/

add_action('init', 'kv_register_shortcode_for_newsletter');

function kv_register_shortcode_for_newsletter()
{

    add_shortcode('kv_email_subscriptions', 'kv_email_subscription_fn');
}

class Kv_Subscription_widget extends WP_Widget
{

    public function __construct()
    {
        $widget_ops = array(
            'classname' => 'kv_email_subscription',
            'description' => 'A Simple Email Subscription Widget to get subscribers info',
        );
        parent::__construct('my_widget', 'Kv Subscriptions', $widget_ops);
    }

    public function widget($args, $instance)
    {
        echo '<aside>';
        do_action('kv_email_subscription');
        echo '</aside>';
    }
}

add_action('widgets_init', function () {
    register_widget('Kv_Subscription_widget');
});


if (!function_exists('kv_email_subscription_fn')) {
    add_action('kv_email_subscription', 'kv_email_subscription_fn');

    function kv_email_subscription_fn()
    {

        if ('POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['my_submit_subscription'])) {

            if (filter_var($_POST['subscriber_email'], FILTER_VALIDATE_EMAIL)) {

                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

                $subject = sprintf(__('New Subscription on %s', 'kvc'), $blogname);

                $to = get_option('admin_email');

                $headers = 'From: ' . sprintf(__('%s Admin', 'kvc'), $blogname) . ' <No-repy@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;

                $message  = sprintf(__('Hi ,', 'kvc')) . PHP_EOL . PHP_EOL;
                $message .= sprintf(__('You have a new subscription on your %s website.', 'kvc'), $_SERVER["REQUEST_URI"]) . PHP_EOL . PHP_EOL;
                $message .= __('Email Details', 'kvc') . PHP_EOL;
                $message .= __('-----------------') . PHP_EOL;
                $message .= __('User E-mail: ', 'kvc') . stripslashes($_POST['subscriber_email']) . PHP_EOL;
                $message .= __('-----------------') . PHP_EOL;
                $message .= __('Regards,', 'kvc') . PHP_EOL . PHP_EOL;
                $message .= sprintf(__('Your %s Team', 'kvc'), $blogname) . PHP_EOL;
                $message .= trailingslashit(get_option('home')) . PHP_EOL . PHP_EOL . PHP_EOL . PHP_EOL;

                if (wp_mail($to, $subject, $message, $headers)) {

                    echo 'You will receive this full story in your e-mail (' . $_POST['subscriber_email'] . ') shortly!';
                } else {
                    echo 'There was a problem with your e-mail (' . $_POST['subscriber_email'] . ')';
                }
            } else {
                echo 'There was a problem with your e-mail (' . $_POST['subscriber_email'] . ')';
            }
        } ?>
        <form id="newsletter-footer" action="" method="POST">
            <div class="flex">
                <input id="email_story" class="shadow appearance-none border rounded w-8/12 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" type="email" name="subscriber_email" placeholder="Email address">
                <input type="hidden" name="my_submit_subscription" value="Submit">
                <input class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-4 focus:outline-none hover:bg-indigo-600 rounded" type="submit" name="submit_form" value="Download">
                <div class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-red-500 ml-4">
                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                    </svg>
                </div>
            </div>
        </form>
<?php }
} ?>