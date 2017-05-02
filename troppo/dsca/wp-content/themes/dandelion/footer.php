  <div id="footer-container">
  <?php if(get_opt('_widgetized_footer')!='off'){?>
    <div id="footer">
      <div id="footer-columns">
<?php 
print_footer_sidebar('footer-first', false);
print_footer_sidebar('footer-second', false);
print_footer_sidebar('footer-third', false);
print_footer_sidebar('footer-fourth', true);
?>
</div>
</div>
</div>
<?php } ?>
<div id="copyrights">
<h5 >&copy; Copyright Dorney Self Catering Apartments</h5>
</div>
<!-- FOOTER ENDS -->
</div>
</div>
</div>
<?php wp_footer(); 
echo(get_opt('_analytics')); ?>
</body>
</html>
