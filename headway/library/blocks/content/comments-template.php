<?php
echo '<div id="comments">';
	
	HeadwayComments::maybe_password_protected_message();

	HeadwayComments::show_comments();

	comment_form(apply_filters('headway_comment_form_args', array()));

echo '</div><!-- #comments -->';