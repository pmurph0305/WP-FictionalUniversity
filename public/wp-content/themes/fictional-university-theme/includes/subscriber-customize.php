<?php
  // Redirect Subscriber Account out of admin and onto homepage.
  function redirectSubscriber() {
      $user = wp_get_current_user();
      if (count($user->roles) == 1 AND $user->roles[0] == 'subscriber') {
          wp_redirect(site_url('/'));
          exit;
      }
  }
  add_action('admin_init', 'redirectSubscriber');

  function noAdminBarForSubscribers() {
    $user = wp_get_current_user();
    if (count($user->roles) == 1 AND $user->roles[0] == 'subscriber') {
        show_admin_bar(false);
    }
  }
  add_action('wp_loaded', 'noAdminBarForSubscribers');
?>