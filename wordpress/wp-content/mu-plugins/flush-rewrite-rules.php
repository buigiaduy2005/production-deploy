<?php
add_action('init', 'flush_rewrite_rules_once');
function flush_rewrite_rules_once() {
    if (get_option('flush_rewrite_rules_once') !== 'flushed') {
        flush_rewrite_rules();
        update_option('flush_rewrite_rules_once', 'flushed');
    }
}
