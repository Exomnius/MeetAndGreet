
<div class="infoWindow">
	<div>
		<h4><i class="<?php print $catIcon; ?>"></i> <?php print $cat->categorie. ' met '.$user['username']; ?></h4>
		<?php if($joinedCount != 0): ?>
			<p><?php print $joinedCount. ' people are going.' ?></p>
		<?php endif; ?>
	</div>
	<span><strong>Extra description</strong></span>
	<p class="float-left"><?php print $event->description; ?></p>
	<a href="#" onclick="joinEvent(<?php print $event->eventId; ?>)" class="btn btn-primary">Join</a>
	<a href="#" onclick="closeInfoWindow()" class="btn btn-default">Cancel</a>
</div>