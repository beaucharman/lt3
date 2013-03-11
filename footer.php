  </section>

  <footer class="page-footer">

    <?php if(is_active_sidebar('footer-sidebar-widgets')) dynamic_sidebar('footer-sidebar-widgets'); ?>

    <p class="site-information">&copy;<?php echo date('Y'); ?>&nbsp;<?php bloginfo('name'); ?></p>

  </footer>

</div>

<?php wp_footer(); ?>

<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', '<?php global $lt3_site_settings; echo $lt3_site_settings['google_analytics']; ?>']);
  _gaq.push(['_trackPageview']);

  (function()
  {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  }
  )();
</script>

</body>
</html>
