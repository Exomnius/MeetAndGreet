
<div class="infoWindow">
	<div>
		<h4><i class="<?php print $catIcon; ?>"></i><?php print $event->eventName; ?></h4>
		<h5><?php print 'With '.$user['username']; ?></h5>
		<?php if($joinedCount != 0): ?>
			<p><?php print $joinedCount. ' people are going.' ?></p>
		<?php endif; ?>
	</div>
	<span><strong>Extra description</strong></span>
	<p class="float-left"><?php print $event->description; ?></p>
	<?php if($allowJoin): ?>
		<a href="#" onclick="joinEvent(<?php print $event->eventId.','.$event->user; ?>)" class="btn btn-primary">Join</a>
	<?php endif; ?>
	<a href="#" onclick="closeInfoWindow()" class="btn btn-default">Cancel</a>
</div>